<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Encryption\DecryptException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class POS extends Component
{
    use LivewireAlert;

    public $session_rooms, $session_cottages, $session_activities, $session_events;
    public $total_rooms, $total_activities, $total_events, $grand_total;
    public $rooms, $cottages, $foods, $activities, $events;

    public $render, $gtotal;
    public function render()
    {
        $title = 'Transaction - Point of Sale';
        $this->rooms = DB::table('rooms')
            //->leftjoin('rooms_galleries', 'rooms.id', '=', 'rooms_galleries.rooms_id')
            ->get();
        $this->cottages = DB::table('cottages')
            //->leftJoin('cottages_galleries', 'cottages.id', '=', 'cottages_galleries.cottages_id')
            ->get();
        $this->foods = DB::table('foods')
            //->leftjoin('foods_galleries', 'foods.id', '=', 'foods_galleries.foods_id')
            ->get();
        $this->activities = DB::table('activities')
            //->leftjoin('activities_galleries', 'activities.id', '=', 'activities_galleries.activities_id')
            ->get();
        $this->events = DB::table('events')
            //->join('events_galleries', 'events.id', '=', 'events_galleries.events_id')
            ->get();

        $this->session_rooms = Session::get('rooms');
        $this->session_cottages = Session::get('cottages');
        $this->session_activities = Session::get('activities');
        $this->session_events = Session::get('events');

        $this->total_rooms = $this->countAllTotal($this->session_rooms);
        $this->total_cottages= $this->countAllTotal($this->session_cottages);
        $this->total_activities = $this->countAllTotal($this->session_activities);
        $this->total_events = $this->countAllTotal($this->session_events);

        $grand_total = $this->total_rooms + $this->total_cottages + $this->total_activities + $this->total_events;

        return view('livewire.p-o-s');
    }

    public function countAllTotal($session){
        $total = 0;
        foreach((array)$session as $sess){
            $total += $sess[0]['rate'];
        }

        return $total;
    }

    public function savePOS()
    {
        $category     = $request->category;
        $validated = $request->validate([
            'surname'    => 'bail|required',
            'firstname'  => 'bail|required',
            'middlename' => 'bail|required',
            // 'email'      => 'bail|required|unique:App\User,email',
            'contact'    => 'bail|required|numeric',
            'is_order'   => 'bail|required|numeric',
            'render'   => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $recovery_code = rand(111111,999999);
            $is_active     = 0; // not active yet need account confirmation via email
            $checkExist = DB::table('users')
            ->where(['email' => $request->email])
            ->where(['contact' => $request->contact])
            ->first();

            if(!$checkExist){
                $users = DB::table('users')->insertGetId([
                    'surname'       => $request->surname,
                    'firstname'     => $request->firstname,
                    'middlename'    => $request->middlename,
                    'province'      => '',
                    'city'          => '',
                    'barangay'      => '',
                    'address'       => '',
                    'email'         => $request->email,
                    'contact'       => $request->contact,
                    'username'      => $request->email,
                    'password'      => Crypt::encryptString(12345678),
                    'is_active'     => $is_active,
                    'recovery_code' => $recovery_code,
                    'roles'         => 1,
                ]);

                $customer_id = $users;
                $query = DB::table('users')->where(['id' => $customer_id])->first();
                $contact_number = $query->contact;

            }else{
                $customer_id = $checkExist->id;
                $contact_number = $checkExist->contact;
            }

            if($category == 'Rooms') {
                $dates        = explode(' - ',$request->dates);
                $date_from    = date('Y-m-d',strtotime($dates[0]));
                $date_to      = date('Y-m-d',strtotime($dates[1]));
                $booking_id   = Crypt::decryptString($request->booking_id);
                $query        = DB::table('rooms')->where(['id' => $booking_id])->first();
                $title        = $query->title;
                $adults       = $query->adults;
                $childrens    = $query->childrens;
                $rates        = $query->rate;
                $booking_type = $category;
                $total        = $request->total_rates;

                if(Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
                    foreach(Session::get('addons_cottages') as $id) {
                        $query = DB::table('cottages')->select('cottages.*','categories.name as category_name')
                        ->join('categories','cottages.categories_id', '=', 'categories.id')
                        ->where(['cottages.id' => $id])
                        ->first();
                        if($query->category_name == 'Nipa Hut') {
                            $cottage_title = $query->category_name.' '.$query->title;
                        } else {
                            $cottage_title = $query->title;
                        }
                        $cottages[] = [
                            'title' => $cottage_title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }

                if(Session::has('addons_foods')  && count(Session::get('addons_foods')) > 0) {
                    foreach(Session::get('addons_foods') as $id) {
                        $query = DB::table('foods')->where(['id' => $id])->first();
                        $foods[] = [
                            'title' => $query->title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }

                if(Session::has('addons_events')  && count(Session::get('addons_events')) > 0) {
                    foreach(Session::get('addons_events') as $id) {
                        $query = DB::table('events')->where(['id' => $id])->first();
                        $events[] = [
                            'title' => $query->title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }

                if(Session::has('addons_activities')  && count(Session::get('addons_activities')) > 0) {
                    foreach(Session::get('addons_activities') as $id) {
                        $query = DB::table('activities')->where(['id' => $id])->first();
                        $activities[] = [
                            'title' => $query->title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }

                
                $description = json_encode([
                    'cottages'   => !isset($cottages) ? [] : $cottages,
                    'meals'      => !isset($foods) ? [] : $foods,
                    'events'     => !isset($events) ? [] : $events,
                    'activities' => !isset($activities) ? [] : $activities,
                    'title'      => $title,
                    'adults'     => $adults,
                    'childrens'  => $childrens,
                    'from'       => $date_from,
                    'to'         => $date_to,
                    'rates'      => $rates,
                    'counter'    => $request->days_counter,
                    'total'      => $total,
                    'partial'    => $total / 2
                ]);

                Session::forget('addons_cottages');
                Session::forget('addons_foods');
                Session::forget('addons_events');
                Session::forget('addons_activities');
                Session::forget('total_events_rate');
                Session::forget('total_activities_rate');
                Session::forget('total_cottages_rate');
                Session::forget('total_foods_rate');
                Session::forget('total_rates');
            } elseif($category == 'Cottages') {

                if(Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
                    foreach(Session::get('addons_rooms') as $id) {
                        
                        $query = DB::table('rooms')->select('rooms.*','categories.name as category_name')
                        ->join('categories','rooms.categories_id', '=', 'categories.id')
                        ->where(['rooms.id' => $id])
                        ->first();
                        $title = $query->category_name.' '.$query->title;
                        $rooms[] = [
                            'title'       => $title,
                            'adults'      => $query->adults,
                            'childrens'   => $query->childrens,
                            'description' => $query->description
                        ];
                    }
                }

                if(Session::has('addons_foods')  && count(Session::get('addons_foods')) > 0) {
                    foreach(Session::get('addons_foods') as $id) {
                        $query = DB::table('foods')->where(['id' => $id])->first();
                        $foods[] = [
                            'title' => $query->title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }

                if(Session::has('addons_events')  && count(Session::get('addons_events')) > 0) {
                    foreach(Session::get('addons_events') as $id) {
                        $query = DB::table('events')->where(['id' => $id])->first();
                        $events[] = [
                            'title' => $query->title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }

                if(Session::has('addons_activities')  && count(Session::get('addons_activities')) > 0) {
                    foreach(Session::get('addons_activities') as $id) {
                        $query = DB::table('activities')->where(['id' => $id])->first();
                        $activities[] = [
                            'title' => $query->title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }

                $dates        = explode(' - ',$request->dates);
                $date_from    = $dates[0];
                $date_to      = $dates[1];
                $booking_id   = Crypt::decryptString($request->booking_id);
                $query        = DB::table('cottages')->where(['id' => $booking_id])->first();
                $title        = $query->title;
                $pax          = $query->pax;
                $rates        = $query->rate;
                $total        = $request->total_rates;
                $booking_type = $category;
                $description = json_encode([
                    'rooms'      => !isset($rooms) ? [] : $rooms,
                    'meals'      => !isset($foods) ? [] : $foods,
                    'events'     => !isset($events) ? [] : $events,
                    'activities' => !isset($activities) ? [] : $activities,
                    'title'      => $title,
                    'pax'        => $pax,
                    'from'       => $date_from,
                    'to'         => $date_to,
                    'rates'      => $rates,
                    'counter'    => $request->days_counter,
                    'total'      => $total,
                    'partial'    => $total / 2
                ]);

                Session::forget('addons_rooms');
                Session::forget('addons_foods');
                Session::forget('addons_events');
                Session::forget('addons_activities');
                Session::forget('total_rooms_rate');
                Session::forget('total_foods_rate');
                Session::forget('total_events_rate');
                Session::forget('total_activities_rate');
                Session::forget('total_rates');
            } elseif($category == 'Foods') {

                if(Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
                    foreach(Session::get('addons_rooms') as $id) {
                        
                        $query = DB::table('rooms')->select('rooms.*','categories.name as category_name')
                        ->join('categories','rooms.categories_id', '=', 'categories.id')
                        ->where(['rooms.id' => $id])
                        ->first();
                        $title = $query->category_name.' '.$query->title;
                        $rooms[] = [
                            'title'       => $title,
                            'adults'      => $query->adults,
                            'childrens'   => $query->childrens,
                            'description' => $query->description
                        ];
                    }
                }

                if(Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
                    foreach(Session::get('addons_cottages') as $id) {
                        $query = DB::table('cottages')->select('cottages.*','categories.name as category_name')
                        ->join('categories','cottages.categories_id', '=', 'categories.id')
                        ->where(['cottages.id' => $id])
                        ->first();
                        if($query->category_name == 'Nipa Hut') {
                            $cottage_title = $query->category_name.' '.$query->title;
                        } else {
                            $cottage_title = $query->title;
                        }
                        $cottages[] = [
                            'title' => $cottage_title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }

                if(Session::has('addons_events')  && count(Session::get('addons_events')) > 0) {
                    foreach(Session::get('addons_events') as $id) {
                        $query = DB::table('events')->where(['id' => $id])->first();
                        $events[] = [
                            'title' => $query->title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }

                if(Session::has('addons_activities')  && count(Session::get('addons_activities')) > 0) {
                    foreach(Session::get('addons_activities') as $id) {
                        $query = DB::table('activities')->where(['id' => $id])->first();
                        $activities[] = [
                            'title' => $query->title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }

                $dates        = explode(' - ',$request->dates);
                $date_from    = $dates[0];
                $date_to      = $dates[1];
                $booking_id   = Crypt::decryptString($request->booking_id);
                $query        = DB::table('foods')->where(['id' => $booking_id])->first();
                $title        = $query->title;
                $pax          = $query->pax;
                $rates        = $query->rate;
                $total        = $request->total_rates;
                $booking_type = $category;
                $description = json_encode([
                    'rooms'      => !isset($rooms) ? [] : $rooms,
                    'cottages'   => !isset($cottages) ? [] : $cottages,
                    'events'     => !isset($events) ? [] : $events,
                    'activities' => !isset($activities) ? [] : $activities,
                    'title'      => $title,
                    'pax'        => $pax,
                    'from'       => $date_from,
                    'to'         => $date_to,
                    'rates'      => $rates,
                    'counter'    => $request->days_counter,
                    'total'      => $total,
                    'partial'    => $total / 2
                ]);

                Session::forget('addons_rooms');
                Session::forget('addons_cottages');
                Session::forget('addons_events');
                Session::forget('addons_activities');
                Session::forget('total_rooms_rate');
                Session::forget('total_cottages_rate');
                Session::forget('total_events_rate');
                Session::forget('total_activities_rate');
                Session::forget('total_rates');
            } elseif($category == 'Events') {

                if(Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
                    foreach(Session::get('addons_rooms') as $id) {
                        
                        $query = DB::table('rooms')->select('rooms.*','categories.name as category_name')
                        ->join('categories','rooms.categories_id', '=', 'categories.id')
                        ->where(['rooms.id' => $id])
                        ->first();
                        $title = $query->category_name.' '.$query->title;
                        $rooms[] = [
                            'title'       => $title,
                            'adults'      => $query->adults,
                            'childrens'   => $query->childrens,
                            'description' => $query->description
                        ];
                    }
                }

                if(Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
                    foreach(Session::get('addons_cottages') as $id) {
                        $query = DB::table('cottages')->select('cottages.*','categories.name as category_name')
                        ->join('categories','cottages.categories_id', '=', 'categories.id')
                        ->where(['cottages.id' => $id])
                        ->first();
                        if($query->category_name == 'Nipa Hut') {
                            $cottage_title = $query->category_name.' '.$query->title;
                        } else {
                            $cottage_title = $query->title;
                        }
                        $cottages[] = [
                            'title' => $cottage_title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }

                if(Session::has('addons_foods')  && count(Session::get('addons_foods')) > 0) {
                    foreach(Session::get('addons_foods') as $id) {
                        $query = DB::table('foods')->where(['id' => $id])->first();
                        $foods[] = [
                            'title' => $query->title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }

                if(Session::has('addons_activities')  && count(Session::get('addons_activities')) > 0) {
                    foreach(Session::get('addons_activities') as $id) {
                        $query = DB::table('activities')->where(['id' => $id])->first();
                        $activities[] = [
                            'title' => $query->title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }


                $dates        = explode(' - ',$request->dates);
                $date_from    = $dates[0];
                $date_to      = $dates[1];
                $booking_id   = Crypt::decryptString($request->booking_id);
                $query        = DB::table('events')->where(['id' => $booking_id])->first();
                $title        = $query->title;
                $pax          = $query->pax;
                $rates        = $query->rate;
                $total        = $request->total_rates;
                $booking_type = $category;
                $description = json_encode([
                    'rooms'      => !isset($rooms) ? [] : $rooms,
                    'cottages'   => !isset($cottages) ? [] : $cottages,
                    'foods'      => !isset($foods) ? [] : $foods,
                    'activities' => !isset($activities) ? [] : $activities,
                    'title'      => $title,
                    'pax'        => $pax,
                    'from'       => $date_from,
                    'to'         => $date_to,
                    'rates'      => $rates,
                    'counter'    => $request->days_counter,
                    'total'      => $total,
                    'partial'    => $total / 2
                ]);

                Session::forget('addons_rooms');
                Session::forget('addons_cottages');
                Session::forget('addons_foods');
                Session::forget('addons_activities');
                Session::forget('total_rooms_rate');
                Session::forget('total_cottages_rate');
                Session::forget('total_foods_rate');
                Session::forget('total_activities_rate');
                Session::forget('total_rates');
            } elseif($category == 'Activities') {

                if(Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
                    foreach(Session::get('addons_rooms') as $id) {
                        
                        $query = DB::table('rooms')->select('rooms.*','categories.name as category_name')
                        ->join('categories','rooms.categories_id', '=', 'categories.id')
                        ->where(['rooms.id' => $id])
                        ->first();
                        $title = $query->category_name.' '.$query->title;
                        $rooms[] = [
                            'title'       => $title,
                            'adults'      => $query->adults,
                            'childrens'   => $query->childrens,
                            'description' => $query->description
                        ];
                    }
                }

                if(Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
                    foreach(Session::get('addons_cottages') as $id) {
                        $query = DB::table('cottages')->select('cottages.*','categories.name as category_name')
                        ->join('categories','cottages.categories_id', '=', 'categories.id')
                        ->where(['cottages.id' => $id])
                        ->first();
                        if($query->category_name == 'Nipa Hut') {
                            $cottage_title = $query->category_name.' '.$query->title;
                        } else {
                            $cottage_title = $query->title;
                        }
                        $cottages[] = [
                            'title' => $cottage_title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }

                if(Session::has('addons_foods')  && count(Session::get('addons_foods')) > 0) {
                    foreach(Session::get('addons_foods') as $id) {
                        $query = DB::table('foods')->where(['id' => $id])->first();
                        $foods[] = [
                            'title' => $query->title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }

                if(Session::has('addons_events')  && count(Session::get('addons_events')) > 0) {
                    foreach(Session::get('addons_events') as $id) {
                        $query = DB::table('events')->where(['id' => $id])->first();
                        $events[] = [
                            'title' => $query->title,
                            'pax'   => $query->pax,
                            'rate'   => $query->rate,
                        ];
                    }
                }

                $dates        = explode(' - ',$request->dates);
                $date_from    = $dates[0];
                $date_to      = $dates[1];
                $booking_id   = Crypt::decryptString($request->booking_id);
                $query        = DB::table('activities')->where(['id' => $booking_id])->first();
                $title        = $query->title;
                $pax          = $query->pax;
                $rates        = $query->rate;
                $total        = $request->total_rates;
                $booking_type = $category;
                $description = json_encode([
                    'rooms'      => !isset($rooms) ? [] : $rooms,
                    'cottages'   => !isset($cottages) ? [] : $cottages,
                    'foods'      => !isset($foods) ? [] : $foods,
                    'events'     => !isset($events) ? [] : $events,
                    'title'      => $title,
                    'pax'        => $pax,
                    'from'       => $date_from,
                    'to'         => $date_to,
                    'rates'      => $rates,
                    'counter'    => $request->days_counter,
                    'total'      => $total,
                    'partial'    => $total / 2
                ]);

                Session::forget('addons_rooms');
                Session::forget('addons_cottages');
                Session::forget('addons_foods');
                Session::forget('addons_events');
                Session::forget('total_rooms_rate');
                Session::forget('total_cottages_rate');
                Session::forget('total_foods_rate');
                Session::forget('total_events_rate');
                Session::forget('total_rates');
            }
        
            $payment_type = 'OTC';


            $reference = Session::get('OrderID');
            $getID = DB::table('reservations')->insertGetId([
                'customer_id'    => $customer_id,
                'description'    => $description,
                'booking_type'   => $booking_type,
                'booking_id'     => $booking_id,
                'payment_type'   => $payment_type,
                'amount'         => $total,
                'date_from'      => $date_from,
                'date_to'        => $date_to,
                'reference'      => $reference,
                'status'         => 'Fully Paid',
                'booking_status' => 'Approved',
                'render'         => $request->render,
                'change'         => $request->render - $total
            ]);
            $user    = DB::table('users')->where(['id' => $customer_id])->first();
            $contact = $contact_number;
            $message = 'Your reservation in Santorenz Bay Resort has been successful with reference code '.$reference.'. Thank you for using our website.';
            $apicode = 'ST-JOHND761571_M91HO';
            $passwd  = 'jdlozano';
            $itexmo  = $this->itexmo($contact,$message,$apicode,$passwd);
          
            DB::commit();
            return redirect()->route('adminReceipt',['OrderID' => $getID]);
            // return redirect('admin/dashboard')->with('message','You have successfully reserved a room with reference code '.$reference);
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...
            DB::rollback();
            
            // and throw the error again.
            throw $e;
        }
    }
}
