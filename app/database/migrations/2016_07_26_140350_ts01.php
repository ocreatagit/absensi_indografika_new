<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ts01 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ts01', function($table) {
            $table->increments('id');
            $table->datetime('tgltrans');
            $table->integer('mk01_id')->unsigned();
            $table->foreign('mk01_id')->references('idkar')->on('mk01');
            $table->bigInteger('tbsld');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('ts01');
    }

}
