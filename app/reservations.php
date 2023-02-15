<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reservations extends Model
{
    //
    protected $table = 'reservations';
    protected $primaryKey = 'id';
    protected $fillable = ['customer_id','description','booking_type','booking_id','payment_type','amount','date_from','date_to','reference','status','booking_status'];

    public function room_detail()
    {
        return $this->belongsTo(rooms::class, 'booking_id', 'id');
    }

    public function customer_detail()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

}
