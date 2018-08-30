<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersSavedListings extends Model
{
    protected $table = 'UsersSavedListings';
    public $timestamps = false;
    public $incrementing = false;
    
    /**
     * An entry can only have 1 user
     */
    public function userId()
    {
        return $this->belongsTo('App\Users', 'userId');
    }
    
    /**
     * An entry can only have 1 listing
     */
    public function listing()
    {
        return $this->belongsTo('App\Listings', 'savedListingId');
    }
}