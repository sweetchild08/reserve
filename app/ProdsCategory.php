<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class ProdsCategory extends Model
{
    use HasFactory;

    protected $fillable=[
        'category_name',
        'description'
    ];

    public function encryptedId()
    {
        return Crypt::encrypt($this->id);
    }
}
