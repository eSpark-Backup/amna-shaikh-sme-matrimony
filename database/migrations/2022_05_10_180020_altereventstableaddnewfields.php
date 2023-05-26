<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Altereventstableaddnewfields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `events` 
            ADD COLUMN `siblings` TEXT NULL AFTER `total_seats`,
            ADD COLUMN `allow_siblings` INTEGER(11) UNSIGNED NULL AFTER `siblings`
        ");
    }
}
