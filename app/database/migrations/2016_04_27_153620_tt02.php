<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tt02 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tt02', function($table) {
            $table->increments('idtt');
            $table->text('nortt');
            $table->datetime('tgltt');
            $table->bigInteger('niltt');
            $table->integer("idkar")->unsigned();
            $table->foreign('idkar')->references('idkar')->on('mk01');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('tt02');
    }

}
