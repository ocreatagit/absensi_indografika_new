<?php

class mk03 extends Eloquent {

    protected $table = 'mk03';    

    public function getKeterangan($nama) {
        $sql = "SELECT * FROM mk03 WHERE nama = '".$nama."';";
        $mk03 = DB::select(DB::raw($sql));
        $mk03 = $mk03[0];
        return $mk03->ket;
    }

    public function getNilKeterangan($nama) {
        $sql = "SELECT * FROM mk03 WHERE nama = '".$nama."';";
        $mk03 = DB::select(DB::raw($sql));
        $mk03 = $mk03[0];
        return $mk03->nilket;
    }

    public function getIDKeterangan($nama) {
        $sql = "SELECT * FROM mk03 WHERE nama = '".$nama."';";
        $mk03 = DB::select(DB::raw($sql));
        $mk03 = $mk03[0];
        return $mk03->id;
    }
}
