<?php

class ta01 extends Eloquent {

    protected $table = 'ta01';
    protected $primaryKey = 'idabs';

    public function getJamKerjaKaryawan($id) {
        $sql = "SELECT DISTINCT ta01_id, DATE(tglmsk) as tgl FROM `ta02` WHERE mk01_id = " . $id;
        return DB::select(DB::raw($sql));        
    }

}
