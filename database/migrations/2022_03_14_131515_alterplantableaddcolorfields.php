<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Alterplantableaddcolorfields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `plans` ADD COLUMN `start_color` VARCHAR(30) NULL AFTER `description`, ADD COLUMN `end_color` VARCHAR(30) NULL AFTER start_color");
    }
}
