<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeleteMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delete_messages', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('chat_message_id')->unsigned()->nullable()->index('chat_message_id');

            $table->integer('chat_user_id')->unsigned()->nullable()->index('chat_user_id');
            $table->integer('user_id')->unsigned()->nullable()->index('user_id');

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
        Schema::dropIfExists('delete_messages');
    }
}
