<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class inventories extends Model
{
    protected $table = 'inventories';
    protected $primaryKey = 'id';
    protected $fillable = ['categories_id','sku','name','description','price','stocks'];
}
