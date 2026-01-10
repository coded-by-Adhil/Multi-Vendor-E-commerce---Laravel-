@extends('admin.admin_master')
@section('admin')

<!-- CHANGE PASSWORD CARD -->
            <div class="password-page-wrapper">
                <div class="password-card">
                    <h3 class="section-title">Security Settings</h3>
                    
                    <form id="passwordForm" action="{{ route('admin.password.update') }}" method="POST">
                        @csrf

                       

                        @if ($errors->updatePassword->any())
                         <div class="alert alert-danger" role="alert">
                
                                @foreach ($errors->updatePassword->all() as $error)
                                    <li style="list-style:none;">{{ $error }}</li>
                                @endforeach
                          
                         </div>
                        @endif

                        

                        <div class="password-grid">
                            <!-- 1. Old Password -->
                            <div class="form-group">
                                <label class="form-label">Current Password</label>
                                <div class="input-wrapper">
                                    <input type="password" name="current_password" id="oldPass" class="form-control-custom" placeholder="Enter current password" required>
                                    <i class="bi bi-eye-slash toggle-password" onclick="togglePass(this)"></i>
                                </div>
                                <span class="helper-text">Required for verification</span>
                            </div>

                            <!-- 2. New Password -->
                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <div class="input-wrapper">
                                    <input type="password" name="password" id="newPass" class="form-control-custom" placeholder="Enter new password" onkeyup="checkStrength()" required>
                                    <i class="bi bi-eye-slash toggle-password" onclick="togglePass(this)"></i>
                                </div>
                                <span class="helper-text" id="strengthText">Min 8 chars, mixed case & symbols</span>
                            </div>

                            <!-- 3. Confirm Password -->
                            <div class="form-group">
                                <label class="form-label">Confirm New Password</label>
                                <div class="input-wrapper">
                                    <input type="password" name="password_confirmation" id="confirmPass" class="form-control-custom" placeholder="Re-enter new password" onkeyup="checkMatch()" required>
                                    <i class="bi bi-eye-slash toggle-password" onclick="togglePass(this)"></i>
                                </div>
                                <span class="helper-text" id="matchText">Passwords must match</span>
                            </div>

                        </div>

                        <!-- Actions -->
                        <div class="form-actions">
                            <!-- <button type="button" class="btn-cancel">Cancel</button> -->
                            <button type="submit" class="btn-save">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>

    <script>

      

    document.addEventListener('DOMContentLoaded', function() {
        @if(!empty($status))
            showToast('success', @json($status));
        @endif
    });


        document.getElementById("passwordForm").addEventListener("submit", function (e) {
            e.preventDefault();
            
        
            if (!checkStrength()) return;
            console.log("hii");
            this.submit();
        });



        // Toggle Password Visibility
        function togglePass(icon) {
            const input = icon.previousElementSibling;
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("bi-eye-slash", "bi-eye");
                icon.style.color = "#667eea";
            } else {
                input.type = "password";
                icon.classList.replace("bi-eye", "bi-eye-slash");
                icon.style.color = "#a0aec0";
            }
        }

        // Simple Match Checker
        function checkMatch() {
            const p1 = document.getElementById("newPass").value;
            const p2 = document.getElementById("confirmPass").value;
            const text = document.getElementById("matchText");

            if (p2 && p1 === p2) {
                text.innerHTML = '<i class="bi bi-check-circle-fill"></i> Passwords Match';
                text.classList.add("text-success");
                text.classList.remove("text-danger");
            } else if (p2) {
                text.innerHTML = '<i class="bi bi-x-circle-fill"></i> Passwords do not match';
                text.classList.add("text-danger");
                text.classList.remove("text-success");
            } else {
                text.innerHTML = 'Passwords must match';
                text.classList.remove("text-success", "text-danger");
            }
        }

        // Simple Strength Checker
        function checkStrength() {
            const val = document.getElementById("newPass").value;
            const text = document.getElementById("strengthText");
            
            if (!checkOldVsNew()) return;


            if (val.length > 7) {
                text.innerHTML = '<i class="bi bi-shield-check"></i> Strong Password';
                text.classList.add("text-success");
            } else {
                text.innerHTML = 'Min 8 chars, mixed case & symbols';
                text.classList.remove("text-success");
            }
            checkMatch(); // Re-check match if main password changes
            return true;
        }

    function checkOldVsNew() {
        const oldPass = document.getElementById("oldPass").value;
        const newPass = document.getElementById("newPass").value;
        const strengthText = document.getElementById("strengthText");

        if (oldPass && newPass && oldPass === newPass) {
            strengthText.innerHTML = '<i class="bi bi-x-circle-fill"></i> New password cannot be the same as current password';
            strengthText.classList.add("text-danger");
            strengthText.classList.remove("text-success");
            return false;
        }

        return true;
    }

    </script>

@endsection('admin')