<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //
    protected $table = "refprovince";

    protected $primaryKey = 'provCode';

    public $timestamps = false;

    protected $fillable = ['provCode', 'provDesc', 'regCode'];
}
