<?php

class ta03 extends Eloquent {

    protected $table = 'ta03';
    
    function mk01(){
        return $this->belongsTo("mk01");
    }

    function getAlpha($idkar, $date, $jenis) {
        $sql = "SELECT * FROM ta03 WHERE ta03.idkar = $idkar AND DATE(ta03.tglabs) = '" . date("Y-m-d", strtotime($date)) . "' AND jenis = '".$jenis."';";
        $ta03 = DB::select(DB::raw($sql));
        return $ta03;
    }
    
    function getTotalAlpha($idkar, $date, $jenis) {
        $sql = "SELECT COUNT(id) as alpha FROM ta03 WHERE ta03.idkar = $idkar AND MONTH(ta03.tglabs) = '" . date("m", strtotime($date)) . "' AND YEAR(ta03.tglabs) = '" . date("Y", strtotime($date)) . "' AND jenis = '".$jenis."';";
        $count = DB::select(DB::raw($sql));
        if (count($count) != 0) {
            $count = $count[0];
            $count = $count->alpha;
        } else {
            $count = 0;
        }
        return $count;
    }
    
    function getAllAlpha() {
        $sql = "SELECT ta03.*, mk01.nama FROM ta03 INNER JOIN mk01 ON mk01.idkar = ta03.idkar ORDER BY tglabs DESC;";
        $ta03 = DB::select(DB::raw($sql));
        return $ta03;
    }
}
