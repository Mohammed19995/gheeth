<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = ['name' , 'information'];
    protected $dates = ['add_date'];

    public function donation() {
        return $this->belongsTo('App\DonationDetail' , 'project_id' ,'id' );
    }

    public function donation2() {
        return $this->hasMany('App\DonationDetail' , 'project_id' ,'id' );
    }

}
