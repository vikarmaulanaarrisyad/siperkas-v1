window.SwalHelper = {
    // Loading
    loading(message = "Mohon tunggu...") {
        Swal.fire({
            title: "Memproses...",
            text: message,
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });
    },

    // Success Alert
    success(message = "Data berhasil diproses") {
        Swal.fire({
            icon: "success",
            title: "Berhasil",
            text: message,
            timer: 2500,
            showConfirmButton: false,
        });
    },

    // Error Alert
    error(message = "Terjadi kesalahan pada server") {
        Swal.fire({
            icon: "error",
            title: "Oops!",
            text: message,
            confirmButtonColor: "#d33",
        });
    },

    // Info
    info(message = "Informasi") {
        return Swal.fire({
            icon: "info",
            title: "Informasi",
            text: message,
            confirmButtonColor: "#3085d6",
        });
    },

    // Toast Notification
    toast(icon = "success", message = "Berhasil") {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        Toast.fire({
            icon: icon,
            title: message,
        });
    },

    // Confirm
    confirm(title = "Apakah anda yakin?", text = "") {
        return Swal.fire({
            title: title,
            text: text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            reverseButtons: true,
        });
    },

    // Confirm Delete
    confirmDelete(name = "data") {
        return Swal.fire({
            title: "Hapus Data?",
            html: `
                <p>Anda akan menghapus:</p>
                <strong class="text-danger">${name}</strong>
                <br><br>
                <small class="text-muted">
                    Data yang sudah dihapus tidak dapat dikembalikan
                </small>
            `,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal",
            reverseButtons: true,
        });
    },

    // Validation Error
    validation(errors) {
        let message = "";

        $.each(errors, function (key, value) {
            message += `${value[0]} <br>`;
        });

        Swal.fire({
            icon: "error",
            title: "Validasi Gagal",
            html: message,
        });
    },
};
