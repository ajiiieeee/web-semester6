$(document).ready(function () {
    // =========================
    // BTN TAMBAH
    // =========================
    $("#btnTambahSurat").on("click", function () {
        const idSuratBaru = $(this).data("id_surat");

        $("#formSurat").trigger("reset");
        $("#formSurat").attr("action", $("#formSurat").data("store-url"));
        $("#formMethod").val("POST");

        $("#inputIdSurat").val(idSuratBaru);
        $("#modalTitle").text("Tambah Surat");

        $("#modalForm").modal("show");
    });

    // =========================
    // BTN EDIT (pakai delegation)
    // =========================
    $(document).on("click", ".btnEditSurat", function () {
        const action = $(this).data("action");
        const id = $(this).data("id");
        const nama = $(this).data("nama");

        $("#formSurat").attr("action", action);
        $("#formMethod").val("PUT");

        $("#inputIdSurat").val(id);
        $("#inputNamaSurat").val(nama);
        $("#modalTitle").text("Edit Surat");

        $("#modalForm").modal("show");
    });

    // =========================
    // BTN HAPUS (pakai jQuery)
    // =========================
    $(document).on("click", ".btnDeleteSurat", function (e) {
        e.preventDefault();

        const id = $(this).data("id");
        const nama = $(this).data("nama");

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

    // =========================
    // SEARCH AUTO SUBMIT
    // =========================
    let timeout = null;

    $("#searchInput").on("input", function () {
        clearTimeout(timeout);

        timeout = setTimeout(function () {
            $("#searchForm").submit();
        }, 500);
    });
});
