<?php

use Illuminate\Database\Seeder;
use App\activities;
class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=1;$i<=6;$i++) { 
            $is_featued = $i == 6 ? 1 : 0;
            activities::create(['image' => 'default.jpg','categories_id' => 24,'title' => 'Outing No. '.$i, 'description' => 'Not Available', 'pax' => 30, 'rate' => '1000', 'is_featured' => $is_featued]);
        }

        for($i=1;$i<=6;$i++) { 
            $is_featued = $i == 6 ? 1 : 0;
            activities::create(['image' => 'default.jpg','categories_id' => 25,'title' => 'Kayaking No. '.$i, 'description' => 'Not Available', 'pax' => 35, 'rate' => '1000', 'is_featured' => $is_featued]);
        }

        for($i=1;$i<=6;$i++) { 
            $is_featued = $i == 6 ? 1 : 0;
            activities::create(['image' => 'default.jpg','categories_id' => 26,'title' => 'Sight Seeing No. '.$i, 'description' => 'Not Available', 'pax' => 10, 'rate' => '1000', 'is_featured' => $is_featued]);
        }

        for($i=1;$i<=6;$i++) { 
            $is_featued = $i == 6 ? 1 : 0;
            activities::create(['image' => 'default.jpg','categories_id' => 27,'title' => 'Team Building No. '.$i, 'description' => 'Not Available', 'pax' => 20, 'rate' => '1000', 'is_featured' => $is_featued]);
        }
    }
}
