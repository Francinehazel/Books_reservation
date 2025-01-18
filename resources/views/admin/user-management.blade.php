<!DOCTYPE html>
<html>
<head>
  <title>Admin User Management</title>
  <link rel="stylesheet" href="{{ asset('css/Admin.UserManagement.css') }}">
</head>
<body>
  <div class="container">
    <h2>Admin User Management</h2>
    <form method="POST" action="{{ route('admin.update.profile') }}">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ $admin->name }}" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ $admin->email }}" required>
      </div>
      <button type="submit" class="btn">Update Profile</button>
    </form>
    <hr>
    <form method="POST" action="{{ route('admin.update.password') }}">
      @csrf
      @method('PUT')
      <h3>Change Password</h3>
      <div class="form-group">
        <label for="current-password">Current Password:</label>
        <input type="password" id="current-password" name="current_password" required>
      </div>
      <div class="form-group">
        <label for="new-password">New Password:</label>
        <input type="password" id="new-password" name="new_password" required>
      </div>
      <div class="form-group">
        <label for="confirm-password">Confirm New Password:</label>
        <input type="password" id="confirm-password" name="new_password_confirmation" required>
      </div>
      <button type="submit" class="btn">Change Password</button>
    </form>
  </div>
</body>
</html>
