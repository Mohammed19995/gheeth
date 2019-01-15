<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrokerContact extends Model
{
    protected $table = 'broker_contacts';
    protected $fillable = ['broker_id' , 'contact_type' , 'contact_details'];

    public function broker() {
        return $this->belongsTo('App\Broker');
    }

}
