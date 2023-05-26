<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMembersIntroductionFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         DB::statement("ALTER TABLE `members` ADD COLUMN `looking_for` TINYINT(1) DEFAULT 0  NULL AFTER `profile_image`, ADD COLUMN `drinking` TINYINT(1) DEFAULT 0  NULL AFTER `looking_for`,
            ADD COLUMN `smoking` TINYINT(1) DEFAULT 0  NULL AFTER `drinking`,
            ADD COLUMN `start_sign` TINYINT(1) DEFAULT 0  NULL AFTER `smoking`,
            ADD COLUMN `language_id` TINYINT(1) DEFAULT 0  NULL AFTER `start_sign`,
            ADD COLUMN `occupation` VARCHAR(100)   NULL AFTER `language_id`,
            ADD COLUMN `annual_imcome` DOUBLE   NULL AFTER `occupation`;");
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
