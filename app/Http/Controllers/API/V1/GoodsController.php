<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Goods;
use App\Http\Resources\GoodsCollection;
use App\Http\Resources\GoodsResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;
use ApiBuilder;
use App\Http\Requests\GoodsValidation;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try {
        $code = 200;
        $message = "Success";
        $counter = 1;
        $response = Goods::query()->latest();
        if (request()->has("search") && strlen(request()->query("search")) >= 1) {
          $response->where(
            "goods.name", "like", "%" . request()->query("search") . "%"
        );}
        $pagination = 5;
        $response = $response->paginate($pagination);
        $response = new GoodsCollection($response);
       }catch (\Exception $e) {
        $code = 500;
        $message = "An Error Has Ocurred";
        $response = [];
      }
      return ApiBuilder::apiRespond($code, $response, $message);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GoodsValidation $request)
    {
      try{
          $response = new Goods($request->except("_token"));
          $response->status = '1';
          $response->save();

          $code = 200;
          $message = "success";

      }catch (\Exception $e) {
        if ($e instanceof ValidationException) {
              $code = 422;
              $message = $e->errors();
              $response = [];
          } else {
              $code = 500;
              $message = $e->getMessage();
              $response = [];
          }
      }
      return ApiBuilder::apiRespond($code, $response, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
          $code = 200;
          $message = "success";
          $response = Goods::findOrFail($id);
          $response = new GoodsResource($response);

        } catch (\Exception $e) {
          if($e instanceof ModelNotFoundException){
            $code= 200;
            $message = "Data Not Exist";
            $response = [];
          }
          else{
            $code= 500;
            $message = $e->errors();
            $response = [];
          }
        }
        return ApiBuilder::apiRespond($code, $response, $message);
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
