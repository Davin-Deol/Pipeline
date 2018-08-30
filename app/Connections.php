<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Connections extends Model
{
    protected $table = 'Connections';
    public $timestamps = false;
    public $incrementing = false;
    
    /**
     * @param userId - holds the id of the user we're going to get statistics for
     * @return the statistics representing info about the user's listings
     */
    public static function getUsersConnectionsStatistics($userId)
    {
        $statistics = DB::table('Connections')
            ->select('status', DB::raw('count(*) as total'))
            ->where('interestedPartyId', $userId)
            ->orWhere('creatorId', $userId)
            ->groupBy('status')
            ->get();
        return $statistics;
    }
    
    public function interestedParty()
    {
        return $this->belongsTo('App\Users', 'interestedPartyId');
    }
    
    public function creator()
    {
        return $this->belongsTo('App\Users', 'creatorId');
    }
    
    public function approvedBy()
    {
        return $this->belongsTo('App\Users');
    }
    
    public function listing()
    {
        return $this->belongsTo('App\Listings', 'listingId');
    }
}
