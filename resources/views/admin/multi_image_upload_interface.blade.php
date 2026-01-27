@extends('admin.admin_master')
@section('admin')




         <div class="up-wrapper">
        <div class="up-card">
            
            <!-- Header -->
            <div class="up-header">
                <div>
                    <h1 class="up-title">Upload Gallery Images</h1>
                    <p class="up-subtitle">Add images to your project gallery (Max 10MB per file)</p>
                </div>
                <div class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                    <i class="bi bi-images me-1 text-primary"></i> Gallery
                </div>
            </div>

            <!-- Dropzone Area -->
            <div class="up-dropzone-area">
                <!-- FORM: Action connects to your backend route -->
                <form action="/upload-target" class="dropzone" id="my-awesome-dropzone">
                    <div class="dz-message needsclick">
                        <i class="bi bi-cloud-arrow-up up-upload-icon"></i>
                        <h3 class="up-upload-text">Drag & Drop files here or click to browse</h3>
                        <span class="up-upload-hint">Supports JPG, PNG, GIF up to 10MB</span>
                    </div>
                </form>
            </div>

            <!-- Actions Footer -->
            <div class="up-actions">
                <button type="button" class="up-btn up-btn-secondary" id="cancelBtn">
                    <i class="bi bi-x-circle"></i> Cancel All
                </button>
                <button type="button" class="up-btn up-btn-primary" id="uploadBtn">
                    <i class="bi bi-check-lg"></i> Upload Files
                </button>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

   <script>
        Dropzone.autoDiscover = false;

        const MAX_SIZE_MB = 10;

        let myDropzone = new Dropzone("#my-awesome-dropzone", {
            url: "{{ route('about.upload') }}",
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 5,
            maxFiles: 10,
            maxFilesize: MAX_SIZE_MB, // MB
            acceptedFiles: "image/jpeg,image/png,image/webp,image/gif",
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },

            init: function () {
                let dz = this;

                document.getElementById("uploadBtn").addEventListener("click", function () {
                    if (dz.getQueuedFiles().length === 0) {
                        showToast('warning', 'Please select images first.');
                        return;
                    }
                    dz.processQueue();
                });

                document.getElementById("cancelBtn").addEventListener("click", function () {
                    dz.removeAllFiles(true);
                });

            
                dz.on("addedfile", function (file) {
                    if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                        showToast('error', 'Image exceeds 10MB and was removed.');
                        dz.removeFile(file);
                    }
                });

                dz.on("successmultiple", function (files, response) {
                    showToast('success', response.message);
                    dz.removeAllFiles();
                });

                dz.on("errormultiple", function (files, response) {
                    showToast('error', response.message || 'Upload failed.');
                });
            }
        });
</script>










@endsection