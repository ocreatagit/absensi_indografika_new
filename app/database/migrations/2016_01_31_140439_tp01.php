<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tp01 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tp01', function($table) {
            $table->increments('idpt');
            $table->datetime('tglpt');
            $table->bigInteger('nilpt');
            $table->integer("idkar")->unsigned();
            $table->timestamps();
        });

        Schema::table('tp01', function($table) {
            $table->foreign('idkar')->references('idkar')->on('mk01');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('tp01');
    }

}
