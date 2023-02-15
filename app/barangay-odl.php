<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class barangay extends Model
{
    //
     protected $table = "refbrgy";

    public $timestamps = false;

    protected $fillable = ['brgyCode', 'brgyDesc', 'regCode', 'provCode', 'citymunCode'];
}
