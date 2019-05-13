<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Goods;
use App\Shelfs;
use App\Categories;
use Sessions;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $counter = 1;
      $shelf = Shelfs::all();
      $category = Categories::all();
      $good = Goods::all();
      return view('admin.barang', compact('good','counter','shelf', 'category'));
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
      $this->validate($request,[
          'name' => 'required | unique:goods',
          'stock' => 'required | numeric',
          'categories_id' => 'required',
          'shelfs_id' => 'required',
      ]);

      try{
          $good = new Goods($request->except("_token"));
          $good->status = '1';
          $good->save();
          //validasi pesan berhasil
          $request->session()->flash('message','Berhasil Menambahkan Data');
          return redirect()->back();

      }catch (Exception $e) {
          report($e);
          $request->session()->flash('message_gagal','Data Rak Sudah Ada');
          return redirect()->back();
      }
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
      $shelf = Shelfs::all();
      $category = Categories::all();
      $data = Goods::find($id);
      return view('admin.barang_edit', compact('data','shelf','category'));
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
          'stock' => 'required | numeric',
          'categories_id' => 'required',
          'shelfs_id' => 'required',
      ]);

      try{
        \DB::beginTransaction();
        $data = Goods::find($id);
        $data->name = $request->name;
        $data->stock = $request->stock;
        $data->categories_id = $request->categories_id;
        $data->shelfs_id = $request->shelfs_id;
        $data->save();
        \DB::commit();
        $request->session()->flash('message','Berhasil Update Data');
        return redirect()->back();
      }
      catch (Exception $e) {
        report($e);
        \DB::rollBack();
        $request->session()->flash('message_gagal','Data Sudah Ada');
        return redirect()->back();
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $data = Goods::find($id);
      $data->delete();
      if($data) {
          Session::flash('message','Berhasil menghapus Data');
      }
      return redirect()->back();
    }
}
