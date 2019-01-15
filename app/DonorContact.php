<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonorContact extends Model
{
    protected $table = 'donor_contacts';
    protected $fillable = ['donor_id' , 'contact_type' , 'contact_details'];

    public function broker() {
        return $this->belongsTo('App\Broker');
    }
}
