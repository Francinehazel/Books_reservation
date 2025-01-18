<!DOCTYPE html>
<html>
<head>
    <title>UNIARCHIVE</title>
    <link rel="stylesheet" href="{{ asset('css/Student.ForgotPassword.css') }}">
</head>
<body style="background-image: url('{{ asset('assets/background-art.png') }}'); background-size: cover; background-repeat: no-repeat; background-position: center;">

    <!-- Main Content -->
    <div class="forgot-password-container">
        <h2>Forgot Your Password?</h2>
        <p>Enter your email address below, and we'll send you a link to reset your password.</p>

        <!-- Forgot Password Form -->
        <form id="forgotPasswordForm" method="POST" action="{{ route('password.email') }}">
            @csrf
            <label for="email">Enter your Email:</label>
            <input type="email" id="email" name="email" placeholder="Your email address" required>
            <button type="submit" class="submit-btn">Send Reset Link</button>
        </form>

        <p class="back-to-login">
            <a onclick="window.location.href='{{ route('student.login') }}';">Back to Login</a>
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 UNIARCHIVE - All rights reserved.</p>
    </div>

    <script>
        // Handle the "Forgot Password" form submission
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting the usual way

            const email = document.getElementById('email').value.trim();

            if (email) {
                // Simulating sending a reset email
                alert(`A reset link has been sent to ${email}. Please check your inbox.`);
                
                // Reset the form
                document.getElementById('forgotPasswordForm').reset();
            } else {
                alert('Please enter a valid email address.');
            }
        });
    </script>

</body>
</html>