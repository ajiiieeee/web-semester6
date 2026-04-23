@extends('RW.layout.main')
@section('title', 'Dashboard')

@section('content')

<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
   <h1>Dashboard RW {{ $rw }}</h1>
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
                {{-- Surat Masuk --}}
        <div class="col-6 mb-3">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="fas fa-envelope"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header"><h4>Surat Masuk</h4></div>
              <div class="card-body">{{ $jumlahSuratMasuk }}</div>
            </div>
          </div>
        </div>

        {{-- Surat Ditolak --}}
        <div class="col-6 mb-3">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
              <i class="fas fa-times"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header"><h4>Ditolak</h4></div>
              <div class="card-body">{{ $jumlahSuratDitolak }}</div>
            </div>
          </div>
        </div>

        {{-- Surat Selesai --}}
        <div class="col-6 mb-3">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-check"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header"><h4>Selesai</h4></div>
              <div class="card-body">{{ $jumlahSuratSelesai }}</div>
            </div>
          </div>
        </div>

        {{-- RT --}}
        <div class="col-6 mb-3">
          <div class="card card-statistic-1">
            <div class="card-icon bg-dark">
              <i class="fas fa-map"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header"><h4>RT</h4></div>
              <div class="card-body">{{ $jumlahRT }}</div>
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

    const canvas = document.getElementById('chartPenduduk');

    if (!canvas) {
        console.log('Canvas tidak ditemukan');
        return;
    }

    if (typeof Chart === 'undefined') {
        console.log('Chart.js tidak terload');
        return;
    }

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                label: 'Jumlah Penduduk',
                data: [
                    {{ $jumlahLaki ?? 0 }},
                    {{ $jumlahWanita ?? 0 }}
                ],
                backgroundColor: [
                    '#36A2EB',
                    '#FF6384'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

});
</script>
@endpush