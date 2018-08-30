<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Requests extends Model
{
    //
    protected $table = 'Requests';
    public $timestamps = false;
    protected $primaryKey = 'requestID';
    public $incrementing = false;
    
    public static function findByEmail($userEmail)
    {
        $user = DB::table('requests as r')
            ->where(DB::raw('BINARY `email`'), $userEmail)
            ->first();
        return $user;
    }
    
    /**
     * A request can have 0 or more interests
     */
    public function interests()
    {
        return $this->hasMany('App\RequestToInterests', 'requestID');
    }
    
    /**
     * A request can have a request ID associated with one sign up link
     */
    public function request()
    {
        return $this->belongsTo('App\SignUpLinks', 'requestID');
    }
}
