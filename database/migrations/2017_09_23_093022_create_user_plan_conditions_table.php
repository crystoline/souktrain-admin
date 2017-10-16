<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPlanConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    //Schema::dropIfExists('user_plan_conditions');
        Schema::create('user_plan_conditions', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('user_id', false, true);
            $table->integer('plan_condition_id', false, true);


            //$table->foreign('user_id')->references('id')->on('users');
	        //$table->foreign('plan_condition_id', 'plan_conditions_foreign')->references('id')->on('plan_conditions');

	        $table->unique(['user_id', 'plan_condition_id']);
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
	    Schema::table('user_plan_conditions', function (Blueprint $table) {

		    //$table->dropForeign(['user_id']);
		     //$table->dropForeign(['plan_condition_id']);

		    $table->dropUnique(['user_id', 'plan_condition_id']);
	    });
        Schema::dropIfExists('user_plan_conditions');
    }
}
