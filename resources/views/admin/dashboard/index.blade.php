@extends('admin.layout.main')
@section('title', 'Dashboard')

@section('content')

<section class="section">

  {{-- HEADER --}}
  <div class="section-header">
    <h1>Selamat Datang, {{ auth()->user()->name ?? 'Admin Desa' }}</h1>
  </div>

  {{-- TEKS TAMBAHAN (DI BAWAH HEADER / CARD PUTIH) --}}
  <div class="mb-4">
    <p style="font-size: 14px; color: #444; line-height: 1.6;">
      Sistem Informasi Desa Kalipait — Kelola data penduduk, kartu keluarga, 
      dan layanan administrasi desa secara terintegrasi dan efisien.
    </p>

    <small style="color: #555;">
      {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
    </small>
  </div>

  <div class="row">

    {{-- KIRI: CHART --}}
    <div class="col-lg-7">
      <div class="card">
        <div class="card-header">
          <h4>Statistik Penduduk</h4>
        </div>
        <div class="card-body">
          <div style="height:300px;">
            <canvas id="chartPenduduk"></canvas>
          </div>
        </div>
      </div>
    </div>

    {{-- KANAN: 6 CARD --}}
    <div class="col-lg-5">
      <div class="row">

        {{-- Penduduk --}}
        <div class="col-6 mb-3">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header"><h4>Penduduk</h4></div>
              <div class="card-body">{{ $jumlahPenduduk }}</div>
            </div>
          </div>
        </div>

        {{-- KK --}}
        <div class="col-6 mb-3">
          <div class="card card-statistic-1">
            <div class="card-icon bg-info">
              <i class="fas fa-home"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header"><h4>KK</h4></div>
              <div class="card-body">{{ $jumlahKK }}</div>
            </div>
          </div>
        </div>

        {{-- Pria --}}
        <div class="col-6 mb-3">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-male"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header"><h4>Pria</h4></div>
              <div class="card-body">{{ $jumlahLaki }}</div>
            </div>
          </div>
        </div>

        {{-- Wanita --}}
        <div class="col-6 mb-3">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
              <i class="fas fa-female"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header"><h4>Wanita</h4></div>
              <div class="card-body">{{ $jumlahPerempuan }}</div>
            </div>
          </div>
        </div>

        {{-- RT --}}
        <div class="col-6 mb-3">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="fas fa-map"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header"><h4>RT</h4></div>
              <div class="card-body">{{ $jumlahRT }}</div>
            </div>
          </div>
        </div>

        {{-- RW --}}
        <div class="col-6 mb-3">
          <div class="card card-statistic-1">
            <div class="card-icon bg-dark">
              <i class="fas fa-map-marked"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header"><h4>RW</h4></div>
              <div class="card-body">{{ $jumlahRW }}</div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>

</section>

@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('chartPenduduk');

    if (ctx) {
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Pria', 'Wanita'],
                datasets: [{
                    data: [
                        {{ $jumlahLaki }},
                        {{ $jumlahPerempuan }}
                    ],
                    backgroundColor: ['#36A2EB', '#FF6384']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
});
</script>
@endpush