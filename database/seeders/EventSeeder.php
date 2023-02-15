<?php

use Illuminate\Database\Seeder;
use App\events;
class EventSeeder extends Seeder
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
            events::create(['image' => 'default.jpg','categories_id' => 15,'title' => 'Birthday No. '.$i, 'description' => 'Not Available', 'pax' => 30, 'rate' => '1000', 'is_featured' => $is_featued]);
        }

        for($i=1;$i<=6;$i++) { 
            $is_featued = $i == 6 ? 1 : 0;
            events::create(['image' => 'default.jpg','categories_id' => 16,'title' => 'Birthday No. '.$i, 'description' => 'Not Available', 'pax' => 35, 'rate' => '1000', 'is_featured' => $is_featued]);
        }

        for($i=1;$i<=6;$i++) { 
            $is_featued = $i == 6 ? 1 : 0;
            events::create(['image' => 'default.jpg','categories_id' => 17,'title' => 'Birthday No. '.$i, 'description' => 'Not Available', 'pax' => 40, 'rate' => '1000', 'is_featured' => $is_featued]);
        }

        for($i=1;$i<=6;$i++) { 
            $is_featued = $i == 6 ? 1 : 0;
            events::create(['image' => 'default.jpg','categories_id' => 18,'title' => 'Wedding No. '.$i, 'description' => 'Not Available', 'pax' => 30, 'rate' => '1000', 'is_featured' => $is_featued]);
        }

        for($i=1;$i<=6;$i++) { 
            $is_featued = $i == 6 ? 1 : 0;
            events::create(['image' => 'default.jpg','categories_id' => 19,'title' => 'Wedding No. '.$i, 'description' => 'Not Available', 'pax' => 35, 'rate' => '1000', 'is_featured' => $is_featued]);
        }

        for($i=1;$i<=6;$i++) { 
            $is_featued = $i == 6 ? 1 : 0;
            events::create(['image' => 'default.jpg','categories_id' => 20,'title' => 'Wedding No. '.$i, 'description' => 'Not Available', 'pax' => 40, 'rate' => '1000', 'is_featured' => $is_featued]);
        }

        for($i=1;$i<=6;$i++) { 
            $is_featued = $i == 6 ? 1 : 0;
            events::create(['image' => 'default.jpg','categories_id' => 21,'title' => 'Anniversary No. '.$i, 'description' => 'Not Available', 'pax' => 30, 'rate' => '1000', 'is_featured' => $is_featued]);
        }

        for($i=1;$i<=6;$i++) { 
            $is_featued = $i == 6 ? 1 : 0;
            events::create(['image' => 'default.jpg','categories_id' => 22,'title' => 'Anniversary No. '.$i, 'description' => 'Not Available', 'pax' => 35, 'rate' => '1000', 'is_featured' => $is_featued]);
        }

        for($i=1;$i<=6;$i++) { 
            $is_featued = $i == 6 ? 1 : 0;
            events::create(['image' => 'default.jpg','categories_id' => 23,'title' => 'Anniversary No. '.$i, 'description' => 'Not Available', 'pax' => 40, 'rate' => '1000', 'is_featured' => $is_featued]);
        }
    }
}
