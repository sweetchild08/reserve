<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Encryption\DecryptException;


class AdminBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rooms()
    {
        //
        $title = 'Rooms';
        $rooms = DB::table('rooms')->select('rooms.*','rooms_services.rooms_id','rooms_services.services','categories.name as category_name','rooms.id as TabID')
        ->join('rooms_services','rooms_services.rooms_id', '=', 'rooms.id')
        ->join('categories','categories.id', '=', 'rooms.categories_id')->get();
        return view('admin.booking.rooms',compact('title','rooms'));
    }

    public function room_details($id) {
        $query    = DB::table('rooms')->where(['id' => Crypt::decryptString($id)])->first();
        $services = DB::table('rooms_services')->where(['rooms_id' => Crypt::decryptString($id)])->get();
        $related  = DB::table('rooms')->where('id','!=',Crypt::decryptString($id))->where('categories_id','=',$query->categories_id)->get();
        $gallery  = DB::table('rooms_galleries')->where(['rooms_id' => Crypt::decryptString($id)])->get();
        $title    = $query->title;
        $addons_cottages = DB::table('cottages')->select('cottages.*','categories.name as category_name')
        ->join('categories','cottages.categories_id', '=', 'categories.id')
        ->get();

        $addons_foods = DB::table('foods')->select('foods.*','categories.name as category_name')
        ->join('categories','foods.categories_id', '=', 'categories.id')
        ->get();

        $addons_activities = DB::table('activities')->select('activities.*','categories.name as category_name')
        ->join('categories','activities.categories_id', '=', 'categories.id')
        ->get();

        $addons_events = DB::table('events')->select('events.*','categories.name as category_name')
        ->join('categories','events.categories_id', '=', 'categories.id')
        ->get();


        if(Session::has('customer_id')) {
            $userQuery = DB::table('users')->select(DB::raw('CONCAT(firstname," ",middlename," ",surname) as name'),'email','contact')->where(['id' => Session::get('customer_id')])->first();
        } else {
            $userQuery = [];
        }

        $comments = DB::table('comments')->select('comments.*',DB::raw('CONCAT(users.firstname," ",users.middlename," ",users.surname) as name'))
        ->join('users','users.id', '=', 'comments.users_id')
        ->where(['category' => 'Rooms','booking_id' => Crypt::decryptString($id)])
        ->get();

        return view('admin.booking.rooms-details',compact('services','comments','title','query','gallery','related','userQuery','id','addons_cottages','addons_foods','addons_activities','addons_events'));
    }

    public function cottages()
    {
        //
        $title = 'Cottages';
        $cottages = DB::table('cottages')->select('cottages.*','categories.name as category_name')
        ->join('categories','categories.id', '=', 'cottages.categories_id')->get();
        return view('admin.booking.cottages',compact('title','cottages'));
    }

    public function foods()
    {
        //
        $title = 'Foods';
        $foods = DB::table('foods')->select('foods.*','categories.name as category_name')
        ->join('categories','categories.id', '=', 'foods.categories_id')->get();
        return view('admin.booking.foods',compact('title','foods'));
    
    }

    public function events()
    {
        //
        $title = 'Events';
        $events = DB::table('events')->select('events.*','categories.name as category_name')
        ->join('categories','categories.id', '=', 'events.categories_id')->get();
        return view('admin.booking.events',compact('title','events'));
    }

    public function activities()
    {
        $title = 'Activities';
        $activities = DB::table('activities')->select('activities.*','categories.name as category_name')
        ->join('categories','categories.id', '=', 'activities.categories_id')->get();
        return view('admin.booking.activities',compact('title','activities'));
    }

    public function adminReceipt(Request $request)
    {
        $OrderID = $request->segment(5);
        $data = DB::table('reservations')
        ->select('*','reservations.created_at as ReservedDate')
        ->leftJoin('users','users.id','=','reservations.customer_id')
        ->leftJoin('refprovince','refprovince.provCode','=','users.province')
        ->leftJoin('refcitymun','refcitymun.citymunCode','=','users.city')
        ->leftJoin('refbrgy','refbrgy.brgyCode','=','users.barangay')
        ->where('reservations.id',$OrderID)
        ->first();
        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';
        // exit;

        return view('admin.booking.receipt',compact('data'));
    }

    public function reservation(Request $request) {
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

    public function itexmo($contact, $message, $apicode, $passwd) {
        $url = 'https://api.itexmo.com/api/broadcast';
        $request = [
            'Email'      => 'lozanojohndavid@gmail.com',
            'Password'   => $passwd,
            'ApiCode'    => $apicode,
            'Recipients' => [$contact],
            'Message'    => $message,
        ];
        // return Http::post($url,$request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
