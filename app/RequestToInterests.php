<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RequestToInterests extends Model
{
    //
    protected $table = 'RequestToInterests';
    public $timestamps = false;
    
    /**
     * An interest can be applied to 0 or more requests
     */
    public function requests()
    {
        return $this->belongsToMany('App\Requests', 'requestID');
    }
}
