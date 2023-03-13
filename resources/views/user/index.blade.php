@extends('layouts.user')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
  {{-- Container --}}
  <div class="container">
    <section id="Navbar">
      <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Pengaduan Masyarakat</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarNav">
          @if (Auth::guard('masyarakat')->check())
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a href="{{ route('pemas.laporan') }}" class="nav-link text-center text-white">Laporan</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('pemas.logout') }}" class="nav-link text-center text-white"
                  style="text-decoration: underline;">{{ Auth::guard('masyarakat')->user()->nama }}</a>
              </li>
            </ul>
          @else
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a type="button" type="button" data-toggle="modal" data-target="#LoginModal"
                  class="nav-link text-white">Masuk</a>
              </li>
              <li class="nav-item active">
                <a type="button" data-toggle="modal" data-target="#DaftarAkun" class="nav-link btn btn-outline-custom"
                  href="#">Daftar</a>
              </li>
            </ul>
          @endif
        </div>
      </nav>
    </section>


    <div class="container">

      <div class="row justify-content-center">
        <div class="col-lg-8">
          <h1 class="mt-5 text-center text-white">Layanan Pengaduan Masyarakat</h1>
          <p class="text-center text-white">Ayo laporkan masalah masyarakat andas kepada kami!!</p>
          @if (Session::has('berhasil'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('berhasil') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
          @if (Session::has('gagal'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ Session::get('gagal') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
        </div>
      </div>

      <section id="card-pengaduan">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="content">
              <div class="card mb-3">Tulisan laporan anda disini</div>
              <form action="{{ route('pemas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <textarea name="isi_laporan" placeholder="Masukkan Isi Laporan" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                  <input type="file" name="foto" class="form-control">
                </div>
                <button type="submit" class="btn btn-custom mt-2">Kirim</button>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>

    <div class="modal fade" id="LoginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <h3>Masuk terlebih dahulu</h3>
            <p>Silahkan masuk menggunakan akun yang sudah didaftarkan</p>
            <form action="{{ route('pemas.login') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <button type="submit" class="btn btn-custom">Login</button>
            </form>
            @if (Session::has('pesan'))
              <div class="alert alert-danger mt-2">
                {{ Session::get('pesan') }}
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="DaftarAkun" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <h3>Daftar Pengaduan Masyarakat</h3>
            <p>Silahkan mendaftar akun pengaduan masyarakat, dan jangan lupa isi semua form di bawah ini sesuai dengan
              data
              anda masing-masing.</p>
            <form action="{{ route('pemas.daftar') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="nik">Nik</label>
                <input type="text" class="form-control" id="nik" name="nik">
              </div>
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama">
              </div>
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <div class="form-group">
                <label for="telp">No. Telepon</label>
                <input type="number" class="form-control" id="telp" name="telp">
              </div>
              <button type="submit" class="btn btn-custom">Daftar</button>
            </form>
            @if (Session::has('pesan'))
              <div class="alert alert-danger mt-2">
                {{ Session::get('pesan') }}
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection

@section('js')
  @if (Session::has('pesan'))
    <script>
      $('#LoginModal').modal('show');
    </script>
  @endif
@endsection
