<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cottages_gallery extends Model
{
    //
    protected $table = 'cottages_galleries';
    protected $primaryKey = 'id';
    protected $fillable = ['cottages_id','gallery'];
}
