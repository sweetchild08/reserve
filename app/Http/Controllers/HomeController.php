<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rooms;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Encryption\DecryptException;
use Session;
use Xendit\Xendit;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title      = 'Home';
        $rooms      = $this->featured('rooms');
        $cottages   = $this->featured('cottages');
        $foods      = $this->featured('foods');
        $events     = $this->featured('events');
        $activities = $this->featured('activities');
        $categories = DB::table('categories')->where(['category' => 'Rooms'])->get();
        return view('home',compact('title','rooms','categories','cottages','foods','activities','events'));
    }

    public function terms_agreement() {
        return view('terms-agreement');
    }

    public function resort_inquiries() {
        if(Session::has('customer_id')) {
            $userQuery = DB::table('users')->select(DB::raw('CONCAT(firstname," ",middlename," ",surname) as name'),'email','contact')->where(['id' => Session::get('customer_id')])->first();
        } else {
            $userQuery = [];
        }
        return view('resort-reservation',compact('userQuery'));
    }

    public function featured($table) {
        return DB::table($table)->select($table.'.*','categories.name as category_name')
        ->join('categories',$table.'.categories_id', '=', 'categories.id')
        ->where([$table.'.is_featured' => 1])
        ->limit(3)
        ->get();
    }

    public function test11(){
        $cottages = DB::table('cottages')
           // ->join('cottages_galleries', 'cottages.id', '=', 'cottages_galleries.cottages_id')
            ->get();

        return $cottages;

       

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
