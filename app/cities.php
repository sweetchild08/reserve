<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cities extends Model
{
    //
    protected $table = 'cities';
    protected $primaryKey = 'id';
    protected $fillable = ['psgcCode','citymunDesc','regDesc','provCode','citymunCode'];
}
