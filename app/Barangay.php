<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    //
    protected $table = "refbrgy";

    protected $primaryKey = 'brgyCode';

    public $timestamps = false;

    protected $fillable = ['brgyCode', 'brgyDesc', 'regCode', 'provCode', 'citymunCode'];
}
