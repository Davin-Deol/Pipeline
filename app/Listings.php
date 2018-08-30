<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Listings extends Model
{
    protected $table = 'Listings';
    public $timestamps = false;
    protected $primaryKey = 'listingID';
    public $incrementing = false;
    private $maps = ['users_usersId' => 'userId'];
    
    /**
     * @param userId - holds the id of the user we're going to get statistics for
     * @return the statistics representing info about the user's listings
     */
    public static function getUsersListingsStatistics($userId)
    {
        $statistics = DB::table('Listings')
            ->select('status', DB::raw('count(*) as total'))
            ->where('userId', $userId)
            ->groupBy('status')
            ->get();
        return $statistics;
    }
    
    /**
     * A listing can only fall under one subcategory
     */
    public function subCategory()
    {
        return $this->belongsTo('App\Interest');
    }
    
    /**
     * A listing can only be under one jurisdiction
     */
    public function jurisdiction()
    {
        return $this->belongsTo('App\Jurisdiction');
    }
    
    /**
     * A listing can only have one type of currency
     */
    public function investmentType()
    {
        return $this->belongsTo('App\Currency');
    }
    
    /**
     * A listing can only belong to one user
     */
    public function creator()
    {
        return $this->belongsTo('App\Users', 'userId');
    }
    
    /**
     * A listing can have 0 or more images
     */
    public function listingImages()
    {
        return $this->hasMany('App\ListingToImages', 'listingID');
    }
    
    /**
     * A listing can play a role in 0 or more connections
     */
    public function connections()
    {
        return $this->hasMany('App\Connections', 'listingId');
    }
    
    /**
     * A listing can be saved by 0 or more users
     */
    public function usersSavedListings()
    {
        return $this->hasMany('App\UsersSavedListings', 'savedListingId');
    }
}
