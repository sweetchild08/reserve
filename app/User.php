<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'id';
    protected $fillable = [
        'surname','firstname','middlename','email','contact','province','city','barangay','address','username', 'is_active','recovery_code','roles'
    ];
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function province_detail()
    {
        return $this->belongsTo(Province::class, 'province', 'provCode');
    }

    public function city_detail()
    {
        return $this->belongsTo(Municipality::class, 'city', 'citymunCode');
    }

    public function barangay_detail()
    {
        return $this->belongsTo(Barangay::class, 'barangay', 'brgyCode');
    }

   
}
