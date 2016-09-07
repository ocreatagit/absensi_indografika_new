<?php

class Presensi {

    public static function getPresensiOld($idkar = 0, $tglfrom = "", $tglto = "") {
        if ($idkar == 0 && $tglfrom == "") {
            $filter = " AND MONTH(ta02.tglmsk) = MONTH(NOW()) AND YEAR(ta02.tglmsk) = YEAR(NOW()) ";
        } else if ($idkar == 0) {
            $filter = " AND DATE(ta02.tglmsk) >= DATE('" . date("Y-m-d", strtotime($tglfrom)) . "') AND DATE(ta02.tglmsk) <= DATE('" . date("Y-m-d", strtotime($tglto)) . "') ";
        } else if ($tglfrom == "") {
            $filter = " AND MONTH(ta02.tglmsk) = MONTH(NOW()) AND YEAR(ta02.tglmsk) = YEAR(NOW()) AND mk01.idkar = " . $idkar;
        } else {
            $filter = " AND DATE(ta02.tglmsk) >= DATE('" . date("Y-m-d", strtotime($tglfrom)) . "') AND DATE(ta02.tglmsk) <= DATE('" . date("Y-m-d", strtotime($tglto)) . "') AND mk01.idkar = " . $idkar;
        }


        $sqlMasuk = "SELECT mk01.idkar, 
                       mk01.nama, 
                       ta02.tglmsk as tgl,
                       DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                FROM mk01
                INNER JOIN ta02 ON ta02.mk01_id = mk01.idkar
                WHERE ta02.abscd = 0 " . $filter;
        $sqlPulang = "SELECT mk01.idkar, 
                       mk01.nama, 
                       DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                FROM mk01
                INNER JOIN ta02 ON ta02.mk01_id = mk01.idkar
                WHERE ta02.abscd = 1 " . $filter;
        $sqlKeluar = "SELECT mk01.idkar, 
                       mk01.nama, 
                       DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                FROM mk01
                INNER JOIN ta02 ON ta02.mk01_id = mk01.idkar
                WHERE ta02.abscd = 2 " . $filter;
        $sqlKembali = "SELECT mk01.idkar, 
                       mk01.nama, 
                       DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                FROM mk01
                INNER JOIN ta02 ON ta02.mk01_id = mk01.idkar
                WHERE ta02.abscd = 3 " . $filter;
        $sqlLemburM = "SELECT mk01.idkar, 
                       mk01.nama, 
                       DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                FROM mk01
                INNER JOIN ta02 ON ta02.mk01_id = mk01.idkar
                WHERE ta02.abscd = 4 " . $filter;
        $sqlLemburK = "SELECT mk01.idkar, 
                       mk01.nama, 
                       DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                FROM mk01
                INNER JOIN ta02 ON ta02.mk01_id = mk01.idkar
                WHERE ta02.abscd = 5 " . $filter;

        $dbMasuk = DB::select(DB::raw($sqlMasuk));
        $dbPulang = DB::select(DB::raw($sqlPulang));
        $dbKeluar = DB::select(DB::raw($sqlKeluar));
        $dbKembali = DB::select(DB::raw($sqlKembali));
        $dbLemburM = DB::select(DB::raw($sqlLemburM));
        $dbLemburK = DB::select(DB::raw($sqlLemburK));

        $cMasuk = 0;
        $cPulang = 0;
        $cKeluar = 0;
        $cKembali = 0;
        $cLemburM = 0;
        $cLemburK = 0;

        $cek = true;
        $global_array = array();
        do {
            $array = array();
            if (count($dbMasuk) > $cMasuk) {
                array_push($array, $dbMasuk[$cMasuk]->idkar);
                array_push($array, $dbMasuk[$cMasuk]->nama);
                array_push($array, $dbMasuk[$cMasuk]->tgl);
                array_push($array, $dbMasuk[$cMasuk]->tglmsk);
                $cMasuk++;
            } else {
                $cek = FALSE;
            }

            if (count($dbPulang) > $cPulang && $cek) {
                if ($dbPulang[$cPulang]->idkar == $array[0]) {
                    array_push($array, $dbPulang[$cPulang]->tglmsk);
                    $cPulang++;
                } else {
                    array_push($array, "-");
                }
            } else {
                array_push($array, "-");
            }

            if (count($dbKeluar) > $cKeluar && $cek) {
                if ($dbKeluar[$cKeluar]->idkar == $array[0]) {
                    array_push($array, $dbKeluar[$cKeluar]->tglmsk);
                    $cKeluar++;
                } else {
                    array_push($array, "-");
                }
            } else {
                array_push($array, "-");
            }

            if (count($dbKembali) > $cKembali && $cek) {
                if ($dbKembali[$cKembali]->idkar == $array[0]) {
                    array_push($array, $dbKembali[$cKembali]->tglmsk);
                    $cKembali++;
                } else {
                    array_push($array, "-");
                }
            } else {
                array_push($array, "-");
            }

            if (count($dbLemburM) > $cLemburM && $cek) {
                if ($dbLemburM[$cLemburM]->idkar == $array[0]) {
                    array_push($array, $dbLemburM[$cLemburM]->tglmsk);
                    $cLemburM++;
                } else {
                    array_push($array, "-");
                }
            } else {
                array_push($array, "-");
            }

            if (count($dbLemburK) > $cLemburK && $cek) {
                if ($dbLemburK[$cLemburK]->idkar == $array[0]) {
                    array_push($array, $dbLemburK[$cLemburK]->tglmsk);
                    $cLemburK++;
                } else {
                    array_push($array, "-");
                }
            } else {
                array_push($array, "-");
            }

            if ($cek) {
                array_push($global_array, $array);
            }
        } while ($cek);
        //dd($global_array);
        return $global_array;
    }
    
    public static function GetPresensi($idkar = 0, $tglfrom = "", $tglto = ""){
        if ($idkar == 0 && $tglfrom == "") {
            $filter = " AND MONTH(ta02.tglmsk) = MONTH(NOW()) AND YEAR(ta02.tglmsk) = YEAR(NOW()) ";
        } else if ($idkar == 0) {
            $filter = " AND DATE(ta02.tglmsk) >= DATE('" . date("Y-m-d", strtotime($tglfrom)) . "') AND DATE(ta02.tglmsk) <= DATE('" . date("Y-m-d", strtotime($tglto)) . "') ";
        } else if ($tglfrom == "") {
            $filter = " AND MONTH(ta02.tglmsk) = MONTH(NOW()) AND YEAR(ta02.tglmsk) = YEAR(NOW()) AND mk01.idkar = " . $idkar;
        } else {
            $filter = " AND DATE(ta02.tglmsk) >= DATE('" . date("Y-m-d", strtotime($tglfrom)) . "') AND DATE(ta02.tglmsk) <= DATE('" . date("Y-m-d", strtotime($tglto)) . "') AND mk01.idkar = " . $idkar;
        }
        
        $sql = "SELECT tableAbsen.tglabs, tableAbsen.idkar, tableAbsen.nama,  
                        CASE WHEN SUM(jammasuk) = 0 THEN '-' ELSE from_unixtime(SUM(jammasuk), '%H:%i') END as jammasuk, 
                        CASE WHEN SUM(jamkeluar) = 0 THEN '-' ELSE from_unixtime(SUM(jamkeluar), '%H:%i') END as jamkeluar, 
                        CASE WHEN SUM(jamkembali) = 0 THEN '-' ELSE from_unixtime(SUM(jamkembali), '%H:%i') END as jamkembali, 
                        CASE WHEN SUM(jampulang) = 0 THEN '-' ELSE from_unixtime(SUM(jampulang), '%H:%i') END as jampulang,
                        CASE WHEN SUM(jamlemburmasuk) = 0 THEN '-' ELSE from_unixtime(SUM(jamlemburmasuk), '%H:%i') END as jamlemburmasuk,
                        CASE WHEN SUM(jamlemburpulang) = 0 THEN '-' ELSE from_unixtime(SUM(jamlemburpulang), '%H:%i') END as jamlemburpulang,
                        CASE WHEN 
                                sum(jamkembali) - sum(jamkeluar) > 3600
                             THEN
                                CASE WHEN
                                        sum(tableAbsen.lbt) = 0 
                                    THEN 
                                        CONCAT(FLOOR((sum(tableAbsen.lbt)+ (sum(jamkembali) - sum(jamkeluar) - 3600)/60)/60), ' Jam ' , (sum(tableAbsen.lbt)+ floor(sum(jamkembali)/60) - floor(sum(jamkeluar)/60) - 60)%60, ' Menit') 
                                    ELSE 
                                        CONCAT(FLOOR((sum(tableAbsen.lbt)+ (sum(jamkembali) - sum(jamkeluar) - 3600)/60)/60), ' Jam ' , (sum(tableAbsen.lbt)+ floor(sum(jamkembali)/60) - floor(sum(jamkeluar)/60) - 60)%60, ' Menit') 
                                END
                             ELSE
                                CASE WHEN
                                        tableAbsen.lbt = 0 
                                    THEN 
                                        '-' 
                                    ELSE 
                                        CONCAT(FLOOR(sum(tableAbsen.lbt)/60), ' Jam ' , sum(tableAbsen.lbt) % 60, ' Menit') 
                                END
                        END as lbt
                FROM (SELECT ta01.idabs, ta01.tglabs, mk01.idkar, mk01.nama, UNIX_TIMESTAMP(ta02.tglmsk) as jammasuk, 0 as jamkeluar, 0 as jamkembali,  0 as jampulang, 0 as jamlemburmasuk, 0 as jamlemburpulang, 
                        sum( 
                            CASE WHEN (
                                CAST(
                                    TIME_TO_SEC(
                                        TIMEDIFF(DATE_FORMAT(ta02.tglmsk, '%H:%i'), DATE_FORMAT(mj02.jmmsk, '%H:%i'))
                                    )/60 as integer)
                                ) < 0 
                            THEN 
                                0 
                            ELSE (
                                CAST(
                                    TIME_TO_SEC(
                                        TIMEDIFF(DATE_FORMAT(ta02.tglmsk, '%H:%i'), DATE_FORMAT(mj02.jmmsk, '%H:%i'))
                                    )/60 as integer)
                                ) 
                            END
                        ) as lbt

                        FROM mk01
                        INNER JOIN ta02 ON ta02.mk01_id = mk01.idkar
                        INNER JOIN ta01 ON ta01.idabs = ta02.ta01_id
                        INNER JOIN mj02 ON mj02.idjk = ta01.idjk
                        WHERE ta02.abscd = 0 $filter
                        GROUP BY idabs, idkar
                        UNION
                        SELECT ta01.idabs, ta01.tglabs, mk01.idkar, mk01.nama, 0 as jammasuk, 0 as jamkeluar, 0 as jamkembali,  UNIX_TIMESTAMP(ta02.tglmsk) as jampulang, 0 as jamlemburmasuk, 0 as jamlemburpulang,
                            sum( 
                                CASE WHEN (
                                    CAST(
                                        TIME_TO_SEC(
                                            TIMEDIFF(DATE_FORMAT(mj02.jmklr, '%H:%i'), DATE_FORMAT( ta02.tglmsk, '%H:%i'))
                                        )/60 as integer)
                                    ) < 0 
                                THEN 
                                    0 
                                ELSE (
                                    CAST(
                                        TIME_TO_SEC(
                                            TIMEDIFF(DATE_FORMAT(mj02.jmklr, '%H:%i'), DATE_FORMAT( ta02.tglmsk, '%H:%i'))
                                        )/60 as integer)
                                    ) 
                                END
                            ) as lbt
                        FROM mk01
                        INNER JOIN ta02 ON ta02.mk01_id = mk01.idkar
                        INNER JOIN ta01 ON ta01.idabs = ta02.ta01_id
                        INNER JOIN mj02 ON mj02.idjk = ta01.idjk
                        WHERE ta02.abscd = 1 $filter
                        GROUP BY idabs, idkar
                        UNION
                        SELECT ta01.idabs, ta01.tglabs, mk01.idkar, mk01.nama, 0 as jammasuk, UNIX_TIMESTAMP(ta02.tglmsk) as jamkeluar, 0 as jamkembali, 0 as jampulang, 0 as jamlemburmasuk, 0 as jamlemburpulang, 0 as lbt
                        FROM mk01
                        INNER JOIN ta02 ON ta02.mk01_id = mk01.idkar
                        INNER JOIN ta01 ON ta01.idabs = ta02.ta01_id
                        WHERE ta02.abscd = 2 $filter
                        GROUP BY idabs, idkar
                        UNION
                        SELECT ta01.idabs, ta01.tglabs, mk01.idkar, mk01.nama, 0 as jammasuk, 0 as jamkeluar, UNIX_TIMESTAMP(ta02.tglmsk) as jamkembali, 0 as jampulang, 0 as jamlemburmasuk, 0 as jamlemburpulang, 0 as lbt
                        FROM mk01
                        INNER JOIN ta02 ON ta02.mk01_id = mk01.idkar
                        INNER JOIN ta01 ON ta01.idabs = ta02.ta01_id
                        WHERE ta02.abscd = 3 $filter
                        GROUP BY idabs, idkar
                        UNION
                        SELECT ta01.idabs, ta01.tglabs, mk01.idkar, mk01.nama, 0 as jammasuk, 0 as jamkeluar, 0 as jamkembali, 0 as jampulang, UNIX_TIMESTAMP(ta02.tglmsk) as jamlemburmasuk, 0 as jamlemburpulang, 0 as lbt
                        FROM mk01
                        INNER JOIN ta02 ON ta02.mk01_id = mk01.idkar
                        INNER JOIN ta01 ON ta01.idabs = ta02.ta01_id
                        WHERE ta02.abscd = 4 $filter
                        GROUP BY idabs, idkar
                        UNION
                        SELECT ta01.idabs, ta01.tglabs, mk01.idkar, mk01.nama, 0 as jammasuk, 0 as jamkeluar, 0 as jamkembali, 0 as jampulang, 0 as jamlemburmasuk, UNIX_TIMESTAMP(ta02.tglmsk) as jamlemburpulang, 0 as lbt
                        FROM mk01
                        INNER JOIN ta02 ON ta02.mk01_id = mk01.idkar
                        INNER JOIN ta01 ON ta01.idabs = ta02.ta01_id
                        WHERE ta02.abscd = 5 $filter
                        GROUP BY idabs, idkar ) as tableAbsen
                GROUP by tableAbsen.idabs, tableAbsen.tglabs, tableAbsen.idkar, tableAbsen.nama
                ORDER BY tableAbsen.tglabs ASC";
        //dd($sql);
        $dbAbsen = DB::select(DB::raw($sql));
        return $dbAbsen;
    }

    public static function GetTa01_id($idkar, $tanggal) {
        $sql = "SELECT ta01_id FROM `ta02` WHERE `mk01_id` = " . $idkar . " and date(`tglmsk`) = date('" . date("Y-m-d H:i:s", strtotime($tanggal)) . "')";
        $data = DB::select(DB::raw($sql));
        if (count($data) == 0) {
            return false;
        }
        return $data[0]->ta01_id;
    }

    public static function CheckPresensi($idkar, $idjk, $tanggal, $abscd) {
        $sql = "SELECT * FROM `ta02` WHERE abscd = " . $abscd . " and ta01_id = " . $idjk . " and `mk01_id` = " . $idkar . " and date(`tglmsk`) = date('" . date("Y-m-d H:i:s", strtotime($tanggal)) . "')";
        $data = DB::select(DB::raw($sql));
        if (count($data) != 0) {
            return $data[0]->id;
        }
        return FALSE;
    }

    public static function UpdatePresensi($id, $tanggal, $jam) {
//        $sql = "UPDATE `ta02` SET `tglmsk`='" . date("Y-m-d", strtotime($tanggal)) . " " . $jam . "' WHERE `id` = " . $id;
//        DB::update();
        
        $ta02 = ta02::find($id);
        $ta02->tglmsk = date("Y-m-d", strtotime($tanggal)) . " " . $jam;
        $ta02->save();
    }

    public static function InsertPresensi($idkar, $idjk, $tanggal, $jam, $abscd) {
        $ta02 = new ta02();
        $ta02->mk01_id = $idkar;
        $ta02->ta01_id = $idjk;
        $ta02->tglmsk = date("Y-m-d", strtotime($tanggal)) . " " . $jam;
        $ta02->abscd = $abscd;
        $ta02->created_at = date("Y-m-d H:i:s");
        $ta02->updated_at = date("Y-m-d H:i:s");
        $ta02->save();
    }

}

?>