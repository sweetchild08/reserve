<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class provinces extends Model
{
    //
    protected $table = 'provinces';
    protected $primaryKey = 'id';
    protected $fillable = ['psgcCode','provDesc','regCode','provCode'];
}
