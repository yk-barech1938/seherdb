<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // admin
            [
                'name'=>'Admin',
                'username'=>'admin',
                'email'=>'admin@gmail.com',
                'password'=>Hash::make('asd'),
                'role'=>'admin',
                'status'=>'active'
            ],
            // agent
            [
                'name'=>'Agent',
                'username'=>'agent',
                'email'=>'agent@gmail.com',
                'password'=>Hash::make('asd'),
                'role'=>'agent',
                'status'=>'active'
            ],
             // user
             [
                'name'=>'User',
                'username'=>'user',
                'email'=>'user@gmail.com',
                'password'=>Hash::make('asd'),
                'role'=>'user',
                'status'=>'active'
             ],

        ]);
    }
}
