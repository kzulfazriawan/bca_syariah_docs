<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Tombur",
            'email' => 'tombur@gmail.com',
            'username' => "tmbr",
            'password' => Hash::make('password'),
            "is_admin" => false,
        ]);

        DB::table('users')->insert([
            'name' => "Joko",
            'email' => 'joko@gmail.com',
            'username' => "joko",
            'password' => Hash::make('password'),
            "is_admin" => true,
        ]);
    }
}
