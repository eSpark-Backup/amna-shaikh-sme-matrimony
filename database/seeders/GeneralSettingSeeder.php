<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('general_settings')->delete();

        \DB::table('general_settings')->insert(array (
            0 =>
            array (
                'id' => 1,
                'system_name' => 'SME Matrimony',
                'system_title' => 'SME Matrimony',
                'email' => 'info@smematrimony.com',
                'phone' => '+1 647 874 1955',
                'address' => '224 Dorchester place Waterloo Ontario n2t2h7 Canada',
                'timezone' => 'Asia/Dhaka',
                'facebook_link' => 'https://www.facebook.com/singlemuslimevents/',
                'youtube_link' => 'https://www.youtube.com/watch?v=4ayZi6SvITg',
                'instagram_link' => 'https://www.instagram.com/single_muslim_events_/',
                'meetup_link' => 'https://www.meetup.com/Single-Muslims-in-uae/',
                'whatsapp' => 'tel:+971 55 77758 977',
                'terms_condition' => '',
                'privacy_policy' => '',
                'deleted_at' => NULL,
                'created_at' => '2021-11-15 16:57:46',
                'updated_at' => '2021-11-15 16:39:57',
            ),
        ));
    }
}
