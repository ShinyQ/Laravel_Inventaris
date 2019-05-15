@extends('base/template')

@section('konten')
<div class="main-content">
<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="#">Halaman Edit Data Peminjaman</a>
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
                            <h3 class="mb-0">Edit Data Peminjaman</h3><br />
                            <form action="/pinjam/{{ $data->id }}/update" method="POST">
                              @csrf
                                <div class="row">

                                  <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Pilih Barang</label>
                                            <select  id="barang" class="form-control form-control-alternative" name="goods_id">
                                              <option value="">--Pilih Kategori--</option>
                                              @foreach($good as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                              @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Jumlah Pinjam</label>
                                            <input value={{ $data->jumlah }} name="jumlah" type="number" id="input-username" class="form-control form-control-alternative" placeholder="Jumlah Barang" >
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Jumlah Pinjam</label>
                                            <input  value={{ $data->tanggal_pinjam }} name="tanggal_pinjam" type="date" id="input-username" class="form-control form-control-alternative" placeholder="Jumlah Barang" >
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Jumlah Pinjam</label>
                                            <input value={{ $data->tanggal_kembali }} name="tanggal_kembali" type="date" id="input-username" class="form-control form-control-alternative" placeholder="Jumlah Barang" >
                                        </div>
                                    </div>


                                    <div class="col-lg-12 text-right">
                                      <a href="/pinjam" class="btn btn-primary  pull-right">Kembali </a>
                                        <input type="submit" class="btn btn-warning  pull-right" value="Edit Data Peminjaman" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
        $('#barang').val("{{ $data->goods_id }}");
        </script>
    @endsection
