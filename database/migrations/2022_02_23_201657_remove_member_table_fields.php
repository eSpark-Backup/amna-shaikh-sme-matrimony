<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveMemberTableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('start_sign');
            $table->dropColumn('country');
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('nationality');
            $table->dropColumn('caste');
            $table->dropColumn('martial_status');
            $table->dropColumn('education');
            $table->dropColumn('specialization');
            $table->dropColumn('job_title');
            $table->dropColumn('working_with');
            $table->dropColumn('looking_for');
            $table->dropColumn('occupation');
        });
    }
}
