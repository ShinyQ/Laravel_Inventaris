<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categories;
use Validator;
use Session;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $counter = 1;
        $category = Categories::all();
        return view('admin.kategori', compact('category','counter'));
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
          'name' => 'required | unique:categories',
      ]);

      try{
          $data = new Categories;
          $data->name = $request->name;
          $data->save();
          //validasi pesan berhasil
          $request->session()->flash('message','Berhasil Menambahkan Data');
          return redirect()->back();

      }catch (Exception $e) {
          report($e);
          $request->session()->flash('message_gagal','Data Genre Sudah Ada');
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
      $data = Categories::find($id);
      return view('admin/kategori_edit', compact('data'));
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
        $data = Categories::find($id);
        $data->name = $request->name;
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
      $data = Categories::find($id);
      $data->delete();
      if($data) {
          Session::flash('message','Berhasil menghapus Data');
      }
      return redirect()->back();
    }
}
