<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categories;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;
use ApiBuilder;

class CategoriesController extends Controller
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

        $response = Categories::query()->latest();
        if (request()->has("search") && strlen(request()->query("search")) >= 1) {
          $response->where(
            "categories.name", "like", "%" . request()->query("search") . "%"
          );
        }

        $pagination = 3;
        $response = $response->paginate($pagination);
        if( request()->has('page') && request()->get('page') > 1){
          $counter += (request()->get('page')- 1) * $pagination;
        }
      } catch (\Exception $e) {
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
    public function store(Request $request)
    {
      try{
          $this->validate($request,[
              'name' => 'required | unique:categories',
          ]);

          $response = new Categories;
          $response->name = $request->name;
          $response->save();

          $code = 200;
          $message = "success";
      }catch (\Exception $e) {
        if ($e instanceof ValidationException) {
              $code = 422;
              $message = $e->errors();
              $response = [];
          } else{
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
      $this->validate($request,[
        'name' => 'required',
      ]);

      try{
        \DB::beginTransaction();
        $response = Categories::findOrFail($id);
        $response->name = $request->name;
        $response->save();
        \DB::commit();
        $code = 200;
        $message = "success";
      }
      catch (Exception $e) {
        \DB::rollBack();
        if($e instanceof ModelNotFoundException){
          $code= 200;
          $message = "Data Not Exist";
          $response = [];
        }
        else{
          $code= 500;
          $message = $e->getMessage();
          $response = [];
        }
      }
      return ApiBuilder::apiRespond($code, $response, $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try {
          $code = 200;
          $message = "success";
          $response = Categories::findOrFail($id);
          $response = $response->delete();
        } catch (\Exception $e) {
          if($e instanceof ModelNotFoundException){
            $code= 200;
            $message = "Data Not Exist";
            $response = [];
          }
          else{
            $code= 500;
            $message = $e->getMessage();
            $response = [];
          }
        }
        return ApiBuilder::apiRespond($code, $response, $message);
    }
}
