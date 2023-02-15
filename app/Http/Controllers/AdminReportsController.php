<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Encryption\DecryptException;
class AdminReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function sales_report() {
        $title = 'Sales Report';
        $reports    = DB::table('reservations')->select('reservations.*','users.id as users_id','users.firstname','users.middlename','users.surname')
        ->join('users','users.id', '=', 'reservations.customer_id')
        ->where(['booking_status' => 'Completed'])->orderByDesc('created_at')->get();

        $yearly_reports    = DB::table('reservations')->select('reservations.*','users.id as users_id','users.firstname','users.middlename','users.surname')
            ->join('users','users.id', '=', 'reservations.customer_id')
            ->where(['booking_status' => 'Completed', 'date_from' => '*/*/2022'])->orderByDesc('created_at')->get();

        // TODO: sql query yearly, monthly, daily

        return view('admin.reports.sales-report',compact('title','reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //
        $dates        = explode(' - ',$request->dates);
        $from    = date('Y-m-d',strtotime($dates[0]));
        $to      = date('Y-m-d',strtotime($dates[1]));
        $booking_type = $request->booking_type;
        if($booking_type == 'All') {
            $reports = DB::table('reservations')
            ->select('reservations.*','users.contact','users.id as users_id','users.firstname','users.middlename','users.surname')
            ->join('users','users.id', '=', 'reservations.customer_id')
            ->where(['booking_status' => 'Completed'])
            ->whereBetween('reservations.created_at',[$from.' 00:00:00',$to.' 23:59:59'])
            ->orderByDesc('reservations.created_at')
            ->get();
        } else {
            $reports = DB::table('reservations')
            ->select('reservations.*','users.contact','users.id as users_id','users.firstname','users.middlename','users.surname')
            ->join('users','users.id', '=', 'reservations.customer_id')
            ->where(['booking_status' => 'Completed','booking_type' => $booking_type])
            ->whereBetween('reservations.created_at',[$from.' 00:00:00',$to.' 23:59:59'])
            ->orderByDesc('reservations.created_at')
            ->get();
        }
        return view('admin.reports.results',compact('reports','from','to'));
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
