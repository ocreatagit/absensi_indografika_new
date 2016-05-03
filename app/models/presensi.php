<?php
 class Presensi
 {
 	
 	public static function getPresensi($idkar = 0, $tglfrom = "", $tglto = "")
 	{
 		if($idkar == 0 && $tglfrom == ""){
 			$filter = " AND MONTH(ta02.tglmsk) = MONTH(NOW()) AND YEAR(ta02.tglmsk) = YEAR(NOW()) "; 			
 		}else if($idkar == 0){
			$filter = " AND DATE(ta02.tglmsk) >= DATE('".date("Y-m-d", strtotime($tglfrom))."') AND DATE(ta02.tglmsk) <= DATE('".date("Y-m-d", strtotime($tglto))."') "; 			
 		}else if($tglfrom == ""){
			$filter = " AND MONTH(ta02.tglmsk) = MONTH(NOW()) AND YEAR(ta02.tglmsk) = YEAR(NOW()) AND mk01.idkar = ".$idkar;
 		}
 		else{
 			$filter = " AND DATE(ta02.tglmsk) >= DATE('".date("Y-m-d", strtotime($tglfrom))."') AND DATE(ta02.tglmsk) <= DATE('".date("Y-m-d", strtotime($tglto))."') AND mk01.idkar = ".$idkar; 
 		}
 		

            $sqlMasuk = "SELECT mk01.idkar, 
                           mk01.nama, 
                           ta02.tglmsk as tgl,
                           DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                    FROM mk01
                    RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                    WHERE ta02.abscd = 0 ".$filter;
            $sqlPulang = "SELECT mk01.idkar, 
                           mk01.nama, 
                           DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                    FROM mk01
                    RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                    WHERE ta02.abscd = 1 ".$filter;
            $sqlKeluar = "SELECT mk01.idkar, 
                           mk01.nama, 
                           DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                    FROM mk01
                    RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                    WHERE ta02.abscd = 2 ".$filter;
            $sqlKembali = "SELECT mk01.idkar, 
                           mk01.nama, 
                           DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                    FROM mk01
                    RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                    WHERE ta02.abscd = 3 ".$filter;
            $sqlLemburM = "SELECT mk01.idkar, 
                           mk01.nama, 
                           DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                    FROM mk01
                    RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                    WHERE ta02.abscd = 4 ".$filter;
            $sqlLemburK = "SELECT mk01.idkar, 
                           mk01.nama, 
                           DATE_FORMAT(ta02.tglmsk, '%H:%i') as tglmsk
                    FROM mk01
                    RIGHT JOIN ta02 ON ta02.mk01_id = mk01.idkar
                    WHERE ta02.abscd = 5 ".$filter;

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

            return $global_array;
 	}
 } 
?>