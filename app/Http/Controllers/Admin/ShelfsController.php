<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shelfs;
use Session;

class ShelfsController extends Controller
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
      return view('admin.rak', compact('shelf','counter'));
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
          'nomor' => 'required',
          'kode' => 'required | unique:shelfs',
      ]);

      try{
          $data = new Shelfs;
          $data->nomor = $request->nomor;
          $data->kode = $request->kode;
          $data->save();

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
      $counter = 1;
      $shelf = Shelfs::with('goods')->find($id);
      return view('admin.rak_barang', compact('shelf','counter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data = Shelfs::find($id);
      return view('admin.rak_edit', compact('data'));
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
        'nomor' => 'required',
        'kode' => 'required'
      ]);

      try{
        \DB::beginTransaction();
        $data = Shelfs::find($id);
        $data->nomor = $request->nomor;
        $data->kode = $request->kode;
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
      $data = Shelfs::find($id);
      $data->delete();
      if($data) {
          Session::flash('message','Berhasil menghapus Data');
      }
      return redirect()->back();
    }
}
