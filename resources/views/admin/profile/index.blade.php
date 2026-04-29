@extends('admin.layout.main')
@section('title', 'Perangkat Desa')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Perangkat Desa</h1>
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

                        <h4>Data Perangkat Desa</h4>

                        <a href="#" class="btn btn-primary" id="btnTambahProfile">
                            + Tambah Data
                        </a>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Tipe</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            <img src="{{ asset('storage/' . $item->foto) }}" width="60">
                                        </td>

                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->jabatan }}</td>
                                        <td>{{ $item->tipe }}</td>

                                        <td>
                                            <button type="button"
                                                class="btn btn-warning btn-sm btnEditProfile"
                                                data-id="{{ $item->id }}"
                                                data-nama="{{ $item->nama }}"
                                                data-jabatan="{{ $item->jabatan }}"
                                                data-tipe="{{ $item->tipe }}"
                                                data-foto="{{ asset('storage/' . $item->foto) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>

                                            <form id="formHapus{{ $item->id }}" method="POST"
                                                action="{{ route('admin.profile.destroy', $item->id) }}"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="btn btn-danger btn-sm btnDeleteProfile">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


{{-- MODAL FORM --}}
<div class="modal fade" id="modalProfile" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleProfile">Tambah Perangkat</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="formProfile" method="POST" enctype="multipart/form-data"
                    action="{{ route('admin.profile.store') }}">

                    @csrf
                    <input type="hidden" name="_method" id="formMethodProfile" value="POST">
                    <input type="hidden" name="id" id="inputId">

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" id="inputNama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Jabatan</label>
                        <input type="text" name="jabatan" id="inputJabatan" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control">
                        <img id="previewFoto" width="100" class="mt-2 d-none">
                    </div>

                </form>

            </div>

            <div class="modal-footer">
                <button type="submit" form="formProfile" class="btn btn-primary">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>


{{-- SCRIPT --}}
<script>
document.getElementById('btnTambahProfile').addEventListener('click', function () {
    document.getElementById('modalTitleProfile').innerText = 'Tambah Perangkat Desa';
    document.getElementById('formProfile').action = "{{ route('admin.profile.store') }}";
    document.getElementById('formMethodProfile').value = "POST";

    document.getElementById('formProfile').reset();
    new bootstrap.Modal(document.getElementById('modalProfile')).show();
});


document.querySelectorAll('.btnEditProfile').forEach(btn => {
    btn.addEventListener('click', function () {

        document.getElementById('modalTitleProfile').innerText = 'Edit Perangkat Desa';

        let id = this.dataset.id;

        document.getElementById('formProfile').action = "/admin/profile/" + id;
        document.getElementById('formMethodProfile').value = "PUT";

        document.getElementById('inputId').value = id;
        document.getElementById('inputNama').value = this.dataset.nama;
        document.getElementById('inputJabatan').value = this.dataset.jabatan;
        

        let preview = document.getElementById('previewFoto');
        preview.src = this.dataset.foto;
        preview.classList.remove('d-none');

        new bootstrap.Modal(document.getElementById('modalProfile')).show();
    });
});
</script>

@endsection