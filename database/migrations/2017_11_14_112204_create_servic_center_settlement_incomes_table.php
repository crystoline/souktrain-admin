<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicCenterSettlementIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servic_center_settlement_incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('settlement_id', false, true);
	        $table->integer('income_id', false, true);

            $table->timestamps();

	        $table->foreign('settlement_id')->references('id')->on('servic_center_settlements')->onDelete('restrict');
	        $table->foreign('income_id')->references('id')->on('servic_center_incomes')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::create('servic_center_settlement_incomes', function (Blueprint $table) {
			$table->dropForeign(['servic_center_settlement_id']);
		    $table->dropForeign(['servic_center_income_id']);

	    });
		    Schema::dropIfExists('servic_center_settlement_incomes');
    }
}
