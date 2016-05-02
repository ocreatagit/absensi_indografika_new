<?php

class mg01 extends Eloquent {

    protected $table = 'mg01';
    protected $primaryKey = 'idgj';
    
    function mg02() {
        return $this->hasMany("mg02");
    }
    
    function tg02() {
        return $this->hasMany("tg02");
    }
            
    function getJenisGajiAktif(){
        return $this->where('status', '=', 'Y')->orderBy('idgj', 'ASC')->get();
    }
    
    function getOtherGaji($idkar){
        $sql = "SELECT mg01.* FROM mg01 WHERE mg01.idgj NOT IN (SELECT mg01_id FROM mg02 WHERE mk01_id = $idkar);";
        $mg01 = DB::select(DB::raw($sql));
        return $mg01;
    }
}
