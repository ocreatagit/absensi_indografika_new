<?php

class tz01 extends Eloquent {

    protected $table = 'tz01';
    protected $primaryKey = 'id';

    function getOmzet() {
        $sql = "SELECT tz01.*, mk01.nama FROM tz01 INNER JOIN mk01 ON mk01.idkar = tz01.idkar;";
        $tt01 = DB::select(DB::raw($sql));
        return $tt01;
    }

    function getOmzetIndividu($idkar, $date) {
        $sql = "SELECT tz01.*, mk01.nama FROM tz01 INNER JOIN mk01 ON mk01.idkar = tz01.idkar WHERE tz01.idkar = $idkar AND MONTH(tz01.tglomz) = " . date("n", strtotime($date)) . ";";
        $tz01 = DB::select(DB::raw($sql));
        if (count($tz01) > 0) {
            $tz01 = $tz01[0];
            return $tz01->nilomz;
        } else {
            return 0;
        }
    }

    function getOmzetTim($idkar, $date) {
        $sql = "SELECT COALESCE(SUM(tz01.nilomz), 0) as nilomz FROM tz01 WHERE tz01.idkar IN (SELECT mk02.mk01_id_child FROM mk02 WHERE mk02.mk01_id_parent = $idkar AND mk02.mk01_id_child <> $idkar) AND MONTH(tz01.tglomz) = " . date("n", strtotime($date)) . ";";
//        echo $sql; exit;
        $tz01 = DB::select(DB::raw($sql));
        if (count($tz01) > 0) {
            $tz01 = $tz01[0];
            return $tz01->nilomz;
        } else {
            return 0;
        }
    }

    function getLatestOmzet($idkar, $date) {
        $sql = "SELECT * FROM tz01 WHERE tz01.idkar = $idkar AND MONTH(tz01.tglomz) = " . date("n", strtotime($date)) . ";";
        $tz01 = DB::select(DB::raw($sql));
        return $tz01;
    }

    function getAllOmzet($tglfrom, $tglto, $idkar) {
        $sql = "SELECT tz01.*, mk01.nama FROM tz01 INNER JOIN mk01 ON mk01.idkar = tz01.idkar ";
        if ($tglfrom != '' && $idkar != 0) {
            $sql .= " WHERE tz01.tglomz >= '$tglfrom' AND tz01.tglomz <= '$tglto' AND tz01.idkar = $idkar;";
        } else if ($tglfrom != '' && $idkar == 0) {
            $sql .= " WHERE tz01.tglomz >= '$tglfrom' AND tz01.tglomz <= '$tglto';";
        } else if ($tglfrom == '' && $idkar != 0) {
            $sql .= " WHERE tz01.idkar = $idkar;";
        } 
//        dd($sql);
        $tz01 = DB::select(DB::raw($sql));
        return $tz01;
    }

}
