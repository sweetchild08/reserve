<?php

namespace App\Http\Controllers;

use App\Bundles;
use App\Prods;
use App\ProdsCategory;
use App\Stocks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Session;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Encryption\DecryptException;
class AdministratorInventoryController extends Controller
{
    public function index()
    {
        $title = 'Inventory';
        $inventories = DB::table('inventories')->select('inventories.*','categories.name as category_name')
        ->join('categories','categories.id', '=', 'inventories.categories_id')->get();
        $categories = DB::table('categories')->where(['category' => 'Product'])->get();
        return view('admin.inventory.inventory',compact('title','inventories','categories'));
    }
    public function products()
    {
        $title = 'Products';
        $types=['consumable','reusable'];
        $categories =ProdsCategory::all();
        $products= Prods::all();
        return view('admin.inventory.products',compact('title','products','categories','types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'bail|required',
            'description'   => 'bail|required',
            'prods_category_id' => 'bail|numeric|required',
            'type'         => 'bail|string|required',
            'sku'           => 'bail|required|unique:App\prods,sku'
        ]);
        $prod=Prods::create($request->all());
        return back()->with('message','Product Added Successfully');
    }

    public function update(Request $request,$id)
    {
        $prod=Prods::findOrFail(Crypt::decrypt($id));
        $request->validate([
            'name'          => 'bail|required',
            'description'   => 'bail|required',
            'prods_category_id' => 'bail|numeric|required',
            'type'         => 'bail|string|required',
            'sku'           => [
                'required',
                Rule::unique('prods')->ignore($prod->id),
            ]
        ]);
        $prod->update($request->all());
        return back()->with('message','Product Updated Successfully');
    }

    public function destroy($id)
    {
        $prod=Prods::findOrFail(Crypt::decrypt($id));
        // if(Prods::where('prods_category_id',$cat->id)->get())
        //     return back()->with('error','Product Category Deleting Failed. Product Category was in use');
        $prod->delete();
        return back()->with('message','Product Deleted Successfully');
    }


    public function category()
    {
        $title = 'Product Categories';
        $categories =ProdsCategory::all();
        return view('admin.inventory.category1',compact('title','categories'));
    }
    public function category_store(Request $request)
    {
        $request->validate([
            'category_name'     => 'bail|required',
            'description' => 'bail|required',
        ]);
        ProdsCategory::create($request->all());
        return back()->with('message','Product Category Added Successfully');
    }

    public function category_update(Request $request,$id)
    {
        $request->validate([
            'category_name'     => 'bail|required',
            'description' => 'bail|required',
        ]);
        $cat=ProdsCategory::findOrFail(Crypt::decrypt($id));
        $cat->update($request->all());
        return back()->with('message','Product Category Updated Successfully');
    }
    
    public function category_destroy($id)
    {
        $cat=ProdsCategory::findOrFail(Crypt::decrypt($id));
        // if(Prods::where('prods_category_id',$cat->id)->get())
        //     return back()->with('error','Product Category Deleting Failed. Product Category was in use');
        $cat->delete();
        return back()->with('message','Product Category Deleted Successfully');
    }

    public function stocks()
    {
        $title = 'Stocks';
        $stocks =Stocks::join('prods','stocks.prod_id','prods.id')->join('prods_categories','prods.prods_category_id','prods_categories.id')
            ->select([
                'prods.name','prods.sku','prods.description','prods_categories.category_name','prods.type','stocks.quantity','stocks.price_per_unit'
            ])->selectRaw('sum(stocks.quantity) as tstocks, sum(stocks.price_per_unit)*sum(stocks.quantity) as tprice')
            ->groupBy(
                'prods.name'
            )
            ->get();
        $prods=Prods::all();
        return view('admin.inventory.Stocks',compact('title','stocks','prods'));
    }
    public function stocks_store(Request $request)
    {
        $request->validate([
            'prod_id'     => 'bail|required|numeric',
            'quantity' => 'bail|required|numeric',
            'price_per_unit'=>'required|numeric'
        ]);
        Stocks::create($request->all());
        return back()->with('message','Product Stocks Added Successfully');
    }
     
    public function deployments()
    {
        $title = 'Deployments';
       
        $prods=Prods::all();
        $bundles=Bundles::all();
        // dd($bundles);
        return view('admin.inventory.deployments',compact('title','bundles','prods'));
    }
    public function bundles_store(Request $request)
    {
        $request->validate([
            "name" => ['required','string'],
            "description" => ['required','string'],
            // "prod_id.*" => [],
            // "quantity.*" => [],
            "notes" => ['required','string']
        ]);
        $pivot=[];
        for($i=0;$i<sizeof($request->prod_id);$i++){
            if($request->prod_id[$i]&&$request->quantity[$i])
                array_push($pivot,['prod_id'=>$request->prod_id[$i],'quantity'=>$request->quantity[$i]]);
        }
        $bundle=Bundles::create($request->all());
        $bundle->products()->sync($pivot);
        return back()->with('message','Bundle Added Successfully');
    }
    
    public function bundles_update(Request $request,$id)
    {
        $bundle=Bundles::findOrFail(Crypt::decrypt($id));
        $request->validate([
            "name" => ['required','string'],
            "description" => ['required','string'],
            // "prod_id.*" => [],
            // "quantity.*" => [],
            "notes" => ['required','string']
        ]);
        $pivot=[];
        for($i=0;$i<sizeof($request->prod_id);$i++){
            if($request->prod_id[$i]&&$request->quantity[$i])
                array_push($pivot,['prod_id'=>$request->prod_id[$i],'quantity'=>$request->quantity[$i]]);
        }
        $bundle->update($request->all());
        $bundle->products()->sync($pivot);
        return back()->with('message','Bundle Updated Successfully');
    }
     
    public function bundles_update_modal($id)
    {
        $bundle=Bundles::findOrFail(Crypt::decrypt($id));
        $prods=Prods::all();
        return view('admin.inventory.parts.updatemodal',compact('bundle','prods'));
    }
    
    public function bundles_deploy_modal($id)
    {
        $bundle=Bundles::findOrFail(Crypt::decrypt($id));
        $prods=Prods::all();
        return view('admin.inventory.parts.deploy',compact('bundle','prods'));
    }
    public function bundles_deploy($id)
    {
        $bundle=Bundles::findOrFail(Crypt::decrypt($id));
        foreach($bundle->products as $prod){
            Stocks::create([
                'prod_id'=>$prod->id,
                'quantity'=>-($prod->pivot->quantity),
                'price_per_unit'=>10,
                'triger'=>'deployed '.$bundle->name
            ]);
        }
        return back()->with('message','Bundle was deployed');
    }
    public function deploy(Request $request)
    {
        Stocks::create([
            'prod_id'=>$request->prod_id,
            'quantity'=>-($request->quantity),
            'price_per_unit'=>10,
            'triger'=>'deployed manually'
        ]);
        return back()->with('message','Product Deployed Successfully');
    }
    public function return(Request $request)
    {
        $arr=[];
        for($i=0;$i<sizeof($request->prod_id);$i++){
            if($request->prod_id[$i]&&$request->quantity[$i])
                array_push($arr,['prod_id'=>$request->prod_id[$i],'quantity'=>$request->quantity[$i]]);
        }
        foreach ($arr as $val) {
            Stocks::create([
                'prod_id'=>$val['prod_id'],
                'quantity'=>$val['quantity'],
                'price_per_unit'=>10,
                'triger'=>'returned'
            ]);
        }
        
        return back()->with('message','Product Deployed Successfully');
    }
    public function bundles_destroy($id)
    {
        $cat=Bundles::findOrFail(Crypt::decrypt($id));
        // if(Prods::where('prods_category_id',$cat->id)->get())
        //     return back()->with('error','Product Category Deleting Failed. Product Category was in use');
        $cat->delete();
        return back()->with('message','Bundle Deleted Successfully');
    }
}
