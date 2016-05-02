<?php

class mj01 extends Eloquent {

    protected $table = 'mj01';
    protected $primaryKey = 'idjb';
    
    function mk01(){
        return $this->hasMany('mk01');
    }
            
    function getJabatanAktif() {
        return $this->where('status', '=', 'Y')->orderBy('idjb', 'ASC')->get();
    }
}
