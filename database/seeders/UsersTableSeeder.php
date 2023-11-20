<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'username' => 'Admin',
                'guid' => '841d5bc6-5bab-453e-8f0b-b74ee43dc2da',
                'domain' => 'default',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'name' => 'pato',
                'username' =>'pato',
                'guid' => '207970ce-fddd-42f7-82a1-c0e6656f8247',
                'domain' => 'default',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'michael',
                'username' => 'michael',
                'guid' => '7029b7c7-1b43-47b9-aacc-c4bc3e5a42ac',
                'domain' => 'default',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'simon',
                'username' => 'simon',
                'guid' => '827cc32c-2ed4-4f44-b40a-02fc5ba6971c',
                'domain' => 'default',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
