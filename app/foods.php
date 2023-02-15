<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class foods extends Model
{
    //
    protected $table = 'foods';
    protected $primaryKey = 'id';
    protected $fillable = ['image','categories_id','title','description','rate','is_featured','is_comments'];
}
