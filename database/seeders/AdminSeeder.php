<?php

// namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->truncate();
        DB::table('users')->insert([
            'surname'       => 'Resort',
            'firstname'     => 'Santorenz Bay',
            'middlename'    => '',
            'province'      => 'Oriental Mindoro',
            'city'          => 'Calapan City',
            'barangay'      => 'Parang',
            'address'       => 'Purok 2',
            'email'         => 'santorenzbayresort2022@gmail.com',
            'contact'       => '09123456789',
            'username'      => 'santorenz',
            'password'      => Hash::make('pass'),
            'is_active'     => 1,
            'recovery_code' => 364415,
            'roles'         => 0,
        ]);
    }
}
