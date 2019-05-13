<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Halaman Login</title>
  <!-- Favicon -->
  <link href="{{url('assets/img/brand/favicon.png')}}" rel="icon" type="image/png">
  <!-- Icons -->
  <link href="{{url('assets/vendor/nucleo/css/nucleo.css')}}" rel="stylesheet">
  <link href="{{url('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
  <!-- Argon CSS -->
  <link type="text/css" href="{{url('assets/css/argon.css?v=1.0.0')}}" rel="stylesheet">
</head>

<body class="bg-default">
  <div class="main-content">
    <div class="header bg-gradient-primary py-7 py-lg-8">
      <div class="container">
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--9 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-transparent pb-5">
              @if ($errors->any())
              <div class="col-sm-12">
                <div class="alert alert-danger">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </div>
              </div>
              @endif
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
              <div class="text-muted text-center mt-2 mb-3"><small>Sign in with</small></div>
              <div class="btn-wrapper text-center">
                <a href="/auth/google" class="btn btn-neutral btn-icon">
                  <span class="btn-inner--icon"><img src="../assets/img/icons/common/google.svg"></span>
                  <span class="btn-inner--text">Google</span>
                </a>
              </div>
            </div>
            <div class="card-body px-lg-6 py-lg-3">
              <div class="text-center text-muted mb-4">
                <small>Or sign in with credentials</small>
              </div>
              <form role="form" action ="/doLogin" method="post">
                @csrf
                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input name="email" class="form-control" placeholder="Email" type="email">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input name="password" class="form-control" placeholder="Password" type="password">
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary my-4">Sign in</button>
                </div>
              </form>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">
              <a href="#" class="text-light"><small>Forgot password?</small></a>
            </div>
            <div class="col-6 text-right">
              <a href="/register" class="text-light"><small>Create new account</small></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{url('assets/vendor/jquery/dist/jquery.min.js')}}></script>
  <script src="{{url('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}></script>
  <!-- Argon JS -->
  <script src="{{url('assets/js/argon.js?v=1.0.0')}}></script>
</body>

</html>
