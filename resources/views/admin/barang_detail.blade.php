@extends('base/template')

@section('konten')
<div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
        <div class="container-fluid">
            <!-- Brand -->
            <br /> <br />
            <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="./index.html">Halaman Detail Data Barang</a>
            <!-- Form -->
            <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">

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
                        @if ($errors->any())
                        <div class="col-sm-12">
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        <div class="col">
                            <h3 class="mb-0">Tabel Detail Data Barang</h3>
                            <table class="table table-bordered">
                                <tr>
                                    <td class="form-control-label">Id Barang</td>
                                    <td class="form-control-label">:</td>
                                    <td><input type="text" value="{{ $data->id }}" class="form-control form-control-alternative" disabled /></td>
                                </tr>
                                <br />
                                <tr>
                                    <td class="form-control-label">Nama Barang</td>
                                    <td>:</td>
                                    <td><input type="text" disabled name="name" value="{{ $data->name }}" class="form-control form-control-alternative"></td>
                                </tr>

                                <tr>
                                    <td class="form-control-label">Foto Barang</td>
                                    <td class="form-control-label">:</td>
                                    <td>
                                      @if ($data->foto)
                                        <img src="{{asset('images')}}/{{ $data->foto }}" width="100px"/>
                                      @else
                                      Tidak Ada Gambar
                                      @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td class="form-control-label">Kategori</td>
                                    <td class="form-control-label">:</td>
                                    <td><input type="text" disabled name="quota" value="{{ $data->categories->name }}" class="form-control form-control-alternative"></td>
                                </tr>

                                <tr>
                                    <td class="form-control-label">Letak Barang</td>
                                    <td class="form-control-label">:</td>
                                    <td><input type="text" disabled name="quota" value="Rak {{ $data->shelfs->nomor }} Kode {{ $data->shelfs->kode }}" class="form-control form-control-alternative"></td>
                                </tr>

                                <tr>
                                    <td class="form-control-label">Stok Barang</td>
                                    <td class="form-control-label">:</td>
                                    <td><input type="text" disabled name="quota" value="{{  $data->stock }}" class="form-control form-control-alternative"></td>
                                </tr>

                                <tr>
                                    <td class="form-control-label">Dibuat Pada</td>
                                    <td class="form-control-label">:</td>
                                    <td><input type="text" disabled name="quota" value="{{ date("d-m-Y", strtotime($data->tanggal_pinjam)) }}" class="form-control form-control-alternative"></td>
                                </tr>

                            </table><br />
                            <div class="col-lg-12 text-right">
                                <a class="btn btn-primary" href="/barang">Kembali</a>
                            </div>
                          </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />

    @endsection
