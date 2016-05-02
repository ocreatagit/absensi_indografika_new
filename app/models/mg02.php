<?php

class mg02 extends Eloquent {
    protected $table = 'mg02';
    
    function mk01(){
        return $this->belongsTo("mk01");
    }
    
    function mg01(){
        return $this->belongsTo("mg01");
    }
    
    function getGajiKaryawan($idkar){
        $sql = "SELECT mg02.*, mg01.* FROM mg02 INNER JOIN mg01 ON mg01.idgj = mg02.mg01_id WHERE mg02.mk01_id = $idkar;";
        $mg02 = DB::select(DB::raw($sql));
        return $mg02;
    }
}
