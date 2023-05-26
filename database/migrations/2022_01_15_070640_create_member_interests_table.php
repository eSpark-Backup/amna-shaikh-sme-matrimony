<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_interests', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('member_id')->unsigned()->nullable()->index('member_id');
            $table->integer('member_interested_id')->unsigned()->nullable()->index('member_interested_id');
            $table->tinyInteger('status')->nullable()->comment("1-accepted,2-request-send,3-rejected")->default('0');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_interests');
    }
}
