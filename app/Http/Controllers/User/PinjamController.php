<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categories;
use App\Goods;
use App\Peminjaman;
use Session;
use Carbon\Carbon;
use App\Http\Requests\PeminjamanValidation;

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
    public function store(PeminjamanValidation $request)
    {
      try {
        $now = Carbon::today();

        if($request->tanggal_pinjam < $now){
          $request->session()->flash('message_gagal','Tanggal Awal Sudah Lewat');
          return redirect()->back();
        }

        else{
          $StockBarang = Goods::where('id', $request->goods_id)->first();
          $CheckStok = $StockBarang->stock - $request->jumlah;
          // dd($CheckStock);
          if($CheckStok >= 0){
            // $CheckPinjaman = Peminjaman::where('user_id', \Auth::user()->id)->where('goods_id', $request->goods_id)->first();
            $KurangiStok = $StockBarang->stock - $request->jumlah;
            $StockBarang->stock = $KurangiStok;
            $StockBarang->save();

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
    public function update(PeminjamanValidation $request, $id)
    {
      try {
        $StockBarang = Goods::where('id', $request->goods_id)->first();
        $CheckJumlahPinjam = Peminjaman::findOrFail($id);

        // dd($StockBarang);
        // dd($CheckJumlahPinjam->jumlah);
        // dd($request->jumlah);
          if($StockBarang->stock - $request->jumlah <= 0){
            $request->session()->flash('message_gagal','Stok Tidak Mencukupi');
            return redirect()->back();
          }
          else{
            if($CheckJumlahPinjam->jumlah < $request->jumlah){
              $KurangiQuota =  $request->jumlah - $CheckJumlahPinjam->jumlah;
              // dd($KurangiQuota);
              $Barang = Goods::find($request->goods_id);
              $Barang->stock =  $Barang->stock - $KurangiQuota;
              $Barang->save();

              $pinjam = Peminjaman::find($id);
              $pinjam->tanggal_kembali = $request->tanggal_kembali;
              $pinjam->tanggal_pinjam = $request->tanggal_pinjam;
              $pinjam->jumlah = $request->jumlah;
              $pinjam->goods_id = $request->goods_id;
              $pinjam->save();
              $request->session()->flash('message','Berhasil Mengubah Data Dan Mengurangi Barang');
              return redirect()->back();
            }

            elseif($CheckJumlahPinjam->jumlah > $request->jumlah){
              $checkquota = $StockBarang->stock - $request->jumlah;
              // dd($checkquota);
              if($checkquota <= 0){
                $request->session()->flash('message_gagal','quota tidak mencukupi');
                return redirect()->back();
              }
              else{
              // dd("Checkpoint");
              $TambahQuota = $CheckJumlahPinjam->jumlah - $request->jumlah;
              $Barang = Goods::find($request->goods_id);
              $Barang->stock = $Barang->stock + $TambahQuota;
              $Barang->save();

              $pinjam = Peminjaman::find($id);
              $pinjam->tanggal_kembali = $request->tanggal_kembali;
              $pinjam->tanggal_pinjam = $request->tanggal_pinjam;
              $pinjam->jumlah = $request->jumlah;
              $pinjam->goods_id = $request->goods_id;
              $pinjam->save();
              $request->session()->flash('message','Berhasil Mengubah Data Dan Menambah Barang');
                        return redirect()->back();
              }
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

      $StockBarang = Goods::where('id', $pinjam->goods_id)->first();
      $TambahStok = $StockBarang->stock + $pinjam->jumlah;
      $StockBarang->stock = $TambahStok;
      $StockBarang->save();

      $data = Peminjaman::find($id);
      $data->delete();
      if($data) {
          Session::flash('message','Berhasil menghapus request peminjaman');
      }
      return redirect()->back();
    }
}
