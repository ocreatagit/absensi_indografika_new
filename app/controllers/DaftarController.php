<?php

class DaftarController extends \BaseController {

    public function getTimeServer() {
        date_default_timezone_set('Asia/Jakarta');
//        echo date('H:i:s');
        echo date('H:i:s');
    }

    public function getDateServer() {
        date_default_timezone_set('Asia/Jakarta');
        echo date('d F Y');
    }

    public function getDaftarMasuk() {
        $sql = "SELECT tableAbsen.tglabs, tableAbsen.idkar, tableAbsen.nama,  
                        CASE WHEN SUM(jammasuk) = 0 THEN '-' ELSE from_unixtime(SUM(jammasuk), '%H:%i') END as jammasuk, 
                        CASE WHEN SUM(jamkeluar) = 0 THEN '-' ELSE from_unixtime(SUM(jamkeluar), '%H:%i') END as jamkeluar, 
                        CASE WHEN SUM(jamkembali) = 0 THEN '-' ELSE from_unixtime(SUM(jamkembali), '%H:%i') END as jamkembali, 
                        CASE WHEN SUM(jampulang) = 0 THEN '-' ELSE from_unixtime(SUM(jampulang), '%H:%i') END as jampulang,
                        CASE WHEN SUM(jamlemburmasuk) = 0 THEN '-' ELSE from_unixtime(SUM(jamlemburmasuk), '%H:%i') END as jamlemburmasuk,
                        CASE WHEN SUM(jamlemburpulang) = 0 THEN '-' ELSE from_unixtime(SUM(jamlemburpulang), '%H:%i') END as jamlemburpulang,
                        CASE WHEN tableAbsen.lbt = 0 THEN '-' ELSE CONCAT(FLOOR(tableAbsen.lbt/60), ' Jam ' , tableAbsen.lbt % 60, ' Menit') END as lbt
                FROM (SELECT ta01.idabs, ta01.tglabs, mk01.idkar, mk01.nama, UNIX_TIMESTAMP(ta02.tglmsk) as jammasuk, 0 as jamkeluar, 0 as jamkembali,  0 as jampulang, 0 as jamlemburmasuk, 0 as jamlemburpulang, 
                        sum( CASE WHEN (CAST(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(ta02.tglmsk, '%H:%i'), DATE_FORMAT(mj02.jmmsk, '%H:%i')))/60 as integer)) < 0 THEN 0 ELSE (CAST(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(ta02.tglmsk, '%H:%i'), DATE_FORMAT(mj02.jmmsk, '%H:%i')))/60 as integer)) END ) as lbt

                        FROM mk01
                        RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                        INNER JOIN ta01 ON ta01.idabs = ta02.ta01_id
                        RIGHT JOIN mj02 ON mj02.idjk = ta01.idjk
                        WHERE date(ta02.tglmsk) = date(now()) AND ta02.abscd = 0
                        GROUP BY idabs, idkar
                        UNION
                        SELECT ta01.idabs, ta01.tglabs, mk01.idkar, mk01.nama, 0 as jammasuk, 0 as jamkeluar, 0 as jamkembali,  UNIX_TIMESTAMP(ta02.tglmsk) as jampulang, 0 as jamlemburmasuk, 0 as jamlemburpulang, 0 as lbt
                        FROM mk01
                        RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                        INNER JOIN ta01 ON ta01.idabs = ta02.ta01_id
                        WHERE date(ta02.tglmsk) = date(now()) AND ta02.abscd = 1
                        UNION
                        SELECT ta01.idabs, ta01.tglabs, mk01.idkar, mk01.nama, 0 as jammasuk, UNIX_TIMESTAMP(ta02.tglmsk) as jamkeluar, 0 as jamkembali, 0 as jampulang, 0 as jamlemburmasuk, 0 as jamlemburpulang, 0 as lbt
                        FROM mk01
                        RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                        INNER JOIN ta01 ON ta01.idabs = ta02.ta01_id
                        WHERE date(ta02.tglmsk) = date(now()) AND ta02.abscd = 2
                        UNION
                        SELECT ta01.idabs, ta01.tglabs, mk01.idkar, mk01.nama, 0 as jammasuk, 0 as jamkeluar, UNIX_TIMESTAMP(ta02.tglmsk) as jamkembali, 0 as jampulang, 0 as jamlemburmasuk, 0 as jamlemburpulang, 0 as lbt
                        FROM mk01
                        RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                        INNER JOIN ta01 ON ta01.idabs = ta02.ta01_id
                        WHERE date(ta02.tglmsk) = date(now()) AND ta02.abscd = 3
                        UNION
                        SELECT ta01.idabs, ta01.tglabs, mk01.idkar, mk01.nama, 0 as jammasuk, 0 as jamkeluar, 0 as jamkembali, 0 as jampulang, UNIX_TIMESTAMP(ta02.tglmsk) as jamlemburmasuk, 0 as jamlemburpulang, 0 as lbt
                        FROM mk01
                        RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                        INNER JOIN ta01 ON ta01.idabs = ta02.ta01_id
                        WHERE date(ta02.tglmsk) = date(now()) AND ta02.abscd = 4
                        UNION
                        SELECT ta01.idabs, ta01.tglabs, mk01.idkar, mk01.nama, 0 as jammasuk, 0 as jamkeluar, 0 as jamkembali, 0 as jampulang, 0 as jamlemburmasuk, UNIX_TIMESTAMP(ta02.tglmsk) as jamlemburpulang, 0 as lbt
                        FROM mk01
                        RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                        INNER JOIN ta01 ON ta01.idabs = ta02.ta01_id
                        WHERE date(ta02.tglmsk) = date(now()) AND ta02.abscd = 5) as tableAbsen
                GROUP by tableAbsen.idabs, tableAbsen.tglabs, tableAbsen.idkar, tableAbsen.nama";

        $dbAbsen = DB::select(DB::raw($sql));
        echo json_encode($dbAbsen);
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
