<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->string('title', 255)->nullable();
            $table->string('location', 255)->nullable();
            $table->string('image', 191)->nullable();
            $table->string('event_video', 191)->nullable();
            $table->integer('joined_female')->unsigned()->nullable();
            $table->integer('joined_male')->unsigned()->nullable();
            $table->string('seats_left', 191)->nullable();
            $table->integer('total_seats')->unsigned()->nullable();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->date('event_date')->nullable();
            $table->tinyInteger('type')->nullable()->comment("0 for PAST, and 1 for upcoming")->default('0');
            $table->decimal('adults_charges', 10, 2)->nullable();
            $table->decimal('child_charges', 10, 2)->nullable();
            $table->decimal('event_charges', 10, 2)->nullable();
            $table->tinyInteger('status')->nullable()->default('1');
            $table->string('country', 191)->nullable();
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
        Schema::dropIfExists('events');
    }
}
