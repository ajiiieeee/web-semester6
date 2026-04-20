$(document).ready(function () {
    // =========================
    // SEARCH AUTO SUBMIT
    // =========================
    const searchInput = document.getElementById("searchInput");
    const searchForm = document.getElementById("searchForm");

    if (searchInput) {
        let timeout = null;
        searchInput.addEventListener("input", function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                searchForm.submit();
            }, 500);
        });
    }

    let modal = $("#modal");

    // =========================
    // INIT SELECT2 SAAT MODAL DIBUKA
    // =========================
    modal.on("shown.bs.modal", function () {
        if ($("#nama").hasClass("select2-hidden-accessible")) {
            $("#nama").select2("destroy");
        }

        $("#nama").select2({
            placeholder: "Pilih Nama Ketua RW",
            width: "100%",
            dropdownParent: modal,
            minimumResultsForSearch: 0,
        });

        // =========================
        // RESTORE OLD VALUE (VALIDASI GAGAL)
        // =========================
        let oldNama = $("#nama").data("old");
        if (oldNama) {
            $("#nama").val(oldNama).trigger("change");
        }
    });

    // =========================
    // AUTO FOCUS SEARCH SELECT2
    // =========================
    $(document).on("select2:open", function () {
        setTimeout(() => {
            document.querySelector(".select2-search__field")?.focus();
        }, 0);
    });

    // =========================
    // AUTO ISI NIK & RW
    // =========================
    $(document).on("change", "#nama", function () {
        let selected = $(this).find(":selected");
        $("#nik").val(selected.data("nik") || "");
        $("#rw").val(selected.data("rw") || "");
    });

    // =========================
    // BTN TAMBAH
    // =========================
    $("#btnTambah").click(function () {
        $("#modalTitle").text("Tambah Akun Ketua RW");
        $("#modalForm").find('[name="_method"]').remove();
        $("#modalForm")[0].reset();

        $("#nama").val(null).trigger("change");

        modal.modal("show");
    });

    // =========================
    // BTN EDIT
    // =========================
    $(".btn-edit").click(function () {
        var id_rtrw = $(this).data("id_rtrw");
        var nik = $(this).data("nik");
        var nama = $(this).data("nama");
        var no_hp = $(this).data("no_hp");
        var rw = $(this).data("rw");
        var updateUrl = $(this).data("url");

        $("#modalTitle").text("Edit Akun Ketua RW");
        $("#modalForm").attr("action", updateUrl);

        $("#modalForm").find('[name="_method"]').remove();
        $("#modalForm").append(
            '<input type="hidden" name="_method" value="PUT">',
        );

        $("#id_rtrw").val(id_rtrw);
        $("#nik").val(nik);
        $("#no_hp").val(no_hp);
        $("#rw").val(rw);

        modal.modal("show");

        setTimeout(() => {
            $("#nama").val(nama).trigger("change");
        }, 200);
    });

    // =========================
    // DELETE CONFIRM
    // =========================
    $(document).on("click", ".btndeleteAkunrw", function (e) {
        e.preventDefault();

        const id = $(this).data("id_rtrw");
        const nama = $(this).data("nama");

        swal({
            title: "Yakin ingin menghapus?",
            text: `Data Ketua RW atas nama "${nama}" akan dihapus!`,
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
