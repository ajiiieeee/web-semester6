$(document).ready(function () {
    // ================= TOGGLE =================
    function toggleKitap() {
        let kewarganegaraan = $('select[name="kewarganegaraan"]').val();
        let noKitap = $('input[name="no_kitap"]');

        if (kewarganegaraan === "WNI") {
            noKitap.val("").prop("disabled", true);
        } else if (kewarganegaraan === "WNA") {
            noKitap.prop("disabled", false);
        } else {
            noKitap.val("").prop("disabled", true);
        }
    }

    function toggleTanggalKawin() {
        let status = $('select[name="status_perkawinan"]').val();
        let tanggal = $('input[name="tanggal_perkawinan"]');

        if (status === "KAWIN") {
            tanggal.prop("disabled", false);
        } else {
            tanggal.val("").prop("disabled", true);
        }
    }

    // ================= INIT SELECTRIC =================
    $(".selectric").selectric();

    // ================= INIT STATE =================
    toggleKitap();
    toggleTanggalKawin();

    // ================= EVENT CHANGE =================
    $('select[name="kewarganegaraan"]').on("change", toggleKitap);
    $('select[name="status_perkawinan"]').on("change", toggleTanggalKawin);

    // ================= EDIT =================
    $(document).on("click", ".btn-edit", function () {
        const data = $(this).data();

        $("#exampleModalLabel").text("Edit Anggota Keluarga");
        $("#anggotaForm").attr("action", "/admin/master_penduduk/" + data.nik);
        $("#formMethod").val("PUT");

        $('[name="nik"]').val(data.nik).prop("readonly", true);
        $('[name="nama_lengkap"]').val(data.nama_lengkap);
        $('[name="tempat_lahir"]').val(data.tempat_lahir);
        $('[name="tanggal_lahir"]').val(data.tanggal_lahir);

        $('[name="jenis_kelamin"]').val(data.jenis_kelamin);
        $('[name="agama"]').val(data.agama);
        $('[name="pendidikan"]').val(data.pendidikan);
        $('[name="pekerjaan"]').val(data.pekerjaan);
        $('[name="golongan_darah"]').val(data.golongan_darah);

        $('[name="tanggal_perkawinan"]').val(data.tanggal_perkawinan);
        $('[name="no_paspor"]').val(data.no_paspor);
        $('[name="no_kitap"]').val(data.no_kitap);
        $('[name="nama_ayah"]').val(data.nama_ayah);
        $('[name="nama_ibu"]').val(data.nama_ibu);

        // set value select dulu
        $('[name="status_perkawinan"]').val(data.status_perkawinan);
        $('[name="status_keluarga"]').val(data.status_keluarga);
        $('[name="kewarganegaraan"]').val(data.kewarganegaraan);

        // refresh UI selectric
        $("select").selectric("refresh");

        // 🔥 baru trigger toggle setelah refresh
        toggleTanggalKawin();
        toggleKitap();

        $("#exampleModal").modal("show");
    });

    // ================= RESET MODAL =================
    $("#exampleModal").on("hidden.bs.modal", function () {
        $("#anggotaForm")[0].reset();
        $("#formMethod").val("POST");
        $("#anggotaForm").attr("action", "/admin/master_penduduk/masuk");
        $("#exampleModalLabel").text("Tambah Anggota Keluarga");
        $('[name="nik"]').prop("readonly", false);

        $("select").selectric("refresh");

        toggleKitap();
        toggleTanggalKawin();
    });

    // ================= DELETE =================
    $(document).on("click", ".btndeletependuduk", function (e) {
        e.preventDefault();

        const id = $(this).data("id");
        const nama = $(this).data("nama_lengkap");

        swal({
            title: "Yakin ingin menghapus?",
            text: `Data surat "${nama}" akan dihapus!`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                swal({
                    title: "Berhasil!",
                    text: "Data berhasil dihapus",
                    icon: "success",
                    buttons: false,
                    timer: 3000,
                });

                setTimeout(() => {
                    $("#formHapus" + id).submit();
                }, 500);
            }
        });
    });
});
