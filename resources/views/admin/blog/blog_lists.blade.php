@extends('admin.admin_master')
@section('admin')


 
    <div class="it-wrapper">
        <div class="it-card">
            
            <div class="it-header">
                <div>
                    <h1 class="it-title">Uploaded Categories</h1>
                </div>
             <button class="btn btn-primary d-flex align-items-center gap-2"
                    data-bs-toggle="modal"
                    data-bs-target="#addBlogCategoryModal">
                <i class="bi bi-cloud-upload"></i> Add Blog Category
            </button>
            </div>

            <div class="it-table-container">
                <table id="imageTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th width="15%">Name</th>
                            <th width="25%">Created At</th>
                            <th width="25%">Updated At</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->

                        @foreach ($blog_categorys as $blog_category)

                            <tr id="image-{{ $blog_category->id }}">
                                <td>
                                    {{ $blog_category->name }}
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $blog_category->created_at->format('Y-m-d') }}</div>
                                    <small class="text-muted">{{ $blog_category->created_at->format('h:i A') }}</small>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $blog_category->updated_at->format('Y-m-d') }}</div>
                                    <small class="text-muted">{{ $blog_category->updated_at->format('h:i A') }}</small>
                                </td>
                                <td>

                                   <button
                                    class="it-btn-action it-btn-delete"
                                    data-delete-url="{{ route('blog-category.delete', $blog_category->id) }}"
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


   <div class="modal fade" id="addBlogCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="addCategoryForm" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Blog Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input
                        type="text"
                        name="categoryname"
                        class="form-control"
                        required
                    >
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">
                        Add Category
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


    <script>

// DELETE FUNCTION (No jQuery used)
function confirmDelete(button) {

    const deleteUrl = button.dataset.deleteUrl;

    Swal.fire({
        title: "Are you sure you want to delete this category?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Delete",
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


// STORE CATEGORY (Pure JavaScript Fetch API)
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("addCategoryForm");

    if (form) {
        form.addEventListener("submit", function (e) {

            e.preventDefault();

            const formData = new FormData(form);

            fetch("{{ route('blog-category.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {

                const modalElement = document.getElementById('addBlogCategoryModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                modal.hide();

                form.reset();

                Swal.fire({
                    icon: 'success',
                    title: 'Category Added Successfully',
                    timer: 1500,
                    showConfirmButton: false
                });

                location.reload(); // optional
            })
            .catch(error => {

                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong'
                });

            });

        });
    }

});

</script>


@endsection