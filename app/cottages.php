<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cottages extends Model
{
    //
    protected $table = 'cottages';
    protected $primaryKey = 'id';
    protected $fillable = ['image','categories_id','title','description','rate','is_featured','is_comments'];
}
