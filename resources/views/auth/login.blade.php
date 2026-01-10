<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:opsz,wght@6..144,1..1000&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- register Css-->
    <link href="{{ asset('backend/assets/css/login.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>
<body>

    <!-- Background Shapes -->
    <div class="background-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <!-- Login Card -->
    <div class="login-card">
        <div class="header-text">
            <h2>Welcome Back</h2>
            <p>Please enter your details to sign in</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <!-- Email -->
            <div class="input-group">
                <input type="text" name="email" class="form-control" placeholder="Username" required>
                <i class="bi bi-envelope"></i>
            </div>

            <!-- Password -->
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                <i class="bi bi-lock"></i>
                <i class="bi bi-eye-slash toggle-password" onclick="togglePassword('password', this)"></i>
            </div>

            <!-- Options Row -->
            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox"> Remember me
                </label>
                <a href="#" class="forgot-link">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-login">
                Sign In
            </button>

            <div class="footer-text">
                Don't have an account? <a href="{{ route('register') }}">Sign Up</a>
            </div>
        </form>
    </div>

    <script>
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
    </script>

</body>
</html>