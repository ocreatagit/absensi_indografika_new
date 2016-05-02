<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mm02 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mm02', function($table) {
            $table->increments('id');
            $table->integer('mk01_id')->unsigned();
            $table->foreign('mk01_id')->references('idkar')->on('mk01');
            $table->integer('mm01_id')->unsigned();
            $table->foreign('mm01_id')->references('idmnu')->on('mm01');
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
		Schema::drop('mm02');
	}

}
