<?php

use Illuminate\Database\Seeder;
use App\Zone;

class ZoneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $zone = new Zone();
      $zone->length = 1;
      $zone->name = 'ไทย';
      $zone->save();

      $zone = new Zone();
      $zone->length = 2;
      $zone->name = 'อังกฤษ';
      $zone->save();

      $zone = new Zone();
      $zone->length = 3;
      $zone->name = 'สเปน';
      $zone->save();

      $zone = new Zone();
      $zone->length = 4;
      $zone->name = 'ฝรั่งเศษ';
      $zone->save();

      $zone = new Zone();
      $zone->length = 5;
      $zone->name = 'เยอรมนี';
      $zone->save();

      $zone = new Zone();
      $zone->length = 6;
      $zone->name = 'ญี่ปุ่น';
      $zone->save();

      $zone = new Zone();
      $zone->length = 7;
      $zone->name = 'บอลถ้วยยุโรป';
      $zone->save();

      $zone = new Zone();
      $zone->length = 8;
      $zone->name = 'บอลถ้วยเอเชีย';
      $zone->save();
    }
}
