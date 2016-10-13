<?php

class tg01 extends Eloquent {

    protected $table = 'tg01';
    protected $primaryKey = 'idtg';

    function mk01() {
        return $this->belongsTo('mk01');
    }

    function tg02() {
        return $this->hasMany('tg02');
    }

    function getAutoIncrement() {
        $sql = "SELECT AUTO_INCREMENT as idtg FROM information_schema.tables WHERE  TABLE_SCHEMA = 'absensi' AND TABLE_NAME = 'tg01'";
        $idtg = DB::select(DB::raw($sql));
        $idtg = $idtg[0];
        return $idtg->idtg;
    }

    // Pengganti method : getJumlahHariGaji
    function getJamKerjaInSec($idkar, $date) {
        $sql = "SELECT mg01.*, mg02.mk01_id, mg02.mg01_id, mg02.nilgj, 
                CASE WHEN mg01.jntgh = 'Bulan' 
                THEN 
                        COALESCE(period_diff(date_format(DATE_ADD('$date', INTERVAL 1 MONTH), '%Y%m'), date_format('$date', '%Y%m')), 0)
                ELSE 
                        CASE WHEN mg01.jntgh = 'Hari' 
                        THEN 
                                COALESCE((SELECT                                  
                                SUM(ifnull(CAST(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(tabel_terluar.goHome, '%H:%i'), DATE_FORMAT(tabel_terluar.goWork, '%H:%i'))) as integer),0)) + SUM(ifnull(CAST(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(tabel_terluar.breakIn, '%H:%i'), DATE_FORMAT(tabel_terluar.breakOut, '%H:%i'))) as integer),3600)) 
                                FROM ( 
                                    SELECT DISTINCT 
                                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 0 ) as goWork, 
                                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 2 ) as breakOut, 
                                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 3 ) as breakIn, 
                                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 1 ) as goHome,
                                        mk01_id
                                    FROM ta02 as tabel_luar 
                                        WHERE MONTH(tabel_luar.tglmsk) = MONTH('$date') AND YEAR(tabel_luar.tglmsk) = YEAR('$date')
                                    ) as tabel_terluar
                                    WHERE mk01_id = karyawan.idkar
                                GROUP BY mk01_id), 0)
                        ELSE 
                COALESCE((SELECT 
                COALESCE((SUM(ifnull(CAST(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(tabel_terluar.overWorkOut, '%H:%i'), DATE_FORMAT(tabel_terluar.overWorkIn, '%H:%i'))) as integer),0))), 0) as nilai
                FROM ( 
                    SELECT DISTINCT         
                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 4 ) as overWorkIn,
                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 5 ) as overWorkOut,
                        mk01_id
                    FROM ta02 as tabel_luar 
                        WHERE MONTH(tabel_luar.tglmsk) = MONTH('$date') AND YEAR(tabel_luar.tglmsk) = YEAR('$date')
                    ) as tabel_terluar
                    WHERE mk01_id = karyawan.idkar
                GROUP BY mk01_id), 0)
                        END 
                END as jmtgh,
                CASE WHEN mg01.jntgh = 'Hari' THEN
                    (SELECT COUNT(*) FROM ta02 WHERE ta02.abscd = 0 AND ta02.mk01_id = karyawan.idkar AND MONTH(ta02.tglmsk) = MONTH('$date'))
                        ELSE
                            CASE WHEN mg01.jntgh = 'Bulan' THEN
                                period_diff(date_format(DATE_ADD('$date', INTERVAL 1 MONTH), '%Y%m'), date_format('$date', '%Y%m'))
                            ELSE
                                0 
                            END
                        END
                    as hari
                FROM mg02 
                INNER JOIN mg01 ON mg01.idgj = mg02.mg01_id 
                INNER JOIN mk01 as karyawan ON karyawan.idkar = mg02.mk01_id
                WHERE karyawan.idkar = $idkar;";
//        echo $sql; exit;
        return $detail = DB::select(DB::raw($sql));
    }

    function getGajiStatusN($startdate = '', $enddate = '', $idkar = 0, $statusBayar = "%") {
        $sql = "SELECT tg01.*, mk01.nama FROM tg01 INNER JOIN mk01 ON mk01.idkar = tg01.idkar";
        if ($startdate != '' && $idkar != 0) {
            $sql .= " WHERE tg01.tgltg >= '$startdate' AND tg01.tgltg <= '$enddate' AND tg01.idkar = $idkar";
        } else if ($startdate != '' && $idkar == 0) {
            $sql .= " WHERE tg01.tgltg >= '$startdate' AND tg01.tgltg <= '$enddate'";
        } else if ($startdate == '' && $idkar != 0) {
            $sql .= " WHERE tg01.idkar = $idkar";
        }
        $sql.= " AND tg01.status LIKE '$statusBayar' ORDER BY tgltg ASC, `status` ASC;";
//        dd($sql);
        $tg01 = DB::select(DB::raw($sql));
        return $tg01;
    }

    function getGajiStatusNMonthYear($month = '', $month2 = '', $year = '', $idkar = 0, $statusBayar = "%") {
        $sql = "SELECT tg01.*, mk01.nama FROM tg01 INNER JOIN mk01 ON mk01.idkar = tg01.idkar";
        if ($month != '' && $idkar != 0) {
            $sql .= " WHERE MONTH(tg01.tgltg) >= '$month' AND MONTH(tg01.tgltg) <= '$month2' AND YEAR(tg01.tgltg) = '$year' AND tg01.idkar = $idkar";
        } else if ($month != '' && $idkar == 0) {
            $sql .= " WHERE MONTH(tg01.tgltg) >= '$month' AND MONTH(tg01.tgltg) <= '$month2' AND YEAR(tg01.tgltg) = '$year'";
        } else if ($month == '' && $idkar != 0) {
            $sql .= " WHERE YEAR(tg01.tgltg) = '$year' AND tg01.idkar = $idkar";
        } else {
            $sql .= " WHERE YEAR(tg01.tgltg) = '$year'";
        }
        $sql.= " AND tg01.status LIKE '$statusBayar';";
//        dd($sql);
        $tg01 = DB::select(DB::raw($sql));
        return $tg01;
    }

    function getKehadiranGaji($date, $idkar) {
        $sql = "SELECT COUNT(*) as countHadir FROM ta02 WHERE mk01_id = $idkar AND MONTH(tglmsk) = " . date("n", strtotime($date)) . " AND abscd = 0;";
        $count = DB::select(DB::raw($sql));
        $count = $count[0];
        return $count->countHadir;
    }

    function getDurasiBekerjaGaji($date, $idkar) {
        $sql = "SELECT (SUM(ifnull(CAST(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(tabel_terluar.goHome, '%H:%i'), DATE_FORMAT(tabel_terluar.goWork, '%H:%i'))) as integer),0)) + 
                SUM(ifnull(CAST(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(tabel_terluar.breakIn, '%H:%i'), DATE_FORMAT(tabel_terluar.breakOut, '%H:%i'))) as integer),3600))) as durasiBekerja
                FROM ( 
                    SELECT DISTINCT 
                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 0 ) as goWork, 
                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 2 ) as breakOut, 
                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 3 ) as breakIn, 
                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 1 ) as goHome,
                        mk01_id
                    FROM ta02 as tabel_luar 
                        WHERE MONTH(tabel_luar.tglmsk) = " . date("n", strtotime($date)) . " AND YEAR(tabel_luar.tglmsk) = " . date("Y", strtotime($date)) . "
                    ) as tabel_terluar
                WHERE mk01_id = $idkar
                GROUP BY mk01_id;";
        $count = DB::select(DB::raw($sql));
        if (count($count) != 0) {
            $count = $count[0];
            $count = $count->durasiBekerja;
        } else {
            $count = 0;
        }
        return $count;
    }

    function getDurasiLemburGaji($date, $idkar) {
        $sql = "SELECT SUM(ifnull(CAST(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(tabel_terluar.overWorkOut, '%H:%i'), DATE_FORMAT(tabel_terluar.overWorkIn, '%H:%i'))) as integer),0)) as jamlembur
                FROM ( 
                    SELECT DISTINCT 
                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 0 ) as goWork, 
                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 2 ) as breakOut, 
                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 3 ) as breakIn, 
                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 1 ) as goHome,
                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 4 ) as overWorkIn,
                        (SELECT tglmsk FROM ta02 WHERE DATE(tglmsk) = DATE(tabel_luar.tglmsk) AND mk01_id = tabel_luar.mk01_id AND abscd = 5 ) as overWorkOut,
                        mk01_id
                    FROM ta02 as tabel_luar 
                        WHERE MONTH(tabel_luar.tglmsk) = " . date("n", strtotime($date)) . " AND YEAR(tabel_luar.tglmsk) = " . date("Y", strtotime($date)) . "
                    ) as tabel_terluar
                WHERE mk01_id = $idkar
                GROUP BY mk01_id;";
//        echo $sql; exit;
        $count = DB::select(DB::raw($sql));
        if (count($count) != 0) {
            $count = $count[0];
            $count = $count->jamlembur;
        } else {
            $count = 0;
        }
        return $count;
    }

    function getKeterlambatan($date, $idkar) {
        $sqlmasuk = "SELECT sum( 
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
                WHERE MONTH(ta02.tglmsk) = " . date("n", strtotime($date)) . " AND YEAR(ta02.tglmsk) = " . date("Y", strtotime($date)) . " AND ta02.abscd = 0 AND mj02.tipe = 1 AND mk01.idkar = $idkar"
        ;
        $sqlpulang = "SELECT ta01.idabs, ta01.tglabs, mk01.idkar, mk01.nama, 0 as jammasuk, 0 as jamkeluar, 0 as jamkembali,  UNIX_TIMESTAMP(ta02.tglmsk) as jampulang, 0 as jamlemburmasuk, 0 as jamlemburpulang,
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
                WHERE MONTH(ta02.tglmsk) = " . date("n", strtotime($date)) . " AND YEAR(ta02.tglmsk) = " . date("Y", strtotime($date)) . " AND ta02.abscd = 1 AND mj02.tipe = 1 AND mk01.idkar = $idkar"
        ;
        $sqlistirahat = "SELECT sum(tabelluar.lbt) as lbt
                from(
                SELECT 
                        CASE WHEN SUM(jamkeluar) = 0 THEN '-' ELSE from_unixtime(SUM(jamkeluar), '%H:%i') END as jamkeluar, 
                        CASE WHEN SUM(jamkembali) = 0 THEN '-' ELSE from_unixtime(SUM(jamkembali), '%H:%i') END as jamkembali,
                        CASE WHEN 
                                sum(jamkembali) - sum(jamkeluar) > 3600
                             THEN
                                (floor(sum(jamkembali)/60) - floor(sum(jamkeluar)/60) - 60)%60
                             ELSE
                                0
                        END as lbt
                FROM (
                        SELECT ta01.idabs, ta01.tglabs, mk01.idkar, mk01.nama, 0 as jammasuk, UNIX_TIMESTAMP(ta02.tglmsk) as jamkeluar, 0 as jamkembali, 0 as jampulang, 0 as jamlemburmasuk, 0 as jamlemburpulang, 0 as lbt
                        FROM mk01
                        INNER JOIN ta02 ON ta02.mk01_id = mk01.idkar
                        INNER JOIN ta01 ON ta01.idabs = ta02.ta01_id
                        WHERE ta02.abscd = 2 AND MONTH(ta02.tglmsk) = " . date("n", strtotime($date)) . " AND YEAR(ta02.tglmsk) = " . date("Y", strtotime($date)) . " AND mk01.idkar = $idkar
                        UNION
                        SELECT ta01.idabs, ta01.tglabs, mk01.idkar, mk01.nama, 0 as jammasuk, 0 as jamkeluar, UNIX_TIMESTAMP(ta02.tglmsk) as jamkembali, 0 as jampulang, 0 as jamlemburmasuk, 0 as jamlemburpulang, 0 as lbt
                        FROM mk01
                        INNER JOIN ta02 ON ta02.mk01_id = mk01.idkar
                        INNER JOIN ta01 ON ta01.idabs = ta02.ta01_id
                        WHERE ta02.abscd = 3 AND MONTH(ta02.tglmsk) = " . date("n", strtotime($date)) . " AND YEAR(ta02.tglmsk) = " . date("Y", strtotime($date)) . " AND mk01.idkar = $idkar
                         ) as tableAbsen
                         GROUP by tableAbsen.idabs, tableAbsen.tglabs, tableAbsen.idkar, tableAbsen.nama)as tabelluar";

        $count = DB::select(DB::raw($sqlmasuk));
        $count1 = DB::select(DB::raw($sqlpulang));
        $count2 = DB::select(DB::raw($sqlistirahat));

        if (count($count) != 0) {
            $count = $count[0]->lbt;
        } else {
            $count = 0;
        }

        if (count($count1) != 0) {
            $count1 = $count1[0]->lbt;
        } else {
            $count1 = 0;
        }

        if (count($count2) != 0) {
            $count2 = $count2[0]->lbt;
        } else {
            $count2 = 0;
        }
        //dd($sqlmasuk."<br><br>".$sqlpulang."<br><br>".$sqlistirahat);
        return $count + $count1 + $count2;
    }

    function checkExistHutangKaryawan($date, $idkar) {
        $th02 = DB::table('th02')
                ->join('th01', 'th01.idhut', '=', 'th02.idhut')
                ->select('th02.idph', 'th02.tglph')
                ->where('th01.idkar', '=', $idkar)
                ->where('th02.idtg', '=', 0)
                ->whereMonth('th02.tglph', '=', date("n", strtotime($date)))
                ->whereYear('th02.tglph', '=', date("Y", strtotime($date)))
                ->get();
        if (count($th02) > 0) {
            return $th02[0]->idph;
        } else {
            return -1;
        }
    }

    function checkExistTabunganKaryawan($date, $idkar) {
        $tt01 = DB::table('tt01')
                ->select('tt01.idtb', 'tt01.tgltb')
                ->where('tt01.idkar', '=', $idkar)
                ->where('tt01.idtg', '=', 0)
                ->whereMonth('tt01.tgltb', '=', date("n", strtotime($date)))
                ->whereYear('tt01.tgltb', '=', date("Y", strtotime($date)))
                ->get();
        if (count($tt01) > 0) {
            return $tt01[0]->idtb;
        } else {
            return -1;
        }
    }

    function updateHutangTabunganLunas($idph, $idtb) {
        if ($idph != -1) {
            $idhut = th02::find($idph)->idhut;
            $sql = "SELECT COUNT(idtg) as c_idtg
                    FROM th02 
                    WHERE idhut = $idhut AND idtg = 0;";

            $count = DB::select(DB::raw($sql));
            $flaglunas = $count[0]->c_idtg;

            if ($flaglunas == 0) {
                $th01 = th01::find($idhut);
                $th01->flglns = "Y";
                $th01->save();
            }
        }
    }

    function updateStatusGaji($idtg, $status) {
        $tg01 = tg01::find($idtg);
        $tg01->status = $status;
        $tg01->save();
    }

    function getGajiKaryawanBersih($date, $idkar) {
        $SQL = "SELECT COALESCE(ttlgj, 0) as ttlgj FROM tg01 WHERE MONTH(tglgjsblm) = '" . date("m", strtotime($date)) . "' AND YEAR(tglgjsblm) = '" . date("Y", strtotime($date)) . "' AND idkar = " . $idkar . ";";
        $tg01 = DB::select(DB::raw($SQL));
        if (count($tg01) > 0) {
            $tg01 = $tg01[0];
            return $tg01->ttlgj;
        } else {
            return 0;
        }
    }

    function getGajiKaryawanKotor($date, $idkar) {
        $SQL = "SELECT COALESCE((ttlgj + ttlbns), 0) as ttlgjktr FROM tg01 WHERE MONTH(tglgjsblm) = '" . date("m", strtotime($date)) . "' AND YEAR(tglgjsblm) = '" . date("Y", strtotime($date)) . "' AND idkar = " . $idkar . ";";
        $tg01 = DB::select(DB::raw($SQL));
        if (count($tg01) > 0) {
            $tg01 = $tg01[0];
            return $tg01->ttlgjktr;
        } else {
            return 0;
        }
    }

    function checkExistTglgj($date, $idkar) {
        $SQL = "SELECT count(idtg) as idtg FROM tg01 WHERE MONTH(tgltg) = '" . date("m", strtotime($date)) . "' AND YEAR(tgltg) = '" . date("Y", strtotime($date)) . "' AND idkar = " . $idkar . ";";
        $tg01 = DB::select(DB::raw($SQL));
        if (count($tg01) > 0) {
            $tg01 = $tg01[0];
            if ($tg01->idtg == 0) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }
    function getSlipGaji($date, $idkar) {
        $SQL = "SELECT idtg, status FROM tg01 WHERE idkar = $idkar AND MONTH(tgltg) = MONTH('$date') AND YEAR(tgltg) = YEAR('$date');";
        $tg01 = DB::select(DB::raw($SQL));
        if (count($tg01) > 0) {
            $tg01 = $tg01[0];
            if($tg01->status == 'Y')
                return $tg01->idtg;
            else
                return -1;
        } else {
            return -1;
        }
    }
    
}
