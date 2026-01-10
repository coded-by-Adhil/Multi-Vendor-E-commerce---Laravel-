@extends('admin.admin_master')
@section('admin')

<!-- Background Elements -->
    <div class="background-blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <div class="container d-flex justify-content-center">
        <div class="profile-card">
            <div class="row align-items-center">
                
                <!-- Left Column: Avatar & Basic Info -->
                <div class="col-lg-5 text-center border-end border-light-subtle">
                    
                    <!-- Profile Image Container -->
                    <div class="profile-img-container" id="profileImgContainer" onclick="triggerImageUpload()">


                        <img 
                        src="{{ $adminData->profile_image 
                            ? asset('storage/' . $adminData->profile_image) 
                            : asset('backend/assets/images/Black White Logo.png') }}" 
                        alt="Admin" class="profile-img" id="profileImage">


                        <!-- Hidden File Input -->
                        <input type="file" id="imageUpload" accept="image/*" style="display: none;" onchange="previewImage(this)">
                        <!-- Edit Overlay (Pencil) -->
                        <div class="edit-overlay">
                            <i class="bi bi-camera-fill"></i>
                        </div>
                        <div class="status-indicator" title="Online"></div>
                    </div>
                    
                    <!-- Editable Name -->
                    <h2 class="user-name">
                        <span id="userNameDisplay">{{ $adminData->name }}</span>
                        <input type="text" id="userNameInput" class="edit-input mb-2 text-center" value="{{ $adminData->name }}">
                    </h2>
                    

                    <div class="d-flex justify-content-center gap-2 mb-4 mb-lg-0" id="actionButtons">
                        <!-- View Mode Buttons -->
                        <button class="btn btn-modern" onclick="toggleEditMode()" id="editBtn">
                            <i class="bi bi-pencil-fill me-2"></i>Edit Profile
                        </button>
                        <button class="btn btn-outline-modern" id="messageBtn"><i class="bi bi-envelope"></i></button>
                        
                        <!-- Edit Mode Buttons (Hidden initially) -->
                        <button class="btn btn-success d-none" onclick="saveProfile()" id="saveBtn">
                            <i class="bi bi-check-lg me-2"></i>Save
                        </button>
                        <button class="btn btn-danger d-none" onclick="cancelEdit()" id="cancelBtn">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Right Column: Details -->
                <div class="col-lg-7 ps-lg-5">
                    
                    <!-- Stats Grid -->
                    <div class="row g-3 mb-4">
                        <!-- <div class="col-4">
                            <div class="stats-box">
                                <span class="stats-number">128</span>
                                <span class="stats-label">Projects</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stats-box">
                                <span class="stats-number">8.4k</span>
                                <span class="stats-label">Followers</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stats-box">
                                <span class="stats-number">95%</span>
                                <span class="stats-label">Rating</span>
                            </div>
                        </div> -->
                    </div>

                    <!-- Contact Info List -->
                    <div class="info-list">
                        <!-- Email Item -->
                        <div class="info-list-item">
                            <div class="info-icon">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div class="w-100">
                                <small class="text-muted d-block">Email Address</small>
                                <span class="fw-medium" id="userEmailDisplay">{{ $adminData->email }}</span>
                                <input type="email" id="userEmailInput" class="edit-input mt-1" value="{{ $adminData->email }}">
                            </div>
                        </div>

                        <div class="info-list-item">
                            <div class="info-icon" style="background: linear-gradient(135deg, #FF9966 0%, #FF5E62 100%);">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Phone Number</small>
                                <span class="fw-medium">+1 (555) 000-1234</span>
                            </div>
                        </div>

                        <div class="info-list-item">
                            <div class="info-icon" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Location</small>
                                <span class="fw-medium">San Francisco, CA</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@if(!empty($response))
    <script>
        const toastData = @json($response);
        showToast(toastData.status, toastData.message);
    </script>
@endif


     <script>

        let isEditing = false;
        let profileImageSrc;
        const ADMIN_UPDATE_URL = "{{ route('admin.update') }}";
        let isSubmitting = false; // Prevent double-click

        function toggleEditMode() {
                isEditing = true;

                // SAVE original image when entering edit mode
                profileImageSrc = document.getElementById('profileImage').src;

                // Toggle Buttons
                document.getElementById('editBtn').classList.add('d-none');
                document.getElementById('messageBtn').classList.add('d-none');
                document.getElementById('saveBtn').classList.remove('d-none');
                document.getElementById('cancelBtn').classList.remove('d-none');

                // Toggle Name Input
                document.getElementById('userNameDisplay').style.display = 'none';
                document.getElementById('userNameInput').style.display = 'block';

                // Toggle Email Input
                document.getElementById('userEmailDisplay').style.display = 'none';
                document.getElementById('userEmailInput').style.display = 'block';

                // Enable Image Hover Effect
                document.getElementById('profileImgContainer').classList.add('editing');
            }

        // --- 2. Cancel Editing ---
        function cancelEdit() {
            isEditing = false;

            // Toggle Buttons
            document.getElementById('editBtn').classList.remove('d-none');
            document.getElementById('messageBtn').classList.remove('d-none');
            document.getElementById('saveBtn').classList.add('d-none');
            document.getElementById('cancelBtn').classList.add('d-none');

            // Reset Inputs (Hide) & Show Text
            document.getElementById('userNameDisplay').style.display = 'inline';
            document.getElementById('userNameInput').style.display = 'none';
            
            document.getElementById('userEmailDisplay').style.display = 'inline';
            document.getElementById('userEmailInput').style.display = 'none';

            // Reset Input Values to original Text
            document.getElementById('userNameInput').value = document.getElementById('userNameDisplay').innerText;
            document.getElementById('userEmailInput').value = document.getElementById('userEmailDisplay').innerText;

            // Disable Image Hover
            document.getElementById('profileImgContainer').classList.remove('editing');
            // document.getElementById('profileImage').src = profileImageSrc;
            document.getElementById('profileImage').src = profileImageSrc;

            

        }


        // --- 4. Image Upload Logic ---
        function triggerImageUpload() {
            if (isEditing) {
                document.getElementById('imageUpload').click();
            }
        }

        function previewImage(input) {

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById('profileImage').src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            }
        }



            function saveProfile() {
                if (isSubmitting) return; // Prevent double submission
                isSubmitting = true;
                const saveBtn = document.getElementById('saveBtn');
                saveBtn.disabled = true;

                const nameInput = document.getElementById('userNameInput');
                const name = nameInput.value.trim();
                const imageInput = document.getElementById('imageUpload');

                // --- 1. Frontend Validations ---
                if (name === "") {
                    showToast('error', 'User name cannot be empty.');
                    resetSubmit();
                    return;
                }

                if (name.length > 255) {
                    showToast('error', 'User name cannot exceed 255 characters.');
                    resetSubmit();
                    return;
                }

                if (imageInput.files.length > 0) {
                    const file = imageInput.files[0];
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(file.type)) {
                        showToast('error', 'Only JPG, JPEG, PNG images are allowed.');
                        resetSubmit();
                        return;
                    }

                    const maxSizeMB = 3;
                    if (file.size > maxSizeMB * 1024 * 1024) {
                        showToast('error', `Image size cannot exceed ${maxSizeMB}MB.`);
                        resetSubmit();
                        return;
                    }
                }

                // --- 2. Prepare FormData ---
                let formData = new FormData();
                formData.append('name', name);
                if (imageInput.files.length > 0) {
                    formData.append('image', imageInput.files[0]);
                }

                // --- 3. Submit via fetch ---
                fetch(ADMIN_UPDATE_URL, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(async res => {
                    let data;
                    try {
                        data = await res.json();

                    } catch(e) {
                        showToast('error', 'Unexpected server response. Please try again.');
                        resetSubmit();
                        return;
                    }

                    if (res.ok) {
                        // Update UI
                        document.getElementById('userNameDisplay').innerText = data.name;

                        if (data.image) {
                            const img = document.getElementById('profileImage');
                            img.src = data.image + '?t=' + Date.now(); // Cache-busting
                        }

                        showToast('success', data.message || 'Profile updated successfully!');

                        if (data.redirect) {
                                setTimeout(() => {
                                    window.location.href = data.redirect;
                                }, 1500); 
                            }


                    } else {
                        // Backend validation errors
                        showToast(data.status || 'error', data.message || 'Update failed.');
                    }
                    resetSubmit();
                })

                .catch(err => {
                    console.error(err);
                    showToast('error', 'Network or server error occurred!');
                    resetSubmit();
                });

                function resetSubmit() {
                    isSubmitting = false;
                    saveBtn.disabled = false;
                }
            }

    </script>



@endsection('admin')