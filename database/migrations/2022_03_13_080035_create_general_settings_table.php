<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
           
            $table->string('system_name', 191)->nullable();
            $table->string('system_title', 191)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 191)->nullable();
            $table->text('address')->nullable();

            $table->string('facebook_link', 191)->nullable();
            $table->string('youtube_link', 191)->nullable();
            $table->string('instagram_link', 191)->nullable();
            $table->string('meetup_link', 191)->nullable();
            $table->string('whatsapp', 191)->nullable();
            $table->text('terms_condition')->nullable();
            $table->text('privacy_policy')->nullable();
            $table->string('timezone', 100)->nullable();
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
        Schema::dropIfExists('general_settings');
    }
}
