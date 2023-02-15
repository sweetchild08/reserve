<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function login()
    {
        //
        $title = 'Login';
        return view('admin.login',compact('title'));
    }

    public function logout() {
        Session::forget('administrator_id');
        return redirect('admin/login');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        //
        $validated = $request->validate([
            'username'  => 'bail|required',
            'password'  => 'bail|required',
        ]);

        $data = User::where(['username' => $request->username,'roles' => 0,'is_active' => 1]);
        if($data->exists()) {
            $row = $data->first();
            $login = Auth::attempt(['username' => $request->username, 'password' => $request->password,'roles' => 0,'is_active' => 1]);
            if($login) {
                Session::put('administrator_id',$row->id);
                Session::put('name',$row->firstname.' '.$row->middlename.' '.$row->surname);
                return redirect('/admin/dashboard');
            } else {
                $message = 'Username or password are incorrect';
            }
        } else {
            $message = 'Username or password are incorrect';
        }
        return back()->with('message',$message);

    }

    public function dashboard() {
        $title      = 'Dashboard';

        $sales_data = DB::table('reservations')
            ->select(
                DB::raw('DATE(updated_at) as "date"'),
                DB::raw('YEAR(updated_at) as "year"'),
                DB::raw('MONTHNAME(updated_at) as "month"'),
                DB::raw('WEEKDAY(updated_at) as "week"'),
                DB::raw('DAY(updated_at) as "day"'),
                DB::raw('amount as "sales"'),
            )
            ->where('booking_status', '=', 'Completed')
            ->get();

        $try = DB::table('reservations')->select(
            DB::raw('MONTH(updated_at) as y'),
            DB::raw('SUM(amount) as x'),
            DB::raw('YEAR(updated_at) as name'),
            DB::raw('MONTH(updated_at) as id')
        )->where('booking_status', '=', 'Completed')->groupBy('updated_at')->get();
       // return dd($try);

        //testong only
        //$select_group = DB::table('reservations')->groupBy('updated_at')->get();

        //data analytics ito
        $cur = 0;
        $blank_array = array();
        $counter = -1;
        $c = 0;

        foreach($try as $value){

            if ($cur != $value->name) {
              $counter++;
              $c = 0;
              $blank_array[$counter]['name'] = $value->name;
              $blank_array[$counter]['id'] = $value->name;
            }

            $monthNum  = $value->y;
            $monthName = date('F', mktime(0, 0, 0, $monthNum, 10)); // March

            $blank_array[$counter]['data'][$c][0] = $monthName;
            $blank_array[$counter]['data'][$c][1] = floatval($value->x);
            $c++;
            if ($cur != $value->name) {
              $cur = $value->name;
            }

        }
        $dateanalyticsY = DB::table('reservations')->select(DB::raw('YEAR(updated_at) as name'), DB::raw('SUM(amount) as y'), DB::raw('YEAR(updated_at) as drilldown'))->where('booking_status', '=', 'Completed')->groupBy(DB::raw('YEAR(updated_at)'))->get();
        // //hanggang dito


        $rooms      = DB::table('rooms')->count();
        $cottages   = DB::table('cottages')->count();
        $foods      = DB::table('foods')->count();
        $events     = DB::table('events')->count();
        $activities = DB::table('activities')->count();
        $pending    = DB::table('reservations')->where('booking_status','Pending')->count();
        $approved   = DB::table('reservations')->where('booking_status','Approved')->count();
        $completed  = DB::table('reservations')->where('booking_status','Completed')->count();
        $cancelled  = DB::table('reservations')->where('booking_status','Cancelled')->count();

        $sales_rooms      = $this->get_daily_sales_report('Rooms');
        $sales_cottages   = $this->get_daily_sales_report('Cottages');
        $sales_foods      = $this->get_daily_sales_report('Foods');
        $sales_events     = $this->get_daily_sales_report('Events');
        $sales_activities = $this->get_daily_sales_report('Activities');

        $incomeRooms      = DB::table('reservations')->where(['booking_status' => 'Approved','booking_type' => 'Rooms'])->sum('amount');
        $incomeCottages   = DB::table('reservations')->where(['booking_status' => 'Approved','booking_type' => 'Cottages'])->sum('amount');
        $incomeFoods      = DB::table('reservations')->where(['booking_status' => 'Approved','booking_type' => 'Foods'])->sum('amount');
        $incomeEvents     = DB::table('reservations')->where(['booking_status' => 'Approved','booking_type' => 'Events'])->sum('amount');
        $incomeActivities = DB::table('reservations')->where(['booking_status' => 'Approved','booking_type' => 'Activities'])->sum('amount');

        return view('admin.dashboard',
            compact('title','rooms','cottages','foods','events','activities','pending','approved','completed','cancelled','sales_rooms','sales_cottages','sales_foods','sales_events','sales_activities','incomeRooms','incomeCottages','incomeFoods','incomeEvents','incomeActivities'))
            ->with('sales_data', json_encode($sales_data, JSON_NUMERIC_CHECK))
            ->with('year', json_encode($dateanalyticsY, JSON_NUMERIC_CHECK))
            ->with('monthKey', json_encode($blank_array, JSON_NUMERIC_CHECK));
    }

    public function result(Request $request) {
        $title      = 'Dashboard';
        $rooms      = DB::table('rooms')->count();
        $cottages   = DB::table('cottages')->count();
        $foods      = DB::table('foods')->count();
        $events     = DB::table('events')->count();
        $activities = DB::table('activities')->count();
        $pending    = DB::table('reservations')->where('booking_status','Pending')->count();
        $approved   = DB::table('reservations')->where('booking_status','Approved')->count();
        $completed  = DB::table('reservations')->where('booking_status','Completed')->count();
        $cancelled  = DB::table('reservations')->where('booking_status','Cancelled')->count();

        $sales_rooms      = $this->get_daily_sales_report('Rooms');
        $sales_cottages   = $this->get_daily_sales_report('Cottages');
        $sales_foods      = $this->get_daily_sales_report('Foods');
        $sales_events     = $this->get_daily_sales_report('Events');
        $sales_activities = $this->get_daily_sales_report('Activities');

        $incomeRooms      = DB::table('reservations')->select(DB::raw('SUM(amount) AS amount'))->whereBetween('created_at',[$request->search_from.' 00:00:00', $request->search_to.' 23:59:59'])->where(['booking_status' => 'Approved','booking_type' => 'Rooms'])->first()->amount;
        $incomeCottages   = DB::table('reservations')->select(DB::raw('SUM(amount) AS amount'))->whereBetween('created_at',[$request->search_from.' 00:00:00', $request->search_to.' 23:59:59'])->where(['booking_status' => 'Approved','booking_type' => 'Cottages'])->first()->amount;
        $incomeFoods      = DB::table('reservations')->select(DB::raw('SUM(amount) AS amount'))->whereBetween('created_at',[$request->search_from.' 00:00:00', $request->search_to.' 23:59:59'])->where(['booking_status' => 'Approved','booking_type' => 'Foods'])->first()->amount;
        $incomeEvents     = DB::table('reservations')->select(DB::raw('SUM(amount) AS amount'))->whereBetween('created_at',[$request->search_from.' 00:00:00', $request->search_to.' 23:59:59'])->where(['booking_status' => 'Approved','booking_type' => 'Events'])->first()->amount;
        $incomeActivities = DB::table('reservations')->select(DB::raw('SUM(amount) AS amount'))->whereBetween('created_at',[$request->search_from.' 00:00:00', $request->search_to.' 23:59:59'])->where(['booking_status' => 'Approved','booking_type' => 'Activities'])->first()->amount;
        $from             = $request->search_from;
        $to               = $request->search_to;
        return view('admin.dashboard',compact('title','from','to','rooms','cottages','foods','events','activities','pending','approved','completed','cancelled','sales_rooms','sales_cottages','sales_foods','sales_events','sales_activities','incomeRooms','incomeCottages','incomeFoods','incomeEvents','incomeActivities'));
    }

    public function get_daily_sales_report($booking_type) {
        // return DB::table('reservations')->select(DB::raw('SUM(amount) AS amount'))->whereBetween('created_at',[date('Y-m-d').' 00:00:00',date('Y-m-d').' 23:59:59'])->where(['booking_status' => 'Approved','booking_type' => $booking_type])->first()->amount;
        return DB::table('reservations')->select(DB::raw('SUM(amount) AS amount'))->whereBetween('created_at',[date('Y-m-d').' 00:00:00',date('Y-m-d').' 23:59:59'])->where(['booking_status' => 'Completed','booking_type' => $booking_type])->first()->amount;
    }

    public function booking() {
        $title = 'Booking';
        return view('admin.booking.booking',compact('title'));
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
