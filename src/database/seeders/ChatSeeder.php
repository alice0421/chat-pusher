<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chats')->insert([
            'sender_id' => 2,
            'receiver_id' => 1,
            'message' => "花子から太郎へのメッセージ",
            'created_at' => "2023-10-18 16:20:00",
            'updated_at' => "2023-10-18 16:20:00",
        ]);
        DB::table('chats')->insert([
            'sender_id' => 1,
            'receiver_id' => 2,
            'message' => "太郎から花子へのメッセージ",
            'created_at' => "2023-10-18 16:30:00",
            'updated_at' => "2023-10-18 16:30:00",
        ]);
    }
}
