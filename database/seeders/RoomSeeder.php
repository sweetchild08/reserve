<?php

use Illuminate\Database\Seeder;
use App\rooms;
class RoomSeeder extends Seeder
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
                'categories_id' => 1,
                'title'         => 'Single Bed',
                'description'   => 'Not Available',
                'rate'          => 1000,
                'adults'        => 2,
                'childrens'     => 0,
                'is_featured'   => 1
            ],
            [
                'image'         => 'default.jpg',
                'categories_id' => 1,
                'title'         => 'Single Bed B',
                'description'   => 'Not Available',
                'rate'          => 1000,
                'adults'        => 2,
                'childrens'     => 0,
                'is_featured'   => 1
            ],
            [
                'image'         => 'default.jpg',
                'categories_id' => 1,
                'title'         => 'Single Bed C',
                'description'   => 'Not Available',
                'rate'          => 1000,
                'adults'        => 2,
                'childrens'     => 0,
                'is_featured'   => 1
            ],
            [
                'image'         => 'default.jpg',
                'categories_id' => 2,
                'title'         => 'Double Bed',
                'description'   => 'Not Available',
                'rate'          => 1700,
                'adults'        => 2,
                'childrens'     => 2,
                'is_featured'   => 1
            ],
            [
                'image'         => 'default.jpg',
                'categories_id' => 2,
                'title'         => 'Double Bed B',
                'description'   => 'Not Available',
                'rate'          => 1800,
                'adults'        => 2,
                'childrens'     => 2,
                'is_featured'   => 1
            ],
            [
                'image'         => 'default.jpg',
                'categories_id' => 2,
                'title'         => 'Double Bed',
                'description'   => 'Not Available C',
                'rate'          => 1750,
                'adults'        => 2,
                'childrens'     => 2,
                'is_featured'   => 1
            ],
            [
                'image'         => 'default.jpg',
                'categories_id' => 3,
                'title'         => 'Deluxe Suite',
                'description'   => 'Not Available',
                'rate'          => 3000,
                'adults'        => 3,
                'childrens'     => 4,
                'is_featured'   => 1
            ],
            [
                'image'         => 'default.jpg',
                'categories_id' => 3,
                'title'         => 'Deluxe Suite B',
                'description'   => 'Not Available',
                'rate'          => 3100,
                'adults'        => 3,
                'childrens'     => 4,
                'is_featured'   => 1
            ],
            [
                'image'         => 'default.jpg',
                'categories_id' => 3,
                'title'         => 'Deluxe Suite C',
                'description'   => 'Not Available',
                'rate'          => 3200,
                'adults'        => 3,
                'childrens'     => 4,
                'is_featured'   => 1
            ]
        ];

        foreach($data as $key => $value) {
            rooms::create(['image' => $value['image'],'categories_id' => $value['categories_id'],'title' => $value['title'],'description' => $value['description'],'rate' => $value['rate'],'adults' => $value['adults'],'childrens' => $value['childrens'],'is_featured' => $value['is_featured']]);
        }
    }
}
