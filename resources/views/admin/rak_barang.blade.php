@extends('base/template')

@section('konten')
<div class="main-content">
<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="./index.html">Halaman Rak</a>
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
                        <div class="col">
                            <h3 class="mb-0">Tabel Data Barang Rak {{ $shelf->nomor }} - Kode {{ $shelf->kode }}</h3>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <!-- Projects table -->
                    <div class="col">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                          @forelse ($shelf->goods as $data)
                            <tr>
                              <tr>
                                  <th scope="row">{{ $counter++ }}</th>
                                  <td>
                                    @if ($data->foto)
                                      <img src="{{asset('images')}}/{{ $data->foto }}" width="100px"/>
                                    @else
                                    -
                                    @endif
                                  </td>
                                  <td>{{ $data->name }}</td>
                                  <td>{{ $data->categories->name }}</td>
                                  <td>{{ $data->stock }}</td>
                              </tr>
                            </tr>
                          @empty
                            <tr>
                              <td> Tidak Ada Data Barang </td>
                            </tr>
                          @endforelse
                        </tbody>
                    </table>
                    <div class="col-lg-12 text-right">
                        <a class="btn btn-primary" href="/rak">Kembali</a>
                    </div><br />
                </div>
            </div>
        </div>
    @endsection
