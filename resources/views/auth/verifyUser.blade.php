<!DOCTYPE html>
<html>
  <head>
      <title>Konfirmasi Email</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  </head>

  <body style="font-family:-apple-system, '.SFNSText-Regular', 'Helvetica Neue', Roboto, 'Segoe UI', sans-serif; color: #666666; background:white; text-decoration: none;">
    <div class="container" style="margin-top:50px;">
      <div class="card">
        <div class="card-body">
          <center>
            <img src="{{url('assets/img/brand/blue.png')}}" width="200px;"/><br /><br />
            <h2>Hello, {{$user['name']}}</h2>
            <br/>
            Alamat Email Kamu : {{$user['email']}}, Telah Berhasil Diregistrasi, <br /> Klik Link Dibawah Untuk Melakukan Konfirmasi
            <br/><br/>
            <a class="btn btn-primary"href="{{url('user/verify', $user->token)}}">Verifikasi Email</a>
          </div>
          </center>
      </div>
    </div>
  </body>

</html>
