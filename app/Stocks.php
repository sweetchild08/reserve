<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Stocks extends Model
{
    use HasFactory;

    protected $fillable=[
        'prod_id',
        'quantity',
        'price_per_unit',
        'trigger'
    ];

    public function encryptedId()
    {
        return Crypt::encrypt($this->id);
    }

    public function products()
    {
        return $this->belongsTo(Prods::class,'prod_id');
    }
}
