<?php

use Illuminate\Database\Seeder;
use App\activities;
use App\activities_gallery;
class ActivityGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $query = activities::all();
        foreach($query as $data) {
            for($i=1;$i<=5;$i++) {
                activities_gallery::create(['activities_id' => $data->id,'gallery' => 'default.jpg']);
            }
        }
    }
}
