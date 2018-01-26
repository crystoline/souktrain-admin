<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatricIncomensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matrix_incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true);
	        $table->integer('upline_id', false, true);
	        $table->integer('plan_condition_id', false, true);
	        $table->float('amount');
	        $table->string('action', 200)->nullable();
	        $table->integer('status', false, true)->length(1);

            $table->timestamps();

	        //$table->foreign('user_id')->references('id')->on('users');
	        //$table->foreign('upline_id')->references('id')->on('users');
	        //$table->foreign('condition_id')->references('id')->on('conditions');


        });
	    Schema::table('plan_conditions', function (Blueprint $table) {
			$table->string('sub_action', '100');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

	    Schema::table('plan_conditions', function (Blueprint $table) {
		    $table->removeColumn('sub_action');
	    });
        Schema::dropIfExists('matrix_incomes');
    }
}
