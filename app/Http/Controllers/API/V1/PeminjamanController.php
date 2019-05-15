<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;
use ApiBuilder;
use App\Peminjaman;
use App\Goods;
use App\Http\Resources\PeminjamanCollection;
use App\Http\Resources\PeminjamanResource;
use App\Http\Requests\PeminjamanValidation;

class PeminjamanController extends Controller
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
          $message = "success";
          $counter = 1;

          $response = Peminjaman::query()->latest();
          // if (request()->has("search") && strlen(request()->query("search")) >= 1) {
          //   $response->where(
          //     "peminjaman.name", "like", "%" . request()->query("search") . "%"
          //   );
          // }
          if (request()->has("status") && strlen(request()->query("status")) >= 1) {
            $response->where(
              "peminjaman.status", request()->query("status")
            );
          }

          $pagination = 5;
          $response = $response->paginate($pagination);
          if( request()->has('page') && request()->get('page') > 1){
            $counter += (request()->get('page')- 1) * $pagination;
          }
          $response = new PeminjamanCollection($response);
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
    public function store(PeminjamanValidation $request)
    {
      try {
        $CheckBarang = Goods::where('id', $request->goods_id)->first();
        $CheckStok = $CheckBarang->stock - $request->jumlah;
        // dd($CheckStock);
        if($CheckStok >= 0){
          // $CheckPinjaman = Peminjaman::where('user_id', \Auth::user()->id)->where('goods_id', $request->goods_id)->first();
          $KurangiStok = $CheckBarang->stock - $request->jumlah;
          $CheckBarang->stock = $KurangiStok;
          $CheckBarang->save();

          $response = new Peminjaman($request->except("_token"));
          $response->status = 'Belum Dikonfirmasi';
          $response->user_id = \Auth::user()->id;

          $response->save();
          $code = 200;
          $message = "success";
        }

        elseif($CheckStok == 0){;
          $code = 200;
          $message = "Stock Barang Sudah Habis";
          $response = [];
        }

        else{
          $code = 200;
          $message = "Jumlah Yang Dimasukkan Melebihi Stok Barang";
          $response = [];
        }
      } catch (\Exception $e) {
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
        $response = Peminjaman::findOrFail($id);
        $response = new PeminjamanResource($response);

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
