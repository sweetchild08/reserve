<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regions extends Model
{
    //
    protected $table = 'regions';
    protected $primaryKey = 'id';
    protected $fillable = ['psgcCode','regDesc','regCode'];
}
