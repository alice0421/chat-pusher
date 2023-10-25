<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JapaneseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('japanese')->insert([
            'user_id' => '1',
            'residence' => '東京',
        ]);
        DB::table('japanese')->insert([
            'user_id' => '2',
            'residence' => '大阪',
        ]);
    }
}
