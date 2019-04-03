<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'is_admin' => '1',
                'password' => bcrypt('adminpass'),
            ]
        );
        DB::table('users')->insert(
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => bcrypt('userpass'),
            ]
        );
    }
}
