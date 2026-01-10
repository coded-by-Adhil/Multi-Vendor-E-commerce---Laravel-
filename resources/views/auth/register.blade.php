<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:opsz,wght@6..144,1..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- register Css-->
        <link href="{{ asset('backend/assets/css/register.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>
<body>

    <!-- Abstract Background Elements -->
    <div class="background-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="register-card">
        <div class="header-text">
            <h2>Create Account</h2>
            <p>Join us to access the full platform</p>
        </div>

         @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color:red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- <form id="registerForm" onsubmit="return validateForm(event)"> -->
        <form id="registerForm" method="POST" action="{{ route('register') }}">
        @csrf
            
            <!-- Full Name -->
            <div class="input-group">
                <input type="text" class="form-control" name="name"  placeholder="Full Name" required>
                <i class="bi bi-person"></i>
            </div>

            <!-- Username -->
            <div class="input-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
                <i class="bi bi-at"></i>
            </div>

            <!-- Email -->
            <div class="input-group">
                <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                <i class="bi bi-envelope"></i>
            </div>

            <!-- Password -->
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                <i class="bi bi-lock"></i>
                <i class="bi bi-eye-slash toggle-password" onclick="togglePassword('password', this)"></i>
            </div>

            <!-- Confirm Password -->
            <div class="input-group">
                <input type="password" name="password_confirmation" id="confirm_password" class="form-control" placeholder="Confirm Password" required>
                <i class="bi bi-lock-fill"></i>
                <i class="bi bi-eye-slash toggle-password" onclick="togglePassword('confirm_password', this)"></i>
                <div class="error-msg" id="passwordError" style="display: none;">
                    <i class="bi bi-exclamation-circle-fill"></i> Passwords do not match
                </div>
            </div>

            <button type="submit" class="btn-register">
                Sign Up
            </button>

            <div class="footer-text">
                Already have an account? <a href="{{ route('login') }}">Log In</a>
            </div>
        </form>
    </div>

    <script>
        // Toggle Password Visibility
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            }
        }

        // Simple Validation
        function validateForm(e) {
            e.preventDefault(); 
            
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('confirm_password').value;
            const errorMsg = document.getElementById('passwordError');

            if (password !== confirm) {
                errorMsg.style.display = 'flex'; // Use flex to align icon and text
                return false;
            } else {
                errorMsg.style.display = 'none';
                alert("Account created successfully!");
                return true;
            }
        }
    </script>

</body>
</html>