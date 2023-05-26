<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       \DB::table('members')->delete();

        \DB::table('members')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Default',
                'price' => 1.00,
                'period' => 4,
                'instant_messages_count' => 5,
                'unlimited_messages_sent' => 1,
                'boosting_profile' => 0,
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-11-15 16:57:46',
                'updated_at' => '2021-11-15 16:39:57',
            ),
        ));
    }
}
