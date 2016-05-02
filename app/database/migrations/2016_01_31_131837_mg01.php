<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mg01 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mg01', function($table) {
            $table->increments('idgj');
            $table->string('jenis');
            $table->integer('jmltgh');
            $table->char('jntgh', 10);
            $table->integer('abscd');
            $table->char('status', 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('mg01');
    }

}
