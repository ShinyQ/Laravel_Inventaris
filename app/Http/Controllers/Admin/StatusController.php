<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Peminjaman;
use App\Goods;
use Carbon\Carbon;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $now = Carbon::today();
      $counter = 1;
      $pinjam = Peminjaman::where('status','Dikonfirmasi')->orderBy('updated_at','desc')->get();
      return view('admin.status_pinjam', compact('pinjam','counter','now'));
    }

    public function konfirmasi($id)
    {
      $pinjam = Peminjaman::find($id);
      $pinjam->status = "Sudah Dikembalikan";
      $pinjam->save();

      request()->session()->flash('message','Berhasil Mengkonfirmasi Pengembalian Barang');
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
