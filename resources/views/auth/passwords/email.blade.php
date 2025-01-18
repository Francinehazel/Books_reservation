<p>Click the link below to reset your password:</p>
<p>
    <a href="{{ route('student.password.reset', ['token' => $token, 'email' => $email]) }}">
        Reset Password
    </a>
</p>
