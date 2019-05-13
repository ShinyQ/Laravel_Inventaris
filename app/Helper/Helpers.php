<?php
//app/Helpers/Envato/User.php
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Helpers {

    public static function apiRespond($code, $data, $message) {
        if($code == 200){
          $response['status'] = 200;
          $response['message'] = $message;
          $response['data'] = $data;
        }elseif($code == 404){
          $response['status'] = 404;
          $response['message'] = $message;
          $response['data'] = $data;
        }elseif($code == 400){
          $response['status'] = 400;
          $response['message'] = $message;
          $response['data'] = $data;
        }
        else{
          $response['status'] = 500;
          $response['message'] = "An Error Has Occured";
          $response['data'] = $data;
        }
        return response()->json($response, $code);
    }

    public static function apiResponseValidationFails($message = null, $errors = null, $status_code = 422) {
        return response()->json([
            'message' => $message,
            'status_code' => $status_code,
            'data' => [
                'errors' => $errors
            ]
        ], $status_code);
    }

    public static function apiResponseSuccess($message = null, $data = null, $status_code = 200) {
      return response()->json([
          'message' => $message,
          'status_code' => $status_code,
          'data' => $data
      ], $status_code);
  }

    public static function apiResponseErrors($message = null, $data = null, $status_code = 401) {
      return response()->json([
          'message' => $message,
          'status_code' => $status_code,
          'data' => $data
      ], $status_code);
  }
}
