@extends('layouts.user')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <link rel="stylesheet" href="{{ asset('css/laporan.css') }}">
@endsection

@section('content')
  {{-- Awal navbar --}}

  <section id="Navbar">
    <div class="container">
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
                  style="text-decoration: underline;">Logout</a>
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
              <li class="nav-item active">
                <a class="nav-link" href="{{ route('pemas.logout') }}">Logout</a>
              </li>
            </ul>
          @endif
        </div>
      </nav>
    </div>
  </section>

  {{-- Akhir navbar --}}

  <div class="container">
    <div class="row justify-content-between">

      {{-- Form Pengaduan Masyarakat --}}
      <div class="col-lg-8">
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
        <div class="content content-top shadow">
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
      {{-- Akhir form pengaduan masyarakat --}}

      <div class="col-lg-4">
        <div class="content content-bottom shadow">
          <div>
            <img src="{{ asset('img/user_default.svg') }}" alt="user profile" class="photo">
            <div class="self-assign">
              <h5 class="text-blue">{{ Auth::guard('masyarakat')->user()->nama }}</h5>
              <p class="text-dark">{{ Auth::guard('masyarakat')->user()->username }}</p>
            </div>
            <div class="row">
              <div class="col-md-4">
                <p class="mb-0 text-center italic">Proses</p>
                <div class="text-center">{{ $hitung[0] }}</div>
              </div>
              <div class="col-md-4">
                <p class="mb-0 text-center italic">Selesai</p>
                <div class="text-center">{{ $hitung[1] }}</div>
              </div>
            </div>
          </div>

        </div>

      </div>

    </div>


    <div class="row mt-5 rounded bg-white p-5 shadow">
      <div class="col-lg-8">
        <a class="d-inline tab {{ $siapa == 'me' ? 'tab-active' : '' }}" href="{{ route('pemas.laporan', 'me') }}">
          Laporan Saya
        </a>
        <hr>
      </div>
      @foreach ($pengaduan as $k => $v)
        <div class="col-lg-8">
          <div class="laporan-top">
            <img src="{{ asset('img/user_default.svg') }}" alt="profile" class="profile">
            <div class="d-flex justify-content-between">
              <div>
                <p>{{ $v->nama }}</p>
                @if ($v->status == '0')
                  <p class="text-danger">Pending</p>
                @elseif($v->status == 'proses')
                  <p class="text-warning">{{ ucwords($v->status) }}</p>
                @else
                  <p class="text-success">{{ ucwords($v->status) }}</p>
                @endif
              </div>
              <div>
                <p>{{ $v->tgl_pengaduan }}</p>
              </div>
            </div>
          </div>
          <div class="laporan-mid">
            <div class="judul-laporan">
              {{ $v->judul_laporan }}
            </div>
            <p>{{ $v->isi_laporan }}</p>
          </div>
          <div class="laporan-bottom">
            @if ($v->foto != null)
              <img src="{{ Storage::url($v->foto) }}" alt="{{ 'Gambar ' . $v->judul_laporan }}"
                class="gambar-lampiran">
            @endif
            @if ($v->tanggapan != null)
              <p class="mt-3 mb-1">{{ '*Tanggapan dari ' . $v->tanggapan->petugas->nama_petugas }}</p>
              <p class="light">{{ $v->tanggapan->tanggapan }}</p>
            @endif
          </div>
          <hr>
        </div>
      @endforeach
    </div>
  </div>
@endsection
