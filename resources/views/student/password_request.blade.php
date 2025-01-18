<!DOCTYPE html>
<html>
<head>
    <title>UNIARCHIVE - Request New Password</title>
    <link rel="stylesheet" href="{{ asset('css/Student.ForgotPassword.css') }}">
</head>
<body>

    <!-- Main Content -->
    <div class="forgot-password-container">
        <h2>Request a New Password</h2>
        <p>Enter a new password for your account below.</p>

        <!-- Display Success/Error Messages -->
        @if(session('status'))
            <div class="success-message">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="error-message">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- New Password Form -->
        <form id="resetPasswordForm" method="POST" action="{{ route('student.password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <label for="newPassword">New Password:</label>
            <input 
                type="password" 
                id="newPassword" 
                name="password" 
                placeholder="Enter your new password" 
                required
            >
            
            <label for="confirmPassword">Confirm Password:</label>
            <input 
                type="password" 
                id="confirmPassword" 
                name="password_confirmation" 
                placeholder="Confirm your new password" 
                required
            >
            
            <button type="submit" class="submit-btn">Reset Password</button>
        </form>
        
        <p class="back-to-login">
            <a href="{{ route('student.login') }}">Back to Login</a>
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 UNIARCHIVE - All rights reserved.</p>
    </div>

</body>
</html>
