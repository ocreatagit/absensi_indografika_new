<?php

class ts01 extends Eloquent {
    protected $table = 'ts01';
    
    function mk01(){
        return $this->belongsTo("mk01");
    }
}
