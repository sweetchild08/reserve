<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountsMail;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Encryption\DecryptException;
class ForgotPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = 'Forgot Password';
        return view('forgot-password',compact('title'));
    }

    public function processing(Request $request) {
        $headers  = "From: " . strip_tags('noreply@santorenzbayresort.com') . "\r\n";
        $headers .= "Reply-To: " . strip_tags($request->email) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message = 'Please click <a href="'.url('accounts/reset').'/'.Crypt::encryptString($request->email).'">here</a> to reset your password.<br><br> This is auto generated email, Please do not reply.';
        $mail = mail($request->email,"Reset Your Password",$message,$headers);
        if($mail) {
            return redirect('forgot-password')->with('message','An email has been sent to '.$request->email.'. to reset  your password');
        } else {
            return redirect('forgot-password')->with('message','Error');
        }
    }

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
