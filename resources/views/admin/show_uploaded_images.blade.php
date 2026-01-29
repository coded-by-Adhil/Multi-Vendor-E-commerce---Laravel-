@extends('admin.admin_master')
@section('admin')


 
    <div class="it-wrapper">
        <div class="it-card">
            
            <div class="it-header">
                <div>
                    <h1 class="it-title">Uploaded Images</h1>
                    <p class="text-muted mb-0">Manage your gallery assets</p>
                </div>
                <a href="{{ route('about.multi_image_view') }}" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="bi bi-cloud-upload"></i> Upload New
                </a>
            </div>

            <div class="it-table-container">
                <table id="imageTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th width="15%">Image</th>
                            <th width="25%">Created At</th>
                            <th width="25%">Updated At</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->

                        @foreach ($images as $image)

                            <tr id="image-{{ $image->id }}">
                                <td>
                                    <img src="{{ asset('storage/' . $image->image_url) }}" alt="Image 1" class="it-img-thumbnail">
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $image->created_at->format('Y-m-d') }}</div>
                                    <small class="text-muted">{{ $image->created_at->format('h:i A') }}</small>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $image->updated_at->format('Y-m-d') }}</div>
                                    <small class="text-muted">{{ $image->updated_at->format('h:i A') }}</small>
                                </td>
                                <td>
                                    <button
                                        class="it-btn-action it-btn-edit"
                                        data-id="{{ $image->id }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editImageModal"
                                        onclick="openEditModal({{ $image->id }})"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <button
                                        class="it-btn-action it-btn-delete"
                                        data-delete-url="{{ route('about.image.delete', $image->id) }}"
                                        onclick="confirmDelete(this)"
                                        title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>



                                </td>
                            </tr>
                         
                        @endforeach


                    </tbody>
                </table>
            </div>

        </div>
    </div>


    <div class="modal fade" id="editImageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form id="editImageForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="editImageId">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept="image/*"
                            required
                        >
                        <small class="text-muted">
                            JPG, PNG, WEBP, GIF — Max 10MB
                        </small>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">
                            Update Image
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>

    function confirmDelete(button) {

        const deleteUrl = button.dataset.deleteUrl;

        Swal.fire({
            title: "Are you sure you want to delete this image?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }
        });
    }


    function openEditModal(id) {
            document.getElementById('editImageId').value = id;
        }

        document.getElementById('editImageForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const id = document.getElementById('editImageId').value;
            const formData = new FormData(this);
            const deleteImageBaseUrl = "{{ url('/admin/about/image/update') }}";
            

            fetch(`${deleteImageBaseUrl}/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    location.reload(); // simplest + reliable
                } else {
                    alert(data.message);
                }
            })
            .catch(() => alert('Update failed'));
        });




    </script>


@endsection