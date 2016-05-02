<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Th01 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('th01', function($table) {
            $table->increments('idhut');
            $table->text('norhut');
            $table->datetime('tglhut');
            $table->string('jenhut');
            $table->tinyInteger('jmlang');
            $table->bigInteger('nilhut');
            $table->char("flglns", 1);
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
        Schema::drop('th01');
    }

}
