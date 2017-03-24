<?php

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
        $user = new \App\User();
        $user->email = 'cse.shashanksingh@gmail.com';
        $user->name = 'Shashank Singh';
        $user->save();

    }
}
