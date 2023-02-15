<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{

    public function index()
    {
        //
        $title = 'Login';
        //return 'working';
        return view('login',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        //
        $validated = $request->validate([
            'username'  => 'bail|required',
            'password'  => 'bail|required',
        ]);

        $data = User::where(['username' => $request->username,'roles' => 1,'is_active' => 1]);
        if($data->exists()) {
            $row = $data->first();
            // $password = Crypt::decryptString($request->password);
            $login = Auth::attempt(['username' => $request->username, 'password' => $request->password]);
            // print_r(json_encode($login));die();
            if($login) {
                Session::put('customer_id',$row->id);
                return redirect('/');
            } else {
                $message = 'Username or password are incorrect';
            }
        } else {
            $message = 'Username or password are incorrect';
        }

        return back()->with('message',$message);

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
