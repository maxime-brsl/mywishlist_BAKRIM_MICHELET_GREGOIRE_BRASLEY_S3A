<?php

namespace mywishlist\models;

class Liste extends \Illuminate\Database\Eloquent\Model{

    protected $table = 'liste';
    protected $primarykey = 'id';
    public $timestamps = false;

    public function items(){
        return($this->hasMany('\models\Item', 'item_id'));
    }

}