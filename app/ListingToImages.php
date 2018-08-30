<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ListingToImages extends Model
{
    protected $table = 'ListingToImages';
    public $timestamps = false;
    public $incrementing = false;
    
    /**
     * An image can only belong to one listing
     */
    public function listingID()
    {
        return $this->belongsTo('App\Listings', 'listingID');
    }
    
    public static function getNumberOfImagesForListing($listingID)
    {
        $numberOfImages = DB::table('ListingToImages as l')
            ->select(DB::raw('count(*) as numberOfImages'))
            ->where('listingID', '=', $listingID)
            ->get();
        return $numberOfImages;
    }
    
    public static function findByListingID($listingID)
    {
        $listingImages = DB::table('ListingToImages as l')
            ->select('image')
            ->where('l.listingID', '=', $listingID)
            ->get();
        return $listingImages;
    }
}