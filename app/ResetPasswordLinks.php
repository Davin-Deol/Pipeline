<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ResetPasswordLinks extends Model
{
    //
    protected $table = 'ResetPasswordLinks';
    public $timestamps = false;
    
    function linkExists($link)
    {
        $linkExists = DB::table('ResetPasswordLinks as r')
            ->select('r.link')
            ->where(DB::raw('BINARY `link`'), $link)
            ->first();
        return !is_null($linkExists);
    }
}
