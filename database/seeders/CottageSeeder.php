<?php

use Illuminate\Database\Seeder;
use App\cottages;

class CottageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=1;$i<=10;$i++) { 
            cottages::create(['image' => 'default.jpg','categories_id' => 4,'title' => 'No. '.$i, 'description' => 'Not Available', 'pax' => 6, 'rate' => '700', 'is_featured' => 0]);
        }
        
        cottages::create(['image' => 'default.jpg','categories_id' => 5,'title' => 'Umbrella Shed', 'description' => 'Not Available', 'pax' => 4, 'rate' => '500', 'is_featured' => 0]);
        cottages::create(['image' => 'default.jpg','categories_id' => 6,'title' => 'Yellow Train', 'description' => 'Not Available', 'pax' => 6, 'rate' => '600', 'is_featured' => 0]);
        cottages::create(['image' => 'default.jpg','categories_id' => 7,'title' => 'Cage', 'description' => 'Not Available', 'pax' => 8, 'rate' => '1000', 'is_featured' => 0]);
        cottages::create(['image' => 'default.jpg','categories_id' => 8,'title' => 'Tegula', 'description' => 'Not Available', 'pax' => 8, 'rate' => '1500', 'is_featured' => 0]);
        cottages::create(['image' => 'default.jpg','categories_id' => 9,'title' => 'Pergola', 'description' => 'Not Available', 'pax' => 20, 'rate' => '3500', 'is_featured' => 1]);
        cottages::create(['image' => 'default.jpg','categories_id' => 10,'title' => 'Pinoy Hut', 'description' => 'Not Available', 'pax' => 15, 'rate' => '1500', 'is_featured' => 1]);
        cottages::create(['image' => 'default.jpg','categories_id' => 11,'title' => 'Gazebo', 'description' => 'Not Available', 'pax' => 20, 'rate' => '3000', 'is_featured' => 1]);
        cottages::create(['image' => 'default.jpg','categories_id' => 12,'title' => 'Roof Deck', 'description' => 'Not Available', 'pax' => 25, 'rate' => '3500', 'is_featured' => 1]);
    }
}
