<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Encryption\DecryptException;


class AdminEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = 'Events';
        $events = DB::table('events')->select('events.*','categories.name as category_name')
        ->join('categories','categories.id', '=', 'events.categories_id')->get();
        return view('admin.events.events',compact('title','events'));
    }

    public function category()
    {
        //
        $title = 'Category';
        $categories = DB::table('categories')->where(['category' => 'Events'])->get();
        return view('admin.events.category',compact('title','categories'));
    }

    public function store_category(Request $request) {
        $validated = $request->validate([
            'name' => 'bail|required',
            'category' => 'bail|required',
        ]);

        DB::beginTransaction();
        try {
            DB::table('categories')->insert(['name' => $request->name,'category' => $request->category]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return back()->with('message','New category has been added');
    }

    public function update_category(Request $request) {
        $validated = $request->validate([
            'name' => 'bail|required',
        ]);

        DB::beginTransaction();
        try {
            DB::table('categories')->where(['id' => Crypt::decryptString($request->events_id)])->update(['name' => $request->name]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return back()->with('message','Category has been updated');
    }

    public function delete_category($id) {
        DB::beginTransaction();
        try {
            $query = DB::table('categories')->where(['id' => Crypt::decryptString($id)])->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return back()->with('message','Category has been deleted');
    }


    public function create_events() {
        $title = 'Create Events';
        $category = DB::table('categories')->where(['category' => 'Events'])->get();
        return view('admin.events.create-events',compact('title','category'));
    }

    public function events_details($id)
    {
        $events_id = Crypt::decryptString($id);
        $events    = DB::table('events')->select('events.*','categories.name as category_name')
        ->join('categories','categories.id', '=', 'events.categories_id')
        ->where(['events.id' => $events_id])->first();
        $title    = $events->title;
        $category = DB::table('categories')->where(['category' => 'Events'])->get();
        $gallery  = DB::table('events_galleries')->where(['events_id' => $events_id])->get();
        return view('admin.events.events-details',compact('title','events','category','gallery'));
    }



    public function delete_events_gallery($id) {
        $gallery_id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            DB::table('events_galleries')->where(['id' => $gallery_id])->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return back()->with('message','Image has been deleted');
    }

    public function store_gallery(Request $request) {
        $events_id = Crypt::decryptString($request->events_id);
        DB::beginTransaction();
        try {
            foreach($request->file('events_gallery') as $data) {
                $image = $data->store('/');
                $path="assets/images/events/".$image;
                Image::make($data)->save($path,10,"jpg");
                DB::table('events_galleries')->insert(['events_id' => $events_id, 'gallery' => $image]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return back()->with('message','New image has been uploaded to events\' gallery');
        
    }

    public function store_events(Request $request) {
        $validated = $request->validate([
            'categories_id' => 'bail|required',
            'title'         => 'bail|required',
            'description'   => 'bail|required',
            'pax'           => 'bail|required|numeric',
            'rate'          => 'bail|required|numeric',
            'is_featured'   => 'bail|required|numeric',
            'is_comments'   => 'bail|required|numeric',
        ]);

        $categories_id = Crypt::decryptString($request->categories_id);

        if(empty($request->file('featured_image'))) {
            DB::beginTransaction();
            try {
                $events_id = DB::table('events')->insert(['categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax, 'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        } else {
            DB::beginTransaction();
            try {
                $image = $request->file('featured_image')->store('/');
                $path="assets/images/events/".$image;
                Image::make($request->file('featured_image'))->save($path,10,"jpg");
                $events = DB::table('events')->insert(['image' => $image,'categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax,'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
            
        }

        return redirect('admin/events/create')->with('message','New events has been added');
    }

    public function delete_events($id) {
        $events_id = Crypt::decryptString($id);
        DB::table('events_galleries')->where(['events_id' => $events_id])->delete();
        DB::table('events')->where(['id' => $events_id])->delete();
        return redirect('admin/events/create')->with('message','Events has been deleted');
    }

    public function update_events(Request $request, $id) {
       
        $validated = $request->validate([
            'categories_id' => 'bail|required',
            'title'         => 'bail|required',
            'description'   => 'bail|required',
            'pax'           => 'bail|required|numeric',
            'rate'          => 'bail|required|numeric',
            'is_featured'   => 'bail|required|numeric',
            'is_comments'   => 'bail|required|numeric',
        ]);

        $events_id      = Crypt::decryptString($id);
        $categories_id = Crypt::decryptString($request->categories_id);

        if(empty($request->file('featured_image'))) {
            DB::beginTransaction();
            try {
                DB::table('events')->where(['id' => $events_id])->update(['categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax,'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        } else {
            DB::beginTransaction();
            try {
                $image = $request->file('featured_image')->store('/');
                $path="assets/images/events/".$image;
                Image::make($request->file('featured_image'))->save($path,10,"jpg");
                DB::table('events')->where(['id' => $events_id])->update(['image' => $image,'categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax, 'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        }
        return back()->with('message','Events has been updated');

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
