<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventAudiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_audiences', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->tinyInteger('gender')->nullable()->comment("0 for female, and 1 for male")->default('0');
            $table->integer('member_id')->unsigned()->nullable();
            $table->integer('event_id')->unsigned()->nullable();
            $table->integer('male_guests')->unsigned()->nullable();
            $table->integer('female_guests')->unsigned()->nullable();
            $table->integer('child_guests')->unsigned()->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->string('payment_id', 255)->nullable();
            $table->decimal('amoun_paid', 10, 2)->nullable();
            $table->string('card_number', 255)->nullable();
            $table->integer('csv')->unsigned()->nullable();
            $table->string('expire_date',10)->nullable();
            $table->tinyInteger('status')->nullable()->default('0');
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
        Schema::dropIfExists('event_audiences');
    }
}
