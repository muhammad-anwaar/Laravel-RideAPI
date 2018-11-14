<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drivers extends Model {
    //
    protected $table = 'drivers';
    public $timestamps = false;
    protected $fillable = ['name','vehiclertype','status',];
}
