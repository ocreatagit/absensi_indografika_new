<?php

class tg02 extends Eloquent {

    protected $table = 'tg02';

    function mg01() {
        return $this->belongsTo("mg01");
    }

    function tg01() {
        return $this->belongsTo("tg01");
    }

    function getDetailGajiKaryawan($idtg) {
        $sql = "SELECT tg02.id, tg01.idtg, tg01.nortg, tg01.tgltg, mg01.idgj, mg01.jenis, tg02.jmtgh, tg02.nmlgj, mg01.jntgh
                FROM tg01 
                INNER JOIN tg02 ON tg02.tg01_id = tg01.idtg
                INNER JOIN mg01 ON mg01.idgj = tg02.mg01_id
                WHERE tg01.idtg = $idtg;";
//        echo $sql; exit;
        $tg02 = DB::select(DB::raw($sql));
        return $tg02;
    }

}
