<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicCenterSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servic_center_settlements', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('title', 150)->unique();
	        $table->integer('servic_center_id', false, true);
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
	    Schema::table('servic_center_settlements', function (Blueprint $table) {
		    $table->dropForeign(['servic_center_id']);
	    });
        Schema::dropIfExists('servic_center_settlements');
    }
}
