<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ta03 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ta03', function($table) {
            $table->increments('id');
            $table->datetime("tglabs");
            $table->integer("durasi");
            $table->char("jenis", 6);
            $table->integer('idkar')->unsigned();
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
        Schema::drop('ta03');
    }
}
