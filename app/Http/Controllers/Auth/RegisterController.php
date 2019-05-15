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
use App\Http\Requests\RegisterValidation;

class RegisterController extends Controller
{
   public function index(){
      if (Auth::user()) {
        return redirect('/studio');
      } else {
      return view('auth.register');
      }
    }

    public function test($value='')
    {
      return view('auth.verifyUser');
    }

    public function doRegister(RegisterValidation $request)
    {

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => 'user',
        'password' => Bcrypt($request->password),
        'token' => str_random(40)
      ]);
      Mail::to($request->email)->send(new VerifyMail($user));
      Session::flash('message', 'Sukses Mendaftar Akun Silahkan, Cek Email Untuk Konfirmasi');
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
          'password' => Bcrypt($request->password),
          'token' => str_random(40)
      ]);
      Mail::to($request->email)->send(new VerifyMail($user));
      $success['user'] = $user;
      $success['token'] = $user->createToken('myApp')->accessToken;

      return ApiBuilder::apiResponseSuccess('Register Sukses!', $success, 200);
    }

    public function verifyUser($token)
    {
      $verifyUser = User::where('token', $token)->first();
      if(isset($verifyUser) ){
          if($verifyUser->email_verified_at == null) {
              $time = Carbon::now();
              $verifyUser->email_verified_at = $time;
              $verifyUser->save();
              Session::flash('message', 'Sukses Melakukan Konfirmasi, Silahkan Login');
          }else{
            Session::flash('message_gagal', 'Anda Sudah Mengkonfirmasi Akun');
          }
      }else{
          Session::flash('message_gagal', 'Akun Tersebut Tidak Ditemukan');
          return redirect('/login');
      }

      return redirect('/login');
    }


}
