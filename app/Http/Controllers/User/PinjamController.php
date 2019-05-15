<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categories;
use App\Goods;
use App\Peminjaman;
use Session;
use Carbon\Carbon;

class PinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $counter = 1;
      $good = \DB::table('goods')->orderBy('name', 'asc')->get();
      $pinjam = Peminjaman::where('user_id', \Auth::user()->id)->orderBy('updated_at','desc')->get();
      return view('user.peminjaman', compact('pinjam','good', 'counter'));
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
          'goods_id' => 'required',
          'jumlah' => 'required | numeric',
          'tanggal_pinjam' => 'required | before:tanggal_kembali',
          'tanggal_kembali' => 'required | after:tanggal_pinjam',
      ]);

      try {
        $now = Carbon::today();

        if($request->tanggal_pinjam < $now){
          $request->session()->flash('message_gagal','Tanggal Awal Sudah Lewat');
          return redirect()->back();
        }

        else{
          $CheckBarang = Goods::where('id', $request->goods_id)->first();
          $CheckStok = $CheckBarang->stock - $request->jumlah;
          // dd($CheckStock);
          if($CheckStok >= 0){
            // $CheckPinjaman = Peminjaman::where('user_id', \Auth::user()->id)->where('goods_id', $request->goods_id)->first();
            $KurangiStok = $CheckBarang->stock - $request->jumlah;
            $CheckBarang->stock = $KurangiStok;
            $CheckBarang->save();

            $pinjam = new Peminjaman($request->except("_token"));
            $pinjam->status = 'Belum Dikonfirmasi';
            $pinjam->user_id = \Auth::user()->id;
            $pinjam->save();
            $request->session()->flash('message','Berhasil Menambahkan Data');
          }

          elseif($CheckStok = 0){
            $request->session()->flash('message_gagal','Stock Barang Sudah Habis');
            return redirect()->back();
          }

          else{
            $request->session()->flash('message_gagal','Jumlah Yang Dimasukkan Melebihi Stok Barang');
            return redirect()->back();
          }
        }
        return redirect()->back();
      } catch (\Exception $e) {
        $request->session()->flash('message_gagal','Data Peminjaman Gagal Ditambahkan');
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


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $good = Goods::all();
      $data = Peminjaman::find($id);
      return view('user.peminjaman_edit', compact('data','good'));
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
          'goods_id' => 'required',
          'jumlah' => 'required | numeric',
          'tanggal_pinjam' => 'required',
          'tanggal_kembali' => 'required',
      ]);

      try {
        $CheckBarang = Goods::where('id', $request->goods_id)->first();
        $CheckStok = $CheckBarang->stock - $request->jumlah;
        $CheckStokSekarang = Goods::findOrFail($request->goods_id);

        if($CheckStok >= 0){
          // $CheckPinjaman = Peminjaman::where('user_id', \Auth::user()->id)->where('goods_id', $request->goods_id)->first();
          if($CheckStokSekarang->stock > $request->jumlah){
            $TambahiStok = $CheckStokSekarang->stock - $request->jumlah;
            $CheckBarang->stock = $CheckStokSekarang - $TambahiStok;

            $CheckBarang->save();

            $pinjam = Peminjaman::find($id);
            $pinjam->tanggal_kembali = $request->tanggal_kembali;
            $pinjam->tanggal_pinjam = $request->tanggal_pinjam;
            $pinjam->jumlah = $request->jumlah;
            $pinjam->goods_id = $request->goods_id;
            $pinjam->save();
            $request->session()->flash('message','Berhasil Mengubah Data');
                      return redirect()->back();
          }

          elseif($CheckStokSekarang->stock < $request->jumlah){
            $KurangiStok = $request->jumlah - $CheckStokSekarang->stock;
            $CheckBarang->stock = $CheckBarang->stock - $TambahiStok;
            $CheckBarang->save();

            $pinjam = Peminjaman::find($id);
            $pinjam->tanggal_kembali = $request->tanggal_kembali;
            $pinjam->tanggal_pinjam = $request->tanggal_pinjam;
            $pinjam->jumlah = $request->jumlah;
            $pinjam->goods_id = $request->goods_id;
            $pinjam->save();
            $request->session()->flash('message','Berhasil Mengubah Data');
                      return redirect()->back();
          }
          else{
            $pinjam = Peminjaman::find($id);
            $pinjam->tanggal_kembali = $request->tanggal_kembali;
            $pinjam->tanggal_pinjam = $request->tanggal_pinjam;
            $pinjam->jumlah = $request->jumlah;
            $pinjam->goods_id = $request->goods_id;
            $pinjam->save();
            $request->session()->flash('message','Berhasil Mengubah Data');
            return redirect()->back();
          }

        }

        elseif($CheckStok = 0){
          $request->session()->flash('message_gagal','Stock Barang Sudah Habis');
          return redirect()->back();
        }

        else{
          $request->session()->flash('message_gagal','Jumlah Yang Dimasukkan Melebihi Stok Barang');
          return redirect()->back();
        }

      } catch (\Exception $e) {
        $request->session()->flash('message_gagal','Gagal Mengubah Data');
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
      $pinjam = Peminjaman::where('id', $id)->first();

      $CheckBarang = Goods::where('id', $pinjam->goods_id)->first();
      $TambahStok = $CheckBarang->stock + $pinjam->jumlah;
      $CheckBarang->stock = $TambahStok;
      $CheckBarang->save();

      $data = Peminjaman::find($id);
      $data->delete();
      if($data) {
          Session::flash('message','Berhasil menghapus request peminjaman');
      }
      return redirect()->back();
    }
}
