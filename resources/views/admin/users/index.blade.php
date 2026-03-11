@extends('layouts.app')

@section('title', 'Data Pengguna')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <x-card>
                <x-slot name="header">
                    <div class="d-flex justify-content-between align-items-center">

                        <h5 class="mb-0">
                            <i class="fas fa-folder-open text-primary"></i>
                            Data Pengguna
                        </h5>

                        <button onclick="addForm(`{{ route('admin.users.store') }}`)" class="btn btn-sm btn-success">
                            <i class="fas fa-plus-circle"></i> Tambah Data
                        </button>
                    </div>
                </x-slot>
                <x-table>
                    <x-slot name="thead">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @include('admin.users.form')
@endsection

@include('includes.datatable')

@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let button = '#submitBtn';
        let importExcel = '#importExcelModal';

        table = $('.table').DataTable({
            processing: false,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('admin.users.data') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
            ]
        })

        function addForm(url, title = 'Form Data Pengguna') {
            SwalHelper.info('Menu tambah hanya digunakan untuk menambahkan data pegawai, bukan membuat akun user.')
                .then(() => {

                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('post');

                    resetForm(`${modal} form`);
                });
        }

        function editForm(url, title = 'Form Data Pengguna') {
            Swal.fire({
                title: "Memuat...",
                text: "Mohon tunggu sebentar...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading(); // Menampilkan spinner loading
                }
            });

            $.get(url)
                .done(response => {
                    Swal.close(); // Tutup loading setelah sukses
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('put');

                    resetForm(`${modal} form`);
                    loopForm(response.data);
                })
                .fail(errors => {
                    Swal.close(); // Tutup loading jika terjadi error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops! Gagal',
                        text: errors.responseJSON?.message || 'Terjadi kesalahan saat memuat data.',
                        showConfirmButton: true,
                    });

                    if (errors.status == 422) {
                        loopErrors(errors.responseJSON.errors);
                    }
                });
        }

        function submitForm(originalForm) {
            $(button).prop('disabled', true);

            // Menampilkan Swal loading
            Swal.fire({
                title: 'Mohon Tunggu...',
                text: 'Sedang memproses data',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading(); // Menampilkan animasi loading
                }
            });

            $.ajax({
                url: $(originalForm).attr('action'),
                type: $(originalForm).attr('method') || 'POST', // Gunakan method dari form
                data: new FormData(originalForm),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response, textStatus, xhr) {
                    Swal.close(); // Tutup Swal Loading

                    if (xhr.status === 201 || xhr.status === 200) {
                        $(modal).modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            $(button).prop('disabled', false);
                            table.ajax.reload(); // Reload DataTables
                        });
                    }
                },
                error: function(xhr) {
                    Swal.close(); // Tutup Swal Loading
                    $(button).prop('disabled', false);

                    let errorMessage = "Terjadi kesalahan!";
                    if (xhr.responseJSON?.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops! Gagal',
                        text: errorMessage,
                        showConfirmButton: false,
                        timer: 3000,
                    });

                    if (xhr.status === 422) {
                        loopErrors(xhr.responseJSON.errors);
                    }
                }
            });
        }

        function deleteData(url, name) {
            Swal.fire({
                title: 'Hapus Data?',
                html: `
            <p>Anda akan menghapus data:</p>
            <strong class="text-danger">${name}</strong>
            <br><br>
            <small class="text-muted">
                Data yang sudah dihapus tidak dapat dikembalikan.
            </small>
        `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus Data',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {

                if (result.isConfirmed) {

                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang menghapus data, mohon tunggu',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        type: "DELETE",
                        url: url,
                        dataType: "json",

                        success: function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message || 'Data berhasil dihapus',
                                confirmButtonColor: '#28a745',
                                timer: 2500,
                                showConfirmButton: false
                            });

                            table.ajax.reload();

                        },

                        error: function(xhr) {

                            let message = 'Terjadi kesalahan pada server';

                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Menghapus',
                                text: message,
                                confirmButtonColor: '#d33'
                            });

                            table.ajax.reload();
                        }
                    });
                }
            });
        }

        function confirmImport() {
            $(importExcel).modal('show');
        }
    </script>
@endpush
