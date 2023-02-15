<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Encryption\DecryptException;
class AdminRoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = 'Rooms';
        $rooms = DB::table('rooms')->select('rooms.*','rooms_services.rooms_id','rooms_services.services','categories.name as category_name')
        ->join('rooms_services','rooms_services.rooms_id', '=', 'rooms.id')
        ->join('categories','categories.id', '=', 'rooms.categories_id')->get();
        return view('admin.rooms.rooms',compact('title','rooms'));
    }

    public function rooms_details($id)
    {
        $rooms_id = Crypt::decryptString($id);
        $rooms = DB::table('rooms')->select('rooms.*','rooms_services.rooms_id','rooms_services.services','categories.name as category_name')
        ->join('rooms_services','rooms_services.rooms_id', '=', 'rooms.id')
        ->join('categories','categories.id', '=', 'rooms.categories_id')
        ->where(['rooms.id' => $rooms_id])->first();
        $title = $rooms->title;
        $category = DB::table('categories')->where(['category' => 'Rooms'])->get();
        $gallery  = DB::table('rooms_galleries')->where(['rooms_id' => $rooms_id])->get();
        return view('admin.rooms.rooms-details',compact('title','rooms','category','gallery'));
    }

    public function delete_room_gallery($id) {
        $gallery_id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            DB::table('rooms_galleries')->where(['id' => $gallery_id])->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return back()->with('message','Image has been deleted');
    }

    public function store_gallery(Request $request) {
        $rooms_id = Crypt::decryptString($request->rooms_id);
        DB::beginTransaction();
        try {
            foreach($request->file('rooms_gallery') as $data) {
                $image = $data->store('/');
                $path="assets/images/rooms/".$image;
                Image::make($data)->save($path,10,"jpg");
                DB::table('rooms_galleries')->insert(['rooms_id' => $rooms_id, 'gallery' => $image]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


        return back()->with('message','New image has been uploaded to room\'s gallery');

    }

    public function store_rooms(Request $request) {
        $validated = $request->validate([
            'categories_id' => 'bail|required',
            'title'         => 'bail|required',
            'services'      => 'bail|required',
            'description'   => 'bail|required',
            'rate'          => 'bail|required|numeric',
            'adults'        => 'bail|required|numeric',
            'childrens'     => 'bail|required|numeric',
            'is_featured'   => 'bail|required|numeric',
            'is_comments'   => 'bail|required|numeric',
        ]);

        $categories_id = Crypt::decryptString($request->categories_id);

        if(empty($request->file('featured_image'))) {
            DB::beginTransaction();
            try {
                $rooms_id = DB::table('rooms')->insert(['categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'adults' => $request->adults, 'childrens' => $request->childrens, 'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::table('rooms_services')->insert(['rooms_id' => $rooms_id,'services' => $request->services]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }

        } else {
            DB::beginTransaction();
            try {
                $image = $request->file('featured_image')->store('/');
                $path="assets/images/rooms/".$image;
                Image::make($request->file('featured_image'))->save($path,10,"jpg");
                $rooms_id = DB::table('rooms')->insert(['image' => $image,'categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'adults' => $request->adults, 'childrens' => $request->childrens, 'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::table('rooms_services')->insert(['rooms_id' => $rooms_id,'services' => $request->services]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }


        }

        return redirect('admin/rooms/create')->with('message','New room has been added');
    }

    public function delete_rooms($id) {
        $rooms_id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            DB::table('rooms_services')->where(['rooms_id' => $rooms_id])->delete();
            DB::table('rooms_galleries')->where(['rooms_id' => $rooms_id])->delete();
            DB::table('rooms')->where(['id' => $rooms_id])->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect('admin/rooms/create')->with('message','Room has been deleted');
    }
    public function update_rooms(Request $request, $id) {

        $validated = $request->validate([
            'categories_id' => 'bail|required',
            'services'      => 'bail|required',
            'description'   => 'bail|required',
            'rate'          => 'bail|required|numeric',
            'adults'        => 'bail|required|numeric',
            'childrens'     => 'bail|required|numeric',
            'is_featured'   => 'bail|required|numeric',
            'is_comments'   => 'bail|required|numeric',
        ]);

        $rooms_id      = Crypt::decryptString($id);
        $categories_id = Crypt::decryptString($request->categories_id);

        if(empty($request->file('featured_image'))) {
            DB::beginTransaction();
            try {
                DB::table('rooms')->where(['id' => $rooms_id])->update(['categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'adults' => $request->adults, 'childrens' => $request->childrens, 'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::table('rooms_services')->where(['rooms_id' => $rooms_id])->update(['services' => $request->services]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }

        } else {
            DB::beginTransaction();
            try {
                $image = $request->file('featured_image')->store('/');
                $path="assets/images/rooms/".$image;
                Image::make($request->file('featured_image'))->save($path,10,"jpg");
                DB::table('rooms_services')->where(['rooms_id' => $rooms_id])->update(['services' => $request->services]);
                DB::table('rooms')->where(['id' => $rooms_id])->update(['image' => $image,'categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'adults' => $request->adults, 'childrens' => $request->childrens, 'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }

        }
        return back()->with('message','Room has been updated');

    }

    public function create_rooms() {
        $title = 'Create Rooms';
        $category = DB::table('categories')->where(['category' => 'Rooms'])->get();
        return view('admin.rooms.create-rooms',compact('title','category'));
    }

    public function category()
    {
        //
        $title      = 'Category';
        $categories = DB::table('categories')->where(['category' => 'Rooms'])->get();
        return view('admin.rooms.category',compact('title','categories'));
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
            DB::table('categories')->where(['id' => Crypt::decryptString($request->rooms_id)])->update(['name' => $request->name]);
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
