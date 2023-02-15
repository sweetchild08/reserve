<?php

use Illuminate\Database\Seeder;
use App\events;
use App\events_gallery;
class EventGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $query = events::all();
        foreach($query as $data) {
            for($i=1;$i<=5;$i++) {
                events_gallery::create(['events_id' => $data->id,'gallery' => 'default.jpg']);
            }
        }
    }
}
