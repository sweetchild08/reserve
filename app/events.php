<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class events extends Model
{
    //
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $fillable = ['image','categories_id','title','description','rate','is_featured','is_comments'];
}
