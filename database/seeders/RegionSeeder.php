<?php

use Illuminate\Database\Seeder;
use App\regions;
class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $array = 
        [
          'RECORDS' => [
            0 => [
              'id' => 1,
              'psgcCode' => '010000000',
              'regDesc' => 'REGION I (ILOCOS REGION)',
              'regCode' => '01',
            ],
            1 => [
              'id' => 2,
              'psgcCode' => '020000000',
              'regDesc' => 'REGION II (CAGAYAN VALLEY)',
              'regCode' => '02',
            ],
            2 => [
              'id' => 3,
              'psgcCode' => '030000000',
              'regDesc' => 'REGION III (CENTRAL LUZON)',
              'regCode' => '03',
            ],
            3 => [
              'id' => 4,
              'psgcCode' => '040000000',
              'regDesc' => 'REGION IV-A (CALABARZON)',
              'regCode' => '04',
            ],
            4 => [
              'id' => 5,
              'psgcCode' => '170000000',
              'regDesc' => 'REGION IV-B (MIMAROPA)',
              'regCode' => '17',
            ],
            5 => [
              'id' => 6,
              'psgcCode' => '050000000',
              'regDesc' => 'REGION V (BICOL REGION)',
              'regCode' => '05',
            ],
            6 => [
              'id' => 7,
              'psgcCode' => '060000000',
              'regDesc' => 'REGION VI (WESTERN VISAYAS)',
              'regCode' => '06',
            ],
            7 => [
              'id' => 8,
              'psgcCode' => '070000000',
              'regDesc' => 'REGION VII (CENTRAL VISAYAS)',
              'regCode' => '07',
            ],
            8 => [
              'id' => 9,
              'psgcCode' => '080000000',
              'regDesc' => 'REGION VIII (EASTERN VISAYAS)',
              'regCode' => '08',
            ],
            9 => [
              'id' => 10,
              'psgcCode' => '090000000',
              'regDesc' => 'REGION IX (ZAMBOANGA PENINSULA)',
              'regCode' => '09',
            ],
            10 => [
              'id' => 11,
              'psgcCode' => '100000000',
              'regDesc' => 'REGION X (NORTHERN MINDANAO)',
              'regCode' => '10',
            ],
            11 => [
              'id' => 12,
              'psgcCode' => '110000000',
              'regDesc' => 'REGION XI (DAVAO REGION)',
              'regCode' => '11',
            ],
            12 => [
              'id' => 13,
              'psgcCode' => '120000000',
              'regDesc' => 'REGION XII (SOCCSKSARGEN)',
              'regCode' => '12',
            ],
            13 => [
              'id' => 14,
              'psgcCode' => '130000000',
              'regDesc' => 'NATIONAL CAPITAL REGION (NCR)',
              'regCode' => '13',
            ],
            14 => [
              'id' => 15,
              'psgcCode' => '140000000',
              'regDesc' => 'CORDILLERA ADMINISTRATIVE REGION (CAR)',
              'regCode' => '14',
            ],
            15 => [
              'id' => 16,
              'psgcCode' => '150000000',
              'regDesc' => 'AUTONOMOUS REGION IN MUSLIM MINDANAO (ARMM)',
              'regCode' => '15',
            ],
            16 => [
              'id' => 17,
              'psgcCode' => '160000000',
              'regDesc' => 'REGION XIII (Caraga)',
              'regCode' => '16',
            ],
          ],
        ];
        foreach($array['RECORDS'] as $key => $value) {
          regions::create(['psgcCode' => $value['psgcCode'],'regDesc' => $value['regDesc'],'regCode' => $value['regCode']]);
        }
    }
}
