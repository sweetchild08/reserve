<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriesSeeder::class);
        // $this->call(RegionSeeder::class);
        // $this->call(ProvinceSeeder::class);
        // $this->call(CitySeeder::class);
        // $this->call(BarangaySeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(RoomGallerySeeder::class);
        $this->call(RoomServiceSeeder::class);
        $this->call(CottageSeeder::class);
        $this->call(CottageGallerySeeder::class);
        $this->call(FoodSeeder::class);
        $this->call(FoodGallerySeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(ActivitySeeder::class);
        $this->call(EventSeeder::class);
        $this->call(ActivityGallerySeeder::class);
        $this->call(EventGallerySeeder::class);
        $this->call(InventorySeeder::class);
    }
}
