<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountsMail;
use Illuminate\Contracts\Encryption\DecryptException;
class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = 'Register';
        //$regions = DB::table('regions')->get();
        $province = DB::table('refprovince')->get();
       // return view('register',compact('title','regions'));
        return view('register')->with('province', $province)->with('title', $title);
    }

    public function reset($data)
    {
        $title   = 'Reset';
        $regions = DB::table('regions')->get();
        try {
            $email   = Crypt::decryptString($data);
            $query   = DB::table('users')->where(['email' => $email])->exists();
            if($query) {
                return view('reset',compact('title','regions','email'));
            } else {
                return redirect('/login');
            }
        } catch (DecryptException $e) {
            return redirect('/login');
        }
    }

    public function retrieve(Request $request)
    {
        $validated = $request->validate([
            'password'  => 'bail|required|required_with:confirm_password|same:confirm_password|min:8',
        ]);

        if($request->password =! $request->confirm_password) {
            return redirect('/reset/'.Crypt::encryptString($request->email))->with('message','Password mismatched.');
        }
        

        DB::beginTransaction();
        try {
            $recovery_code = rand(111111,999999);
            $is_active     = 0; // not active yet need account confirmation via email
            DB::table('users')->where(['email' => $request->email])->update([
                'password'  => Crypt::encryptString($request->confirm_password),
            ]);
            DB::commit();
            return redirect('/login')->with('message','Your password has been reset.');
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function get_province($id){
        $get_province = DB::table('refcitymun')->where('provCode', '=', $id)->orderBy('citymunCode', 'ASC')->get();
        return json_encode($get_province);
    }

    public function get_city($id){
        $get_barangay = DB::table('refbrgy')->where('citymunCode', '=', $id)->orderBy('brgyDesc', 'ASC')->get();
        return json_encode($get_barangay);
    }

    // public function get_provinces(Request $request) {
    //     $regionCode = $request->regionCode;
    //     $query   = DB::table('provinces')->where(['regCode' => $regionCode])->get()->toJson();
    //     return $query;
    // }

    // public function get_cities(Request $request) {
    //     $provCode = $request->provCode;
    //     $query   = DB::table('cities')->where(['provCode' => $provCode])->get()->toJson();
    //     return $query;
    // }

    // public function get_barangay(Request $request) {
    //     $citymunCode = $request->citymunCode;
    //     $query   = DB::table('barangays')->where(['citymunCode' => $citymunCode])->get()->toJson();
    //     return $query;
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $validated = $request->validate([
            'surname'   => 'bail|required',
            'firstname' => 'bail|required',
            'province'  => 'bail|required',
            'city'      => 'bail|required',
            'barangay'  => 'bail|required',
            'address'   => 'bail|required',
            'email'     => 'bail|required|unique:App\User,email',
            'contact'   => 'bail|required|numeric',
            'username'  => 'bail|required|unique:App\User,username',
            'password'  => 'bail|required|min:8',
        ]);

        DB::beginTransaction();
        try {
            $recovery_code = rand(111111,999999);
            $is_active     = 0; // not active yet need account confirmation via email
            DB::table('users')->insert([
                'surname'       => $request->surname,
                'firstname'     => $request->firstname,
                'middlename'    => $request->middlename,
                'province'      => $request->province,
                'city'          => $request->city,
                'barangay'      => $request->barangay,
                'address'       => $request->address,
                'email'         => $request->email,
                'contact'       => $request->contact,
                'username'      => $request->username,
                'password'      => Hash::make($request->password),
                'is_active'     => $is_active,
                'recovery_code' => $recovery_code,
                'roles'         => 1,
            ]);
            DB::commit();
            $data = [
                'name'  => $request->firstname.' '.$request->middlename.' '.$request->surname,
                'email' => $request->email,
            ];
            $headers  = "From: " . strip_tags('noreply@santorenzbayresort.com') . "\r\n";
            $headers .= "Reply-To: " . strip_tags($request->email) . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            //$message = 'Please click <a href="'.url('accounts/activate').'/'.Crypt::encryptString($request->email).'">here</a> to activate your account.<br><br> This is auto generated email, Please do not reply.';
            $message = " Your account has been created Succesfully, Please verify the email first before using your Account. Enjoy your Stay :)";
            //$mail = mail($request->email,"Activate Your Account",$message,$headers);
            // if($mail) {
            //     return "nasend";
            //     //return redirect('login')->with('message','An email has been sent to '.$request->email.'. to verify your account');
            // } else {
            //     return " hindi nasend";
            //     //return redirect('login')->with('message','Error');
            // }
            //return dd(array($message, $request->username, $request->email));
            Mail::to($request->email)->send(new AccountsMail($message, $request->username, $request->email));
            return redirect('login1')->with('message','An email has been sent to '.$request->email.'. to verify your account');
        } catch (\Exception $e) {
            return $e;
            DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

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
