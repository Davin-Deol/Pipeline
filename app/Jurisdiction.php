<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Jurisdiction extends Model
{
    //
    protected $table = 'Jurisdiction';
    public $timestamps = false;
    protected $primaryKey = 'jurisdiction';
    public $incrementing = false;
    
    /**
     * A jurisdiction can be applied to 0 or more listings
     */
    public function listings()
    {
        return $this->hasMany('App\Listings');
    }
}
