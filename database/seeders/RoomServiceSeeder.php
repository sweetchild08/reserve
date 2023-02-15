<?php

use Illuminate\Database\Seeder;
use App\rooms;
use App\rooms_services;
class RoomServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $query = rooms::all();
        foreach($query as $data) {
            $services = 'services 1, services 2, services 3, services 4, services 5, services 6, services 7, services 8, services 9, services 10';
            rooms_services::create(['rooms_id' => $data->id,'services' => $services]);
        }
    }
}
