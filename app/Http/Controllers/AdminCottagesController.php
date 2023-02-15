<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Encryption\DecryptException;

class AdminCottagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = 'Cottages';
        $cottages = DB::table('cottages')->select('cottages.*','categories.name as category_name')
        ->join('categories','categories.id', '=', 'cottages.categories_id')->get();
        return view('admin.cottages.cottages',compact('title','cottages'));
    }

    public function category()
    {
        //
        $title = 'Category';
        $categories = DB::table('categories')->where(['category' => 'Cottages'])->get();
        return view('admin.cottages.category',compact('title','categories'));
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
            return back()->with('message','New category has been added');
        } catch (\Exception $e) {
            DB::rollback();
        }
        
    }

    public function update_category(Request $request) {
        $validated = $request->validate([
            'name' => 'bail|required',
        ]);

        DB::beginTransaction();
        try {
            DB::table('categories')->where(['id' => Crypt::decryptString($request->rooms_id)])->update(['name' => $request->name]);
            DB::commit();
            return back()->with('message','Category has been updated');
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function delete_category($id) {
        DB::beginTransaction();
        try {
            $query = DB::table('categories')->where(['id' => Crypt::decryptString($id)])->delete();
            DB::commit();
            return back()->with('message','Category has been deleted');
        } catch (\Exception $e) {
            DB::rollback();
        }
    }


    public function create_cottages() {
        $title = 'Create Cottages';
        $category = DB::table('categories')->where(['category' => 'Cottages'])->get();
        return view('admin.cottages.create-cottages',compact('title','category'));
    }

    public function cottages_details($id)
    {
        $cottages_id = Crypt::decryptString($id);
        $cottages = DB::table('cottages')->select('cottages.*','categories.name as category_name')
        ->join('categories','categories.id', '=', 'cottages.categories_id')
        ->where(['cottages.id' => $cottages_id])->first();
        $title = $cottages->title;
        $category = DB::table('categories')->where(['category' => 'Cottages'])->get();
        $gallery  = DB::table('cottages_galleries')->where(['cottages_id' => $cottages_id])->get();
        return view('admin.cottages.cottages-details',compact('title','cottages','category','gallery'));
    }



    public function delete_cottages_gallery($id) {
        $gallery_id = Crypt::decryptString($id);
        DB::beginTransaction();
        try {
            DB::table('cottages_galleries')->where(['id' => $gallery_id])->delete();
            DB::commit();
            return back()->with('message','Image has been deleted');
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function store_gallery(Request $request) {
        $cottages_id = Crypt::decryptString($request->cottages_id);

        DB::beginTransaction();
        try {
            foreach($request->file('cottages_gallery') as $data) {
                $image = $data->store('/');
                $path="assets/images/cottages/".$image;
                Image::make($data)->save($path,10,"jpg");
                DB::table('cottages_galleries')->insert(['cottages_id' => $cottages_id, 'gallery' => $image]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return back()->with('message','New image has been uploaded to cottages\' gallery');
        
    }

    public function store_cottages(Request $request) {
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
                $rooms_id = DB::table('cottages')->insert(['categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax, 'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        } else {
            DB::beginTransaction();
            try {
                $image = $request->file('featured_image')->store('/');
                $path="assets/images/cottages/".$image;
                Image::make($request->file('featured_image'))->save($path,10,"jpg");
                $rooms_id = DB::table('cottages')->insert(['image' => $image,'categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax,'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        }

        return redirect('admin/cottages/create')->with('message','New cottages has been added');
    }

    public function delete_cottages($id) {
        $cottages_id = Crypt::decryptString($id);
        DB::table('cottages_galleries')->where(['cottages_id' => $cottages_id])->delete();
        DB::table('cottages')->where(['id' => $cottages_id])->delete();
        return redirect('admin/cottages/create')->with('message','Cottage has been deleted');
    }
    public function update_cottages(Request $request, $id) {
       
        $validated = $request->validate([
            'categories_id' => 'bail|required',
            'title'         => 'bail|required',
            'description'   => 'bail|required',
            'pax'           => 'bail|required|numeric',
            'rate'          => 'bail|required|numeric',
            'is_featured'   => 'bail|required|numeric',
            'is_comments'   => 'bail|required|numeric',
        ]);

        $cottages_id      = Crypt::decryptString($id);
        $categories_id = Crypt::decryptString($request->categories_id);

        if(empty($request->file('featured_image'))) {
            DB::beginTransaction();
            try {
                DB::table('cottages')->where(['id' => $cottages_id])->update(['categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax,'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        } else {
            DB::beginTransaction();
            try {
                $image = $request->file('featured_image')->store('/');
                $path="assets/images/cottages/".$image;
                Image::make($request->file('featured_image'))->save($path,10,"jpg");
                DB::table('cottages')->where(['id' => $cottages_id])->update(['image' => $image,'categories_id' => $categories_id,'title' => $request->title,'description' => $request->description, 'rate' => $request->rate, 'pax' => $request->pax, 'is_featured' => $request->is_featured,'is_comments' => $request->is_comments]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
            }
        }
        return back()->with('message','Cottage has been updated');

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
