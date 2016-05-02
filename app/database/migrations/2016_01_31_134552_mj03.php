<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mj03 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mj03', function($table) {
            $table->increments('id');
            $table->integer('mj02_id')->unsigned();
            $table->foreign('mj02_id')->references('idjk')->on('mj02');
            $table->integer('mk01_id')->unsigned();
            $table->foreign('mk01_id')->references('idkar')->on('mk01');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('mj03');
    }

}
