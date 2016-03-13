<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
    }
}


class UserTableSeeder extends Seeder
{
    public function run() {
        $user = new \App\User();
        $user->name = 'Wendel';
        $user->email = 'wendelprogrammer@gmail.com';
        $user->password = bcrypt('teste123');
        $user->save();
    }
}
