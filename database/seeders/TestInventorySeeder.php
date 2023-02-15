<?php

namespace Database\Seeders;

use App\Prods;
use App\ProdsCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProdsCategory::create(['id'=>1,'category_name'=>'cat 1','description'=>'desc 1']);
        ProdsCategory::create(['id'=>2,'category_name'=>'cat 2','description'=>'desc 2']);
        ProdsCategory::create(['id'=>3,'category_name'=>'cat 3','description'=>'desc 3']);
        ProdsCategory::create(['id'=>4,'category_name'=>'cat 4','description'=>'desc 4']);
        Prods::create([
            'id'=>1,
            'name'=>'name 1',
            'description'=>'desc 1',
            'prods_category_id'=>1,
            'type'=>'consumable',
            'sku'=>rand(0,999999)
        ]);
        Prods::create([
            'id'=>2,
            'name'=>'name 2',
            'description'=>'desc 2',
            'prods_category_id'=>2,
            'type'=>'consumable',
            'sku'=>rand(0,999999)
        ]);
        Prods::create([
            'id'=>3,
            'name'=>'name 3',
            'description'=>'desc 3',
            'prods_category_id'=>3,
            'type'=>'consumable',
            'sku'=>rand(0,999999)
        ]);
        Prods::create([
            'id'=>4,
            'name'=>'name 4',
            'description'=>'desc 4',
            'prods_category_id'=>4,
            'type'=>'consumable',
            'sku'=>rand(0,999999)
        ]);
    }
}
