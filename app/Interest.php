<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Interest extends Model
{
    //
    protected $table = 'Interests';
    public $timestamps = false;
    protected $primaryKey = 'interest';
    public $incrementing = false;
    
    /**
     * An interest can be applied to 0 or more listings
     */
    public function listings()
    {
        return $this->hasMany('App\Listings');
    }
    
    /**
     * An interest can be applied to 0 or more requests
     */
    public function requests()
    {
        return $this->hasMany('App\RequestToInterests', 'email');
    }
}
