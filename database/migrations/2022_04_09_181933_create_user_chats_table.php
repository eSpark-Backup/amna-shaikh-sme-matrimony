<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_chats', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
           
            $table->string('first_name', 191)->nullable();
            $table->string('last_name', 191)->nullable();
            $table->integer('user_id')->unsigned()->comment("sender member ID")->nullable()->index('user_id');
            $table->text('message')->nullable();
            $table->string('msg_file', 255)->nullable();
            $table->string('ip_address', 191)->nullable();
            $table->tinyInteger('instant_count')->nullable()->default('0');
            $table->tinyInteger('is_video')->nullable()->default('0');
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
        Schema::dropIfExists('user_chats');
    }
}
