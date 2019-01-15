<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;


class User extends Authenticatable
{

    use Notifiable;
    use EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'user_pass','section_id','unit_id', 'isActive','username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_pass', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->user_pass;
    }
    
     public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function permissions() {
        return $this->belongsToMany('App\Permission');
    }

    public function products() {
        return $this->hasMany('App\Product');
    }
    
    public function winner() {
        return $this->belongsTo('App\Winner' , 'user_id' , 'id');
    }
    public function generateToken()
    {
        $this->api_token = str_random(150);
        $this->save();

        return $this->api_token;
    }
    public function deleteToken() {
        $this->api_token = null;
        $this->save();
    }


}
