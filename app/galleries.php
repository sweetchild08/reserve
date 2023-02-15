<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class galleries extends Model
{
    //
    protected $table = 'galleries';
    protected $primaryKey = 'id';
    protected $fillable = ['images'];
}
