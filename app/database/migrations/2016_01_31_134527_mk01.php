<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mk01 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('mk01', function($table) {
            $table->increments('idkar');
            $table->string('nama');
            $table->string('usernm');
            $table->string('email');
            $table->string('passwd');
            $table->char('gndr', 1);
            $table->char('norek1', 25);
            $table->char('norek2', 25);
            $table->date('tglaktif');
            $table->date('ttl');
            $table->text('addr1');
            $table->text('notelp');
            $table->char("status", 1);
            $table->text('pic');
            $table->bigInteger('tbsld');
            $table->bigInteger('htsld');
            $table->date('tglgj');
            $table->char("flgref", 3);
            $table->float("kmindv");
            $table->float("kmtim");
            $table->int("jnsusr");
            $table->integer('idjb')->unsigned();
            $table->timestamps();
        });

        Schema::table('mk01', function($table) {
            $table->foreign('idjb')->references('idjb')->on('mj01');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('mk01');
    }

}
