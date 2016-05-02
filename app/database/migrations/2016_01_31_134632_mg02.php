<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mg02 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up() {
        Schema::create('mg02', function($table) {
            $table->increments('id');
            $table->integer('mk01_id')->unsigned();
            $table->foreign('mk01_id')->references('idkar')->on('mk01');
            $table->integer('mg01_id')->unsigned();
            $table->foreign('mg01_id')->references('idgj')->on('mg01');
            $table->bigInteger('nilgj');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('mg02');
    }

}
