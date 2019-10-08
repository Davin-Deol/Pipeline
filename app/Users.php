<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as AuthUser;

class Users extends AuthUser
{
    //
    protected $table = 'Users';
    protected $primaryKey = 'userId';
    public $incrementing = false;
    
    const CREATED_AT = 'creationDate';
    const UPDATED_AT = 'lastUpdated';
    
    protected $hidden = ['password', 'remember_token'];
    protected $fillable = ['userId', 'email', 'password', 'fullName', 'linkedInURL', 'individualOrOrganization'];
    
    protected $guard = 'web';
    
    public static function findByEmail($userEmail)
    {
        $user = Users::where(DB::raw('BINARY `email`'), $userEmail)
            ->first();
        return $user;
    }
    
    /**
     * A user can have 0 or more connections as either playing the creator, interestedParty, and/or admin role
     */
    public function connections()
    {
        return $this->hasMany('App\Connections');
    }
    
    /**
     * A user can have 0 or more listings
     */
    public function listings()
    {
        return $this->hasMany('App\Listings', 'userId');
    }
    
    /**
     * A user can have 0 or more saved listings
     */
    public function savedListings()
    {
        return $this->hasMany('App\UserSavedListings', 'userId');
    }
    
    /**
     * A user can save 0 or more listings
     */
    public function usersSavedListings()
    {
        return $this->hasMany('App\UsersSavedListings');
    }
    
    public static function getEmailsByType($userType)
    {
        $users = Users::select('email')
            ->where('type', $userType)
            ->get();

        $userEmails = array();

        foreach($users as $user) {
            $userEmails[] = $user->email;
        }
        
        return $userEmails;
    }
}
