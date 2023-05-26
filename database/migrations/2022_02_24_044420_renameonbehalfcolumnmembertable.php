<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Renameonbehalfcolumnmembertable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->renameColumn('on_behalf', 'on_behalf_id');
            $table->renameColumn('annual_imcome', 'annual_income');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('on_behalf_id', 'on_behalf');
            $table->renameColumn('annual_income', 'annual_imcome');
        });
    }
}
