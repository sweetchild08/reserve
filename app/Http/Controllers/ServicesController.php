<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rooms;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Encryption\DecryptException;
use PDF;
use Xendit\Xendit;

class ServicesController extends Controller
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

    public function rooms()
    {
        //
        $title = 'Rooms';
        $query = $this->services('rooms');
        // print_r(json_encode($query));die();
//        $query = DB::table('reservations')->distinct('')
//            ->joinSub('')
        return view('services.rooms', compact('title', 'query'));
    }

    public function cottage()
    {
        //
        $title = 'Cottage';
        $query = $this->services('cottages');
        return view('services.cottage', compact('title', 'query'));
    }

    public function foods()
    {
        //
        $title = 'Foods';
        $query = $this->services('foods');
        return view('services.foods', compact('title', 'query'));
    }

    public function activities()
    {
        //
        $title = 'Activities';
        $query = $this->services('activities');
        return view('services.activities', compact('title', 'query'));
    }

    public function events()
    {
        //
        $title = 'Events';
        $query = $this->services('events');
        return view('services.events', compact('title', 'query'));
    }


    public function services($table)
    {
        return DB::table($table)->select(
            $table . '.*', // select * from table
            $table.'.id as TabID',
            'categories.name as category_name', // select name from categories
            )
            ->join('categories', $table . '.categories_id', '=', 'categories.id')
            ->paginate(10);
    }

    public function comments(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'bail|required',
            'category' => 'bail|required',
            'comments' => 'bail|required',
        ]);

        DB::beginTransaction();
        try {
            DB::table('comments')->insert([
                'users_id' => Session::get('customer_id'),
                'booking_id' => Crypt::decryptString($request->booking_id),
                'category' => $request->category,
                'comments' => $request->comments,
            ]);
            DB::commit();

            return back()->with('message', 'Comments has been submitted.');
        } catch (\Exception $e) {
            DB::rollback();
        }
    }


    public function room_details($id)
    {
        $query = DB::table('rooms')->where(['id' => Crypt::decryptString($id)])->first();
        $services = DB::table('rooms_services')->where(['rooms_id' => Crypt::decryptString($id)])->get();
        $related = DB::table('rooms')->where('id', '!=', Crypt::decryptString($id))->where('categories_id', '=', $query->categories_id)->get();
        $gallery = DB::table('rooms_galleries')->where(['rooms_id' => Crypt::decryptString($id)])->get();
        $title = $query->title;
        $addons_cottages = DB::table('cottages')->select('cottages.*', 'categories.name as category_name')
            ->join('categories', 'cottages.categories_id', '=', 'categories.id')
            ->get();

        $addons_foods = DB::table('foods')->select('foods.*', 'categories.name as category_name')
            ->join('categories', 'foods.categories_id', '=', 'categories.id')
            ->get();

        $addons_activities = DB::table('activities')->select('activities.*', 'categories.name as category_name')
            ->join('categories', 'activities.categories_id', '=', 'categories.id')
            ->get();

        $addons_events = DB::table('events')->select('events.*', 'categories.name as category_name')
            ->join('categories', 'events.categories_id', '=', 'categories.id')
            ->get();


        if (Session::has('customer_id')) {
            $userQuery = DB::table('users')->select(DB::raw('CONCAT(firstname," ",middlename," ",surname) as name'), 'email', 'contact')->where(['id' => Session::get('customer_id')])->first();
        } else {
            $userQuery = [];
        }

        $comments = DB::table('comments')->select('comments.*', DB::raw('CONCAT(users.firstname," ",users.middlename," ",users.surname) as name'))
            ->join('users', 'users.id', '=', 'comments.users_id')
            ->where(['category' => 'Rooms', 'booking_id' => Crypt::decryptString($id)])
            ->get();

        return view('services.room-details', compact('services', 'comments', 'title', 'query', 'gallery', 'related', 'userQuery', 'id', 'addons_cottages', 'addons_foods', 'addons_activities', 'addons_events'));
    }

    public function cottages_details($id)
    {
        $query = DB::table('cottages')->where(['id' => Crypt::decryptString($id)])->first();
        $related = DB::table('cottages')->where('id', '!=', Crypt::decryptString($id))->where('categories_id', '=', $query->categories_id)->get();
        $gallery = DB::table('cottages_galleries')->where(['cottages_id' => Crypt::decryptString($id)])->get();
        $title = $query->title;

        $addons_rooms = DB::table('rooms')->select('rooms.*', 'categories.name as category_name')
            ->join('categories', 'rooms.categories_id', '=', 'categories.id')
            ->get();

        $addons_foods = DB::table('foods')->select('foods.*', 'categories.name as category_name')
            ->join('categories', 'foods.categories_id', '=', 'categories.id')
            ->get();

        $addons_activities = DB::table('activities')->select('activities.*', 'categories.name as category_name')
            ->join('categories', 'activities.categories_id', '=', 'categories.id')
            ->get();

        $addons_events = DB::table('events')->select('events.*', 'categories.name as category_name')
            ->join('categories', 'events.categories_id', '=', 'categories.id')
            ->get();

        $comments = DB::table('comments')->select('comments.*', DB::raw('CONCAT(users.firstname," ",users.middlename," ",users.surname) as name'))
            ->join('users', 'users.id', '=', 'comments.users_id')
            ->where(['category' => 'Cottages', 'booking_id' => Crypt::decryptString($id)])
            ->get();

        if (Session::has('customer_id')) {
            $userQuery = DB::table('users')->select(DB::raw('CONCAT(firstname," ",middlename," ",surname) as name'), 'email', 'contact')->where(['id' => Session::get('customer_id')])->first();
        } else {
            $userQuery = [];
        }

        return view('services.cottages-details', compact('title', 'comments', 'query', 'gallery', 'related', 'userQuery', 'id', 'addons_rooms', 'addons_foods', 'addons_activities', 'addons_events'));
    }

    public function foods_details($id)
    {
        $query = DB::table('foods')->where(['id' => Crypt::decryptString($id)])->first();
        $related = DB::table('foods')->where('id', '!=', Crypt::decryptString($id))->where('categories_id', '=', $query->categories_id)->get();
        $gallery = DB::table('foods_galleries')->where(['foods_id' => Crypt::decryptString($id)])->get();
        $title = $query->title;

        $comments = DB::table('comments')->select('comments.*', DB::raw('CONCAT(users.firstname," ",users.middlename," ",users.surname) as name'))
            ->join('users', 'users.id', '=', 'comments.users_id')
            ->where(['category' => 'Foods', 'booking_id' => Crypt::decryptString($id)])
            ->get();

        $addons_rooms = DB::table('rooms')->select('rooms.*', 'categories.name as category_name')
            ->join('categories', 'rooms.categories_id', '=', 'categories.id')
            ->get();

        $addons_cottages = DB::table('cottages')->select('cottages.*', 'categories.name as category_name')
            ->join('categories', 'cottages.categories_id', '=', 'categories.id')
            ->get();

        $addons_activities = DB::table('activities')->select('activities.*', 'categories.name as category_name')
            ->join('categories', 'activities.categories_id', '=', 'categories.id')
            ->get();

        $addons_events = DB::table('events')->select('events.*', 'categories.name as category_name')
            ->join('categories', 'events.categories_id', '=', 'categories.id')
            ->get();

        if (Session::has('customer_id')) {
            $userQuery = DB::table('users')->select(DB::raw('CONCAT(firstname," ",middlename," ",surname) as name'), 'email', 'contact')->where(['id' => Session::get('customer_id')])->first();
        } else {
            $userQuery = [];
        }

        return view('services.foods-details', compact('title', 'comments', 'query', 'gallery', 'related', 'userQuery', 'id', 'addons_rooms', 'addons_cottages', 'addons_activities', 'addons_events'));
    }

    public function events_details($id)
    {
        $query = DB::table('events')->where(['id' => Crypt::decryptString($id)])->first();
        $related = DB::table('events')->where('id', '!=', Crypt::decryptString($id))->where('categories_id', '=', $query->categories_id)->get();
        $gallery = DB::table('events_galleries')->where(['events_id' => Crypt::decryptString($id)])->get();
        $title = $query->title;

        $addons_rooms = DB::table('rooms')->select('rooms.*', 'categories.name as category_name')
            ->join('categories', 'rooms.categories_id', '=', 'categories.id')
            ->get();

        $addons_cottages = DB::table('cottages')->select('cottages.*', 'categories.name as category_name')
            ->join('categories', 'cottages.categories_id', '=', 'categories.id')
            ->get();

        $addons_foods = DB::table('foods')->select('foods.*', 'categories.name as category_name')
            ->join('categories', 'foods.categories_id', '=', 'categories.id')
            ->get();

        $addons_activities = DB::table('activities')->select('activities.*', 'categories.name as category_name')
            ->join('categories', 'activities.categories_id', '=', 'categories.id')
            ->get();

        if (Session::has('customer_id')) {
            $userQuery = DB::table('users')->select(DB::raw('CONCAT(firstname," ",middlename," ",surname) as name'), 'email', 'contact')->where(['id' => Session::get('customer_id')])->first();
        } else {
            $userQuery = [];
        }

        $comments = DB::table('comments')->select('comments.*', DB::raw('CONCAT(users.firstname," ",users.middlename," ",users.surname) as name'))
            ->join('users', 'users.id', '=', 'comments.users_id')
            ->where(['category' => 'Events', 'booking_id' => Crypt::decryptString($id)])
            ->get();

        return view('services.events-details', compact('title', 'query', 'comments', 'gallery', 'related', 'userQuery', 'id', 'addons_rooms', 'addons_cottages', 'addons_activities', 'addons_foods'));
    }

    public function activities_details($id)
    {
        $query = DB::table('activities')->where(['id' => Crypt::decryptString($id)])->first();
        $related = DB::table('activities')->where('id', '!=', Crypt::decryptString($id))->where('categories_id', '=', $query->categories_id)->get();
        $gallery = DB::table('activities_galleries')->where(['activities_id' => Crypt::decryptString($id)])->get();
        $title = $query->title;

        $addons_rooms = DB::table('rooms')->select('rooms.*', 'categories.name as category_name')
            ->join('categories', 'rooms.categories_id', '=', 'categories.id')
            ->get();

        $addons_cottages = DB::table('cottages')->select('cottages.*', 'categories.name as category_name')
            ->join('categories', 'cottages.categories_id', '=', 'categories.id')
            ->get();

        $addons_foods = DB::table('foods')->select('foods.*', 'categories.name as category_name')
            ->join('categories', 'foods.categories_id', '=', 'categories.id')
            ->get();

        $addons_events = DB::table('events')->select('events.*', 'categories.name as category_name')
            ->join('categories', 'events.categories_id', '=', 'categories.id')
            ->get();

        $comments = DB::table('comments')->select('comments.*', DB::raw('CONCAT(users.firstname," ",users.middlename," ",users.surname) as name'))
            ->join('users', 'users.id', '=', 'comments.users_id')
            ->where(['category' => 'Activities', 'booking_id' => Crypt::decryptString($id)])
            ->get();

        if (Session::has('customer_id')) {
            $userQuery = DB::table('users')->select(DB::raw('CONCAT(firstname," ",middlename," ",surname) as name'), 'email', 'contact')->where(['id' => Session::get('customer_id')])->first();
        } else {
            $userQuery = [];
        }

        return view('services.activities-details', compact('title', 'comments', 'query', 'gallery', 'related', 'userQuery', 'id', 'addons_rooms', 'addons_cottages', 'addons_events', 'addons_foods'));
    }

    public function room_post_details($id, $days, $dates)
    {
        $query = DB::table('rooms')->where(['id' => Crypt::decryptString($id)])->first();
        $services = DB::table('rooms_services')->where(['rooms_id' => Crypt::decryptString($id)])->get();
        $related = DB::table('rooms')->where('id', '!=', Crypt::decryptString($id))->where('categories_id', '=', $query->categories_id)->get();
        $gallery = DB::table('rooms_galleries')->where(['rooms_id' => Crypt::decryptString($id)])->get();
        $title = $query->title;

        $addons_cottages = DB::table('cottages')->select('cottages.*', 'categories.name as category_name')
            ->join('categories', 'cottages.categories_id', '=', 'categories.id')
            ->get();

        $addons_foods = DB::table('foods')->select('foods.*', 'categories.name as category_name')
            ->join('categories', 'foods.categories_id', '=', 'categories.id')
            ->get();

        $addons_activities = DB::table('activities')->select('activities.*', 'categories.name as category_name')
            ->join('categories', 'activities.categories_id', '=', 'categories.id')
            ->get();

        $addons_events = DB::table('events')->select('events.*', 'categories.name as category_name')
            ->join('categories', 'events.categories_id', '=', 'categories.id')
            ->get();

        $comments = DB::table('comments')->select('comments.*', DB::raw('CONCAT(users.firstname," ",users.middlename," ",users.surname) as name'))
            ->join('users', 'users.id', '=', 'comments.users_id')
            ->where(['category' => 'Rooms', 'booking_id' => Crypt::decryptString($id)])
            ->get();


        if (Session::has('customer_id')) {
            $userQuery = DB::table('users')->select(DB::raw('CONCAT(firstname," ",middlename," ",surname) as name'), 'email', 'contact')->where(['id' => Session::get('customer_id')])->first();
        } else {
            $userQuery = [];
        }

        $date = Crypt::decryptString($dates);
        return view('services.room-post-details', compact('services', 'comments', 'title', 'query', 'gallery', 'related', 'userQuery', 'id', 'days', 'date', 'addons_cottages', 'addons_foods', 'addons_activities', 'addons_events'));
    }


    public function addons_set_a(Request $request)
    {
        if (!empty($request->addons_cottages)) {
            foreach ($request->addons_cottages as $id) {
                $query = DB::table('cottages')->where(['id' => $id])->first();
                $cottages_rates[] = $query->rate;
                $array_cottages[] = $id;
            }
        }

        if (!empty($request->addons_foods)) {
            foreach ($request->addons_foods as $id) {
                $query = DB::table('foods')->where(['id' => $id])->first();
                $foods_rates[] = $query->rate;
                $array_foods[] = $id;
            }
        }

        if (!empty($request->addons_activities)) {
            foreach ($request->addons_activities as $id) {
                $query = DB::table('activities')->where(['id' => $id])->first();
                $activities_rates[] = $query->rate;
                $array_activities[] = $id;
            }
        }

        if (!empty($request->addons_events)) {
            foreach ($request->addons_events as $id) {
                $query = DB::table('events')->where(['id' => $id])->first();
                $events_rates[] = $query->rate;
                $array_events[] = $id;
            }
        }

        $total_cottages_rate = !isset($cottages_rates) ? 0 : array_sum($cottages_rates);
        $total_foods_rate = !isset($foods_rates) ? 0 : array_sum($foods_rates);
        $total_events_rate = !isset($events_rates) ? 0 : array_sum($events_rates);
        $total_activities_rate = !isset($activities_rates) ? 0 : array_sum($activities_rates);
        $total_rates = $total_cottages_rate + $total_foods_rate + $total_events_rate + $total_activities_rate;

        Session::put('addons_cottages', !isset($array_cottages) ? [] : $array_cottages);
        Session::put('addons_foods', !isset($array_foods) ? [] : $array_foods);
        Session::put('addons_events', !isset($array_events) ? [] : $array_events);
        Session::put('addons_activities', !isset($array_activities) ? [] : $array_activities);
        Session::put('total_cottages_rate', !isset($total_cottages_rate) ? [] : $total_cottages_rate);
        Session::put('total_foods_rate', !isset($total_foods_rate) ? [] : $total_foods_rate);
        Session::put('total_events_rate', !isset($total_events_rate) ? [] : $total_events_rate);
        Session::put('total_activities_rate', !isset($total_activities_rate) ? [] : $total_activities_rate);
        Session::put('total_rates', $total_rates);
        $reference = 'SBRH'.date('yhis').str_pad(rand(1,100000),3,"0", STR_PAD_LEFT);
        Session::put('OrderID', $reference);
        return back();
    }

    public function addons_set_b(Request $request)
    {
        if (!empty($request->addons_rooms)) {
            foreach ($request->addons_rooms as $id) {
                $query = DB::table('rooms')->where(['id' => $id])->first();
                $rooms_rates[] = $query->rate;
                $array_rooms[] = $id;
            }
        }

        if (!empty($request->addons_foods)) {
            foreach ($request->addons_foods as $id) {
                $query = DB::table('foods')->where(['id' => $id])->first();
                $foods_rates[] = $query->rate;
                $array_foods[] = $id;
            }
        }

        if (!empty($request->addons_activities)) {
            foreach ($request->addons_activities as $id) {
                $query = DB::table('activities')->where(['id' => $id])->first();
                $activities_rates[] = $query->rate;
                $array_activities[] = $id;
            }
        }

        if (!empty($request->addons_events)) {
            foreach ($request->addons_events as $id) {
                $query = DB::table('events')->where(['id' => $id])->first();
                $events_rates[] = $query->rate;
                $array_events[] = $id;
            }
        }

        $total_rooms_rate = !isset($rooms_rates) ? 0 : array_sum($rooms_rates);
        $total_foods_rate = !isset($foods_rates) ? 0 : array_sum($foods_rates);
        $total_events_rate = !isset($events_rates) ? 0 : array_sum($events_rates);
        $total_activities_rate = !isset($activities_rates) ? 0 : array_sum($activities_rates);
        $total_rates = $total_rooms_rate + $total_foods_rate + $total_events_rate + $total_activities_rate;

        Session::put('addons_rooms', !isset($array_rooms) ? [] : $array_rooms);
        Session::put('addons_foods', !isset($array_foods) ? [] : $array_foods);
        Session::put('addons_events', !isset($array_events) ? [] : $array_events);
        Session::put('addons_activities', !isset($array_activities) ? [] : $array_activities);
        Session::put('total_rooms_rate', !isset($total_rooms_rate) ? [] : $total_rooms_rate);
        Session::put('total_foods_rate', !isset($total_foods_rate) ? [] : $total_foods_rate);
        Session::put('total_events_rate', !isset($total_events_rate) ? [] : $total_events_rate);
        Session::put('total_activities_rate', !isset($total_activities_rate) ? [] : $total_activities_rate);
        Session::put('total_rates', $total_rates);
        return back();
    }

    public function addons_set_c(Request $request)
    {
        if (!empty($request->addons_rooms)) {
            foreach ($request->addons_rooms as $id) {
                $query = DB::table('rooms')->where(['id' => $id])->first();
                $rooms_rates[] = $query->rate;
                $array_rooms[] = $id;
            }
        }

        if (!empty($request->addons_cottages)) {
            foreach ($request->addons_cottages as $id) {
                $query = DB::table('cottages')->where(['id' => $id])->first();
                $cottages_rates[] = $query->rate;
                $array_cottages[] = $id;
            }
        }

        if (!empty($request->addons_activities)) {
            foreach ($request->addons_activities as $id) {
                $query = DB::table('activities')->where(['id' => $id])->first();
                $activities_rates[] = $query->rate;
                $array_activities[] = $id;
            }
        }

        if (!empty($request->addons_events)) {
            foreach ($request->addons_events as $id) {
                $query = DB::table('events')->where(['id' => $id])->first();
                $events_rates[] = $query->rate;
                $array_events[] = $id;
            }
        }

        $total_rooms_rate = !isset($rooms_rates) ? 0 : array_sum($rooms_rates);
        $total_cottages_rate = !isset($cottages_rates) ? 0 : array_sum($cottages_rates);
        $total_activities_rate = !isset($activities_rates) ? 0 : array_sum($activities_rates);
        $total_events_rate = !isset($events_rates) ? 0 : array_sum($events_rates);
        $total_rates = $total_rooms_rate + $total_cottages_rate + $total_events_rate + $total_activities_rate;

        Session::put('addons_rooms', !isset($array_rooms) ? [] : $array_rooms);
        Session::put('addons_cottages', !isset($array_cottages) ? [] : $array_cottages);
        Session::put('addons_events', !isset($array_events) ? [] : $array_events);
        Session::put('addons_activities', !isset($array_activities) ? [] : $array_activities);
        Session::put('total_rooms_rate', !isset($total_rooms_rate) ? [] : $total_rooms_rate);
        Session::put('total_cottages_rate', !isset($total_cottages_rate) ? [] : $total_cottages_rate);
        Session::put('total_events_rate', !isset($total_events_rate) ? [] : $total_events_rate);
        Session::put('total_activities_rate', !isset($total_activities_rate) ? [] : $total_activities_rate);
        Session::put('total_rates', $total_rates);
        return back();
    }

    public function addons_set_d(Request $request)
    {
        if (!empty($request->addons_rooms)) {
            foreach ($request->addons_rooms as $id) {
                $query = DB::table('rooms')->where(['id' => $id])->first();
                $rooms_rates[] = $query->rate;
                $array_rooms[] = $id;
            }
        }

        if (!empty($request->addons_cottages)) {
            foreach ($request->addons_cottages as $id) {
                $query = DB::table('cottages')->where(['id' => $id])->first();
                $cottages_rates[] = $query->rate;
                $array_cottages[] = $id;
            }
        }

        if (!empty($request->addons_foods)) {
            foreach ($request->addons_foods as $id) {
                $query = DB::table('foods')->where(['id' => $id])->first();
                $foods_rates[] = $query->rate;
                $array_foods[] = $id;
            }
        }

        if (!empty($request->addons_activities)) {
            foreach ($request->addons_activities as $id) {
                $query = DB::table('activities')->where(['id' => $id])->first();
                $activities_rates[] = $query->rate;
                $array_activities[] = $id;
            }
        }

        $total_rooms_rate = !isset($rooms_rates) ? 0 : array_sum($rooms_rates);
        $total_cottages_rate = !isset($cottages_rates) ? 0 : array_sum($cottages_rates);
        $total_foods_rate = !isset($foods_rates) ? 0 : array_sum($foods_rates);
        $total_activities_rate = !isset($activities_rates) ? 0 : array_sum($activities_rates);
        $total_rates = $total_rooms_rate + $total_cottages_rate + $total_foods_rate + $total_activities_rate;

        Session::put('addons_rooms', !isset($array_rooms) ? [] : $array_rooms);
        Session::put('addons_cottages', !isset($array_cottages) ? [] : $array_cottages);
        Session::put('addons_foods', !isset($array_foods) ? [] : $array_foods);
        Session::put('addons_activities', !isset($array_activities) ? [] : $array_activities);
        Session::put('total_rooms_rate', !isset($total_rooms_rate) ? [] : $total_rooms_rate);
        Session::put('total_cottages_rate', !isset($total_cottages_rate) ? [] : $total_cottages_rate);
        Session::put('total_foods_rate', !isset($total_foods_rate) ? [] : $total_foods_rate);
        Session::put('total_activities_rate', !isset($total_activities_rate) ? [] : $total_activities_rate);
        Session::put('total_rates', $total_rates);
        return back();
    }

    public function addons_set_e(Request $request)
    {
        if (!empty($request->addons_rooms)) {
            foreach ($request->addons_rooms as $id) {
                $query = DB::table('rooms')->where(['id' => $id])->first();
                $rooms_rates[] = $query->rate;
                $array_rooms[] = $id;
            }
        }

        if (!empty($request->addons_cottages)) {
            foreach ($request->addons_cottages as $id) {
                $query = DB::table('cottages')->where(['id' => $id])->first();
                $cottages_rates[] = $query->rate;
                $array_cottages[] = $id;
            }
        }

        if (!empty($request->addons_foods)) {
            foreach ($request->addons_foods as $id) {
                $query = DB::table('foods')->where(['id' => $id])->first();
                $foods_rates[] = $query->rate;
                $array_foods[] = $id;
            }
        }

        if (!empty($request->addons_events)) {
            foreach ($request->addons_events as $id) {
                $query = DB::table('events')->where(['id' => $id])->first();
                $events_rates[] = $query->rate;
                $array_events[] = $id;
            }
        }

        $total_rooms_rate = !isset($rooms_rates) ? 0 : array_sum($rooms_rates);
        $total_cottages_rate = !isset($cottages_rates) ? 0 : array_sum($cottages_rates);
        $total_foods_rate = !isset($foods_rates) ? 0 : array_sum($foods_rates);
        $total_events_rate = !isset($events_rates) ? 0 : array_sum($events_rates);
        $total_rates = $total_rooms_rate + $total_cottages_rate + $total_foods_rate + $total_events_rate;

        Session::put('addons_rooms', !isset($array_rooms) ? [] : $array_rooms);
        Session::put('addons_cottages', !isset($array_cottages) ? [] : $array_cottages);
        Session::put('addons_foods', !isset($array_foods) ? [] : $array_foods);
        Session::put('addons_events', !isset($array_events) ? [] : $array_events);
        Session::put('total_rooms_rate', !isset($total_rooms_rate) ? [] : $total_rooms_rate);
        Session::put('total_cottages_rate', !isset($total_cottages_rate) ? [] : $total_cottages_rate);
        Session::put('total_foods_rate', !isset($total_foods_rate) ? [] : $total_foods_rate);
        Session::put('total_events_rate', !isset($total_events_rate) ? [] : $total_events_rate);
        Session::put('total_rates', $total_rates);
        return back();
    }


    public function reservation(Request $request)
    {
        $category = $request->category;
        $customer_id = Session::get('customer_id');

        //adds
        $payment_method = $request->payment;

        if ($payment_method == 'otc') {
            if ($category == 'Rooms') {
                $dates = explode(' - ', $request->dates);
                $date_from = date('Y-m-d',strtotime($dates[0]));
                $date_to = date('Y-m-d',strtotime($dates[1]));
                $booking_id = Crypt::decryptString($request->booking_id);
                $query = DB::table('rooms')->where(['id' => $booking_id])->first();
                $title = $query->title;
                $adults = $query->adults;
                $childrens = $query->childrens;
                $rates = $query->rate;
                $booking_type = $category;
                $total = $request->total_rates;

                if (Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
                    foreach (Session::get('addons_cottages') as $id) {
                        $query = DB::table('cottages')->select('cottages.*', 'categories.name as category_name')
                            ->join('categories', 'cottages.categories_id', '=', 'categories.id')
                            ->where(['cottages.id' => $id])
                            ->first();
                        if ($query->category_name == 'Nipa Hut') {
                            $cottage_title = $query->category_name . ' ' . $query->title;
                        } else {
                            $cottage_title = $query->title;
                        }
                        $cottages[] = [
                            'title' => $cottage_title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_foods') && count(Session::get('addons_foods')) > 0) {
                    foreach (Session::get('addons_foods') as $id) {
                        $query = DB::table('foods')->where(['id' => $id])->first();
                        $foods[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_events') && count(Session::get('addons_events')) > 0) {
                    foreach (Session::get('addons_events') as $id) {
                        $query = DB::table('events')->where(['id' => $id])->first();
                        $events[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_activities') && count(Session::get('addons_activities')) > 0) {
                    foreach (Session::get('addons_activities') as $id) {
                        $query = DB::table('activities')->where(['id' => $id])->first();
                        $activities[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }


                $description = json_encode([
                    'cottages'      => !isset($cottages) ? [] : $cottages,
                    'meals'         => !isset($foods) ? [] : $foods,
                    'events'        => !isset($events) ? [] : $events,
                    'activities'    => !isset($activities) ? [] : $activities,
                    'title'         => $title,
                    'adults'        => $adults,
                    'childrens'     => $childrens,
                    'from'          => $date_from,
                    'to'            => $date_to,
                    'rates'         => $rates,
                    'counter'       => $request->days_counter,
                    'total'         => $total,
                    'partial'       => $total
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
            } elseif ($category == 'Cottages') {

                if (Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
                    foreach (Session::get('addons_rooms') as $id) {

                        $query = DB::table('rooms')->select('rooms.*', 'categories.name as category_name')
                            ->join('categories', 'rooms.categories_id', '=', 'categories.id')
                            ->where(['rooms.id' => $id])
                            ->first();
                        $title = $query->category_name . ' ' . $query->title;
                        $rooms[] = [
                            'title' => $title,
                            'adults' => $query->adults,
                            'childrens' => $query->childrens,
                            'description' => $query->description
                        ];
                    }
                }

                if (Session::has('addons_foods') && count(Session::get('addons_foods')) > 0) {
                    foreach (Session::get('addons_foods') as $id) {
                        $query = DB::table('foods')->where(['id' => $id])->first();
                        $foods[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_events') && count(Session::get('addons_events')) > 0) {
                    foreach (Session::get('addons_events') as $id) {
                        $query = DB::table('events')->where(['id' => $id])->first();
                        $events[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_activities') && count(Session::get('addons_activities')) > 0) {
                    foreach (Session::get('addons_activities') as $id) {
                        $query = DB::table('activities')->where(['id' => $id])->first();
                        $activities[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                $dates = explode(' - ', $request->dates);
                $date_from = $dates[0];
                $date_to = $dates[1];
                $booking_id = Crypt::decryptString($request->booking_id);
                $query = DB::table('cottages')->where(['id' => $booking_id])->first();
                $title = $query->title;
                $pax = $query->pax;
                $rates = $query->rate;
                $total = $request->total_rates;
                $booking_type = $category;
                $description = json_encode([
                    'rooms' => !isset($rooms) ? [] : $rooms,
                    'meals' => !isset($foods) ? [] : $foods,
                    'events' => !isset($events) ? [] : $events,
                    'activities' => !isset($activities) ? [] : $activities,
                    'title' => $title,
                    'pax' => $pax,
                    'from' => $date_from,
                    'to' => $date_to,
                    'rates' => $rates,
                    'counter' => $request->days_counter,
                    'total' => $total,
                    'partial' => $total
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
            } elseif ($category == 'Foods') {

                if (Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
                    foreach (Session::get('addons_rooms') as $id) {

                        $query = DB::table('rooms')->select('rooms.*', 'categories.name as category_name')
                            ->join('categories', 'rooms.categories_id', '=', 'categories.id')
                            ->where(['rooms.id' => $id])
                            ->first();
                        $title = $query->category_name . ' ' . $query->title;
                        $rooms[] = [
                            'title' => $title,
                            'adults' => $query->adults,
                            'childrens' => $query->childrens,
                            'description' => $query->description
                        ];
                    }
                }

                if (Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
                    foreach (Session::get('addons_cottages') as $id) {
                        $query = DB::table('cottages')->select('cottages.*', 'categories.name as category_name')
                            ->join('categories', 'cottages.categories_id', '=', 'categories.id')
                            ->where(['cottages.id' => $id])
                            ->first();
                        if ($query->category_name == 'Nipa Hut') {
                            $cottage_title = $query->category_name . ' ' . $query->title;
                        } else {
                            $cottage_title = $query->title;
                        }
                        $cottages[] = [
                            'title' => $cottage_title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_events') && count(Session::get('addons_events')) > 0) {
                    foreach (Session::get('addons_events') as $id) {
                        $query = DB::table('events')->where(['id' => $id])->first();
                        $events[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_activities') && count(Session::get('addons_activities')) > 0) {
                    foreach (Session::get('addons_activities') as $id) {
                        $query = DB::table('activities')->where(['id' => $id])->first();
                        $activities[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                $dates = explode(' - ', $request->dates);
                $date_from = $dates[0];
                $date_to = $dates[1];
                $booking_id = Crypt::decryptString($request->booking_id);
                $query = DB::table('foods')->where(['id' => $booking_id])->first();
                $title = $query->title;
                $pax = $query->pax;
                $rates = $query->rate;
                $total = $request->total_rates;
                $booking_type = $category;
                $description = json_encode([
                    'rooms' => !isset($rooms) ? [] : $rooms,
                    'cottages' => !isset($cottages) ? [] : $cottages,
                    'events' => !isset($events) ? [] : $events,
                    'activities' => !isset($activities) ? [] : $activities,
                    'title' => $title,
                    'pax' => $pax,
                    'from' => $date_from,
                    'to' => $date_to,
                    'rates' => $rates,
                    'counter' => $request->days_counter,
                    'total' => $total,
                    'partial' => $total
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
            } elseif ($category == 'Events') {

                if (Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
                    foreach (Session::get('addons_rooms') as $id) {

                        $query = DB::table('rooms')->select('rooms.*', 'categories.name as category_name')
                            ->join('categories', 'rooms.categories_id', '=', 'categories.id')
                            ->where(['rooms.id' => $id])
                            ->first();
                        $title = $query->category_name . ' ' . $query->title;
                        $rooms[] = [
                            'title' => $title,
                            'adults' => $query->adults,
                            'childrens' => $query->childrens,
                            'description' => $query->description
                        ];
                    }
                }

                if (Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
                    foreach (Session::get('addons_cottages') as $id) {
                        $query = DB::table('cottages')->select('cottages.*', 'categories.name as category_name')
                            ->join('categories', 'cottages.categories_id', '=', 'categories.id')
                            ->where(['cottages.id' => $id])
                            ->first();
                        if ($query->category_name == 'Nipa Hut') {
                            $cottage_title = $query->category_name . ' ' . $query->title;
                        } else {
                            $cottage_title = $query->title;
                        }
                        $cottages[] = [
                            'title' => $cottage_title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_foods') && count(Session::get('addons_foods')) > 0) {
                    foreach (Session::get('addons_foods') as $id) {
                        $query = DB::table('foods')->where(['id' => $id])->first();
                        $foods[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_activities') && count(Session::get('addons_activities')) > 0) {
                    foreach (Session::get('addons_activities') as $id) {
                        $query = DB::table('activities')->where(['id' => $id])->first();
                        $activities[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }


                $dates = explode(' - ', $request->dates);
                $date_from = $dates[0];
                $date_to = $dates[1];
                $booking_id = Crypt::decryptString($request->booking_id);
                $query = DB::table('events')->where(['id' => $booking_id])->first();
                $title = $query->title;
                $pax = $query->pax;
                $rates = $query->rate;
                $total = $request->total_rates;
                $booking_type = $category;
                $description = json_encode([
                    'rooms' => !isset($rooms) ? [] : $rooms,
                    'cottages' => !isset($cottages) ? [] : $cottages,
                    'foods' => !isset($foods) ? [] : $foods,
                    'activities' => !isset($activities) ? [] : $activities,
                    'title' => $title,
                    'pax' => $pax,
                    'from' => $date_from,
                    'to' => $date_to,
                    'rates' => $rates,
                    'counter' => $request->days_counter,
                    'total' => $total,
                    'partial' => $total
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
            } elseif ($category == 'Activities') {

                if (Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
                    foreach (Session::get('addons_rooms') as $id) {

                        $query = DB::table('rooms')->select('rooms.*', 'categories.name as category_name')
                            ->join('categories', 'rooms.categories_id', '=', 'categories.id')
                            ->where(['rooms.id' => $id])
                            ->first();
                        $title = $query->category_name . ' ' . $query->title;
                        $rooms[] = [
                            'title' => $title,
                            'adults' => $query->adults,
                            'childrens' => $query->childrens,
                            'description' => $query->description
                        ];
                    }
                }

                if (Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
                    foreach (Session::get('addons_cottages') as $id) {
                        $query = DB::table('cottages')->select('cottages.*', 'categories.name as category_name')
                            ->join('categories', 'cottages.categories_id', '=', 'categories.id')
                            ->where(['cottages.id' => $id])
                            ->first();
                        if ($query->category_name == 'Nipa Hut') {
                            $cottage_title = $query->category_name . ' ' . $query->title;
                        } else {
                            $cottage_title = $query->title;
                        }
                        $cottages[] = [
                            'title' => $cottage_title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_foods') && count(Session::get('addons_foods')) > 0) {
                    foreach (Session::get('addons_foods') as $id) {
                        $query = DB::table('foods')->where(['id' => $id])->first();
                        $foods[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_events') && count(Session::get('addons_events')) > 0) {
                    foreach (Session::get('addons_events') as $id) {
                        $query = DB::table('events')->where(['id' => $id])->first();
                        $events[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                $dates = explode(' - ', $request->dates);
                $date_from = $dates[0];
                $date_to = $dates[1];
                $booking_id = Crypt::decryptString($request->booking_id);
                $query = DB::table('activities')->where(['id' => $booking_id])->first();
                $title = $query->title;
                $pax = $query->pax;
                $rates = $query->rate;
                $total = $request->total_rates;
                $booking_type = $category;
                $description = json_encode([
                    'rooms' => !isset($rooms) ? [] : $rooms,
                    'cottages' => !isset($cottages) ? [] : $cottages,
                    'foods' => !isset($foods) ? [] : $foods,
                    'events' => !isset($events) ? [] : $events,
                    'title' => $title,
                    'pax' => $pax,
                    'from' => $date_from,
                    'to' => $date_to,
                    'rates' => $rates,
                    'counter' => $request->days_counter,
                    'total' => $total,
                    'partial' => $total
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

            $random_number = rand(10000000, 99999999);
            $reference = 'OT-' . (int)$this->generateRandomNumber();
            DB::table('reservations')->insert([
                'customer_id' => $customer_id,
                'description' => $description,
                'booking_type' => $booking_type,
                'booking_id' => $booking_id,
                'payment_type' => ($request->payment == 'otc' ? 'Over the Counter' : ''),
                'amount' => $total,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'reference' => $reference,
                'status' => 'Full',
                'booking_status' => 'Pending',
            ]);
            $user = DB::table('users')->where(['id' => Session::get('customer_id')])->first();
            $contact = $user->contact;
            $message = 'You have succesfully submited your reservation. Just wait for the admin to Approved your Reservation.';
            $apicode = 'ST-JOHND761571_M91HO';
            $passwd = 'jdlozano';
            $itexmo = $this->itexmo($contact, $message, $apicode, $passwd);

            return redirect('accounts/my-reservation')->with('message', 'You have succesfully submited your reservation. Just wait for the admin to Approved your Reservation.');
        } elseif ($payment_method == 'gcash') {
            if ($category == 'Rooms') {
                $dates = explode(' - ', $request->dates);
                $date_from = $dates[0];
                $date_to = $dates[1];
                $booking_id = Crypt::decryptString($request->booking_id);
                $query = DB::table('rooms')->where(['id' => $booking_id])->first();
                $title = $query->title;
                $adults = $query->adults;
                $childrens = $query->childrens;
                $rates = $query->rate;
                $booking_type = $category;
                $total = $request->total_rates;

                if (Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
                    foreach (Session::get('addons_cottages') as $id) {
                        $query = DB::table('cottages')->select('cottages.*', 'categories.name as category_name')
                            ->join('categories', 'cottages.categories_id', '=', 'categories.id')
                            ->where(['cottages.id' => $id])
                            ->first();
                        if ($query->category_name == 'Nipa Hut') {
                            $cottage_title = $query->category_name . ' ' . $query->title;
                        } else {
                            $cottage_title = $query->title;
                        }
                        $cottages[] = [
                            'title' => $cottage_title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_foods') && count(Session::get('addons_foods')) > 0) {
                    foreach (Session::get('addons_foods') as $id) {
                        $query = DB::table('foods')->where(['id' => $id])->first();
                        $foods[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_events') && count(Session::get('addons_events')) > 0) {
                    foreach (Session::get('addons_events') as $id) {
                        $query = DB::table('events')->where(['id' => $id])->first();
                        $events[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_activities') && count(Session::get('addons_activities')) > 0) {
                    foreach (Session::get('addons_activities') as $id) {
                        $query = DB::table('activities')->where(['id' => $id])->first();
                        $activities[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }


                $description = json_encode([
                    'cottages' => !isset($cottages) ? [] : $cottages,
                    'meals' => !isset($foods) ? [] : $foods,
                    'events' => !isset($events) ? [] : $events,
                    'activities' => !isset($activities) ? [] : $activities,
                    'title' => $title,
                    'adults' => $adults,
                    'childrens' => $childrens,
                    'from' => $date_from,
                    'to' => $date_to,
                    'rates' => $rates,
                    'counter' => $request->days_counter,
                    'total' => $total,
                    'partial' => $total / 2
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
            } elseif ($category == 'Cottages') {

                if (Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
                    foreach (Session::get('addons_rooms') as $id) {

                        $query = DB::table('rooms')->select('rooms.*', 'categories.name as category_name')
                            ->join('categories', 'rooms.categories_id', '=', 'categories.id')
                            ->where(['rooms.id' => $id])
                            ->first();
                        $title = $query->category_name . ' ' . $query->title;
                        $rooms[] = [
                            'title' => $title,
                            'adults' => $query->adults,
                            'childrens' => $query->childrens,
                            'description' => $query->description
                        ];
                    }
                }

                if (Session::has('addons_foods') && count(Session::get('addons_foods')) > 0) {
                    foreach (Session::get('addons_foods') as $id) {
                        $query = DB::table('foods')->where(['id' => $id])->first();
                        $foods[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_events') && count(Session::get('addons_events')) > 0) {
                    foreach (Session::get('addons_events') as $id) {
                        $query = DB::table('events')->where(['id' => $id])->first();
                        $events[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_activities') && count(Session::get('addons_activities')) > 0) {
                    foreach (Session::get('addons_activities') as $id) {
                        $query = DB::table('activities')->where(['id' => $id])->first();
                        $activities[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                $dates = explode(' - ', $request->dates);
                $date_from = $dates[0];
                $date_to = $dates[1];
                $booking_id = Crypt::decryptString($request->booking_id);
                $query = DB::table('cottages')->where(['id' => $booking_id])->first();
                $title = $query->title;
                $pax = $query->pax;
                $rates = $query->rate;
                $total = $request->total_rates;
                $booking_type = $category;
                $description = json_encode([
                    'rooms' => !isset($rooms) ? [] : $rooms,
                    'meals' => !isset($foods) ? [] : $foods,
                    'events' => !isset($events) ? [] : $events,
                    'activities' => !isset($activities) ? [] : $activities,
                    'title' => $title,
                    'pax' => $pax,
                    'from' => $date_from,
                    'to' => $date_to,
                    'rates' => $rates,
                    'counter' => $request->days_counter,
                    'total' => $total,
                    'partial' => $total / 2
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
            } elseif ($category == 'Foods') {

                if (Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
                    foreach (Session::get('addons_rooms') as $id) {

                        $query = DB::table('rooms')->select('rooms.*', 'categories.name as category_name')
                            ->join('categories', 'rooms.categories_id', '=', 'categories.id')
                            ->where(['rooms.id' => $id])
                            ->first();
                        $title = $query->category_name . ' ' . $query->title;
                        $rooms[] = [
                            'title' => $title,
                            'adults' => $query->adults,
                            'childrens' => $query->childrens,
                            'description' => $query->description
                        ];
                    }
                }

                if (Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
                    foreach (Session::get('addons_cottages') as $id) {
                        $query = DB::table('cottages')->select('cottages.*', 'categories.name as category_name')
                            ->join('categories', 'cottages.categories_id', '=', 'categories.id')
                            ->where(['cottages.id' => $id])
                            ->first();
                        if ($query->category_name == 'Nipa Hut') {
                            $cottage_title = $query->category_name . ' ' . $query->title;
                        } else {
                            $cottage_title = $query->title;
                        }
                        $cottages[] = [
                            'title' => $cottage_title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_events') && count(Session::get('addons_events')) > 0) {
                    foreach (Session::get('addons_events') as $id) {
                        $query = DB::table('events')->where(['id' => $id])->first();
                        $events[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_activities') && count(Session::get('addons_activities')) > 0) {
                    foreach (Session::get('addons_activities') as $id) {
                        $query = DB::table('activities')->where(['id' => $id])->first();
                        $activities[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                $dates = explode(' - ', $request->dates);
                $date_from = $dates[0];
                $date_to = $dates[1];
                $booking_id = Crypt::decryptString($request->booking_id);
                $query = DB::table('foods')->where(['id' => $booking_id])->first();
                $title = $query->title;
                $pax = $query->pax;
                $rates = $query->rate;
                $total = $request->total_rates;
                $booking_type = $category;
                $description = json_encode([
                    'rooms' => !isset($rooms) ? [] : $rooms,
                    'cottages' => !isset($cottages) ? [] : $cottages,
                    'events' => !isset($events) ? [] : $events,
                    'activities' => !isset($activities) ? [] : $activities,
                    'title' => $title,
                    'pax' => $pax,
                    'from' => $date_from,
                    'to' => $date_to,
                    'rates' => $rates,
                    'counter' => $request->days_counter,
                    'total' => $total,
                    'partial' => $total / 2
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
            } elseif ($category == 'Events') {

                if (Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
                    foreach (Session::get('addons_rooms') as $id) {

                        $query = DB::table('rooms')->select('rooms.*', 'categories.name as category_name')
                            ->join('categories', 'rooms.categories_id', '=', 'categories.id')
                            ->where(['rooms.id' => $id])
                            ->first();
                        $title = $query->category_name . ' ' . $query->title;
                        $rooms[] = [
                            'title' => $title,
                            'adults' => $query->adults,
                            'childrens' => $query->childrens,
                            'description' => $query->description
                        ];
                    }
                }

                if (Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
                    foreach (Session::get('addons_cottages') as $id) {
                        $query = DB::table('cottages')->select('cottages.*', 'categories.name as category_name')
                            ->join('categories', 'cottages.categories_id', '=', 'categories.id')
                            ->where(['cottages.id' => $id])
                            ->first();
                        if ($query->category_name == 'Nipa Hut') {
                            $cottage_title = $query->category_name . ' ' . $query->title;
                        } else {
                            $cottage_title = $query->title;
                        }
                        $cottages[] = [
                            'title' => $cottage_title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_foods') && count(Session::get('addons_foods')) > 0) {
                    foreach (Session::get('addons_foods') as $id) {
                        $query = DB::table('foods')->where(['id' => $id])->first();
                        $foods[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_activities') && count(Session::get('addons_activities')) > 0) {
                    foreach (Session::get('addons_activities') as $id) {
                        $query = DB::table('activities')->where(['id' => $id])->first();
                        $activities[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }


                $dates = explode(' - ', $request->dates);
                $date_from = $dates[0];
                $date_to = $dates[1];
                $booking_id = Crypt::decryptString($request->booking_id);
                $query = DB::table('events')->where(['id' => $booking_id])->first();
                $title = $query->title;
                $pax = $query->pax;
                $rates = $query->rate;
                $total = $request->total_rates;
                $booking_type = $category;
                $description = json_encode([
                    'rooms' => !isset($rooms) ? [] : $rooms,
                    'cottages' => !isset($cottages) ? [] : $cottages,
                    'foods' => !isset($foods) ? [] : $foods,
                    'activities' => !isset($activities) ? [] : $activities,
                    'title' => $title,
                    'pax' => $pax,
                    'from' => $date_from,
                    'to' => $date_to,
                    'rates' => $rates,
                    'counter' => $request->days_counter,
                    'total' => $total,
                    'partial' => $total / 2
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
            } elseif ($category == 'Activities') {

                if (Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
                    foreach (Session::get('addons_rooms') as $id) {

                        $query = DB::table('rooms')->select('rooms.*', 'categories.name as category_name')
                            ->join('categories', 'rooms.categories_id', '=', 'categories.id')
                            ->where(['rooms.id' => $id])
                            ->first();
                        $title = $query->category_name . ' ' . $query->title;
                        $rooms[] = [
                            'title' => $title,
                            'adults' => $query->adults,
                            'childrens' => $query->childrens,
                            'description' => $query->description
                        ];
                    }
                }

                if (Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
                    foreach (Session::get('addons_cottages') as $id) {
                        $query = DB::table('cottages')->select('cottages.*', 'categories.name as category_name')
                            ->join('categories', 'cottages.categories_id', '=', 'categories.id')
                            ->where(['cottages.id' => $id])
                            ->first();
                        if ($query->category_name == 'Nipa Hut') {
                            $cottage_title = $query->category_name . ' ' . $query->title;
                        } else {
                            $cottage_title = $query->title;
                        }
                        $cottages[] = [
                            'title' => $cottage_title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_foods') && count(Session::get('addons_foods')) > 0) {
                    foreach (Session::get('addons_foods') as $id) {
                        $query = DB::table('foods')->where(['id' => $id])->first();
                        $foods[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                if (Session::has('addons_events') && count(Session::get('addons_events')) > 0) {
                    foreach (Session::get('addons_events') as $id) {
                        $query = DB::table('events')->where(['id' => $id])->first();
                        $events[] = [
                            'title' => $query->title,
                            'pax' => $query->pax,
                            'rate' => $query->rate,
                        ];
                    }
                }

                $dates = explode(' - ', $request->dates);
                $date_from = $dates[0];
                $date_to = $dates[1];
                $booking_id = Crypt::decryptString($request->booking_id);
                $query = DB::table('activities')->where(['id' => $booking_id])->first();
                $title = $query->title;
                $pax = $query->pax;
                $rates = $query->rate;
                $total = $request->total_rates;
                $booking_type = $category;
                $description = json_encode([
                    'rooms' => !isset($rooms) ? [] : $rooms,
                    'cottages' => !isset($cottages) ? [] : $cottages,
                    'foods' => !isset($foods) ? [] : $foods,
                    'events' => !isset($events) ? [] : $events,
                    'title' => $title,
                    'pax' => $pax,
                    'from' => $date_from,
                    'to' => $date_to,
                    'rates' => $rates,
                    'counter' => $request->days_counter,
                    'total' => $total,
                    'partial' => $total / 2
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

            $gcashParams = [
                 'external_id' => 'demo_' . time(),
                 'amount' => $total,
                 'phone' => '081298498259',
                 'expiration_date' => '2100-02-20T00:00:00.000Z',
                 'callback_url' => 'https://my-shop.com/callbacks',
                 'redirect_url' => 'https://my-shop.com/home',
                 'ewallet_type' => 'GCASH'
            ];

            $createGcash = \Xendit\EWallets::create($gcashParams);

            $getGcash = \Xendit\EWallets::getPaymentStatus($gcashParams['external_id'], 'GCASH');

            $random_number = rand(10000000, 99999999);
            $reference = 'OT-' . (int)$this->generateRandomNumber();
            DB::table('reservations')->insert([
                'customer_id' => $customer_id,
                'description' => $description,
                'booking_type' => $booking_type,
                'booking_id' => $booking_id,
                'payment_type' => ($request->payment == 'otc' ? 'Over the Counter' : ''),
                'amount' => $total,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'reference' => $reference,
                'status' => 'Full',
                'booking_status' => 'Pending',
            ]);
            // $user = DB::table('users')->where(['id' => Session::get('customer_id')])->first();
            // $contact = $user->contact;
            // $message = 'You have succesfully submitted your reservation. Just wait for the admin to Approved your Reservation.';
            // $apicode = 'ST-JOHND761571_M91HO';
            // $passwd = 'jdlozano';
            // $itexmo = $this->itexmo($contact, $message, $apicode, $passwd);

            Xendit::setApiKey("xnd_development_6rfGXTylCcqc2omA216Rby6qs7X471GfmLdb4a6eObkfzklREcvHLAHFLt2saLq");

            $params = [
                "external_id" => "demo_147580196270",
                "payer_email" => "sample_email@xendit.co",
                "description" => $description,
                "amount" => $total,
            ];

            $createInvoice = \Xendit\Invoice::create($params);
        // print_r($createInvoice);

            $id = $createInvoice["id"];

            $getInvoice = \Xendit\Invoice::retrieve($id);
            //print_r($getInvoice['invoice_url']);
            return redirect($getInvoice['invoice_url']);
            //return redirect('accounts/my-reservation')->with('message', 'You have successfully reserved a room with reference code ' . $reference);
        }

        // if($category == 'Rooms') {
        //     $dates        = explode(' - ',$request->dates);
        //     $date_from    = $dates[0];
        //     $date_to      = $dates[1];
        //     $booking_id   = Crypt::decryptString($request->booking_id);
        //     $query        = DB::table('rooms')->where(['id' => $booking_id])->first();
        //     $title        = $query->title;
        //     $adults       = $query->adults;
        //     $childrens    = $query->childrens;
        //     $rates        = $query->rate;
        //     $booking_type = $category;
        //     $total        = $request->total_rates;

        //     if(Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
        //         foreach(Session::get('addons_cottages') as $id) {
        //             $query = DB::table('cottages')->select('cottages.*','categories.name as category_name')
        //             ->join('categories','cottages.categories_id', '=', 'categories.id')
        //             ->where(['cottages.id' => $id])
        //             ->first();
        //             if($query->category_name == 'Nipa Hut') {
        //                 $cottage_title = $query->category_name.' '.$query->title;
        //             } else {
        //                 $cottage_title = $query->title;
        //             }
        //             $cottages[] = [
        //                 'title' => $cottage_title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }

        //     if(Session::has('addons_foods')  && count(Session::get('addons_foods')) > 0) {
        //         foreach(Session::get('addons_foods') as $id) {
        //             $query = DB::table('foods')->where(['id' => $id])->first();
        //             $foods[] = [
        //                 'title' => $query->title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }

        //     if(Session::has('addons_events')  && count(Session::get('addons_events')) > 0) {
        //         foreach(Session::get('addons_events') as $id) {
        //             $query = DB::table('events')->where(['id' => $id])->first();
        //             $events[] = [
        //                 'title' => $query->title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }

        //     if(Session::has('addons_activities')  && count(Session::get('addons_activities')) > 0) {
        //         foreach(Session::get('addons_activities') as $id) {
        //             $query = DB::table('activities')->where(['id' => $id])->first();
        //             $activities[] = [
        //                 'title' => $query->title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }


        //     $description = json_encode([
        //         'cottages'   => !isset($cottages) ? [] : $cottages,
        //         'meals'      => !isset($foods) ? [] : $foods,
        //         'events'     => !isset($events) ? [] : $events,
        //         'activities' => !isset($activities) ? [] : $activities,
        //         'title'      => $title,
        //         'adults'     => $adults,
        //         'childrens'  => $childrens,
        //         'from'       => $date_from,
        //         'to'         => $date_to,
        //         'rates'      => $rates,
        //         'counter'    => $request->days_counter,
        //         'total'      => $total,
        //         'partial'    => $total / 2
        //     ]);

        //     Session::forget('addons_cottages');
        //     Session::forget('addons_foods');
        //     Session::forget('addons_events');
        //     Session::forget('addons_activities');
        //     Session::forget('total_events_rate');
        //     Session::forget('total_activities_rate');
        //     Session::forget('total_cottages_rate');
        //     Session::forget('total_foods_rate');
        //     Session::forget('total_rates');
        // } elseif($category == 'Cottages') {

        //     if(Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
        //         foreach(Session::get('addons_rooms') as $id) {

        //             $query = DB::table('rooms')->select('rooms.*','categories.name as category_name')
        //             ->join('categories','rooms.categories_id', '=', 'categories.id')
        //             ->where(['rooms.id' => $id])
        //             ->first();
        //             $title = $query->category_name.' '.$query->title;
        //             $rooms[] = [
        //                 'title'       => $title,
        //                 'adults'      => $query->adults,
        //                 'childrens'   => $query->childrens,
        //                 'description' => $query->description
        //             ];
        //         }
        //     }

        //     if(Session::has('addons_foods')  && count(Session::get('addons_foods')) > 0) {
        //         foreach(Session::get('addons_foods') as $id) {
        //             $query = DB::table('foods')->where(['id' => $id])->first();
        //             $foods[] = [
        //                 'title' => $query->title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }

        //     if(Session::has('addons_events')  && count(Session::get('addons_events')) > 0) {
        //         foreach(Session::get('addons_events') as $id) {
        //             $query = DB::table('events')->where(['id' => $id])->first();
        //             $events[] = [
        //                 'title' => $query->title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }

        //     if(Session::has('addons_activities')  && count(Session::get('addons_activities')) > 0) {
        //         foreach(Session::get('addons_activities') as $id) {
        //             $query = DB::table('activities')->where(['id' => $id])->first();
        //             $activities[] = [
        //                 'title' => $query->title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }

        //     $dates        = explode(' - ',$request->dates);
        //     $date_from    = $dates[0];
        //     $date_to      = $dates[1];
        //     $booking_id   = Crypt::decryptString($request->booking_id);
        //     $query        = DB::table('cottages')->where(['id' => $booking_id])->first();
        //     $title        = $query->title;
        //     $pax          = $query->pax;
        //     $rates        = $query->rate;
        //     $total        = $request->total_rates;
        //     $booking_type = $category;
        //     $description = json_encode([
        //         'rooms'      => !isset($rooms) ? [] : $rooms,
        //         'meals'      => !isset($foods) ? [] : $foods,
        //         'events'     => !isset($events) ? [] : $events,
        //         'activities' => !isset($activities) ? [] : $activities,
        //         'title'      => $title,
        //         'pax'        => $pax,
        //         'from'       => $date_from,
        //         'to'         => $date_to,
        //         'rates'      => $rates,
        //         'counter'    => $request->days_counter,
        //         'total'      => $total,
        //         'partial'    => $total / 2
        //     ]);

        //     Session::forget('addons_rooms');
        //     Session::forget('addons_foods');
        //     Session::forget('addons_events');
        //     Session::forget('addons_activities');
        //     Session::forget('total_rooms_rate');
        //     Session::forget('total_foods_rate');
        //     Session::forget('total_events_rate');
        //     Session::forget('total_activities_rate');
        //     Session::forget('total_rates');
        // } elseif($category == 'Foods') {

        //     if(Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
        //         foreach(Session::get('addons_rooms') as $id) {

        //             $query = DB::table('rooms')->select('rooms.*','categories.name as category_name')
        //             ->join('categories','rooms.categories_id', '=', 'categories.id')
        //             ->where(['rooms.id' => $id])
        //             ->first();
        //             $title = $query->category_name.' '.$query->title;
        //             $rooms[] = [
        //                 'title'       => $title,
        //                 'adults'      => $query->adults,
        //                 'childrens'   => $query->childrens,
        //                 'description' => $query->description
        //             ];
        //         }
        //     }

        //     if(Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
        //         foreach(Session::get('addons_cottages') as $id) {
        //             $query = DB::table('cottages')->select('cottages.*','categories.name as category_name')
        //             ->join('categories','cottages.categories_id', '=', 'categories.id')
        //             ->where(['cottages.id' => $id])
        //             ->first();
        //             if($query->category_name == 'Nipa Hut') {
        //                 $cottage_title = $query->category_name.' '.$query->title;
        //             } else {
        //                 $cottage_title = $query->title;
        //             }
        //             $cottages[] = [
        //                 'title' => $cottage_title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }

        //     if(Session::has('addons_events')  && count(Session::get('addons_events')) > 0) {
        //         foreach(Session::get('addons_events') as $id) {
        //             $query = DB::table('events')->where(['id' => $id])->first();
        //             $events[] = [
        //                 'title' => $query->title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }

        //     if(Session::has('addons_activities')  && count(Session::get('addons_activities')) > 0) {
        //         foreach(Session::get('addons_activities') as $id) {
        //             $query = DB::table('activities')->where(['id' => $id])->first();
        //             $activities[] = [
        //                 'title' => $query->title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }

        //     $dates        = explode(' - ',$request->dates);
        //     $date_from    = $dates[0];
        //     $date_to      = $dates[1];
        //     $booking_id   = Crypt::decryptString($request->booking_id);
        //     $query        = DB::table('foods')->where(['id' => $booking_id])->first();
        //     $title        = $query->title;
        //     $pax          = $query->pax;
        //     $rates        = $query->rate;
        //     $total        = $request->total_rates;
        //     $booking_type = $category;
        //     $description = json_encode([
        //         'rooms'      => !isset($rooms) ? [] : $rooms,
        //         'cottages'   => !isset($cottages) ? [] : $cottages,
        //         'events'     => !isset($events) ? [] : $events,
        //         'activities' => !isset($activities) ? [] : $activities,
        //         'title'      => $title,
        //         'pax'        => $pax,
        //         'from'       => $date_from,
        //         'to'         => $date_to,
        //         'rates'      => $rates,
        //         'counter'    => $request->days_counter,
        //         'total'      => $total,
        //         'partial'    => $total / 2
        //     ]);

        //     Session::forget('addons_rooms');
        //     Session::forget('addons_cottages');
        //     Session::forget('addons_events');
        //     Session::forget('addons_activities');
        //     Session::forget('total_rooms_rate');
        //     Session::forget('total_cottages_rate');
        //     Session::forget('total_events_rate');
        //     Session::forget('total_activities_rate');
        //     Session::forget('total_rates');
        // } elseif($category == 'Events') {

        //     if(Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
        //         foreach(Session::get('addons_rooms') as $id) {

        //             $query = DB::table('rooms')->select('rooms.*','categories.name as category_name')
        //             ->join('categories','rooms.categories_id', '=', 'categories.id')
        //             ->where(['rooms.id' => $id])
        //             ->first();
        //             $title = $query->category_name.' '.$query->title;
        //             $rooms[] = [
        //                 'title'       => $title,
        //                 'adults'      => $query->adults,
        //                 'childrens'   => $query->childrens,
        //                 'description' => $query->description
        //             ];
        //         }
        //     }

        //     if(Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
        //         foreach(Session::get('addons_cottages') as $id) {
        //             $query = DB::table('cottages')->select('cottages.*','categories.name as category_name')
        //             ->join('categories','cottages.categories_id', '=', 'categories.id')
        //             ->where(['cottages.id' => $id])
        //             ->first();
        //             if($query->category_name == 'Nipa Hut') {
        //                 $cottage_title = $query->category_name.' '.$query->title;
        //             } else {
        //                 $cottage_title = $query->title;
        //             }
        //             $cottages[] = [
        //                 'title' => $cottage_title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }

        //     if(Session::has('addons_foods')  && count(Session::get('addons_foods')) > 0) {
        //         foreach(Session::get('addons_foods') as $id) {
        //             $query = DB::table('foods')->where(['id' => $id])->first();
        //             $foods[] = [
        //                 'title' => $query->title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }

        //     if(Session::has('addons_activities')  && count(Session::get('addons_activities')) > 0) {
        //         foreach(Session::get('addons_activities') as $id) {
        //             $query = DB::table('activities')->where(['id' => $id])->first();
        //             $activities[] = [
        //                 'title' => $query->title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }


        //     $dates        = explode(' - ',$request->dates);
        //     $date_from    = $dates[0];
        //     $date_to      = $dates[1];
        //     $booking_id   = Crypt::decryptString($request->booking_id);
        //     $query        = DB::table('events')->where(['id' => $booking_id])->first();
        //     $title        = $query->title;
        //     $pax          = $query->pax;
        //     $rates        = $query->rate;
        //     $total        = $request->total_rates;
        //     $booking_type = $category;
        //     $description = json_encode([
        //         'rooms'      => !isset($rooms) ? [] : $rooms,
        //         'cottages'   => !isset($cottages) ? [] : $cottages,
        //         'foods'      => !isset($foods) ? [] : $foods,
        //         'activities' => !isset($activities) ? [] : $activities,
        //         'title'      => $title,
        //         'pax'        => $pax,
        //         'from'       => $date_from,
        //         'to'         => $date_to,
        //         'rates'      => $rates,
        //         'counter'    => $request->days_counter,
        //         'total'      => $total,
        //         'partial'    => $total / 2
        //     ]);

        //     Session::forget('addons_rooms');
        //     Session::forget('addons_cottages');
        //     Session::forget('addons_foods');
        //     Session::forget('addons_activities');
        //     Session::forget('total_rooms_rate');
        //     Session::forget('total_cottages_rate');
        //     Session::forget('total_foods_rate');
        //     Session::forget('total_activities_rate');
        //     Session::forget('total_rates');
        // } elseif($category == 'Activities') {

        //     if(Session::has('addons_rooms') && count(Session::get('addons_rooms')) > 0) {
        //         foreach(Session::get('addons_rooms') as $id) {

        //             $query = DB::table('rooms')->select('rooms.*','categories.name as category_name')
        //             ->join('categories','rooms.categories_id', '=', 'categories.id')
        //             ->where(['rooms.id' => $id])
        //             ->first();
        //             $title = $query->category_name.' '.$query->title;
        //             $rooms[] = [
        //                 'title'       => $title,
        //                 'adults'      => $query->adults,
        //                 'childrens'   => $query->childrens,
        //                 'description' => $query->description
        //             ];
        //         }
        //     }

        //     if(Session::has('addons_cottages') && count(Session::get('addons_cottages')) > 0) {
        //         foreach(Session::get('addons_cottages') as $id) {
        //             $query = DB::table('cottages')->select('cottages.*','categories.name as category_name')
        //             ->join('categories','cottages.categories_id', '=', 'categories.id')
        //             ->where(['cottages.id' => $id])
        //             ->first();
        //             if($query->category_name == 'Nipa Hut') {
        //                 $cottage_title = $query->category_name.' '.$query->title;
        //             } else {
        //                 $cottage_title = $query->title;
        //             }
        //             $cottages[] = [
        //                 'title' => $cottage_title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }

        //     if(Session::has('addons_foods')  && count(Session::get('addons_foods')) > 0) {
        //         foreach(Session::get('addons_foods') as $id) {
        //             $query = DB::table('foods')->where(['id' => $id])->first();
        //             $foods[] = [
        //                 'title' => $query->title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }

        //     if(Session::has('addons_events')  && count(Session::get('addons_events')) > 0) {
        //         foreach(Session::get('addons_events') as $id) {
        //             $query = DB::table('events')->where(['id' => $id])->first();
        //             $events[] = [
        //                 'title' => $query->title,
        //                 'pax'   => $query->pax,
        //             ];
        //         }
        //     }

        //     $dates        = explode(' - ',$request->dates);
        //     $date_from    = $dates[0];
        //     $date_to      = $dates[1];
        //     $booking_id   = Crypt::decryptString($request->booking_id);
        //     $query        = DB::table('activities')->where(['id' => $booking_id])->first();
        //     $title        = $query->title;
        //     $pax          = $query->pax;
        //     $rates        = $query->rate;
        //     $total        = $request->total_rates;
        //     $booking_type = $category;
        //     $description = json_encode([
        //         'rooms'      => !isset($rooms) ? [] : $rooms,
        //         'cottages'   => !isset($cottages) ? [] : $cottages,
        //         'foods'      => !isset($foods) ? [] : $foods,
        //         'events'     => !isset($events) ? [] : $events,
        //         'title'      => $title,
        //         'pax'        => $pax,
        //         'from'       => $date_from,
        //         'to'         => $date_to,
        //         'rates'      => $rates,
        //         'counter'    => $request->days_counter,
        //         'total'      => $total,
        //         'partial'    => $total / 2
        //     ]);

        //     Session::forget('addons_rooms');
        //     Session::forget('addons_cottages');
        //     Session::forget('addons_foods');
        //     Session::forget('addons_events');
        //     Session::forget('total_rooms_rate');
        //     Session::forget('total_cottages_rate');
        //     Session::forget('total_foods_rate');
        //     Session::forget('total_events_rate');
        //     Session::forget('total_rates');
        // }

        // $payment_type = 'GCASH';

        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        // CURLOPT_URL => 'https://g.payx.ph/payment_request',
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => 'POST',
        // CURLOPT_POSTFIELDS => array(
        //         'x-public-key' => 'pk_61f42753a6d00f4d0537fe118cb969c1',
        //         'amount' => $total / 2,
        //         'description' => 'Room reservation ('.$title.') from '.$date_from.' to '.$date_to
        //     ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
        // $data = json_decode($response);
        // if(isset($data->success) && $data->success == 1) {
        //     $reference = $data->data->code;
        //     DB::table('reservations')->insert([
        //         'customer_id'    => $customer_id,
        //         'description'    => $description,
        //         'booking_type'   => $booking_type,
        //         'booking_id'     => $booking_id,
        //         'payment_type'   => $payment_type,
        //         'amount'         => $total / 2,
        //         'date_from'      => $date_from,
        //         'date_to'        => $date_to,
        //         'reference'      => $reference,
        //         'status'         => 'Partial',
        //         'booking_status' => 'Pending',
        //     ]);
        //     $user    = DB::table('users')->where(['id' => Session::get('customer_id')])->first();
        //     $contact = $user->contact;
        //     $message = 'Your reservation in Santorenz Bay Resort has been successful with reference code '.$reference.'. Thank you for using our website.';
        //     $apicode = 'ST-JOHND761571_M91HO';
        //     $passwd  = 'jdlozano';
        //     $itexmo  = $this->itexmo($contact,$message,$apicode,$passwd);
        // } else {
        //     return redirect('accounts/my-reservation')->with('message',$data->error);
        // }
        // return redirect('accounts/my-reservation')->with('message','You have successfully reserved a room with reference code '.$reference);
    }

    public function itexmo($contact, $message, $apicode, $passwd)
    {
        $url = 'https://api.itexmo.com/api/broadcast';
        $request = [
            'Email' => 'lozanojohndavid@gmail.com',
            'Password' => $passwd,
            'ApiCode' => $apicode,
            'Recipients' => [$contact],
            'Message' => $message,
        ];
        return http::post($url, $request);
    }

    public function generateRandomNumber()
    {
        $random = "";
        $length = 8;
        // srand((double) microtime() * 1000000);

        $data = "123456123456789071234567890890";


        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }

        return $random;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function result(Request $request)
    {
        $title = 'Rooms';
        $types = Crypt::decryptString($request->type);
        if ($types == 'All') {
            $query = DB::table('rooms')
                ->select('rooms.*', 'categories.name as category_name')
                ->join('categories', 'rooms.categories_id', '=', 'categories.id')->where('adults', '>=', $request->adults)->where('childrens', '>=', $request->childrens)->get();
        } else {
            $query = DB::table('rooms')
                ->select('rooms.*', 'categories.name as category_name')
                ->join('categories', 'rooms.categories_id', '=', 'categories.id')
                ->where('adults', '>=', $request->adults)
                ->where('childrens', '>=', $request->childrens)
                ->where('categories_id', '=', $types)
                ->get();
        }

        $records = [
            'dates' => $request->dates,
            'days' => $request->days,
        ];
        return view('services.result', compact('title', 'query', 'records'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function test()
    {
        $pw = Crypt::encryptString('SantorenzBayResort');

        return $pw;
    }
}
