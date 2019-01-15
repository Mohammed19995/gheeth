<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    protected $table = 'donors';
    protected $fillable = ['name' , 'alias_name' , 'information'];

    public function contacts() {
        return $this->hasMany('App\DonorContact');
    }
    public function brokers() {
        return $this->belongsToMany('App\Broker');
    }
    public function donation() {
        return $this->belongsTo('App\DonationDetail' , 'donor_id' ,'id' );
    }

    public function donation2() {
        return $this->hasMany('App\DonationDetail' , 'donor_id' ,'id' );
    }

}
