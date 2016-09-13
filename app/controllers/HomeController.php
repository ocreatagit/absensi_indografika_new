<?php

class HomeController extends BaseController {

    public function getAbsen() {
        date_default_timezone_set('Asia/Jakarta');
        $sql = "SELECT mk01.idkar,
		mk01.nama,
        mk01.pic,
                            DATE_FORMAT(ta02.tglmsk, '%H:%i') as jammsk, 
                            ta02.abscd,
                            CASE WHEN 
                            	ta02.abscd = 0
                            THEN 
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
                            WHEN ta02.abscd = 1 
                            THEN
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
                            ELSE
                             0
                            END  as lbt 

                            FROM ta02
                    INNER JOIN ta01 on ta01.idabs = ta02.ta01_id
                    INNER JOIN mk01 on mk01.idkar = ta02.mk01_id
                    INNER JOIN mj02 on mj02.idjk = ta01.idjk
                    WHERE ta02.tglmsk >= '" . date('Y-m-d H:i:s', time() - 5) . "' 
                    ORDER BY ta02.tglmsk DESC LIMIT 1";
        $data = DB::select(DB::raw($sql));
        echo json_encode($data);
    }

    public function test() {
        $sql = " . date('Y-m-d H:i:s', time() - 5) . ";
        return View::make("myindografika.master");
    }

}
