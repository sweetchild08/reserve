<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rooms extends Model
{
    //
    protected $table = 'rooms';
    protected $primaryKey = 'id';
    protected $fillable = ['image','categories_id','title','description','rate','adults','childrens','is_featured','is_comments'];

    public function reservations() {
        return $this->hasMany(reservations::class, 'booking_id', 'id');
    }
}
