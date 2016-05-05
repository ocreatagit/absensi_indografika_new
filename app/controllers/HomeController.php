<?php
class HomeController extends BaseController {

    public function getAbsen() {
        date_default_timezone_set('Asia/Jakarta');
        $sql = "SELECT mk01.idkar, 
                            mk01.nama, 
                            DATE_FORMAT(ta02.tglmsk, '%H:%i') as jammsk, 
                            ta02.abscd,
                            mk01.pic,
                            CAST(TIME_TO_SEC(TIMEDIFF(DATE_FORMAT(ta02.tglmsk, '%H:%i'), DATE_FORMAT(mj02.jmmsk, '%H:%i')))/60 as integer) as lbt 
                            FROM ta02
                    INNER JOIN mk01 on mk01.idkar = ta02.mk01_id
                    INNER JOIN mj03 ON mj03.mk01_id = ta02.mk01_id
                    INNER JOIN mj02 ON mj02.idjk = mj03.mj02_id
                    WHERE ta02.tglmsk >= '" . date('Y-m-d H:i:s', time() - 30) . "' 
                    ORDER BY ta02.tglmsk DESC LIMIT 1";
        $data = DB::select(DB::raw($sql));
        echo json_encode($data);
    }
    
    public function test(){
        return View::make("myindografika.master");
    }

}
