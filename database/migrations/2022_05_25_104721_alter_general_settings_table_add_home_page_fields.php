<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterGeneralSettingsTableAddHomePageFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `general_settings` 
            ADD COLUMN `happy_couple_title` VARCHAR(99) NULL AFTER `privacy_policy`,
            ADD COLUMN `happy_couple_description` TEXT NULL AFTER `happy_couple_title`,

            ADD COLUMN `events_title` VARCHAR(99) NULL AFTER `happy_couple_description`,
            ADD COLUMN `events_description` TEXT NULL AFTER `events_title`,

            ADD COLUMN `members_title` VARCHAR(99) NULL AFTER `events_description`,
            ADD COLUMN `members_description` TEXT NULL AFTER `members_title`,

            ADD COLUMN `about_title` VARCHAR(99) NULL AFTER `members_description`,
            ADD COLUMN `about_description` TEXT NULL AFTER `about_title`,
            ADD COLUMN `about_images` TEXT NULL AFTER `about_description`,

            ADD COLUMN `slider_title_first` TEXT NULL AFTER `about_images`,
            ADD COLUMN `slider_sub_title_first` TEXT NULL AFTER `slider_title_first`,

            ADD COLUMN `slider_title_sec` TEXT NULL AFTER `slider_sub_title_first`,
            ADD COLUMN `slider_sub_title_sec` TEXT NULL AFTER `slider_title_sec`,

            ADD COLUMN `slider_title_third` TEXT NULL AFTER `slider_sub_title_sec`,
            ADD COLUMN `slider_sub_title_third` TEXT NULL AFTER `slider_title_third`,
            ADD COLUMN `slider_images` TEXT NULL AFTER `slider_sub_title_third`

        ");
    }
}
