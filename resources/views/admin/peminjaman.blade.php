@extends('base/template')
<style>
::-webkit-scrollbar {
  height: 7px;
  border-radius: 10px 10px 10px 10px;
}

::-webkit-scrollbar-track {
  background: #cecece;
}

::-webkit-scrollbar-thumb {
  background: #6772e5;
  transition: 0.5s;
}

::-webkit-scrollbar-thumb:hover {
  background: #0041aa;
  transition: 0.5s;
  cursor: pointer;
}
</style>
@section('konten')

<div class="main-content">
<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="./index.html">Halaman Request Peminjaman</a>
        <!-- Form -->
        <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
            <div class="form-group mb-0">
                <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input class="form-control" placeholder="Search" type="text">
                </div>
            </div>
        </form>
        <!-- User -->
    </div>
</nav>
<!-- Header -->

<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">

            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--8">
        <div class="col-md-12 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                      @if (Session::has('message'))
                        <div class="col-sm-12">
                          <div class="alert alert-success">
                              {{ Session::get('message') }}
                          </div>
                        </div>
                      @endif
                      @if (Session::has('message_gagal'))
                        <div class="col-sm-12">
                          <div class="alert alert-danger">
                              {{ Session::get('message_gagal') }}
                          </div>
                        </div>
                      @endif
                        <div class="col">
                            <h3 class="mb-0">Tabel Data Request Peminjaman</h3>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Peminjam</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Tgl Pinjam</th>
                                <th scope="col">Tgl Kembali</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @forelse ($pinjam as $data)
                            <tr>
                                <th scope="row">{{ $counter++ }}</th>
                                <td>{{ $data->goods->name ?? '-' }}</td>
                                <td>{{ $data->users->name ?? '-' }}</td>
                                <td>{{ $data->jumlah ?? '-' }}</td>
                                <td>{{ date("j F Y", strtotime($data->tanggal_pinjam)) }}</td>
                                <td>{{ date("j F Y", strtotime($data->tanggal_kembali )) }}</td>
                                <td>
                  								<a class="btn btn-success" href="/peminjaman/{{$data->id}}/konfirmasi">Konfirmasi</i></a>
                                  <a class="btn btn-danger" href="/peminjaman/{{$data->id}}/tolak">Tolak</i></a>
                                </td>
                            </tr>
                          @empty
                            <tr>
                              <td>Belum Ada Request Barang</td>
                            </tr>
                          @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
