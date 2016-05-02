<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ta02 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ta02', function($table) {
            $table->increments('id');
            $table->integer('ta01_id')->unsigned();
            $table->foreign('ta01_id')->references('idabs')->on('ta01');
            $table->integer('mk01_id')->unsigned();
            $table->foreign('mk01_id')->references('idkar')->on('mk01');
            $table->datetime("tglmsk");
            $table->tinyInteger("abscd");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('ta02');
    }

}
