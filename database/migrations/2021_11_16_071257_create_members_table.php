<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->integer('plan_id')->unsigned()->nullable()->index('plan_id');
            $table->string('first_name', 191);
            $table->string('last_name', 191);
            $table->string('mobile', 50)->nullable();
            $table->string('email', 191)->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('password', 191);
            $table->string('original_password', 100)->nullable();
            $table->string('on_behalf', 90)->nullable();
            $table->tinyInteger('gender')->nullable()->comment("0-male,1-female,3-trangender")->default('0');
            $table->date('date_of_birth');
            $table->string('country', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('nationality', 50)->nullable();
            $table->string('caste', 50)->nullable();
            $table->string('height', 50)->nullable();
            $table->boolean('martial_status')->nullable()->default(0);
            $table->integer('kids')->nullable()->default(0);
            $table->string('education', 100)->nullable();
            $table->string('specialization', 100)->nullable();
            $table->string('job_title', 100)->nullable();
            $table->string('working_with', 100)->nullable();
            $table->text('about')->nullable();
            $table->string('profile_image', 100)->nullable();
            $table->string('timezone', 100)->nullable();
            $table->tinyInteger('is_approved')->nullable()->comment("0-pending,1-approved,2-block,3-cancel")->default('0');
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
        Schema::dropIfExists('members');
    }
}
