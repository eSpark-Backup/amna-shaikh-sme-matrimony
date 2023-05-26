<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserChatsTableAddUserReceiverField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `user_chats` ADD COLUMN `user_receiver` BIGINT(20) UNSIGNED NULL AFTER `user_id` ");
    }
}
