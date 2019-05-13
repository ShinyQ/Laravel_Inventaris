<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ApiBuilder;
use Session;
use Hash;
use Bcrypt;
use Carbon\Carbon;
use App\User;
use App\Mail\VerifyMail;
use Mail;
use Auth;
use Validator;

class RegisterController extends Controller
{
   public function index(){
      if (Auth::user()) {
        return redirect('/studio');
      } else {
      return view('auth.register');
      }
    }

    public function doRegister(Request $request)
    {
      $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
      ]);

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => 'user',
        'password' => Bcrypt($request->password),
      ]);

      Session::flash('sukses', 'Sukses Mendaftar Akun Silahkan, Cek Email Untuk Konfirmasi');
      return redirect('/login');
    }

    public function register(Request $request)
    {
      $validator = Validator::make($request->all(), [
          'name' => ['required', 'string', 'max:255'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required', 'string', 'min:8', 'confirmed'],
      ]);

      if ($validator->fails()) {
          return ApiBuilder::apiResponseValidationFails('Validation error messages!', $validator->errors()->all());
      }

      $user = User::create([
          'name' => $request->name,
          'email' => $request->email,
          'role' => 'user',
          'password' => Bcrypt($request->password)
      ]);

      $success['user'] = $user;
      $success['token'] = $user->createToken('myApp')->accessToken;

      return ApiBuilder::apiResponseSuccess('Register Sukses!', $success, 200);
    }

}
