<x-modal data-backdrop="static" data-keyboard="false" size="modal-md">

    <x-slot name="title">
        <i class="fas fa-folder-open text-primary"></i>
        Form Jenis Berkas
    </x-slot>

    @method('POST')

    <div class="row">

        <div class="col-12">
            <div class="form-group">
                <label for="kode_berkas">
                    Kode Berkas <span class="text-danger">*</span>
                </label>

                <input id="kode_berkas" type="text" name="kode_berkas" class="form-control"
                    placeholder="Contoh: BRK001" autocomplete="off" required>

                <small class="text-muted">
                    Gunakan kode unik untuk identifikasi berkas.
                </small>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="nama_berkas">
                    Nama Berkas <span class="text-danger">*</span>
                </label>

                <input id="nama_berkas" type="text" name="nama_berkas" class="form-control"
                    placeholder="Contoh: Ijazah, Transkrip Nilai" autocomplete="off" required>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="deskripsi">
                    Deskripsi
                </label>

                <textarea id="deskripsi" name="deskripsi" rows="3" class="form-control"
                    placeholder="Tambahkan keterangan atau penjelasan berkas..."></textarea>

                <small class="text-muted">
                    Opsional: berisi informasi tambahan mengenai berkas.
                </small>
            </div>
        </div>

    </div>

    <x-slot name="footer">

        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary" id="submitBtn">

            <span id="spinner-border" class="spinner-border spinner-border-sm d-none" role="status">
            </span>

            <i class="fas fa-save mr-1"></i>
            Simpan Data
        </button>

        <button type="button" data-dismiss="modal" class="btn btn-sm btn-secondary">

            <i class="fas fa-times"></i>
            Tutup
        </button>

    </x-slot>

</x-modal>
