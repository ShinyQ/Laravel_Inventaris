<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Peminjaman;
use App\Goods;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $counter = 1;
      $pinjam = Peminjaman::where('status','Belum Dikonfirmasi')->orderBy('updated_at','desc')->get();
      return view('admin.peminjaman', compact('pinjam','counter'));
    }

    public function konfirmasi($id)
    {
      $pinjam = Peminjaman::find($id);
      $pinjam->status = "Dikonfirmasi";
      $pinjam->save();

      request()->session()->flash('message','Berhasil Mengkonfirmasi Peminjaman');
      return redirect()->back();
    }

    public function tolak($id)
    {
      $stok = Peminjaman::where('id', $id)->first();

      $CheckBarang = Goods::where('id', $stok->goods_id)->first();
      $TambahStok = $CheckBarang->stock + $stok->jumlah;
      $CheckBarang->stock = $TambahStok;
      $CheckBarang->save();

      $pinjam = Peminjaman::find($id);
      $pinjam->status = "Ditolak";
      $pinjam->save();

      request()->session()->flash('message','Berhasil Mengnolak Peminjaman');
      return redirect()->back();
    }
}
