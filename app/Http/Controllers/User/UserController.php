<?php

namespace App\Http\Controllers\User;

use App\Models\Masyarakat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
      return view('user.index', [
        'title' => 'Pengaduan Masyarakat'
      ]);
    }

    public function login(Request $request)
    {
      
      $username = Masyarakat::where('username', $request->username)->first();
      
      if(!$username) {
        return redirect()->back()->with('pesan', 'Username tidak terdaftar');
      }

      $password = Hash::check($request->password, $username->password);

      if(!$password) {
        return redirect()->back()->with('pesan', 'Password tidak sesuai');
      }

      if(Auth::guard('masyarakat')->attempt(['username' => $request->username, 'password' => $request->password])) {
        return redirect()->back()->with('berhasil', 'Berhasil login');
      } else {
        return redirect()->back()->with('pesan', 'Akun tidak terdaftar');
      }


    }

    public function registrasi(Request $request)
    {

      $masyarakat = $request->all();

      $validate = Validator::make($masyarakat, [
        'nik' => ['required', 'max:16'],
        'nama' => ['required', 'string', 'max:36'],
        'username' => ['required', 'string', 'max:25'],
        'password' => ['required', 'min:4'],
        'telp' => ['required', 'string', 'max:13']
      ]);

      if($validate->fails()) {
        return redirect()->back()->with('pesan', $validate->errors());
      }

      $username = Masyarakat::where('username', $request->username)->first();

      if($username) {
        return redirect()->back()->with('pesan', 'Username sudah terdaftar');
      }

      Masyarakat::create([
        'nik' => $masyarakat['nik'],
        'nama' => $masyarakat['nama'],
        'username' => $masyarakat['username'],
        'password' => Hash::make($masyarakat['password']),
        'telp' => $masyarakat['telp'],
      ]);

      return redirect()->route('pemas.index');
      
    }

    public function storePengaduan(Request $request)
    {

      if(!Auth::guard('masyarakat')->user()) {
        return redirect()->back()->with('pesan', 'Login dibutuhkan')->withInput();
      }

      $laporan = $request->all();

      $validate = Validator::make($laporan, [
        'isi_laporan' => ['required'],
      ]);

      if($validate->fails()) {
        return redirect()->back()->withInput()->withErrors($validate);
      }
      
      if($request->file('foto')) {
        $laporan['foto'] = $request->file('foto')->store('assets/pengaduan', 'public');
      }
      
      $pengaduan = Pengaduan::create([
        'tgl_pengaduan' => date('Y-m-d h:i:s'),
        'nik' => Auth::guard('masyarakat')->user()->nik,
        'isi_laporan' => $laporan['isi_laporan'],
        'foto' => $laporan['foto'] ?? '',
        'status' => '0',
      ]);

      if($pengaduan) {
        return redirect()->route('pemas.laporan', 'me')->with('berhasil', 'Laporan berhasil terkirim');
      } else {
        return redirect()->back()->with('gagal', 'Gagal terkirim');
      }


    }

    public function laporan($siapa = '')
    {

      $proses = Pengaduan::where([['nik', Auth::guard('masyarakat')->user()->nik], ['status', 'proses']])->get()->count();
      $selesai = Pengaduan::where([['nik', Auth::guard('masyarakat')->user()->nik], ['status', 'selesai']])->get()->count();

      $hitung = [$proses, $selesai];

      if($siapa == 'me') {
        $pengaduan = Pengaduan::where('nik', Auth::guard('masyarakat')->user()->nik)->orderBy('tgl_pengaduan', 'desc')->get();

        return view('user.laporan', ['title' => 'Laporan'], ['pengaduan' => $pengaduan, 'siapa' => $siapa, 'hitung' => $hitung]);
      } else {
        $pengaduan = Pengaduan::where([['nik', '!=', Auth::guard('masyarakat')->user()->nik], ['status', '!=', '0']])->orderBy('tgl_pengaduan', 'desc')->get();

        return view('user.laporan', ['title' => 'Laporan'], compact('pengaduan', 'hitung', 'siapa'));
      }



    }

    public function logout()
    {
      Auth::guard('masyarakat')->logout();

      return redirect()->back()->with('berhasil', 'berhasil logout');
    }

}
