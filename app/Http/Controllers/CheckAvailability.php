<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rooms;
use App\reservations;
class CheckAvailability extends Controller
{
    public static function check($roomID)
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');

        $filter = $endDate;
        $d = reservations::where('booking_id',$roomID)
        ->where('booking_type','Rooms')
        ->where('booking_status','Approved')
        ->where(function ($res) use ($filter) {
            if (!empty($filter)) {
                $res->whereBetween('date_from', [$filter, $filter]);
                $res->orwhereBetween('date_to', [$filter, $filter]);
            }
        })
        ->first();

        if($d){
            $da = [
                'Status' => '<span class="text-danger font-weight-bold">Not Available</span>',
                'Booked' => $d->date_to,
                'isAvail' => 1
            ];
        }else{
            $da = [
                'Status' => '<span class="text-success font-weight-bold">Available</span>',
                'Booked' => '.',
                'isAvail' => 0
            ];
        }

        return $da;
        
    }
}
