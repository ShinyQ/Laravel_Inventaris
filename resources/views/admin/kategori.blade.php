@extends('base/template')

@section('konten')
<div class="main-content">
<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="./index.html">Halaman Kategori</a>
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
    <div class="row">
        <div class="col-md-6 mb-5 mb-xl-0">
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
                            <h3 class="mb-0">Tambah Kategori Barang</h3><br />
                            <form action="/kategori" method="POST">
                              @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-username">Nama Kategori</label>
                                            <input name="name" type="text" id="input-username" class="form-control form-control-alternative" placeholder="Username" >
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-right">
                                        <input type="submit" class="btn btn-primary  pull-right" value="+ Tambah Kategori" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br />
        <div class="col-md-6 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Tabel Kategori Barang</h3>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Kategori</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($category as $data)
                            <tr>
                                <th scope="row">{{ $counter++ }}</th>
                                <td>{{ $data->name }}</td>
                                <td>
                                  <a class="btn btn-warning" href="/kategori/{{$data->id}}/edit">Edit</i></a>
                  								<a class="btn btn-danger" href="kategori/{{$data->id}}/delete">Delete</i></a>
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12" style="margin:0; text-align:center;">
              <center>
                  {!! $category->appends(request()->all())->links() !!}
              </center>
              </div>
            </div>
        </div>
    </div>
    @endsection
