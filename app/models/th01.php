<?php

class th01 extends Eloquent {

    protected $table = 'th01';
    protected $primaryKey = 'idhut';

    function mk01() {
        return $this->belongsTo("mk01");
    }

    function getAutoIncrement() {
        $sql = "SELECT AUTO_INCREMENT as idth FROM information_schema.tables WHERE TABLE_SCHEMA = 'absensi' AND TABLE_NAME = 'th01'";
        $th01 = DB::select(DB::raw($sql));
        $th01 = $th01[0];
        return $th01->idth;
    }

    function getHutangBlmLunas() {
        $sql = "SELECT th01.*, mk01.nama FROM th01 INNER JOIN mk01 ON mk01.idkar = th01.idkar WHERE th01.flglns = 'N';";
        $th01 = DB::select(DB::raw($sql));
        return $th01;
    }

    function getHutang($idhut) {
        $sql = "SELECT th01.*, mk01.nama, mk01.usernm, mk01.pic FROM th01 INNER JOIN mk01 ON mk01.idkar = th01.idkar WHERE th01.idhut = $idhut;";
        $th01 = DB::select(DB::raw($sql));
        return $th01;
    }

    function getDetailHutang($idhut) {
        $sql = "SELECT * FROM th02 WHERE th02.idhut = $idhut;";
        $th02 = DB::select(DB::raw($sql));
        return $th02;
    }

    function getHutangBulan($idkar, $date) {
        $sql = "SELECT * FROM th02 INNER JOIN th01 ON th01.idhut = th02.idhut WHERE MONTH(th02.tglph) = " . date("n", strtotime($date)) . " AND YEAR(th02.tglph) = " . date("Y", strtotime($date)) . " AND th01.jenhut = 'Hutang' AND th01.idkar = $idkar;";
        $th02 = DB::select(DB::raw($sql));
        return $th02;
    }
    
    function getTotalHutangBulan($idkar, $date) {
        $sql = "SELECT COALESCE(SUM(nilph), 0) as hutang FROM th02 INNER JOIN th01 ON th01.idhut = th02.idhut WHERE MONTH(th02.tglph) = " . date("n", strtotime($date)) . " AND YEAR(th02.tglph) = " . date("Y", strtotime($date)) . " AND th01.jenhut = 'Hutang' AND th01.idkar = $idkar;";
        $count = DB::select(DB::raw($sql));
        if (count($count) != 0) {
            $count = $count[0];
            $count = $count->hutang;
        } else {
            $count = 0;
        }
        return $count;
    }

    function getKasBonBulan($idkar, $date) {
        $sql = "SELECT * FROM th02 INNER JOIN th01 ON th01.idhut = th02.idhut WHERE MONTH(th02.tglph) = " . date("n", strtotime($date)) . " AND YEAR(th02.tglph) = " . date("Y", strtotime($date)) . " AND th01.jenhut = 'Kas Bon' AND th01.idkar = $idkar;";
        $th02 = DB::select(DB::raw($sql));
        return $th02;
    }

    function getTotalKasBonBulan($idkar, $date) {
        $sql = "SELECT COALESCE(SUM(nilph), 0) as kasbon FROM th02 INNER JOIN th01 ON th01.idhut = th02.idhut WHERE MONTH(th02.tglph) = " . date("n", strtotime($date)) . " AND YEAR(th02.tglph) = " . date("Y", strtotime($date)) . " AND th01.jenhut = 'Kas Bon' AND th01.idkar = $idkar;";
        $count = DB::select(DB::raw($sql));
        if (count($count) != 0) {
            $count = $count[0];
            $count = $count->kasbon;
        } else {
            $count = 0;
        }
        return $count;
    }

    function checkAktifHutang($idkar) {
        $sql = "SELECT COUNT(idhut) as c_idhut FROM th01 WHERE idkar = $idkar AND flglns = 'N';";
        $th02 = DB::select(DB::raw($sql));
        $th02 = $th02[0]->c_idhut;
        return $th02;
    }

    function getLatestHutang($idkar) {
        $sql = "SELECT COUNT(tglhut), tglhut FROM th01 WHERE idkar = $idkar ORDER BY tglhut DESC LIMIT 1;";
        $th01 = DB::select(DB::raw($sql));
        return $th01;
    }

    function getAllHutang($tglfrom, $tglto, $idkar, $jenis, $status) {
        $sql = "SELECT th01.idhut, th01.norhut, th01.tglhut, th01.jenhut, th01.jmlang, th01.nilhut, th01.flglns, mk01.nama FROM th01 INNER JOIN mk01 ON mk01.idkar = th01.idkar";
        if ($tglfrom != '' && $idkar != 0) {
            $sql .= " WHERE th01.tglhut >= '$tglfrom' AND th01.tglhut <= '$tglto' AND th01.idkar = $idkar ";
        } else if ($tglfrom != '' && $idkar == 0) {
            $sql .= " WHERE th01.tglhut >= '$tglfrom' AND th01.tglhut <= '$tglto' ";
        } else if ($tglfrom == '' && $idkar != 0) {
            $sql .= " WHERE th01.idkar = $idkar ";
        }
        $sql .= " AND th01.jenhut = '$jenis' AND th01.flglns = '$status';";
//        dd($sql);
        $th01 = DB::select(DB::raw($sql));
        return $th01;
    }

}
