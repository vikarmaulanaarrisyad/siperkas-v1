<x-modal data-backdrop="static" data-keyboard="false" size="modal-md">

    <x-slot name="title">
        <i class="fas fa-users text-primary"></i>
        Form Data Pengguna
    </x-slot>

    @method('POST')

    <div class="row">

        <div class="col-12">
            <div class="form-group">
                <label for="name">
                    Nama Pengguna <span class="text-danger">*</span>
                </label>

                <input id="name" type="text" name="name" class="form-control"
                    placeholder="Masukkan nama pengguna" autocomplete="off" required>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="username">
                    Username <span class="text-danger">*</span>
                </label>

                <input id="username" type="text" name="username" class="form-control"
                    placeholder="Masukkan username" autocomplete="off" required>

                <small class="text-muted">
                    Username digunakan untuk login selain email.
                </small>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="email">
                    Email <span class="text-danger">*</span>
                </label>

                <input id="email" type="email" name="email" class="form-control"
                    placeholder="Contoh: user@email.com" autocomplete="off" required>

                <small class="text-muted">
                    Email akan digunakan sebagai akun login.
                </small>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="password">
                    Password <span class="text-danger">*</span>
                </label>

                <div class="input-group">
                    <input id="password" type="password" name="password" class="form-control"
                        placeholder="Masukkan password" autocomplete="new-password" required>

                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary"
                            onclick="togglePassword('password', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="password_confirmation">
                    Konfirmasi Password <span class="text-danger">*</span>
                </label>

                <div class="input-group">
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control"
                        placeholder="Ulangi password" autocomplete="new-password" required>

                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary"
                            onclick="togglePassword('password_confirmation', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
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
