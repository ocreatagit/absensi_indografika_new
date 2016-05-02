<?php

class th02 extends Eloquent {

    protected $table = 'th02';
    protected $primaryKey = 'idph';

    function th01() {
        return $this->belongsTo("th01");
    }   

}
