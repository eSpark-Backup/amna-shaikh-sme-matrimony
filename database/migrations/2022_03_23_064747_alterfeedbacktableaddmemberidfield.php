<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Alterfeedbacktableaddmemberidfield extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `feed_back` 

            ADD COLUMN `member_id` BIGINT(20) UNSIGNED NULL AFTER `id` ");
    }
}
