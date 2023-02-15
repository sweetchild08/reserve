<?php

use Illuminate\Database\Seeder;
use App\foods;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data = [
            [
                'image'         => 'default.jpg',
                'categories_id' => 13,
                'title'         => 'Pancit Bihon',
                'description'   => 'Not Available',
                'rate'          => 350,
                'pax'           => 8,
                'is_featured'   => 1
            ],
            [
                'image'         => 'default.jpg',
                'categories_id' => 14,
                'title'         => 'Adobong Baboy',
                'description'   => 'Not Available',
                'rate'          => 120,
                'pax'           => 2,
                'is_featured'   => 1
            ],
            [
                'image'         => 'default.jpg',
                'categories_id' => 14,
                'title'         => 'Tinolang Manok',
                'description'   => 'Not Available',
                'rate'          => 120,
                'pax'           => 2,
                'is_featured'   => 1
            ],
            [
                'image'         => 'default.jpg',
                'categories_id' => 14,
                'title'         => 'Beaf Steak',
                'description'   => 'Not Available',
                'rate'          => 180,
                'pax'           => 2,
                'is_featured'   => 0
            ]
        ];

        foreach($data as $key => $value) {
            foods::create(['image' => $value['image'],'categories_id' => $value['categories_id'],'title' => $value['title'],'description' => $value['description'],'rate' => $value['rate'],'pax' => $value['pax'],'is_featured' => $value['is_featured']]);
        }

    }
}
