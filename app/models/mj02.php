<?php

class mj02 extends Eloquent {

    protected $table = 'mj02';
    protected $primaryKey = 'idjk';

    function mj03() {
        return $this->hasMany("mj03");
    }

//    function mk01() {
//        return $this->belongsToMany("mk01");
//    }
//    function Karyawan(){
//        return $this->belongsToMany("Karyawan", "mj03");
//    }

    function getAllJamWithoutSat() {
        return $this->where('status', '=', 'Y')->whereRaw('day IN ("mon-fri", "all")')->orderBy('day', 'ASC')->orderBy('idjk', 'ASC')->get();
    }
    
    function getAllJam() {
        return $this->where('status', '=', 'Y')->orderBy('idjk', 'ASC')->get();
    }
    
    function getJamKerjaAktif() {
        return $this->where('status', '=', 'Y')->where('tipe', '=', 1)->where("day", "=", "mon-fri")->orderBy('idjk', 'ASC')->get();
    }

    function getJamIstirahatAktif() {
        return $this->where('status', '=', 'Y')->where('tipe', '=', 2)->orderBy('idjk', 'ASC')->get();
    }

    function checkJamKerja($tipe, $jmmsk, $jmklr) {
        $sql = "SELECT COUNT(*) as count FROM mj02 WHERE tipe = $tipe AND jmmsk = '$jmmsk' AND jmklr = '$jmklr';";
        $count = DB::select(DB::raw($sql));
        $count = $count[0]->count;
        if($count > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
