<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class foodsGalleries extends Model
{
    //
    protected $table = 'foods_galleries';
    protected $primaryKey = 'id';
    protected $fillable = ['foods_id','gallery'];
}
