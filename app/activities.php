<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class activities extends Model
{
    //
    protected $table = 'activities';
    protected $primaryKey = 'id';
    protected $fillable = ['image','categories_id','title','description','rate','is_featured','is_comments'];
}
