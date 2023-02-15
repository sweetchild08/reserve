<?php

use Illuminate\Database\Seeder;
use App\foods;
use App\foodsGalleries;

class FoodGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $query = foods::all();
        foreach($query as $data) {
            for($i=1;$i<=5;$i++) {
                foodsGalleries::create(['foods_id' => $data->id,'gallery' => 'default.jpg']);
            }
        }
    }
}
