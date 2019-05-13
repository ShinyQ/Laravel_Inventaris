<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use ApiBuilder;
use Session;
use Hash;
use Bcrypt;
use App\User;

class LoginController extends Controller
{

  public function index(){
   if (Auth::user()) {
  		return redirect('/kategori');
  	} else {
  	   return view('auth.login');
  	}
  }

  public function doLogin(Request $request){

      $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required',
      ]);

      if(!Auth::attempt([
        'email' => $request->email,
        'password' => $request->password
      ])){
        Session::flash('gagal', 'Username Atau password Salah');
        return redirect()->back();
      }
      else{
          return redirect('/kategori');
      }
    }


  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
        'email' => ['required', 'email'],
        'password' => ['required']
    ]);

    if ($validator->fails()) {
        return ApiBuilder::apiResponseValidationFails('Login validation fails!', $validator->errors()->all(), 422);
    }

    if (Auth::attempt([
        'email' => $request->email,
        'password' => $request->password
    ])) {
        $user = Auth::user();
        $success['user'] = $user;
        $success['token'] = $user->createToken('myApp')->accessToken;
        return ApiBuilder::apiResponseSuccess('Anda berhasil login!', $success, 200);
    } else {
        return ApiBuilder::apiResponseErrors('Gagal login!', [
            'User belum terdaftar atau password anda salah'
        ], 401);
    }
  }

  /**
  * logout user
  */

  public function logout()
  {
    Auth::logout();
    return ApiBuilder::apiResponseSuccess('Anda berhasil logout', null, 200);
  }

  public function doLogout()
  {
    Auth::logout();
    Session::flash('sukses', 'Sukses Keluar Akun');
    return redirect('/login');
  }


}
