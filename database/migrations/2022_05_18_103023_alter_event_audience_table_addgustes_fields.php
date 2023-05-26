<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEventAudienceTableAddgustesFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `event_audiences` 

            ADD COLUMN `guests` TEXT NULL AFTER `event_id`,
            ADD COLUMN `guest_charges` DECIMAL(10,2) NULL AFTER `guests`,
            ADD COLUMN `total_guests` INTEGER NULL AFTER `guest_charges`

            ");
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
