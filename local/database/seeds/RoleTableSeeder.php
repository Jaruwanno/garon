<?php

use Illuminate\Database\Seeder;
use App\UamRole;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $role = new UamRole();
      $role->id = 1;
      $role->user_id = 1;
      $role->access_name = 'users';
      $role->save();
    }
}
