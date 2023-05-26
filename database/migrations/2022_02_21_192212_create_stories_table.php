<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
           $table->increments('id');
          $table->integer('member_id')->unsigned()->index('member_id');
           $table->string('title', 255)->nullable();
           $table->text('description')->nullable();
           $table->string('partner_name', 100)->nullable();
           $table->string('image', 255)->nullable();
           $table->boolean('status')->default(0);
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
        Schema::dropIfExists('stories');
    }
}
