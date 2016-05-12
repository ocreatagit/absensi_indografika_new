<?php

class mm01 extends Eloquent {

    protected $table = 'mm01';
    protected $primaryKey = 'idmnu';
    
    function getKaryawanUserMatrix($idkar){
        $sql = "SELECT mm02.* FROM mm02 WHERE mm02.mk01_id = $idkar;";
        $mm02 = DB::select(DB::raw($sql));
        return $mm02;
    }
}
