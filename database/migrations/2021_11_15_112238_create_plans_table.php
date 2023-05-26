<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191);
            $table->decimal('price', $precision = 10, $scale = 2);
            $table->integer('period');
            $table->integer('instant_messages_count');
            $table->boolean('unlimited_messages_sent')->nullable()->default(0);
            $table->boolean('boosting_profile')->nullable()->default(0);
            $table->boolean('status')->nullable()->default(0);
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
        Schema::dropIfExists('plans');
    }
}
