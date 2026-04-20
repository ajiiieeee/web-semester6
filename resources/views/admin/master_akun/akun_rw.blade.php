@extends('admin.layout.main')
@php
function showError($field) {
    if (isset($errors) && $errors->has($field)) {
        return '<small class="text-danger">'.$errors->first($field).'</small>';
    }
    return '';
}
@endphp
@section('content')
@section('title', 'Akun RW')
<section class="section">
    <div class="section-header">
        <h1>Akun Rukun Warga</h1>
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

                    <!-- CARD HEADER -->
                    <div class="card-header">
                      <div class="d-flex justify-content-between w-100">
                    {{-- form search --}}
                        <form id="searchForm" class="d-flex" action="{{ route('akunrw') }}" method="get">
                            <input class="form-control me-1" type="search" name="katakunci"
                            id="searchInput"
                            value="{{ Request::get('katakunci') }}"
                            placeholder="Cari" aria-label="Search"
                            autocomplete="off">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </form>

                        <!-- KANAN : TOMBOL TAMBAH -->
                        <button id="btnTambah" class="btn btn-primary">
                            + Tambah Data
                        </button>
                      </div>
                    </div>

                    <!-- CARD BODY -->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table table-striped" id="activityTable">
                                <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama Ketua Rukun Warga</th>
                            <th>Nomor Handphone</th>
                            <th>RW</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataakunrw as $a)
                            
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $a->nik }}</td>
                                    <td>{{ $a->nama }}</td>
                                    <td>{{ $a->no_hp }}</td>
                                    <td>{{ $a->rw }}</td>
                                    <td>
                                        <button 
                                            class="btn btn-warning btn-sm btn-edit"
                                            data-id_rtrw="{{ $a->id_rtrw }}"
                                            data-nik="{{ $a->nik }}"
                                            data-nama="{{ $a->nama }}"
                                            data-no_hp="{{ $a->no_hp }}"
                                            data-rw="{{ $a->rw }}"
                                            data-url="{{ route('akunrw.update', $a->id_rtrw) }}"
                                        >
                                        <i class="fas fa-pencil-alt"></i>
                                        </button>

                                        <form id="formHapus{{ $a->id_rtrw }}" style="display: inline" action="{{ route('akunrw.delete', $a->id_rtrw) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm btndeleteAkunrw" data-id_rtrw="{{ $a->id_rtrw }}" data-nama="{{ $a->nama }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                        </form>

                                    </td>
                                </tr>
                           
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $dataakunrw->withQueryString()->links() }}
            </div>
</section>
            
            {{-- modal --}}
            <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form id="modalForm" action="{{ route('akunrw.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title" id="modalTitle">Tambah Akun Ketua RW</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" name="id_rtrw" id="id_rtrw" value="{{ $id_rtrw }}">

                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Ketua RW</label>
                                    <select data-old="{{ old('nama') }}" class="form-control select2 w-100 {{ $errors->has('nama') ? 'is-invalid' : '' }}" name="nama" id="nama" required>
                                        <option disabled selected value="">Pilih Nama</option>
                                        @foreach ($data as $value)
                                            <option 
                                                value="{{ $value->nama_lengkap }}"
                                                data-nik="{{ $value->nik }}"
                                                data-rw="{{ $value->rw }}">
                                                {{ $value->nama_lengkap }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">
                                        {{ $errors->first('nama') }}
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nomor HP</label>
                                    <input type="text" class="form-control {{ $errors->has('no_hp') ? 'is-invalid' : '' }}" value="{{ old('no_hp') }}" name="no_hp" id="no_hp" required>
                                    <small class="text-danger">
                                        {{ $errors->first('no_hp') }}
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">NIK</label>
                                    <input type="text" class="form-control {{ $errors->has('nik') ? 'is-invalid' : '' }}" value="{{ old('nik') }}" name="nik" id="nik" readonly>
                                    <small class="text-danger">
                                        {{ $errors->first('nik') }}
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">RW</label>
                                    <input type="text" class="form-control {{ $errors->has('rw') ? 'is-invalid' : '' }}" value="{{ old('rw') }}" name="rw" id="rw" required>
                                    <small class="text-danger">
                                        {{ $errors->first('rw') }}
                                    </small>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- scripts --}}
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
            <script src="{{ asset('assets/js/page/modules-sweetalert.js') }}"></script>
            <script src="{{ asset('js/rw.js') }}"></script>
            @if ($errors->any())
            <script>
                $(document).ready(function () {
                    $("#modal").modal("show");
                });
            </script>
            @endif
            <style>
                .select2-container {
                    width: 100% !important;
                }

                .select2-container {
                    z-index: 9999 !important;
                }

                .select2-dropdown {
                    z-index: 9999 !important;
                }
                .select2-container--default.select2-container--focus .select2-selection,
                .is-invalid + .select2 .select2-selection {
                    border-color: red !important;
                }
            </style>


        </div>
    </div>
@endsection