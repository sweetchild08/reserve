<?php

use Illuminate\Database\Seeder;
use App\categories;
class CategoriesSeeder extends Seeder
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
                'name' => 'Single Room', //1
                'category' => 'Rooms',
            ],
            [
                'name' => 'Double Room',//2
                'category' => 'Rooms',
            ],
            [
                'name' => 'Deluxe Room',//3
                'category' => 'Rooms',
            ],
            [
                'name' => 'Nipa Hut', // 4
                'category' => 'Cottages',
            ],
            [
                'name' => 'Umbrella Shed', //5 
                'category' => 'Cottages',
            ],
            [
                'name' => 'Yellow Train', //6 
                'category' => 'Cottages',
            ],
            [
                'name' => 'Cage', //7
                'category' => 'Cottages',
            ],
            [
                'name' => 'Tegula', //8 
                'category' => 'Cottages',
            ],
            [
                'name' => 'Pergola', //9
                'category' => 'Cottages',
            ],
            [
                'name' => 'Pinoy Hut', //10
                'category' => 'Cottages',
            ],
            [
                'name' => 'Gazebo', //11
                'category' => 'Cottages',
            ],
            [
                'name' => 'Roof Deck', //12
                'category' => 'Cottages',
            ],
            [
                'name' => 'Filipino Cuisine', //13
                'category' => 'Foods',
            ],
            [
                'name' => 'Noodle Dishes', //14
                'category' => 'Foods',
            ],
            [
                'name' => 'Birthday Package A', //15
                'category' => 'Events',
            ],
            [
                'name' => 'Birthday Package B', //16
                'category' => 'Events',
            ],
            [
                'name' => 'Birthday Package C', //17
                'category' => 'Events',
            ],
            [
                'name' => 'Wedding Package A', //18
                'category' => 'Events',
            ],
            [
                'name' => 'Wedding Package B', //19
                'category' => 'Events',
            ],
            [
                'name' => 'Wedding Package C', //20
                'category' => 'Events',
            ],
            [
                'name' => 'Anniversary Package A', //21
                'category' => 'Events',
            ],
            [
                'name' => 'Anniversary Package B', //22
                'category' => 'Events',
            ],
            [
                'name' => 'Anniversary Package C', //23
                'category' => 'Events',
            ],
            [
                'name' => 'Outing', //24
                'category' => 'Activities',
            ],
            [
                'name' => 'Kayaking', //25
                'category' => 'Activities',
            ],
            [
                'name' => 'Sight Seeing', //26
                'category' => 'Activities',
            ],
            [
                'name' => 'Team Building', //27
                'category' => 'Activities',
            ],
            [
                'name' => 'Soap', //28
                'category' => 'Product',
            ],
            [
                'name' => 'Shampoo', //29
                'category' => 'Product',
            ],
            [
                'name' => 'Conditioner', //30
                'category' => 'Product',
            ]
            
        ];
        foreach($array as $key => $value) {
            categories::create([
                'name'     => $value['name'],
                'category' => $value['category'],
            ]);
        }
    }
}
