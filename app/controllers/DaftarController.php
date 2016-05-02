<?php

class DaftarController extends \BaseController {
    
    public function getTimeServer(){  
        date_default_timezone_set('Asia/Jakarta');
        echo date('H:i:s');
    }
    
    public function getDateServer(){  
        date_default_timezone_set('Asia/Jakarta');
        echo date('d F Y');
    }

    public function getDaftarMasuk(){
        $sql = "SELECT mk01.idkar, mk01.nama, DATE_FORMAT(mj02.jmmsk, '%H:%i') as jmmsk, DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk,CAST(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(ta02.tglmsk, '%H:%i'), DATE_FORMAT(mj02.jmmsk, '%H:%i')))/60 as integer) as lbt  FROM mk01
                RIGHT JOIN mj03 ON mj03.mk01_id = mk01.idkar
                RIGHT JOIN mj02 ON mj02.idjk = mj03.mj02_id

                RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                WHERE date(ta02.tglmsk) = date(NOW()) AND ta02.abscd = 0";
        echo json_encode(DB::select(DB::raw($sql)));
    }
    
    public function getDaftarPulang(){
        $sql = "SELECT mk01.idkar, mk01.nama, DATE_FORMAT(mj02.jmklr, '%H:%i') as jmmsk, DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk,CAST(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(ta02.tglmsk, '%H:%i'), DATE_FORMAT(mj02.jmklr, '%H:%i')))/60 as integer) as lbt  FROM mk01
                RIGHT JOIN mj03 ON mj03.mk01_id = mk01.idkar
                RIGHT JOIN mj02 ON mj02.idjk = mj03.mj02_id

                RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                WHERE date(ta02.tglmsk) = date(NOW()) AND ta02.abscd = 1";
        echo json_encode(DB::select(DB::raw($sql)));
    }
}
