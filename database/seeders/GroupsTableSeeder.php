<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('groups')->insert([
            'group_name' => 'developers',
            'group_admin_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
