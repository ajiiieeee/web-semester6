@extends('rt.layout.main')
@section('title', 'Surat Ditolak')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Surat Ditolak</h1>
    </div>
    @if(session('success'))
    <div id="alertPopup" class="alert alert-success alert-floating">
        {{ session('success') }}
    </div>
    @endif

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <form id="searchForm" class="d-flex" action="{{ route('rt.suratditolak.index') }}" method="get">
                            <input class="form-control me-2" type="search" name="katakunci" id="searchInput"
                                   value="{{ Request::get('katakunci') }}" placeholder="Cari..." autocomplete="off">
                            <button class="btn btn-outline-primary">
                                Cari
                            </button>
                        </form>
                    </div>

        {{-- Tabel Data --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal Pengajuan</th>
                        <th>RW</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengajuan as $a)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $a->nik }}</td>
                        <td>{{ $a->nama_lengkap }}</td>
                        <td>{{ $a->nama_surat }}</td>
                        <td>{{ $a->tanggal_diajukan }}</td>
                        <td>{{ $a->rw }}</td>
                        <td>
                            <!-- Detail -->
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail-{{ $a->id_pengajuan }}">
                                <i class="bi bi-eye-fill"></i>
                            </button>

                            <!-- Alasan -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalAlasan-{{ $a->id_pengajuan }}">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </button>

                            <!-- Hapus -->
                            <button type="button" class="btn btn-danger btn-sm btn-hapus" data-id="{{ $a->id_pengajuan }}" data-nama="{{ $a->nama_lengkap }}">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>

                    {{-- Modal Detail --}}
                    <div class="modal fade" id="modalDetail-{{ $a->id_pengajuan }}" tabindex="-1">
                        <div class="modal-dialog"> 
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title">Detail Pengajuan</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" value="{{ $a->nama_lengkap }}" readonly>
                                    <label class="form-label mt-2">Nama Surat</label>
                                    <input type="text" class="form-control" value="{{ $a->nama_surat }}" readonly>
                                    <label class="form-label mt-2">Jenis Kelamin</label>
                                    <input type="text" class="form-control" value="{{ $a->jenis_kelamin }}" readonly>
                                    <label class="form-label mt-2">TTL</label>
                                    <input type="text" class="form-control" value="{{ $a->tempat_tanggal_lahir }}" readonly>
                                    <label class="form-label mt-2">Warga / Agama</label>
                                    <input type="text" class="form-control" value="{{ $a->warga_agama }}" readonly>
                                    <label class="form-label mt-2">RW</label>
                                    <input type="text" class="form-control" value="{{ $a->rw }}" readonly>
                                    <label class="form-label mt-2">RT</label>
                                    <input type="text" class="form-control" value="{{ $a->rt }}" readonly>
                                    <label class="form-label mt-2">Keperluan</label>
                                    <input type="text" class="form-control" value="{{ $a->keperluan }}" readonly>
                                    <label class="form-label mt-2">Tanggal Diajukan</label>
                                    <input type="text" class="form-control" value="{{ $a->tanggal_diajukan }}" readonly>

                                    <div class="mt-3">
                                        @for ($i = 1; $i <= 8; $i++)
                                            @php $foto = 'foto'.$i; @endphp
                                            @if (!empty($a->$foto))
                                                <label class="form-label">Bukti {{ $i }}</label><br>
                                                <img src="{{ asset($a->$foto) }}" class="img-fluid mb-2">
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Alasan --}}
                    <div class="modal fade" id="modalAlasan-{{ $a->id_pengajuan }}" tabindex="-1">
                        <div class="modal-dialog"> 
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title">Alasan Penolakan</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <textarea class="form-control" rows="5" readonly>{{ $a->keterangan_ditolak }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Hidden Delete Form --}}
<form id="formHapus" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.btn-hapus').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.dataset.id;
        const nama = this.dataset.nama;

        Swal.fire({
            title: `<div class="text-danger">Hapus Data?</div>`,
            html: `
                <div class="card p-3">
                    <div class="fw-bold text-dark mb-2">Pengajuan Surat : ${nama}</div>
                    <div class="text-muted">Data akan dihapus secara permanen.</div>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('formHapus');
                form.action = `/rt/suratditolak/${id}`;
                form.submit();
            }
        });
    });
});
</script>

{{-- Notifikasi berhasil --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        html: `<div class="text-success fw-bold">{{ session('success') }}</div>`,
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif

{{-- Pencarian otomatis --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector('input[name="katakunci"]');
    const searchForm = document.querySelector('form');

    let timeout = null;
    searchInput.addEventListener('input', function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            searchForm.submit();
        }, 500);
    });
});
</script>

@endsection
