<?php

class DaftarController extends \BaseController {

    public function getTimeServer() {
        date_default_timezone_set('Asia/Jakarta');
        echo date('H:i:s');
    }

    public function getDateServer() {
        date_default_timezone_set('Asia/Jakarta');
        echo date('d F Y');
    }

    public function getDaftarMasuk() {
        $sqlMasuk = "SELECT mk01.idkar, 
                       mk01.nama, 
                       DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                FROM mk01
                RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                WHERE date(ta02.tglmsk) = date(NOW()) AND ta02.abscd = 0";
        $sqlPulang = "SELECT mk01.idkar, 
                       mk01.nama, 
                       DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                FROM mk01
                RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                WHERE date(ta02.tglmsk) = date(NOW()) AND ta02.abscd = 1";
        $sqlKeluar = "SELECT mk01.idkar, 
                       mk01.nama, 
                       DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                FROM mk01
                RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                WHERE date(ta02.tglmsk) = date(NOW()) AND ta02.abscd = 2";
        $sqlKembali = "SELECT mk01.idkar, 
                       mk01.nama, 
                       DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                FROM mk01
                RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                WHERE date(ta02.tglmsk) = date(NOW()) AND ta02.abscd = 3";

        $dbMasuk = DB::select(DB::raw($sqlMasuk));
        $dbPulang = DB::select(DB::raw($sqlPulang));
        $dbKeluar = DB::select(DB::raw($sqlKeluar));
        $dbKembali = DB::select(DB::raw($sqlKembali));

        $cMasuk = 0;
        $cPulang = 0;
        $cKeluar = 0;
        $cKembali = 0;

        $cek = true;
        $global_array = array();
        do {
            $array = array();
            if (count($dbMasuk) > $cMasuk) {
                array_push($array, $dbMasuk[$cMasuk]->idkar);
                array_push($array, $dbMasuk[$cMasuk]->nama);
                array_push($array, $dbMasuk[$cMasuk]->tglmsk);
                $cMasuk++;
            } else {
                $cek = FALSE;
            }

            if (count($dbPulang) > $cPulang) {
                if ($dbPulang[$cPulang]->idkar == $array[0]) {
                    array_push($array, $dbPulang[$cPulang]->tglmsk);
                    $cPulang++;
                } else {
                    array_push($array, "-");
                }
            } else {
                array_push($array, "-");
            }

            if (count($dbKeluar) > $cKeluar) {
                if ($dbKeluar[$cKeluar]->idkar == $array[0]) {
                    array_push($array, $dbKeluar[$cKeluar]->tglmsk);
                    $cKeluar++;
                } else {
                    array_push($array, "-");
                }
            } else {
                array_push($array, "-");
            }

            if (count($dbKembali) > $cKembali) {
                if ($dbKembali[$cKembali]->idkar == $array[0]) {
                    array_push($array, $dbKembali[$cKembali]->tglmsk);
                    $cKembali++;
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



        echo json_encode($global_array);
    }

    public function getDaftarPulang() {
        $sql = "SELECT mk01.idkar, 
                       mk01.nama, 
                       DATE_FORMAT(mj02.jmklr, '%H:%i') as jmmsk, 
                       DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk,
                       CAST(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(ta02.tglmsk, '%H:%i'), DATE_FORMAT(mj02.jmklr, '%H:%i')))/60 as integer) as lbt  
                FROM mk01
                RIGHT JOIN mj03 ON mj03.mk01_id = mk01.idkar
                RIGHT JOIN mj02 ON mj02.idjk = mj03.mj02_id

                RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                WHERE date(ta02.tglmsk) = date(NOW()) AND ta02.abscd = 1";
        echo json_encode(DB::select(DB::raw($sql)));
    }

}
