<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        \DB::table('admins')->delete();

        \DB::table('admins')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Super Admin',
                'email' => 'admin@smematrimony.com',
                'password' => '$2y$10$l6fwi/302prpJy4bjJBbquq6DJVDd/NSI7gD/Th6.pcFHLCHjz6jq',
                'original_password' => '12345678',
                'login_background' => '',
                'forgot_background' => '',
                'remember_token' => 'gvSbh2E9SlrXWJyFxjF21SingjvNRghykg1a28u0KCbLn5OfMcERCY8bL2ao',
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2021-11-09 19:47:46',
                'updated_at' => '2021-11-09 18:39:57',
            ),
        ));
    }
}
