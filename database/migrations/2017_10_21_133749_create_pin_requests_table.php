<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePinRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pin_requests', function (Blueprint $table) {
            $table->increments('id');

	        $table->string('email');
	        $table->integer('pin_collection_id');
	        $table->integer('count');
	        $table->float('cost');
	        $table->float('value');
	        $table->integer('status')->length(1)->default(0);
	        $table->string('ref_no');
	        $table->timestamp('sent_date')->isNullable();

            $table->timestamps();
	        //$table->foreign('currency_id')->references('id')->on('currencies');


	        //$table->foreign('pin_collection_id')->references('pin_collections')->on('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('pin_requests', function (Blueprint $table) {
	    	//$table->dropForeign(['pin_collection_id']);
	    });

        Schema::dropIfExists('pin_requests');
    }
}
