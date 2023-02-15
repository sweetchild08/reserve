<?php

use Illuminate\Database\Seeder;
use App\rooms_gallery;
use App\rooms;

class RoomGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $query = rooms::all();
        foreach($query as $data) {
            for($i=1;$i<=5;$i++) {
                rooms_gallery::create(['rooms_id' => $data->id,'gallery' => 'default.jpg']);
            }
        }
    }
}
