<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicCenterIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servic_center_incomes', function (Blueprint $table) {
            $table->increments('id');

	        $table->integer('servic_center_id', false, true);
	        $table->float('amount' );
	        $table->text('description');
            $table->timestamps();


	        $table->foreign('servic_center_id')->references('id')->on('servic_centers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('servic_center_incomes', function (Blueprint $table) {
		    $table->dropForeign(['servic_center_id']);
	    });
        Schema::dropIfExists('servic_center_incomes');
    }
}
