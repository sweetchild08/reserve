<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rooms_services extends Model
{
    //
    protected $table = 'rooms_services';
    protected $primaryKey = 'id';
    protected $fillable = ['rooms_id','services'];
}
