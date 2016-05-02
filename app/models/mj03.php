<?php

class mj03 extends Eloquent {

    protected $table = 'mj03';
    
    function mk01(){
        return $this->belongsTo("mk01");
    }
    
    function mj02(){
        return $this->belongsTo("mj02");
    }
    
    function getJamKerjaKaryawan($idkar){
        $sql = "SELECT mj03.* FROM mj03 WHERE mj03.mk01_id = $idkar;";
        $mj03 = DB::select(DB::raw($sql));
        return $mj03;
    }
}
