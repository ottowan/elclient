<?php

use App\Task;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->delete();
 
        User::create(array(
            'name' => 'firstuser',
            'description' => 'firstuser',
            'user_id' => '1'
        ));
 
        User::create(array(
            'username' => 'seconduser',
            'description' => 'firstuser',
            'user_id' => '2'
        ));
    }
}
