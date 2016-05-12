<?php

class mk02 extends Eloquent {

    protected $table = 'mk02';
    protected $primaryKey = 'id';
    
    function getReferral($idkar){
        $sql = "SELECT mk02.* FROM mk02 WHERE mk02.mk01_id_parent = $idkar;";
        $mk02 = DB::select(DB::raw($sql));
        return $mk02;
    }

    // START Eloquent Relationship
//    function mk01_parent() {
//        return $this->belongsTo('mk01', 'idkar');
//    }
    // END Eloquent Relationship
}
