<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Goods;
use App\Peminjaman;
use Carbon\Carbon;

class StatusController extends Controller
{
  public function index()
  {
    $today = Carbon::today();
    // dd($today);
    $now = Carbon::now();
    $counter = 1;
    $good = \DB::table('goods')->orderBy('name', 'asc')->get();
    $pinjam = Peminjaman::where('user_id', \Auth::user()->id)->whereIn('status', ['Dikonfirmasi', 'Sudah Dikembalikan'])->orderBy('tanggal_kembali','asc')->get();
    return view('user.status', compact('today','pinjam','good', 'counter','now'));
  }
}
