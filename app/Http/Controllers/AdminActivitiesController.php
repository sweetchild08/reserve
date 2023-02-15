<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Encryption\DecryptException;

class AdminActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = 'Activities';
        $activities = DB::table('activities')->select('activities.*','categories.name as category_name')
        ->join('categories','categories.id', '=', 'activities.categories_id')->get();
        return view('admin.activities.activities',compact('title','activities'));
    }

    public function category()
    {
        //
        $title = 'Category';
        $categories = DB::table('categories')->where(['category' => 'Activities'])->get();
        return view('admin.activities.category',compact('title','categories'));
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
            DB::table('categories')->where(['id' => Crypt::decryptString($request->activities_id)])->update(['name' => $request->name]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('message','An error occured');
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
            return back()->with('message','An error occured');
        }
        return back()->with('message','Category has been deleted');
    }


    public function create_activities() {
        $title = 'Create Activities';
        $category = DB::table('categories')->where(['category' => 'Activities'])->get();
        return view('admin.activities.create-activities',compact('title','category'));
    }

    public function activities_details($id)
    {
        $activities_id = Crypt::decryptString($id);
        $activities    = DB::table('activities')->select('activities.*','categories.name as category_name')
        ->join('categories','categories.id', '=', 'activities.categories_id')
        ->where(['activities.id' => $activities_id])->first();
        $title    = $activities->title;
        $category = DB::table('categories')->where(['category' => 'Activities'])->get();
        $gallery  = DB::table('activities_galleries')->where(['activities_id' => $activities_id])->get();
        return view('admin.activities.activities-details',compact('title','activities','category','gallery'));
    }



    public function delete_activities_gallery($id) {
        $gallery_id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            DB::table('activities_galleries')->where(['id' => $gallery_id])->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('message','An error occured');
        }
        return back()->with('message','Image has been deleted');
    }

    public function store_gallery(Request $request) {
        $activities_id = Crypt::decryptString($request->activities_id);
        DB::beginTransaction();
        try {
            foreach($request->file('activities_gallery') as $data) {
                $image = $data->store('/');
                $path="assets/images/activities/".$image;
                Image::make($data)->save($path,10,"jpg");
                DB::table('activities_galleries')->insert(['activities_id' => $activities_id, 'gallery' => $image]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('message','An error occured');
        }
        return back()->with('message','New image has been uploaded to events\' gallery');
        
    }

    public function store_activities(Request $request) {
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
                DB::table('activities')->insert(['categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax, 'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('message','An error occured');
            }
        } else {
            DB::beginTransaction();
            try {
                $image = $request->file('featured_image')->store('/');
                $path="assets/images/activities/".$image;
                Image::make($request->file('featured_image'))->save($path,10,"jpg");
                DB::table('activities')->insert(['image' => $image,'categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax,'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('message','An error occured');
            }
            
        }

        return redirect('admin/activities/create')->with('message','New activities has been added');
    }

    public function delete_activities($id) {
        $activities_id = Crypt::decryptString($id);
        DB::table('activities_galleries')->where(['activities_id' => $activities_id])->delete();
        DB::table('activities')->where(['id' => $activities_id])->delete();
        return redirect('admin/activities/create')->with('message','Activities has been deleted');
    }

    public function update_activities(Request $request, $id) {
       
        $validated = $request->validate([
            'categories_id' => 'bail|required',
            'title'         => 'bail|required',
            'description'   => 'bail|required',
            'pax'           => 'bail|required|numeric',
            'rate'          => 'bail|required|numeric',
            'is_featured'   => 'bail|required|numeric',
            'is_comments'   => 'bail|required|numeric',
        ]);

        $activities_id      = Crypt::decryptString($id);
        $categories_id = Crypt::decryptString($request->categories_id);

        if(empty($request->file('featured_image'))) {
            DB::beginTransaction();
            try {
                DB::table('activities')->where(['id' => $activities_id])->update(['categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax,'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('message','An error occured');
            }
        } else {
            DB::beginTransaction();
            try {
                $image = $request->file('featured_image')->store('/');
                $path="assets/images/activities/".$image;
                Image::make($request->file('featured_image'))->save($path,10,"jpg");
                DB::table('activities')->where(['id' => $activities_id])->update(['image' => $image,'categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax, 'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('message','An error occured');
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
