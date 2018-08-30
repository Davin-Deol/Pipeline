<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SignUpLinks extends Model
{
    protected $table = 'SignUpLinks';
    public $timestamps = false;
    protected $primaryKey = 'link';
    public $incrementing = false;
    
    /**
     * Every sign up link has a request ID associated with one request
     */
    public function request()
    {
        return $this->belongsTo('App\Requests', 'requestID');
    }
}
