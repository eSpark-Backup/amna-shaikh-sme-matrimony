<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AltermembersAddmorepartnerfieldsmembertable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `members` 
            ADD COLUMN `body_art` VARCHAR(30) NULL AFTER `body_type`,
            ADD COLUMN `citizenship_country_id` BIGINT(20) UNSIGNED   NULL AFTER `residency_country_id`,
            ADD COLUMN `growup_country_id` BIGINT(20) UNSIGNED   NULL AFTER `citizenship_country_id`;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
