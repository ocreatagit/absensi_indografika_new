<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tt01 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tt01', function($table) {
            $table->increments('idtb');
            $table->text('nortb');
            $table->datetime('tgltb');
            $table->bigInteger('niltb');
            $table->integer("idkar")->unsigned();
            $table->foreign('idkar')->references('idkar')->on('mk01');
            $table->integer("idtg");
            $table->timestamps();
        });

        Schema::table('tt01', function($table) {
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('tt01');
    }

}
