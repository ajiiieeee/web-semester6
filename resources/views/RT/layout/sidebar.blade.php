<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">

    <!-- Logo besar -->
    <div class="sidebar-brand normal-logo">
      <a href="{{ url('/rt/dashboard-rt') }}" class="d-flex align-items-center justify-content-center">
        <span style="font-weight: 900; font-size: 20px;">DIGITAL VILLAGE</span>
      </a>
    </div>

    <!-- Logo kecil -->
    <div class="sidebar-brand sidebar-brand-sm collapsed-logo">
      <a href="{{ url('/rt/dashboard-rt') }}">
        <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo Kecil" style="height:35px; margin-left:5px;">
      </a>
    </div>

    <ul class="sidebar-menu">
      <li><a href="{{ url('/rt/dashboard-rt') }}" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
      <!-- Pengajuan Surat -->
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
          <i class="fas fa-envelope"></i>
          <span>Pengajuan Surat</span>
          {{-- <span class="badge bg-danger" id="pengajuan-count">{{ $jumlahPengajuan ?? 0 }}</span> --}}
        </a>
        <ul class="dropdown-menu">
          <li><a href="{{ url('rt/suratmasuk-rt') }}" class="nav-link">Surat Masuk</a></li>
          <li><a href="{{ url('rt/suratselesai-rt') }}" class="nav-link">Surat Selesai</a></li>
          <li><a href="{{ url('rt/suratditolak-rt') }}" class="nav-link">Surat Ditolak</a></li>
        </ul>
      </li>
    </ul>

  </aside>
</div>

<style>
  .collapsed-logo { display: none; }
  body.sidebar-mini .normal-logo { display: none !important; }
  body.sidebar-mini .collapsed-logo { display: block !important; }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>