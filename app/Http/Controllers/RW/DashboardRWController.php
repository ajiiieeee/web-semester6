<?php

namespace App\Http\Controllers\RW;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardRWController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $nik = $user->nik ?? $user->username;

    // Ambil RW dari user
    $rwData = DB::table('master_rt_rw')->where('nik', $nik)->first();

    if (!$rwData) {
        return view('rw.dashboard')->with('error', 'Data RW tidak ditemukan');
    }

    $rw = $rwData->rw;

    // Ambil semua KK di RW
    $kkList = DB::table('master_kartukeluargas')
        ->where('rw', $rw)
        ->pluck('no_kk');

    // Ambil semua NIK
    $niks = DB::table('master_penduduks')
        ->whereIn('no_kk', $kkList)
        ->pluck('nik');

    // ======================
    // 📊 DATA PENDUDUK
    // ======================

    $jumlahPenduduk = DB::table('master_penduduks')
        ->whereIn('nik', $niks)
        ->count();

    $jumlahKK = $kkList->count();

    $jumlahLaki = DB::table('master_penduduks')
        ->whereIn('nik', $niks)
        ->whereRaw("LOWER(jenis_kelamin) REGEXP 'laki'")
        ->count();

    $jumlahWanita = DB::table('master_penduduks')
        ->whereIn('nik', $niks)
        ->whereRaw("LOWER(REPLACE(jenis_kelamin, ' ', '')) = 'perempuan'")
        ->count();

    // ======================
    // 📄 DATA SURAT
    // ======================

    $jumlahSuratMasuk = DB::table('master_pengajuan')
        ->whereIn('nik', $niks)
        ->where('status', 'Disetujui RT')
        ->count();

    $jumlahSuratDitolak = DB::table('master_pengajuan')
        ->whereIn('nik', $niks)
        ->where('status', 'Ditolak')
        ->count();

    $jumlahSuratSelesai = DB::table('master_pengajuan')
        ->whereIn('nik', $niks)
        ->where('status', 'Disetujui RW')
        ->count();

    // ======================
    // 🏘️ DATA RT
    // ======================

    $jumlahRT = DB::table('master_rt_rw')
        ->where('rw', $rw)
        ->distinct('rt')
        ->count('rt');

    return view('rw.dashboard', compact(
        'jumlahPenduduk',
        'jumlahKK',
        'jumlahLaki',
        'jumlahWanita',
        'jumlahSuratMasuk',
        'jumlahSuratDitolak',
        'jumlahSuratSelesai',
        'jumlahRT',
        'rw'
    ));
}
}