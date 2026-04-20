@extends('rw.layout.main')
@section('title', 'Surat Selesai')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>Surat Selesai </h1>
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
                        <form id="searchForm" class="d-flex" action="{{ route('rw.suratselesai.index') }}" method="get">
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
                        <th>RT</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuan as $index => $item)
                        <tr class="text-center">
                            <td>{{ $pengajuan->firstItem() + $index }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ $item->nama_surat }}</td>
                            <td>{{ $item->tanggal_diajukan }}</td>
                            <td>{{ $item->rt }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail-{{ $item->id_pengajuan }}">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                                <button class="btn btn-danger btn-sm btn-hapus" data-id="{{ $item->id_pengajuan }}" data-nama="{{ $item->nama_lengkap }}">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Modal Detail --}}
                        <div class="modal fade" id="modalDetail-{{ $item->id_pengajuan }}" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Detail Pengajuan</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label class="form-label">Nama</label>
                                        <input type="text" class="form-control" value="{{ $item->nama_lengkap }}" readonly>
                                        <label class="form-label mt-2">Nama Surat</label>
                                        <input type="text" class="form-control" value="{{ $item->nama_surat }}" readonly>
                                        <label class="form-label mt-2">Jenis Kelamin</label>
                                        <input type="text" class="form-control" value="{{ $item->jenis_kelamin }}" readonly>
                                        <label class="form-label mt-2">TTL</label>
                                        <input type="text" class="form-control" value="{{ $item->tempat_tanggal_lahir }}" readonly>
                                        <label class="form-label mt-2">Warga / Agama</label>
                                        <input type="text" class="form-control" value="{{ $item->warga_agama }}" readonly>
                                        <label class="form-label mt-2">RW</label>
                                        <input type="text" class="form-control" value="{{ $item->rw }}" readonly>
                                        <label class="form-label mt-2">RT</label>
                                        <input type="text" class="form-control" value="{{ $item->rt }}" readonly>
                                        <label class="form-label mt-2">Keperluan</label>
                                        <input type="text" class="form-control" value="{{ $item->keperluan }}" readonly>
                                        <label class="form-label mt-2">Tanggal Diajukan</label>
                                        <input type="text" class="form-control" value="{{ $item->tanggal_diajukan }}" readonly>

                                        <div class="mt-3">
                                            @for ($i = 1; $i <= 8; $i++)
                                                @php $foto = 'foto' . $i; @endphp
                                                @if (!empty($item->$foto))
                                                    <label class="form-label">Bukti {{ $i }}</label><br>
                                                    <img src="{{ asset($item->$foto) }}" class="img-fluid mb-2" alt="Bukti {{ $i }}">
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                @if(request('katakunci'))
                                    Data dengan kata kunci <strong>{{ request('katakunci') }}</strong> tidak ditemukan.
                                @else
                                    Belum ada data.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $pengajuan->links() }}
        </div>
    </div>
</div>

{{-- Form Delete --}}
<form id="formHapus" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection
