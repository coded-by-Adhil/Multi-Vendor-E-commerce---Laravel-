  
@extends('admin.admin_master')
@section('admin')

 <!-- Main Wrapper -->
    <div class="ab-wrapper">
        
        <div class="ab-card">
            
            <!-- Header -->
            <div class="ab-header">
                <div class="ab-header-icon">
                    <i class="bi bi-info-circle"></i>
                </div>
                <div>
                    <h1 class="ab-title">About Page Setup</h1>
                    <p class="text-muted small mb-0">Update the content for your organization's About Us page</p>
                </div>
            </div>


            <!-- Form -->
            <form id="abForm" action="{{ route('about-page.update') }}" method="POST" enctype="multipart/form-data">
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
                    <div class="ab-form-group">
                        <label class="ab-label" for="ab-title">
                            <i class="bi bi-type-h1"></i> Title
                        </label>
                        <input type="text" id="ab-title" name="title" value="{{ $About_page_Content->title ?? '' }}" class="ab-input" placeholder="e.g. Our Story" required>
                    </div>

                    <!-- Short Title Input -->
                    <div class="ab-form-group">
                        <label class="ab-label" for="ab-short-title">
                            <i class="bi bi-card-heading"></i> Short Title
                        </label>
                        <input type="text" id="ab-short-title" value="{{ $About_page_Content->short_title ?? '' }}"
                         name="short_title" class="ab-input" placeholder="e.g. About Us" required>
                    </div>

                    <!-- Short Description (Textarea) -->
                    <div class="ab-form-group" style="grid-column: span 2;">
                        <label class="ab-label" for="ab-short-desc">
                            <i class="bi bi-text-paragraph"></i> Short Description
                        </label>
                        <textarea id="ab-short-desc" name="short_description" class="ab-input" placeholder="Brief introduction text..." required>
                            {{ $About_page_Content->short_description ?? '' }}
                        </textarea>
                    </div>

                    <!-- Long Description (Summernote Editor) -->
                    <div class="ab-form-group" style="grid-column: span 2;">
                        <label class="ab-label" for="summernote">
                            <i class="bi bi-file-richtext"></i> Long Description
                        </label>
                        <!-- Actual Summernote Target -->
                        <textarea id="summernote" name="long_description">
                            {{ $About_page_Content->long_description ?? '' }}
                        </textarea>
                    </div>

                    <!-- Image Upload -->
                    <div class="ab-form-group" style="grid-column: span 2;">
                        <label class="ab-label" for="ab-file">
                            <i class="bi bi-image"></i> About Section Image
                        </label>
                        <div class="ab-file-wrapper">
                            <input type="file" id="ab-file" name="about_image" class="ab-input" accept="image/*" onchange="previewAbImage(this)">
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
                            <img id="ab-preview-img" src="{{ asset(
                                    $About_page_Content?->image_url
                                        ? 'storage/' . $About_page_Content->image_url
                                        : 'backend/assets/images/Black White Logo.png'
                                ) }}" class="ab-preview-img" alt="About Image Preview">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="ab-actions">
                        <button type="submit" class="ab-btn-submit">
                            <i class="bi bi-check-lg"></i> Update About Page
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <script>
        
    </script>

@endsection('admin')
