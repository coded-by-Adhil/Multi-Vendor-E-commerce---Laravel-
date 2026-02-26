@extends('admin.admin_master')
@section('admin')


 
    <div class="it-wrapper">
        <div class="it-card">
            
            <div class="it-header">
                <div>
                    <h1 class="it-title">SetUp Portfolio</h1>
                </div>
            </div>

            <div class="it-table-container">
                <table id="imageTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th width="15%">Image</th>
                            <th width="15%">portfolio_name</th>
                            <th width="15%">portfolio_title</th>
                            <th width="15%">portfolio_description</th>
                            <th width="25%">Created At</th>
                            <th width="25%">Updated At</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->

                        @foreach ($portfolio as $data)

                            <tr id="image-{{ $data->id }}">
                                <td>
                                    <img src="{{ asset('storage/' . $data->portfolio_image) }}" alt="Image 1" class="it-img-thumbnail">
                                </td>
                                <td>
                                    {{ $data->portfolio_name }}
                                </td>
                                <td>
                                    {{ $data->portfolio_title }}
                                    
                                </td>
                                <td>
                                    {!! $data->portfolio_description !!}
                                    
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $data->created_at->format('Y-m-d') }}</div>
                                    <small class="text-muted">{{ $data->created_at->format('h:i A') }}</small>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $data->updated_at->format('Y-m-d') }}</div>
                                    <small class="text-muted">{{ $data->updated_at->format('h:i A') }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('portfolio-page.edit', $data->id) }}" 
                                    class="it-btn-action it-btn-edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <button
                                        class="it-btn-action it-btn-delete"
                                        data-delete-url="{{ route('about.image.delete', $data->id) }}"
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

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = deleteUrl;

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = "{{ csrf_token() }}";

            form.appendChild(csrf);
            document.body.appendChild(form);
            form.submit();
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