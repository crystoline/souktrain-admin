<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatricLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matrix_logs', function (Blueprint $table) {
            $table->increments('id');

	        $table->integer('user_id', false, true);
	        $table->integer('upline_id', false, true);
	        $table->integer('plan_id', false, true);
	        $table->integer('level', false, true)->nullable();

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
        Schema::dropIfExists('matrix_logs');
    }
}
