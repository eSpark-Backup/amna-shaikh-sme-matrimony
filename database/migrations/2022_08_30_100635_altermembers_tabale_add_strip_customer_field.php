<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AltermembersTabaleAddStripCustomerField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         DB::statement("ALTER TABLE `members` 

            ADD COLUMN `stripe_customer` TEXT NULL AFTER `plan_id`,
            ADD COLUMN `stripe_payment_method` TEXT NULL AFTER `stripe_customer`
            ");
    }

    
}
