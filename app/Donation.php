<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 'donations';
    protected $fillable = ['total_price'];

    public function donationDetails() {
        return $this->hasMany('App\DonationDetail' , 'donations_id' , 'id');
    }
}
