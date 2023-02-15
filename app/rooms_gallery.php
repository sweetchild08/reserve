<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rooms_gallery extends Model
{
    //
    protected $table = 'rooms_galleries';
    protected $primaryKey = 'id';
    protected $fillable = ['rooms_id','gallery'];
}
