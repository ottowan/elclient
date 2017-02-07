<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->delete();
 
        User::create(array(
            'name' => 'firstuser',
            'email' => 'firstuser@gmail.com',
            'password' => Hash::make('first_password')
        ));
 
        User::create(array(
            'name' => 'seconduser',
            'email' => 'seconduser@gmail.com',
            'password' => Hash::make('second_password')
        ));
    }
}
