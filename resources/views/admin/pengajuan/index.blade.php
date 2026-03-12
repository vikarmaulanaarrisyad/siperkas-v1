@extends('layouts.app')

@section('title', 'Jenis Berkas')

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
                            Data Jenis Berkas
                        </h5>

                    </div>
                </x-slot>

                {{-- FILTER --}}
                <div class="row mb-3">

                    <div class="col-md-3">
                        <label>Status</label>
                        <select id="filter_status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="menunggu">Menunggu</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Tanggal Dari</label>
                        <input type="date" id="filter_dari" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>Tanggal Sampai</label>
                        <input type="date" id="filter_sampai" class="form-control">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">

                        <button class="btn btn-primary mr-2" id="btnFilter">
                            <i class="fas fa-search"></i> Filter
                        </button>

                        <button class="btn btn-secondary" id="btnReset">
                            <i class="fas fa-sync"></i> Reset
                        </button>

                    </div>

                </div>

                <x-table>
                    <x-slot name="thead">

                        <tr class="text-center">
                            <th>No</th>
                            <th>Jenis Berkas</th>
                            <th>File</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Aksi</th>
                        </tr>

                    </x-slot>
                </x-table>

            </x-card>

        </div>
    </div>

    @include('admin.pengajuan.view_file')
    @include('admin.pengajuan.form')

@endsection

@include('includes.datatable')

@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let button = '#submitBtn';
        let importExcel = '#importExcelModal';

        table = $('.table').DataTable({

            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,

            ajax: {
                url: '{{ route('admin.pengajuan.data') }}',
                data: function(d) {
                    d.status = $('#filter_status').val()
                    d.dari = $('#filter_dari').val()
                    d.sampai = $('#filter_sampai').val()
                }
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'jenis_berkas'
                },

                {
                    data: 'file'
                },

                {
                    data: 'keterangan'
                },

                {
                    data: 'status'
                },

                {
                    data: 'tanggal_pengajuan'
                },

                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                }
            ]
        })

        /* FILTER */

        $('#btnFilter').click(function() {
            table.ajax.reload();
        })

        $('#btnReset').click(function() {

            $('#filter_status').val('')
            $('#filter_dari').val('')
            $('#filter_sampai').val('')

            table.ajax.reload();

        })

        function addForm(url, title = 'Form Data Jenis Berkas') {

            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('post');

            resetForm(`${modal} form`);

        }

        function editForm(url, title = 'Form Data Jenis Berkas') {

            Swal.fire({
                title: "Memuat...",
                text: "Mohon tunggu sebentar...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.get(url)

                .done(response => {

                    Swal.close();

                    $(modal).modal('show');

                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('put');

                    resetForm(`${modal} form`);
                    loopForm(response.data);

                })

                .fail(errors => {

                    Swal.close();

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops! Gagal',
                        text: errors.responseJSON?.message || 'Terjadi kesalahan saat memuat data.'
                    });

                    if (errors.status == 422) {
                        loopErrors(errors.responseJSON.errors);
                    }

                });

        }

        function submitForm(originalForm) {

            $(button).prop('disabled', true);

            Swal.fire({
                title: 'Mohon Tunggu...',
                text: 'Sedang memproses data',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({

                url: $(originalForm).attr('action'),
                type: $(originalForm).attr('method') || 'POST',
                data: new FormData(originalForm),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,

                success: function(response, textStatus, xhr) {

                    Swal.close();

                    if (xhr.status === 201 || xhr.status === 200) {

                        $(modal).modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 3000,
                            showConfirmButton: false
                        })

                        table.ajax.reload()

                    }

                },

                error: function(xhr) {

                    Swal.close();
                    $(button).prop('disabled', false);

                    let errorMessage = "Terjadi kesalahan!"

                    if (xhr.responseJSON?.message) {
                        errorMessage = xhr.responseJSON.message
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops! Gagal',
                        text: errorMessage,
                        timer: 3000,
                        showConfirmButton: false
                    })

                    if (xhr.status === 422) {
                        loopErrors(xhr.responseJSON.errors)
                    }

                }

            })

        }

        function deleteData(url, name) {

            Swal.fire({

                title: 'Hapus Data?',
                html: `<p>Anda akan menghapus data:</p>
                <strong class="text-danger">${name}</strong>
                <br><br>
                <small class="text-muted">Data yang sudah dihapus tidak dapat dikembalikan.</small>`,

                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus Data',
                cancelButtonText: 'Batalkan',
                reverseButtons: true

            }).then((result) => {

                if (result.isConfirmed) {

                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang menghapus data',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })

                    $.ajax({

                        type: "DELETE",
                        url: url,
                        dataType: "json",

                        success: function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message || 'Data berhasil dihapus',
                                timer: 2500,
                                showConfirmButton: false
                            })

                            table.ajax.reload()

                        },

                        error: function(xhr) {

                            let message = 'Terjadi kesalahan server'

                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Menghapus',
                                text: message
                            })

                        }

                    })

                }

            })

        }

        function approvePengajuan(url) {

            Swal.fire({
                title: "Terima Pengajuan?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Terima"
            }).then((result) => {

                if (result.isConfirmed) {

                    $.post(url).done((res) => {

                        Swal.fire("Berhasil", res.message, "success")
                        table.ajax.reload()

                    })

                }

            })

        }

        function rejectPengajuan(url) {

            Swal.fire({
                title: "Tolak Pengajuan",
                input: "textarea",
                inputLabel: "Alasan Penolakan",
                showCancelButton: true,
                confirmButtonText: "Tolak"
            }).then((result) => {

                if (result.isConfirmed) {

                    $.post(url, {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                        catatan: result.value
                    }).done((res) => {

                        Swal.fire("Berhasil", res.message, "success")
                        table.ajax.reload()

                    })

                }

            })

        }
    </script>

    <script>
        function lihatFile(url, namaFile = 'Berkas') {

            $('#fileName').text(namaFile)

            $('#previewFile').hide()
            $('#loadingFile').show()

            $('#previewFile').attr('src', url)

            $('#btnDownload').attr('href', url)
            $('#btnOpenTab').attr('href', url)

            $('#modalFile').modal('show')

        }

        $('#previewFile').on('load', function() {

            $('#loadingFile').hide()
            $('#previewFile').show()

        })

        $('#modalFile').on('hidden.bs.modal', function() {

            $('#previewFile').attr('src', '')
            $('#loadingFile').show()
            $('#previewFile').hide()

        })
    </script>
@endpush
