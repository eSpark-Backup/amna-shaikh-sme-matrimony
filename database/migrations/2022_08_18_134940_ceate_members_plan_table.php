<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CeateMembersPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_plan', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('member_id')->unsigned()->nullable()->index('member_id');
            $table->integer('plan_id')->unsigned()->nullable()->index('plan_id');
            $table->decimal('total_price', 10, 2)->nullable();
            $table->decimal('amoun_paid', 10, 2)->nullable();
            $table->string('payment_id', 255)->nullable();
            $table->string('stripe_customer_id', 255)->nullable();
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
        Schema::dropIfExists('members_plan');
    }
}
