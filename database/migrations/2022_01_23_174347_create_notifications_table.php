<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned()->nullable()->index('user_id');
            $table->integer('chat_id')->unsigned()->nullable()->index('chat_id');
            $table->integer('event_id')->unsigned()->nullable()->index('event_id');

            $table->string('title',255)->nullable();
            $table->text('body', 65535)->nullable();
            $table->string('click_action', 255)->nullable();
            $table->string('image', 191)->nullable();
            $table->string('priority', 191)->nullable();

            $table->boolean('is_readed')->nullable()->default(0);
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
        Schema::dropIfExists('notifications');
    }
}
