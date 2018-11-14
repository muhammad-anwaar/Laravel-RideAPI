<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model {
    //
    protected $table = 'ride';
    public $timestamps = false;
    protected $fillable = ['userid','driverid','travellingstatus',];

    public function haveDriverEngagedAlready($userID,$driverID) {

    }
}
