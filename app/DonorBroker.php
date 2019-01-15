<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonorBroker extends Model
{
    protected $table = 'broker_donor';
    protected $fillable = ['broker_id' , 'donor_id'];
}
