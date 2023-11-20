<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('folders')->insert([
            'name' => 'Repository',
            'path' => '/home',
            'parent_folder_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
