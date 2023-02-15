<?php

use Illuminate\Database\Seeder;
use App\inventories;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $array = [
            [
                'categories_id' => 28,
                'sku'           => 'S2022A1011',
                'name'          => 'Bioderm',
                'description'   => '99.9% germs free',
                'price'         => 50,
                'stocks'        => 5000
            ],[
                'categories_id' => 28,
                'sku'           => 'S2022A1012',
                'name'          => 'Safeguard',
                'description'   => '99.9% germs free',
                'price'         => 50,
                'stocks'        => 5000
            ],[
                'categories_id' => 28,
                'sku'           => 'S2022A1010',
                'name'          => 'Hotel Bath Soap',
                'description'   => 'No Description',
                'price'         => 5,
                'stocks'        => 5000
            ]
        ];

        foreach($array as $key => $value) {
            inventories::create(['categories_id' => $value['categories_id'],'sku' => $value['sku'], 'name' => $value['name'],'description' => $value['description'],'price' => $value['price'],'stocks' => $value['stocks']]);
        }
    }
}
