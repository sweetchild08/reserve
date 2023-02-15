<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    //
    protected $table = "refcitymun";

    protected $primaryKey = 'citymunCode';

    public $timestamps = false;

    protected $fillable = ['citymunCode', 'citymunDesc',  'provCode'];
}
