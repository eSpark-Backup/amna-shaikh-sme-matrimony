<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstantCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instant_count', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->nullable()->default(0);
            $table->integer('plan_id')->nullable()->default(0);
            $table->tinyInteger('instant_messages_count');
            $table->boolean('is_active')->nullable()->default(0);
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
        Schema::dropIfExists('instant_count');
    }
}
