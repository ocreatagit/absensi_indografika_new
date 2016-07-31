<?php

class mj03 extends Eloquent {

    protected $table = 'mj03';

    function mk01() {
        return $this->belongsTo("mk01");
    }

    function mj02() {
        return $this->belongsTo("mj02");
    }

    function getJamKerjaKaryawan($idkar) {
        $sql = "SELECT mj02.*, mj03.mk01_id, mj03.id FROM mj03 INNER JOIN mj02 ON mj02.idjk = mj03.mj02_id WHERE mj03.mk01_id = $idkar;";
        $mj03 = DB::select(DB::raw($sql));
        return $mj03;
    }

    function getIdJamKerjaKaryawan($idjk, $idkar) {
        $sql = "SELECT mj03.*, mj02.tipe FROM mj03 INNER JOIN mj02 ON mj02.idjk = mj03.mj02_id WHERE mj03.mj02_id = $idjk AND mj03.mk01_id = $idkar;";
        $mj03 = DB::select(DB::raw($sql));
        if (count($mj03) > 0) {
            $mj03 = $mj03[0];
            return $mj03;
        } else {
            return array();
        }
    }
    function validateJamIstirahatKaryawan($idkar) {
        $sql = "SELECT COUNT(mj03.id) as cnt_id FROM mj03 INNER JOIN mj02 ON mj02.idjk = mj03.mj02_id WHERE mj02.tipe = 2 AND mj03.mk01_id = " . $idkar . ";";
        $mj03 = DB::select(DB::raw($sql));
        $mj03 = $mj03[0];
        return $mj03->cnt_id;
    }
    
    function validateJamKerjaKaryawan($idkar) {
        $sql = "SELECT COUNT(mj03.id) as cnt_id FROM mj03 INNER JOIN mj02 ON mj02.idjk = mj03.mj02_id WHERE mj02.tipe = 1 AND mj03.mk01_id = " . $idkar . ";";
        $mj03 = DB::select(DB::raw($sql));
        $mj03 = $mj03[0];
        return $mj03->cnt_id;
    }

}
