<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tz01 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tz01', function($table) {
            $table->increments('id');
            $table->datetime('tglomz');
            $table->integer('nilomz');
            $table->integer('idkar')->unsigned()->index();
            $table->foreign('idkar')->references('idkar')->on('mk01');
            $table->float('prsomz');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
