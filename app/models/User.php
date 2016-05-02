<?php

class User {

    public static function loginCheck($tipe, $idmenu = FALSE) {
//        dd($idmenu);
        if (Session::has('user') && $idmenu) {
            $user = Session::get('user');
            if (in_array($user['tipe'], $tipe)) {
                $sql = "SELECT mm02.*, mm01.url FROM `mm02` INNER JOIN mm01 ON mm01.idmnu = mm02.mm01_id WHERE mm01_id = $idmenu AND mk01_id = " . $user["idkar"];
                $usermatrik = DB::select(DB::raw($sql));
                if (count($usermatrik) > 0) {
                    $arr = array(
                        "bool" => true,
                        "url" => $usermatrik[0]->url
                    );
                    return $arr;
                } else {
                    //redirect ke peringatan akses halaman
                    $sql = "SELECT mm02.*, mm01.url FROM `mm02` INNER JOIN mm01 ON mm01.idmnu = mm02.mm01_id WHERE mk01_id = " . $user['idkar'] . ";";
                    $usermatrik = DB::select(DB::raw($sql));
                    if (count($usermatrik) > 0) {
                        $arr = array(
                            "bool" => FALSE,
                            "url" => $usermatrik[0]->url
                        );
                        return $arr;
                    } else {
                        $idmenu = FALSE;
                        Session::forget('user');
                        $arr = array(
                            "bool" => false,
                            "url" => "login"
                        );
                        return $arr;
                    }
                }
            }
        }
        $arr = array(
            "bool" => false,
            "url" => "login"
        );
        return $arr;
    }
    
    public static function getUserMatrix() {
        $user = Session::get('user');
        $datas = DB::table('mm02')->select('mm01_id')->where('mk01_id', '=', $user['idkar'])->get();
        $usermatrik = array();
        
        foreach ($datas as $data){
            array_push($usermatrik, $data->mm01_id);
        }

        return $usermatrik;
    }
}
