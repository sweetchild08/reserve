<?php

use Illuminate\Database\Seeder;
use App\cottages_gallery;
class CottageGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $query = DB::table('cottages')->get();
        foreach($query as $data) {
            for($i=1;$i<=5;$i++) {
                cottages_gallery::create(['cottages_id' => $data->id, 'gallery' => 'default.jpg']);
            }
        }

    }
}
