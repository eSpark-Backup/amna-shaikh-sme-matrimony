<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('chat_user_id')->unsigned()->nullable()->index('chat_user_id');
            $table->integer('user_id')->unsigned()->comment("sender member ID")->nullable()->index('user_id');
            $table->integer('user_id_receiver')->unsigned()->comment("receiver member ID")->nullable()->index('user_id_receiver');
            $table->string('first_name', 191)->nullable();
            $table->string('last_name', 191)->nullable();
            $table->text('message')->nullable();
            $table->string('msg_file', 255)->nullable();
            $table->string('ip_address', 191)->nullable();
            $table->tinyInteger('instant_count')->nullable()->default('0');
            $table->tinyInteger('is_video')->nullable()->default('0');
            $table->tinyInteger('un_red')->nullable()->default('0');
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
        Schema::dropIfExists('chat_messages');
    }
}
