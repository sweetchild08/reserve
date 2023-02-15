<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Encryption\DecryptException;

class AdminFoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = 'Foods';
        $foods = DB::table('foods')->select('foods.*','categories.name as category_name')
        ->join('categories','categories.id', '=', 'foods.categories_id')->get();
        return view('admin.foods.foods',compact('title','foods'));
    }

    public function category()
    {
        //
        $title = 'Category';
        $categories = DB::table('categories')->where(['category' => 'Foods'])->get();
        return view('admin.foods.category',compact('title','categories'));
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
            DB::table('categories')->where(['id' => Crypt::decryptString($request->foods_id)])->update(['name' => $request->name]);
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


    public function create_foods() {
        $title = 'Create Foods';
        $category = DB::table('categories')->where(['category' => 'Foods'])->get();
        return view('admin.foods.create-foods',compact('title','category'));
    }

    public function foods_details($id)
    {
        $foods_id = Crypt::decryptString($id);
        $foods = DB::table('foods')->select('foods.*','categories.name as category_name')
        ->join('categories','categories.id', '=', 'foods.categories_id')
        ->where(['foods.id' => $foods_id])->first();
        $title = $foods->title;
        $category = DB::table('categories')->where(['category' => 'Foods'])->get();
        $gallery  = DB::table('foods_galleries')->where(['foods_id' => $foods_id])->get();
        return view('admin.foods.foods-details',compact('title','foods','category','gallery'));
    }



    public function delete_foods_gallery($id) {
        $gallery_id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            DB::table('foods_galleries')->where(['id' => $gallery_id])->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return back()->with('message','Image has been deleted');
    }

    public function store_gallery(Request $request) {
        $foods_id = Crypt::decryptString($request->foods_id);
        DB::beginTransaction();
        try {
            foreach($request->file('foods_gallery') as $data) {
                $image = $data->store('/');
                $path="assets/images/foods/".$image;
                Image::make($data)->save($path,10,"jpg");
                DB::table('foods_galleries')->insert(['foods_id' => $foods_id, 'gallery' => $image]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return back()->with('message','New image has been uploaded to foods\' gallery');
        
    }

    public function store_foods(Request $request) {
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
                $foods_id = DB::table('foods')->insert(['categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax, 'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        } else {
            DB::beginTransaction();
            try {
                $image = $request->file('featured_image')->store('/');
                $path="assets/images/foods/".$image;
                Image::make($request->file('featured_image'))->save($path,10,"jpg");
                $foods = DB::table('foods')->insert(['image' => $image,'categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax,'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
            
        }

        return redirect('admin/foods/create')->with('message','New foods has been added');
    }

    public function delete_foods($id) {
        $foods_id = Crypt::decryptString($id);
        DB::table('foods_galleries')->where(['foods_id' => $foods_id])->delete();
        DB::table('foods')->where(['id' => $foods_id])->delete();
        return redirect('admin/foods/create')->with('message','Foods has been deleted');
    }
    public function update_foods(Request $request, $id) {
       
        $validated = $request->validate([
            'categories_id' => 'bail|required',
            'title'         => 'bail|required',
            'description'   => 'bail|required',
            'pax'           => 'bail|required|numeric',
            'rate'          => 'bail|required|numeric',
            'is_featured'   => 'bail|required|numeric',
            'is_comments'   => 'bail|required|numeric',
        ]);

        $foods_id      = Crypt::decryptString($id);
        $categories_id = Crypt::decryptString($request->categories_id);

        if(empty($request->file('featured_image'))) {
            DB::beginTransaction();
            try {
                DB::table('foods')->where(['id' => $foods_id])->update(['categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax,'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        } else {
            DB::beginTransaction();
            try {
                $image = $request->file('featured_image')->store('/');
                $path="assets/images/foods/".$image;
                Image::make($request->file('featured_image'))->save($path,10,"jpg");
                DB::table('foods')->where(['id' => $foods_id])->update(['image' => $image,'categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax, 'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        }
        return back()->with('message','Foods has been updated');

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
