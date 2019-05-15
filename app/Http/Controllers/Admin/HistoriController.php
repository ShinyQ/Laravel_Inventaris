<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Peminjaman;
use App\Goods;
use Carbon\Carbon;

class HistoriController extends Controller
{
  public function index()
  {
    $now = Carbon::today();
    $counter = 1;
    $pinjam = Peminjaman::whereIn('status', ['Ditolak', 'Dikonfirmasi', 'Sudah Dikembalikan'])->orderBy('updated_at','desc')->get();
    return view('admin.histori', compact('now','pinjam','counter'));
  }
}
