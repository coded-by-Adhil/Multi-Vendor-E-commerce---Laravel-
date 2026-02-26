  
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


            @php
                if (!empty($portfolio)) {
                    $url = route('portfolio-page.update', $portfolio->id);
                } else {
                    $url = route('portfolio-page.store');
                }
            @endphp

        <form id="abForm" action="{{ $url }}" method="POST" enctype="multipart/form-data">
                 @csrf

               @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
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
                        <label class="ab-label" for="ab-name">
                            <i class="bi bi-type-h1"></i> Name
                        </label>
                        <input type="text" id="ab-name" name="portfolio_name" value="{{ $portfolio->portfolio_name ?? '' }}" class="ab-input" placeholder="e.g. Our Story" required>
                    </div>
                    
                    <!-- Title Input -->
                    <div class="ab-form-group">
                        <label class="ab-label" for="ab-title">
                            <i class="bi bi-type-h1"></i> Title
                        </label>
                        <input type="text" id="ab-title" name="portfolio_title" value="{{ $portfolio->portfolio_title ?? '' }}" class="ab-input" placeholder="e.g. Our Story" required>
                    </div>

                    <!-- Long Description (Summernote Editor) -->
                    <div class="ab-form-group" style="grid-column: span 2;">
                        <label class="ab-label" for="summernote">
                            <i class="bi bi-file-richtext"></i> Description
                        </label>
                        <!-- Actual Summernote Target -->
                        <textarea id="summernote" name="portfolio_description">
                            {{ $portfolio->portfolio_description ?? '' }}
                        </textarea>
                    </div>

                    <!-- Image Upload -->
                    <div class="ab-form-group" style="grid-column: span 2;">
                        <label class="ab-label" for="ab-file">
                            <i class="bi bi-image"></i>Image
                        </label>
                        <div class="ab-file-wrapper">
                            <input type="file" id="ab-file" name="portfolio_image" class="ab-input" accept="image/*" onchange="previewAbImage(this)" required>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="ab-preview-area">
                        <div>
                            <div class="ab-preview-label">Selected Image</div>
                            <small class="text-muted d-block" style="max-width: 250px;">
                                Preview of the selected image.
                            </small>
                        </div>
                        @php
                            if (!empty($portfolio->portfolio_image)) {
                                $image = $portfolio->portfolio_image;
                            } else {
                                $image = null;
                            }
                        @endphp


                        <div class="ab-img-container">
                            <img id="ab-preview-img" src="{{ asset($image ? 'storage/' . $image : 'backend/assets/images/Black White Logo.png') }}" class="ab-preview-img" alt="About Image Preview">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="ab-actions">
                        <button type="submit" class="ab-btn-submit">
                            <i class="bi bi-check-lg"></i> Update
                        </button>
                    </div>


                    <input type="hidden" name="id" value="{{ $portfolio->id ?? '' }}" />
                </div>
            </form>

        </div>
    </div>

    <script>
        
    </script>

@endsection('admin')
