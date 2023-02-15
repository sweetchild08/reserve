<?php

namespace App\Http\Controllers;

use App\reservations as Reservations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use PDF;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('accounts/profile');
    }

    public function profile() {
        $title = 'Profile';
        $query = DB::table('users')->where(['id' => Session::get('customer_id')])->first();
        return view('accounts.profile',compact('title','query'));
    }

    public function my_reservations() {
        $title            = 'My Reservations';
        $rooms            = $this->reservations('reservations','Rooms');
        $cottages         = $this->reservations('reservations','Cottages');
        $foods            = $this->reservations('reservations','Foods');
        $eventsQuery      = $this->reservations('reservations','Events');
        $activitiesQuery  = $this->reservations('reservations','Activities');
        return view('accounts.my-reservation',compact('title','rooms','cottages','foods','eventsQuery','activitiesQuery'));
    }

    public function reservations($table,$booking_type) {
        return DB::table($table)->where(['customer_id' => Session::get('customer_id'),'booking_type' => $booking_type])->paginate(10);
    }

    public function change_password() {
        $title = 'Change Password';
        return view('accounts.change-password',compact('title'));
    }

    public function logout() {
        Session::forget('customer_id');
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        if($request->type == 'Profile') {
            $validated = $request->validate([
                'surname'   => 'bail|required',
                'firstname' => 'bail|required',
                'province'  => 'bail|required',
                'city'      => 'bail|required',
                'barangay'  => 'bail|required',
                'address'   => 'bail|required',
                'email'     => 'bail|required',
                'contact'   => 'bail|required|numeric',
            ]);
    
            DB::beginTransaction();
            try {
                DB::table('users')->where(['id' => Session::get('customer_id')])->update([
                    'surname'       => $request->surname,
                    'firstname'     => $request->firstname,
                    'middlename'    => $request->middlename,
                    'province'      => $request->province,
                    'city'          => $request->city,
                    'barangay'      => $request->barangay,
                    'address'       => $request->address,
                    'email'         => $request->email,
                    'contact'       => $request->contact,
                ]);
                DB::commit();
                return redirect('accounts/profile')->with('message','Profile has been updated');
            } catch (\Exception $e) {
                DB::rollback();
            }
        } else {
            $validated = $request->validate([
                'old_password'     => 'bail|required',
                'password'         => 'bail|required',
                'confirm_password' => 'bail|required',
            ]);
           
            DB::beginTransaction();
            try {
                $users = DB::table('users')->where(['id' => Session::get('customer_id')])->first();
                $password = Crypt::decryptString($users->password);
    
                if($password != $request->old_password) {
                    return redirect('accounts/change-password')->with('message','Invalid old password');
                }
    
                if($request->password != $request->confirm_password) {
                    return redirect('accounts/change-password')->with('message','Invalid old password');
                } 
    
                DB::table('users')->where(['id' => Session::get('customer_id')])->update(['password' => Crypt::encryptString($request->password)]);
                DB::commit();
                return redirect('accounts/change-password')->with('message','Password has been changed');
            } catch (\Exception $e) {
                DB::rollback();
            }
        }
        
    }

    public function cancel($id)
    {
        //
        $reservations_id = Crypt::decryptString($id);
        DB::table('reservations')->where(['id' => $reservations_id])->update(['booking_status' => 'Cancelled']);
        return back()->with('message','Your reservation has been cancelled');
    }

    public function print($id)
    {
        $reservations_id = Crypt::decryptString($id);
        $get_query = Reservations::where(['id' => $reservations_id])->first();

        // $data = [
            
        //     'approved_on' => $get_query->updated_at, 
        //     'reference' => $get_query->reference, 
        //     'payment_type' => $get_query->payment_type,
        //     'description' => json_decode($get_query->description),
        //     'from' => $get_query->date_from,
        //     'to' => $get_query->date_to,
        //     'total' => $get_query->amount
        // ];
        //return dd($data['approved_on']);

        // $custom_size = array(0,0,322,511);
        // $pdf = PDF::loadView('receipt', $data);
        // $pdf->set_paper($custom_size);

        // return $pdf->download('invoice.pdf');
       // return dd($data['description']);
       return view('receipt')->with('data', $get_query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($email)
    {
        //
        $email = Crypt::decryptString($email);
        DB::table('users')->where(['email' => $email])->update(['is_active' => 1]);
        return redirect('/login1')->with('message','Your account has been actived');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
