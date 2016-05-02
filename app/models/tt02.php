<?php

class tt02 extends Eloquent {

    protected $table = 'tt02';
    protected $primaryKey = 'idtt';

    function mk01() {
        return $this->belongsTo("mk01");
    }

    function getAutoIncrement() {
        $sql = "SELECT AUTO_INCREMENT as idtt FROM information_schema.tables WHERE TABLE_SCHEMA = 'absensi' AND TABLE_NAME = 'tt02'";
        $tt02 = DB::select(DB::raw($sql));
        $tt02 = $tt02[0];
        return $tt02->idtt;
    }

    function getAllTarik() {
        $sql = "SELECT tt02.*, mk01.nama FROM tt02 INNER JOIN mk01 ON mk01.idkar = tt02.idkar ORDER BY tt02.idtt ASC;";
        $tt02 = DB::select(DB::raw($sql));
        return $tt02;
    }

}
