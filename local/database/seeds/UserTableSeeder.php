<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'โอม';
        $user->email = 'jaruwanno1991@gmail.com';
        $user->password = bcrypt('abc456');
        $user->role_name = 'admin';
        $user->created_at = '2017-09-02';
        $user->updated_at = '2017-09-02';
        $user->save();
    }
}
