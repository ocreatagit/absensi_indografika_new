<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tg01 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tg01', function($table) {
            $table->increments('idtg');
            $table->text('nortg');
            $table->datetime('tgltg');
            $table->datetime('tglgjsblm');
            $table->string('status');
            $table->integer('ttlgj');
            $table->integer('ttlbns');
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
        Schema::drop('tg01');
    }

}
