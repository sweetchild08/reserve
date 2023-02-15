<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Bundles extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'description',
        'notes'
    ];
    
    public function products()
    {
        return $this->belongsToMany(Prods::class,'bundles_prods','bundle_id','prod_id')->withPivot('quantity');
    }

    public function encryptedId()
    {
        return Crypt::encrypt($this->id);
    }
}
