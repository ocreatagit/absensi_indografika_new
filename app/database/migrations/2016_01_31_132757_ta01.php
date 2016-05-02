<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ta01 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ta01', function($table) {
            $table->increments('idabs');
            $table->datetime('tglabs');
            $table->string('tipe');
            $table->integer('idjk')->unsigned();
            $table->timestamps();
        });
        
        Schema::table('ta01', function($table) {
            $table->foreign('idjk')->references('idjk')->on('mj02');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('ta01');
    }

}
