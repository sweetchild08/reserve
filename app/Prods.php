<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Prods extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'description',
        'prods_category_id',
        'type',
        'sku'
    ];
    public function category()
    {
        return $this->hasOne(ProdsCategory::class,'id','prods_category_id');
    }

    public function getCategory()
    {
        return $this->category->category_name??'None';
    }
    public function encryptedId()
    {
        return Crypt::encrypt($this->id);
    }
}
