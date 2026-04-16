@extends('admin.admin_master')
@section('admin')


 
    <div class="it-wrapper">
        <div class="it-card">
            
            <div class="it-header">
                <div>
                    <h1 class="it-title">Blogs</h1>
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
                            <th width="15%">No</th>
                            <th width="15%">Title</th>
                            <th width="25%">Image</th>
                            <th width="25%">Tags</th>
                            <th width="25%">Categories</th>
                            <th width="25%">Description</th>
                            <th width="25%">Update&nbsp;At</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->

                        @foreach ($blogs as $blog)

                            <tr id="image-{{ $blog->id }}">
                                <td>                             
                                    {{ $loop->iteration }}                                
                                </td>{{-- Serial Number --}}

                                <td>
                                    {{ $blog->title }}
                                </td>
                                <td>
                                    <img src="{{ asset('storage/' . $blog->image) }}" alt="Image 1" class="it-img-thumbnail">
                                </td>
                                <td>
                                   @php
                                        $tags = json_decode($blog->tags, true);
                                    @endphp

                                    @if(!empty($tags))
                                        @foreach($tags as $tag)
                                            <span class="tag-badge">{{ $tag }}</span>
                                        @endforeach
                                    @else
                                        <span class="tag-badge">No Tags</span>
                                    @endif
                               </td>
                                 <td>
                                    <span class="tag-badge">
                                        {{ $blog_categorys[$blog->blog_category_id] }}
                                    </span>
                                </td>
                                <td>
                                    {{ substr(strip_tags($blog->description), 0, 50) }}...
                                </td>
                             
                                <td>
                                    <div class="fw-medium">{{ $blog->updated_at->format('Y/m/d') }}</div>
                                    <small class="text-muted">{{ $blog->updated_at->format('h:i A') }}</small>
                                </td>
                                <td>

                                   <button
                                    class="it-btn-action it-btn-delete"
                                    data-delete-url="{{ route('blogs.delete', $blog->id) }}"
                                    onclick="confirmDelete(this)"
                                    title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>

                                    <button
                                    class="it-btn-action it-btn-delete"
                                    data-delete-url="{{ route('blogs.edit', $blog->id) }}"
                                    onclick="confirmEdit(this)"
                                    title="Edit">
                                    <i class="bi bi-pencil-square"></i>
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






            <!-- Form -->
            <form id="abForm" action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                 @csrf

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Oops! Please fix the following:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif


                <div class="ab-grid">
                    
                <!-- Title Input -->
                  <div class="ab-form-group" style="grid-column: span 2;">
                            <label class="ab-label" for="ab-title">
                                    <i class="bi bi-type-h1"></i> Title
                                </label>
                                <input type="text" id="ab-title" name="title" value="" class="ab-input" placeholder="e.g. Our Story" required>
                        </div>
                       
                <!--  Category -->
                  <div class="ab-form-group" style="grid-column: span 2;">

                <div class="ab-form-group" style="grid-column: span 2;">
                        <select class="form-select" name="blog_category_id" aria-label="Default select example">
                                        <option selected>Select Category</option>
                                    @foreach ($blog_categorys as $id => $blog_category)
                                        <option value="{{ $id }}">{{ $blog_category }}</option>
                                            @endforeach
                            </select>
                        </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tags</label>
                        
                        <div class="tag-wrapper">
                            
                            <div class="tag-input-box" id="tagInputBox">
                                <input type="text" name="selected_tags" id="tagInput" placeholder="Type a tag and press Enter...">
                            </div>
                            
                           <div class="tag-dropdown" id="tagDropdown"></div>
                            
                            <input type="hidden" name="tags" id="hiddenTags">
                            
                        </div>
                    </div>

                    </div>


                    <!-- Long Description (Summernote Editor) -->
                    <div class="ab-form-group" style="grid-column: span 2;">
                        <label class="ab-label" for="summernote">
                            <i class="bi bi-file-richtext"></i> Long Description
                        </label>
                        <!-- Actual Summernote Target -->
                        <textarea id="summernote" name="description">
                      
                        </textarea>
                    </div>

                    <!-- Image Upload -->
                    <div class="ab-form-group" style="grid-column: span 2;">
                        <label class="ab-label" for="ab-file">
                            <i class="bi bi-image"></i> About Section Image
                        </label>
                        <div class="ab-file-wrapper">
                            <input type="file" id="ab-file" name="image" class="ab-input" accept="image/*" onchange="previewAbImage(this)">
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="ab-preview-area">
                        <div>
                            <div class="ab-preview-label">Current Image</div>
                            <small class="text-muted d-block" style="max-width: 250px;">
                                Preview of the selected or currently saved image.
                            </small>
                        </div>
                        
                        <div class="ab-img-container">
                            <img id="ab-preview-img" src="" class="ab-preview-img" alt="About Image Preview">
                        </div>
                    </div>

                </div>
            </form>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">
                        Add Blog
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



  document.addEventListener('DOMContentLoaded', function() {
            // --- Configuration ---
            // These are your database/existing tags
            const availableTags = @json($Tags->pluck('name'));

            // State management
            let selectedTags = [];

            // --- DOM Elements ---
            const inputBox = document.getElementById('tagInputBox');
            const inputField = document.getElementById('tagInput');
            const dropdown = document.getElementById('tagDropdown');
            const hiddenInput = document.getElementById('hiddenTags');

            // --- Event Listeners ---

            // 1. Focus effects
            inputField.addEventListener('focus', () => {
                inputBox.classList.add('focus');
                showSuggestions(inputField.value.trim().toLowerCase());
                dropdown.classList.add('show');
            });

            // Focus input when clicking anywhere inside the box
            inputBox.addEventListener('click', () => inputField.focus());

            // 2. Handle Typing (Filtering suggestions)
            inputField.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                showSuggestions(query);
            });

          


            // 3. Handle Keyboard events (Enter, Comma, Backspace)
            inputField.addEventListener('keydown', function(e) {
                const value = this.value.trim();

                // Add Tag on 'Enter' or 'Comma'
                if (e.key === 'Enter' || e.key === ',') {
                    e.preventDefault(); // Prevent form submit or comma typing
                    if (value) {
                        // Remove trailing comma if user typed it
                        const cleanValue = value.replace(/,+$/, '');
                        addTag(cleanValue);
                    }
                } 
                // Remove last tag on 'Backspace' if input is empty
                else if (e.key === 'Backspace' && value === '' && selectedTags.length > 0) {
                    removeTag(selectedTags[selectedTags.length - 1]);
                }
            });

            // Hide dropdown when clicking outside
           document.addEventListener('click', function (e) {
                if (!inputBox.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.remove('show');
                }
            });



            // --- Core Functions ---
           function addTag(tagText) {
            const isDuplicate = selectedTags.some(t => t.toLowerCase() === tagText.toLowerCase());

            if (tagText && !isDuplicate) {
                selectedTags.push(tagText);
                renderTags();
            }

            inputField.value = '';

            // 🔥 refresh list
            showSuggestions('');

            // 🔥 keep dropdown OPEN
            dropdown.classList.add('show');

            // 🔥 keep focus
            inputField.focus();
        }



            // Expose globally so inline onclick works
           function removeTag(tagText) {
                selectedTags = selectedTags.filter(t => t !== tagText);
                renderTags();

                showSuggestions(inputField.value.trim().toLowerCase());

                dropdown.classList.add('show'); // 🔥 keep open
                inputField.focus();             // 🔥 keep focus
            }

            function renderTags() {

                const existingPills = inputBox.querySelectorAll('.tag-pill');
                existingPills.forEach(pill => pill.remove());


                selectedTags.forEach(tag => {
                    const pill = document.createElement('div');
                    pill.className = 'tag-pill';

                    const text = document.createTextNode(tag);

                    const removeBtn = document.createElement('i');
                    removeBtn.className = 'bi bi-x remove-tag';

                    removeBtn.addEventListener('mousedown', function (e) {
                            e.preventDefault(); // 🔥 prevents input blur
                            removeTag(tag);
                        });
                    pill.appendChild(text);
                    pill.appendChild(removeBtn);

                    // 🔥 Insert into DOM
                    inputBox.insertBefore(pill, inputField);
                });

                // 🔥 Update hidden input
                hiddenInput.value = selectedTags.join(',');
            }


          function showSuggestions(query = '') {
                dropdown.innerHTML = '';

                let sortedTags = [...availableTags];

                if (query.length > 0) {
                    sortedTags.sort((a, b) => {
                        const aIndex = a.toLowerCase().indexOf(query);
                        const bIndex = b.toLowerCase().indexOf(query);

                        if (a.toLowerCase() === query) return -1;
                        if (b.toLowerCase() === query) return 1;

                        if (aIndex === 0 && bIndex !== 0) return -1;
                        if (bIndex === 0 && aIndex !== 0) return 1;

                        if (aIndex !== -1 && bIndex === -1) return -1;
                        if (bIndex !== -1 && aIndex === -1) return 1;

                        return 0;
                    });
                }

                sortedTags.forEach(tag => {
                    if (selectedTags.some(t => t.toLowerCase() === tag.toLowerCase())) return;

                    const div = document.createElement('div');
                    div.className = 'tag-dropdown-item';

                    if (query) {
                        const regex = new RegExp(`(${query})`, "gi");
                        div.innerHTML = tag.replace(regex, "<strong>$1</strong>");
                    } else {
                        div.innerHTML = tag;
                    }

                    // ✅ FIXED HERE
                    div.addEventListener('mousedown', function(e) {
                        e.preventDefault();
                        addTag(tag);
                    });

                    dropdown.appendChild(div);
                });

                dropdown.classList.add('show');

                // ✅ ONLY show if input is focused
                if (document.activeElement === inputField) {
                    dropdown.classList.add('show');
                }
            }

            showSuggestions();

        });


        document.getElementById("addCategoryForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);

            fetch("{{ route('blogs.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: formData
            })
            .then(async res => {
                let data = await res.json();

                if (!res.ok) {
                    throw data;
                }

                Swal.fire({
                    icon: 'success',
                    title: data.message || 'Blog created successfully!',
                    timer: 1500,
                    showConfirmButton: false
                });

                form.reset();
                location.reload();

            })
            .catch(err => {

                if (err.errors) {
                    let errorMsg = Object.values(err.errors).flat().join('\n');
                    Swal.fire('Error', errorMsg, 'error');
                } else {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }

            });
        });

</script>

      


@endsection