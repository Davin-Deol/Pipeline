<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InvestmentType extends Model
{
    //
    protected $table = 'InvestmentType';
    public $timestamps = false;
    protected $primaryKey = 'investmentType';
    public $incrementing = false;
    
    /**
     * An investment type can be applied to 0 or more listings
     */
    public function listings()
    {
        return $this->hasMany('App\Listings');
    }
}
