<!DOCTYPE html>
<html>
<head>
    <title>Library Management System</title>
    <link rel="stylesheet" href="{{ asset('css/Admin.login.css') }}">
</head>
<body>
    <div>
        <img src="{{ asset('assets/UNIARCHIVE LOGO.png') }}" />

        <!-- Add the Laravel form for authentication -->
        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf <!-- CSRF token for security -->

            <p>
                Email:
                <input type="text" name="email" size="35" maxlength="50" required />
                <br>
            </p>
            <p>
                Password:
                <input type="password" name="password" size="35" maxlength="16" required />
                <br>
            </p>
            @if ($errors->any())
                <div>
                    <strong style="color: red;">{{ $errors->first() }}</strong>
                </div>
            @endif
            <p>
                <input type="submit" name="LogIn" value="Log-In" />
            </p>
        </form>
    </div>
</body>
</html>
