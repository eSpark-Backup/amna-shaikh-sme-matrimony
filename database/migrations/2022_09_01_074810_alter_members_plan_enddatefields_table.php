<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMembersPlanEnddatefieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `members_plan`
            ADD COLUMN `start_date` DATE NULL AFTER `status`,
            ADD COLUMN `end_date` DATE NULL AFTER `start_date`; ");
    }

    
}
