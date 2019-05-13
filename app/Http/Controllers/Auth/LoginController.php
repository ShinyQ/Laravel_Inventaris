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
  		if(Auth::user()->role == "admin"){
        return redirect('/kategori');
      }
      else{
        return redirect('/pinjam');
      }
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
        Session::flash('message_gagal', 'Username Atau password Salah');
        return redirect()->back();
      }
      elseif(Auth::user()->role == "admin"){
          return redirect('/kategori');
      }
      elseif(Auth::user()->role == "user" && Auth::user()->email_verified_at == NULL){
            Session::flash('message_gagal', 'Email Varus Dikonfirmasi Terlebih Dahulu');
            return redirect('/login');
      }
      else{
          return redirect('/pinjam');
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
    return ApiBuilder::apiResponseSuccess('Anda berhasil logout', [], 200);
  }

  public function doLogout()
  {
    Auth::logout();
    Session::flash('message', 'Sukses Keluar Akun');
    return redirect('/login');
  }


}
