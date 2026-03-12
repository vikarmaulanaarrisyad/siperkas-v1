<div class="modal fade" id="modalFile" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg">

            <!-- HEADER -->
            <div class="modal-header bg-light">
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-alt text-primary mr-2"></i>
                    <div>
                        <h5 class="modal-title mb-0">Preview Berkas</h5>
                        <small class="text-muted" id="fileName">Memuat file...</small>
                    </div>
                </div>

                <div class="ml-auto">

                    <a id="btnDownload" href="#" target="_blank" class="btn btn-sm btn-success mr-2">
                        <i class="fas fa-download"></i> Download
                    </a>

                    <a id="btnOpenTab" href="#" target="_blank" class="btn btn-sm btn-info mr-2">
                        <i class="fas fa-external-link-alt"></i> Buka Tab
                    </a>

                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>

                </div>
            </div>

            <!-- BODY -->
            <div class="modal-body p-0">

                <div id="loadingFile" class="text-center p-5">
                    <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                    <p class="mt-2 text-muted">Memuat file...</p>
                </div>

                <iframe id="previewFile" src="" width="100%" height="650px"
                    style="border:none; display:none;">
                </iframe>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer bg-light">
                <small class="text-muted">
                    Tips: Gunakan tombol <strong>Buka Tab</strong> untuk melihat file lebih jelas.
                </small>
            </div>

        </div>
    </div>
</div>
