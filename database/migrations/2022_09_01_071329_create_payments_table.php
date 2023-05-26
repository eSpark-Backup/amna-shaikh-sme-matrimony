<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('members_plan_id')->unsigned()->nullable()->index('members_plan_id');
            $table->integer('event_audiences_d')->unsigned()->nullable()->index('event_audiences_d');
            $table->decimal('amoun_paid', 10, 2)->nullable();
            $table->string('payment_id', 255)->nullable();
            $table->date('plan_end_date')->nullable();
            $table->string('stripe_status', 255)->nullable();
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
        Schema::dropIfExists('payments');
    }
}
