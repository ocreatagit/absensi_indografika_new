<?php

class tt01 extends Eloquent {

    protected $table = 'tt01';
    protected $primaryKey = 'idtb';

    function mk01() {
        return $this->belongsTo("mk01");
    }

    function getAutoIncrement() {
        $sql = "SELECT AUTO_INCREMENT as idtb FROM information_schema.tables WHERE TABLE_SCHEMA = 'absensi' AND TABLE_NAME = 'tt01'";
        $tt01 = DB::select(DB::raw($sql));
        $tt01 = $tt01[0];
        return $tt01->idtb;
    }

    function getTabungan() {
        $sql = "SELECT tt01.*, mk01.nama FROM tt01 INNER JOIN mk01 ON mk01.idkar = tt01.idkar;";
        $tt01 = DB::select(DB::raw($sql));
        return $tt01;
    }

    function getTabunganGaji($idkar, $date) {
        $sql = "SELECT * FROM tt01 WHERE MONTH(tt01.tgltb) = " . date("n", strtotime($date)) . " AND YEAR(tt01.tgltb) = " . date("Y", strtotime($date)) . " AND tt01.idkar = $idkar;";
        $tt01 = DB::select(DB::raw($sql));
        return $tt01;
    }

    function getKarTabungan($id) {
        $sql = "SELECT tt01.*, mk01.nama FROM tt01 INNER JOIN mk01 ON mk01.idkar = tt01.idkar WHERE tt01.idtb = $id";
        $tt01 = DB::select(DB::raw($sql));
        return $tt01;
    }

    function getLatestTabungan($idkar, $date) {
        $sql = "SELECT * FROM tt01 WHERE idkar = $idkar AND MONTH(tgltb) = " . date("n", strtotime($date)) . ";";
        $tt01 = DB::select(DB::raw($sql));
        return $tt01;
    }

    function getAllTabungan($tglfrom, $tglto, $idkar) {
        $sql = "SELECT tt01.idtb, tt01.nortb, tt01.tgltb, tt01.niltb, tt01.idkar, mk01.nama FROM tt01 INNER JOIN mk01 ON mk01.idkar = tt01.idkar";

        if ($tglfrom != '' && $idkar != 0) {
            $sql .= " WHERE tt01.tgltb >= '$tglfrom' AND tt01.tgltb <= '$tglto' AND tt01.idkar = $idkar ";
        } else if ($tglfrom != '' && $idkar == 0) {
            $sql .= " WHERE tt01.tgltb >= '$tglfrom' AND tt01.tgltb <= '$tglto' ";
        } else if ($tglfrom == '' && $idkar != 0) {
            $sql .= " WHERE tt01.idkar = $idkar ";
        }
//        dd($sql);
        $sql.= " UNION 
                SELECT tt02.idtt, tt02.nortt, tt02.tgltt, -1 * tt02.niltt, tt02.idkar, mk01.nama
                FROM tt02 
                INNER JOIN mk01 ON mk01.idkar = tt02.idkar ";
        if ($tglfrom != '' && $idkar != 0) {
            $sql .= " WHERE tt02.tgltt >= '$tglfrom' AND tt02.tgltt <= '$tglto' AND tt02.idkar = $idkar ";
        } else if ($tglfrom != '' && $idkar == 0) {
            $sql .= " WHERE tt02.tgltt >= '$tglfrom' AND tt02.tgltt <= '$tglto' ";
        } else if ($tglfrom == '' && $idkar != 0) {
            $sql .= " WHERE tt02.idkar = $idkar ";
        }
//        dd($sql);
        $tt01 = DB::select(DB::raw($sql));
        return $tt01;
    }

    public function getAllTabunganKaryawan() {
        $sql = "SELECT mk01.idkar, mk01.nama, (SELECT SUM(niltb) FROM tt01 WHERE tt01.idkar = mk01.idkar) as tbmsk, (SELECT SUM(niltt) FROM tt02 WHERE tt02.idkar = mk01.idkar) as tbklr, mk01.tbsld FROM mk01;";
//        echo $sql; exit;
        $tt01 = DB::select(DB::raw($sql));
        return $tt01;
    }

}
