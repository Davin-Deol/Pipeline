<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Currency extends Model
{
    //
    protected $table = 'Currency';
    public $timestamps = false;
    protected $primaryKey = 'currency';
    public $incrementing = false;
    
    /**
     * A currency can be applied to 0 or more listings
     */
    public function listings()
    {
        return $this->hasMany('App\Listings');
    }
}
