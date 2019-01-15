<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Broker extends Model
{
    protected $table = 'brokers';
    protected $fillable = ['name' , 'alias_name' , 'information'];

    public function contacts() {
        return $this->hasMany('App\BrokerContact');
    }
    public function donors() {
        return $this->belongsToMany('App\Donor');
    }

    public function donation() {
        return $this->belongsTo('App\DonationDetail' , 'broker_id' ,'id' );
    }

    public function donation2() {
        return $this->hasMany('App\DonationDetail' , 'donor_id' ,'id' );
    }
}
