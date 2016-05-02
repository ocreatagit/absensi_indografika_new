<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mk02 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mk02', function($table) {
            $table->increments('id');
            $table->integer('mk01_id_parent')->unsigned()->index();
            $table->integer('mk01_id_child')->unsigned()->index();
            $table->foreign('mk01_id_parent')->references('idkar')->on('mk01');
            $table->foreign('mk01_id_child')->references('idkar')->on('mk01');
            $table->char("flglead", 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('mk02');
    }

}
