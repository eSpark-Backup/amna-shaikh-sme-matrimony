<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 191);
            $table->string('email', 191)->unique();
            $table->string('password', 191);
            $table->string('original_password', 191);
            $table->string('login_background', 100)->nullable();
            $table->string('forgot_background', 100)->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->string('password_reset_token', 191)->nullable();
            $table->dateTime('password_reset_token_date')->nullable();
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
        Schema::dropIfExists('admins');
    }
}
