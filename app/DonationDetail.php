<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonationDetail extends Model
{
    protected $table = 'donation_details';
    protected $fillable = ['donations_id' , 'broker_id' , 'donor_id' , 'price' , 'coin_type'
                           , 'sar' , 'project_id' , 'note' ,'add_date'];

    protected $dates = ['add_date'];

    public function projects() {
        return $this->hasMany('App\Project', 'id' , 'project_id');
    }
    public function donor() {
        return $this->hasOne('App\Donor', 'id' , 'donor_id');
    }
    public function broker() {
        return $this->hasOne('App\Broker', 'id' , 'broker_id');
    }
    public function project() {
        return $this->hasOne('App\Project', 'id' , 'project_id');
    }

    public function donation() {
        return $this->belongsTo('App\Donation' , 'donations_id' , 'id');
    }
}
