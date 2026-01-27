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
                                    <button class="it-btn-action it-btn-edit" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="it-btn-action it-btn-delete" title="Delete" onclick="confirmDelete({{ $image->id }})">
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


    <script>

        function confirmDelete(id) {
            if (!confirm('Are you sure you want to delete this image?')) return;

            fetch(`/admin/about/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                showToast(data.status, data.message);
                if (data.status === 'success') {
                    document.getElementById(`image-${id}`).remove();
                }
            })
            .catch(() => showToast('error', 'Delete failed'));
        }


    </script>


@endsection