<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->insert([
            'sender_id' => 2,
            'receiver_id' => 1,
            'context' => "花子から太郎へのメッセージ",
            'created_at' => "2023-10-18 16:20:00",
            'updated_at' => "2023-10-18 16:20:00",
        ]);
        DB::table('messages')->insert([
            'sender_id' => 1,
            'receiver_id' => 2,
            'context' => "太郎から花子へのメッセージ",
            'created_at' => "2023-10-18 16:30:00",
            'updated_at' => "2023-10-18 16:30:00",
        ]);
    }
}
