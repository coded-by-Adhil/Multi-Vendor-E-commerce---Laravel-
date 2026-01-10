@extends('admin.admin_master')
@section('admin')

 <!-- This wrapper simulates your main content area -->
    <div class="hs-wrapper">
        
        <div class="hs-card">
            
            <!-- Header -->
            <div class="hs-header">
                <div class="hs-header-icon">
                    <i class="bi bi-sliders"></i>
                </div>
                <div>
                    <h1 class="hs-title">Home Slide Setup</h1>
                    <p class="text-muted small mb-0">Manage your homepage hero section content</p>
                </div>
            </div>

            <!-- Form -->
            <form id="hsForm" action="{{ route('home-slide.update') }}" method="POST" enctype="multipart/form-data">
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


                <div class="hs-grid">
                    
                    <!-- Title Input -->
                    <div class="hs-form-group">
                        <label class="hs-label" for="hs-title">
                            <i class="bi bi-type-h1"></i> Slide Title
                        </label>
                        <input type="text" id="hs-title" value="{{ $Home_page_Content->title }}" name="title" class="hs-input" placeholder="e.g. Welcome to Our Platform" required>
                    </div>

                    <!-- Video URL Input -->
                    <div class="hs-form-group">
                        <label class="hs-label" for="hs-video">
                            <i class="bi bi-camera-video"></i> Video URL
                        </label>
                        <input type="url" id="hs-video" value="{{ $Home_page_Content->video_url }}" name="video_url" class="hs-input" placeholder="https://youtube.com/..." required>
                    </div>

                    <!-- Short Description (Full Width) -->
                    <div class="hs-form-group" style="grid-column: span 2;">
                        <label class="hs-label" for="hs-desc">
                            <i class="bi bi-text-paragraph"></i> Short Description
                        </label>
                        <input type="text" value="{{ $Home_page_Content->short_description }}" id="hs-desc" name="short_description" class="hs-input" placeholder="Brief summary of the slide content" required>
                    </div>

                    <!-- Image Upload -->
                    <div class="hs-form-group" style="grid-column: span 2;">
                        <label class="hs-label" for="hs-file">
                            <i class="bi bi-image"></i> Banner Image
                        </label>
                        <div class="hs-file-wrapper">
                            <input type="file" id="hs-file" name="slide_image" class="hs-input" accept="image/*" onchange="previewHsImage(this)">
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="hs-preview-area">
                        <div>
                            <div class="hs-preview-label">Current Preview</div>
                            <small class="text-muted d-block" style="max-width: 250px;">
                                This is how the current image appears. Uploading a new file will update this preview immediately.
                            </small>
                        </div>
                        
                        <div class="hs-img-container">
                            <img id="hs-preview-img" src="{{ $Home_page_Content->banner 
                    ? asset('storage/' . $Home_page_Content->banner) 
                    : asset('backend/assets/images/Black White Logo.png') }}" class="hs-preview-img" alt="Slide Preview">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="hs-actions">
                        <button type="submit" class="hs-btn-submit">
                            <i class="bi bi-check-lg"></i> Save Changes
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
            

@endsection('admin')