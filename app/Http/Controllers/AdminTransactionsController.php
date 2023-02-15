<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Encryption\DecryptException;
class AdminTransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pos()
    {
        $title = 'Transaction - Point of Sale';
        $rooms = DB::table('rooms')
            //->leftjoin('rooms_galleries', 'rooms.id', '=', 'rooms_galleries.rooms_id')
            ->get();
            // print_r(json_encode($rooms));die();
        $cottages = DB::table('cottages')
            //->leftJoin('cottages_galleries', 'cottages.id', '=', 'cottages_galleries.cottages_id')
            ->get();

        $foods = DB::table('foods')
            //->leftjoin('foods_galleries', 'foods.id', '=', 'foods_galleries.foods_id')
            ->get();

        $activities = DB::table('activities')
            //->leftjoin('activities_galleries', 'activities.id', '=', 'activities_galleries.activities_id')
            ->get();

        $events = DB::table('events')
            //->join('events_galleries', 'events.id', '=', 'events_galleries.events_id')
            ->get();
            // print_r(json_encode($events));die();

        $session_rooms = Session::get('rooms');
        $session_cottages = Session::get('cottages');
        $session_activities = Session::get('activities');
        $session_events = Session::get('events');

        $total_rooms = $this->countAllTotal($session_rooms);
        $total_cottages= $this->countAllTotal($session_cottages);
        $total_activities = $this->countAllTotal($session_activities);
        $total_events = $this->countAllTotal($session_events);

        $grand_total = $total_rooms + $total_cottages + $total_activities + $total_events;

        return view('admin.transactions.poslivewire', compact('title', 'rooms', 'cottages', 'foods', 'activities', 'events', 'grand_total'));
    }

    public function rooms()
    {
        //
        $title = 'Transaction - Rooms';
        $rooms    = DB::table('reservations')->select('reservations.*','users.id as users_id','users.firstname','users.middlename','users.surname')
        ->join('users','users.id', '=', 'reservations.customer_id')
        ->where(['reservations.booking_type' => 'Rooms'])->orderByDesc('created_at')->get();
        return view('admin.transactions.rooms',compact('title','rooms'));
    }

    public function cottages()
    {
        //
        $title = 'Transaction - Cottages';
        $cottages = DB::table('reservations')->select('reservations.*','users.id as users_id','users.firstname','users.middlename','users.surname')
        ->join('users','users.id', '=', 'reservations.customer_id')
        ->where(['reservations.booking_type' => 'Cottages'])->orderByDesc('created_at')->get();
        return view('admin.transactions.cottages',compact('title','cottages'));
    }

    public function foods()
    {
        //
        $title = 'Transaction - Foods';
        $foods = DB::table('reservations')->select('reservations.*','users.id as users_id','users.firstname','users.middlename','users.surname')
        ->join('users','users.id', '=', 'reservations.customer_id')
        ->where(['reservations.booking_type' => 'Foods'])->orderByDesc('created_at')->get();
        return view('admin.transactions.foods',compact('title','foods'));
    }

    public function events()
    {
        //
        $title = 'Transaction - Events';
        $events = DB::table('reservations')->select('reservations.*','users.id as users_id','users.firstname','users.middlename','users.surname')
        ->join('users','users.id', '=', 'reservations.customer_id')
        ->where(['reservations.booking_type' => 'Events'])->orderByDesc('created_at')->get();
        return view('admin.transactions.events',compact('title','events'));
    }

    public function activities()
    {
        //
        $title = 'Transaction - Activities';
        $activities = DB::table('reservations')->select('reservations.*','users.id as users_id','users.firstname','users.middlename','users.surname')
        ->join('users','users.id', '=', 'reservations.customer_id')
        ->where(['reservations.booking_type' => 'Activities'])->orderByDesc('created_at')->get();
        return view('admin.transactions.activities',compact('title','activities'));
    }

    public function rooms_status($id,$stats) {
        if($stats == 'Cancel') {
            $status = 'Cancelled';
        } elseif($stats == 'Approve') {
            $status = 'Approved';
        } elseif($stats == 'Complete') {
            $status = 'Completed';
        }

        DB::beginTransaction();
        try {
            DB::table('reservations')->where(['id' => Crypt::decryptString($id)])->update(['booking_status' => $status]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return back()->with('message','Transaction has been '.$status);
    }

    public function pos_add(Request $request){
        $category = $request->category;
        $id = $request->id;

        $result = '';

        if($category =='rooms') {
            $query = DB::table('rooms')->where('id','=', $id)->first();
            $rooms_rates[] = $query->rate;
            $array_rooms[] = $id;
        }

        if($category == 'cottages') {
            $query = DB::table('cottages')->where('id','=', $id)->first();
            $cottages_rates[] = $query->rate;
            $array_cottages[] = $id;
        }

        if($category =='activities') {
            $query = DB::table('activities')->where('id','=', $id)->first();
            $activities_rates[] = $query->rate;
            $array_activities[] = $id;
        }

        if($category =='events') {
            $query = DB::table('events')->where('id','=', $id)->first();
            $events_rates[] = $query->rate;
            $array_events[] = $id;
        }
        // switch($category){
        //     case 'rooms':
        //         $query = DB::table('rooms')->where('id', '=', $id)->first();
        //         $rooms_rates[] = $query->rate;
        //         $array_rooms[] = $id;
        //         $result = $query->title;
        //         break;
        //     case 'cottages':
        //         $query = DB::table('cottages')->where('id', '=', $id)->first();
        //         $cottages_rates[] = $query->rate;
        //         $array_cottages[] = $id;
        //         $result = $query->title;
        //         break;
        //     case 'activities':
        //         $query = DB::table('activities')->where('id', '=', $id)->first();
        //         $activities_rates[] = $query->rate;
        //         $array_activities[] = $id;
        //         $result = $query->title;
        //         break;
        //     case 'events':
        //         $query = DB::table('events')->where('id', '=', $id)->first();
        //         $events_rates[] = $query->rate;
        //         $array_events[] = $id;
        //         $result = $query->title;
        //         break;
        //     default:
        //         echo 'na';
        // }
        // if(!empty($request->addons_cottages)) {
        //     foreach($request->addons_cottages as $id) {
        //         $query = DB::table('cottages')->where(['id' => $id])->first();
        //         $cottages_rates[] = $query->rate;
        //         $array_cottages[] = $id;
        //     }
        // }

        $total_cottages_rate    = !isset($cottages_rates) ? 0 : array_sum($cottages_rates);
        $total_foods_rate       = !isset($foods_rates) ? 0 : array_sum($foods_rates);
        $total_events_rate      = !isset($events_rates) ? 0 : array_sum($events_rates);
        $total_activities_rate  = !isset($activities_rates) ? 0 : array_sum($activities_rates);
        $total_rates            = $total_cottages_rate + $total_foods_rate + $total_events_rate + $total_activities_rate;

        Session::put('addons_cottages',!isset($array_cottages) ? [] : $array_cottages);
        // Session::put('addons_foods',!isset($array_foods) ? [] : $array_foods);
        Session::put('addons_events',!isset($array_events) ? [] : $array_events);
        Session::put('addons_activities',!isset($array_activities) ? [] : $array_activities[] = $array_activities);
        Session::put('total_cottages_rate',!isset($total_cottages_rate) ? [] : $total_cottages_rate);
        // Session::put('total_foods_rate',!isset($total_foods_rate) ? [] : $total_foods_rate);
        Session::put('total_events_rate',!isset($total_events_rate) ? [] : $total_events_rate);
        Session::put('total_activities_rate',!isset($total_activities_rate) ? [] : $total_activities_rate);
        Session::put('total_rates',$total_rates);
        //return json_encode($request->all());

        return json_encode(session()->all());

    }

    public function reservations($table,$booking_type,$customer_id) {
        return DB::table($table)->where(['customer_id' =>$customer_id,'booking_type' => $booking_type])
        // ->whereIn('booking_status',['Approved','Completed'])
        ->paginate(10);
    }

    public function viewTransaction(Request $request)
    {
        $customer_id = decrypt($request->segment(4));
        $customer = DB::table('users')->where('id', $customer_id)->first();
        $query = DB::table('reservations')
        ->where('customer_id', $customer_id)
        ->get();

        $title            = 'My Reservations';
        $rooms            = $this->reservations('reservations','Rooms',$customer_id);
        $cottages         = $this->reservations('reservations','Cottages',$customer_id);
        $foods            = $this->reservations('reservations','Foods',$customer_id);
        $eventsQuery      = $this->reservations('reservations','Events',$customer_id);
        $activitiesQuery  = $this->reservations('reservations','Activities',$customer_id);
        return view('admin.customers.history',compact('title','rooms','cottages','foods','eventsQuery','activitiesQuery','query','customer'));
    }

    public function pos_add_test(Request $request){
        $category = $request->category;
        $id = $request->id;

        if($category == 'rooms'){
            $query = DB::table('rooms')->where('id', '=', $id)->first();
            $rooms[] = array(
                'id' => $query->id,
                'title' => $query->title,
                'rate' => $query->rate

            );

            Session::push('rooms', !isset($rooms) ? [] : $rooms);
            
           
        }

        if($category == 'cottages'){
            $query = DB::table('cottages')->where('id', '=', $id)->first();
            $cottages[] = array(
                'id' => $query->id,
                'title' => $query->title,
                'rate' => $query->rate

            );

            Session::push('cottages', !isset($cottages) ? [] : $cottages);

            
        }

        if($category == 'activities'){
            $query = DB::table('activities')->where('id', '=', $id)->first();
            $activities[] = array(
                'id' => $query->id,
                'title' => $query->title,
                'rate' => $query->rate

            );

            Session::push('activities', !isset($activities) ? [] : $activities);

            
        }

        if($category == 'events'){
            $query = DB::table('events')->where('id', '=', $id)->first();
            $events[] = array(
                'id' => $query->id,
                'title' => $query->title,
                'rate' => $query->rate

            );

            Session::push('events', !isset($events) ? [] : $events);

        }

        // Session::forget('rooms');
        // Session::forget('cottages');
        // Session::forget('activities');
        // Session::forget('events');

        $total_cottages_rate    = !isset($cottages_rates) ? 0 : array_sum($cottages_rates);
        $total_foods_rate       = !isset($foods_rates) ? 0 : array_sum($foods_rates);
        $total_events_rate      = !isset($events_rates) ? 0 : array_sum($events_rates);
        $total_activities_rate  = !isset($activities_rates) ? 0 : array_sum($activities_rates);
        $total_rates            = $total_cottages_rate + $total_foods_rate + $total_events_rate + $total_activities_rate;


        return json_encode(session()->all());


    }

    public function countAllTotal($session){
        $total = 0;
        foreach((array)$session as $sess){
            $total += $sess[0]['rate'];
        }

        return $total;
    }

    public function clear_booking(){
        Session::forget('rooms');
        Session::forget('cottages');
        Session::forget('activities');
        Session::forget('events');

        return back();
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
