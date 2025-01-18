<!DOCTYPE html>
<html>
<head>
  <title>UNIARCHIVE</title>
  <link rel="stylesheet" href="{{ asset('css/Student.ProfilePage.css') }}">
</head>
<body>

    <!-- Header -->
    <div class="header">
        <img src="{{ asset('assets/UNIARCHIVE.HEADER.png') }}" alt="UNIARCHIVE Logo" class="logo">

        <div class="search-container">
            <input type="text" placeholder="Find book..." class="search-bar" id="search-input">
            <button class="search-btn" onclick="searchBook()">Search</button>
            <button class="clear-btn" onclick="clearSearch()">✖</button>
        </div>
        
        <script>
            function searchBook() {
                const searchQuery = document.getElementById("search-input").value.toLowerCase();
                
                if (searchQuery) {
                    const listItems = document.querySelectorAll('#list li');
                    let resultsFound = false;
            
                    listItems.forEach(item => {
                        const itemTitle = item.querySelector('.title').textContent.toLowerCase();
                        
                        if (itemTitle.includes(searchQuery)) {
                            item.style.display = 'block'; // Show matching item
                            resultsFound = true;
                        } else {
                            item.style.display = 'none'; // Hide non-matching item
                        }
                    });
            
                    if (!resultsFound) {
                        alert("No matching results found.");
                    }
                } else {
                    // If search input is empty, show all items
                    const listItems = document.querySelectorAll('#list li');
                    listItems.forEach(item => {
                        item.style.display = 'block';
                    });
                }
            }

            function clearSearch() {
                // Clear the search input field
                document.getElementById("search-input").value = "";
                
                // Show all items in the list again
                const listItems = document.querySelectorAll('#list li');
                listItems.forEach(item => {
                    item.style.display = 'block';
                });
            }
            
        </script>

        <div class="header-icons">
        <button class="profile" onclick="window.location.href='{{ route('student.user-management') }}';">👤</button>
            <form method="POST" action="{{ route('student.logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Log out</button>
            </form>
        </div>
    </div>

    <!-- Title Bar -->
    <div class="title-bar">
        <span id="current-date"></span>
        <span id="current-time"></span>
    </div>

    <script>
        function updateDateTime() {
            const now = new Date();
            const date = now.toLocaleDateString('en-US');
            const time = now.toLocaleTimeString('en-US');
            document.getElementById('current-date').textContent = date;
            document.getElementById('current-time').textContent = time;
        }
        setInterval(updateDateTime, 1000);
        window.onload = updateDateTime;
    </script>

    <!-- Sidebar -->
    <div class="sidebar">
        <button onclick="window.location.href='{{ route('student.dashboard') }}';">Home</button>

    <!-- Library Button -->
        <button onclick="window.location.href='{{ route('student.library') }}';">Library</button>
    </div>
    
    <!-- Form section for displaying information -->
    <div class="form-container">
        <form id="student-info-form">
            <div class="form-row">
                <label for="student-id">Student ID:</label>
                <input type="text" id="student-id" value="{{ $student->student_id }}" readonly>
            </div>
            <div class="form-row">
                <label for="name">Name:</label>
                <input type="text" id="name" value="{{ $student->name }}" readonly>
            </div>
            <div class="form-row">
                <label for="year-section">Year & Section:</label>
                <input type="text" id="year-section" value="{{ $student->year_section }}" readonly>
            </div>
            <div class="form-row">
                <label for="program">Program:</label>
                <input type="text" id="program" value="{{ $student->program }}" readonly>
            </div>
            <div class="form-row">
                <label for="gender">Gender:</label>
                <input type="text" id="gender" value="{{ $student->gender }}" readonly>
            </div>
            <div class="form-row">
                <label for="birthday">Birthday:</label>
                <input type="text" id="birthday" value="{{ $student->birthday }}" readonly>
            </div>
            <div class="form-row">
                <label for="contact-number">Contact Number:</label>
                <input type="text" id="contact-number" value="{{ $student->contact }}" readonly>
            </div>
            <div class="form-row">
                <label for="email">E-mail:</label>
                <input type="text" id="email" value="{{ $student->email }}" readonly>
            </div>
        </form>
    </div>

    <script>
        // Pass PHP data to JavaScript
        const studentData = @json($student);

        // Populate the form fields dynamically
        function populateStudentInfo() {
            document.getElementById("student-id").value = studentData.student_id || '';
            document.getElementById("name").value = studentData.name || '';
            document.getElementById("year-section").value = studentData.year_section || '';
            document.getElementById("program").value = studentData.program || '';
            document.getElementById("gender").value = studentData.gender || '';
            document.getElementById("birthday").value = studentData.birthday || '';
            document.getElementById("contact-number").value = studentData.contactNumber || '';
            document.getElementById("email").value = studentData.email || '';
        }

        // Call the function to populate the form when the page loads
        window.onload = populateStudentInfo;
    </script>

    <div class="button-container">
        <button class="btn change-password" onclick="toggleContainer('change-password-container')">Change Password</button>
        <button class="btn edit-profile" onclick="toggleContainer('edit-profile-container')">Edit Profile</button>
        <button class="btn delete-account" onclick="toggleContainer('delete-account-container')">Delete Account</button>
    </div>
    
    <!-- Change Password Container -->
    <div id="change-password-container" class="container" style="display: none;">
        <form id="change-password-form" method="POST" action="{{ route('student.update.password') }}">
            @csrf
            <h3>Change Password</h3>
            <div class="form-row">
                <label for="current-password">Current Password:</label>
                <input type="password" name="current_password" required>
            </div>
            <div class="form-row">
                <label for="new-password">New Password:</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="form-row">
                <label for="confirm-password">Confirm New Password:</label>
                <input type="password" name="new_password_confirmation" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn submit">Submit</button>
                <button type="button" class="btn cancel" onclick="console.log('Cancel clicked'); toggleContainer('change-password-container')">Cancel</button>
            </div>
        </form>
    </div>

    <!-- Edit Profile Container -->
    <div id="edit-profile-container" class="container" style="display: none;">
        <form id="edit-profile-form" method="POST" action="{{ route('student.update.profile') }}">
            @csrf
            @method('PUT')
            <h3>Edit Profile</h3>
            <div class="form-row">
                <label for="name">Name:</label>
                <input type="text" name="name" value="{{ $student->name }}">
            </div>
            <div class="form-row">
                <label for="contact-number">Contact Number:</label>
                <input type="tel" name="contact" value="{{ $student->contact }}">
            </div>
            <div class="form-row">
                <label for="email">E-mail:</label>
                <input type="email" name="email" value="{{ $student->email }}">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn update">Update Changes</button>
                <button type="button" class="btn cancel" onclick="console.log('Cancel clicked'); toggleContainer('edit-profile-container')">Cancel</button>
            </div>
        </form>
    </div>

    <!-- Delete Account Container -->
    <div id="delete-account-container" class="container" style="display: none;">
        <form id="delete-account-form" method="POST" action="{{ route('student.delete.account') }}">
            @csrf
            @method('DELETE')
            <h3>Delete Account</h3>
            <p>Are you sure you want to delete your account? This action cannot be undone.</p>
            <div class="form-actions">
                <button type="submit" class="btn confirm">Confirm</button>
                <button type="button" class="btn cancel" onclick="console.log('Cancel clicked'); toggleContainer('delete-account-container')">Cancel</button>
            </div>
        </form>
    </div>
    <script>
        function toggleContainer(containerId) {
            const container = document.getElementById(containerId);
            if (container) {
                container.style.display = (container.style.display === 'none' || container.style.display === '') ? 'block' : 'none';
            } else {
                console.error(`Container with ID "${containerId}" not found.`);
            }
        }

        // Script for Change Password Form Submission
        document.getElementById('change-password-form').addEventListener('submit', function (event) {
            const newPassword = document.querySelector('input[name="new_password"]').value;
            const confirmPassword = document.querySelector('input[name="new_password_confirmation"]').value;

            if (newPassword !== confirmPassword) {
                alert('New password and confirmation do not match!');
                event.preventDefault(); // Prevent form submission
            }
        });
    
        // Script for Edit Profile Form Submission
        document.getElementById('student-info-form').addEventListener('submit', function(event) {
            event.preventDefault();
            alert('Profile updated successfully!');
            toggleContainer('edit-profile-container');
        });
    
        
        function cancelContainer(containerId) {
            // Get the specified container
            let container = document.getElementById(containerId);
            
            if (container) {
                // Hide the container
                container.style.display = 'none';
            }
        }
    
        document.getElementById('delete-account-form').addEventListener('submit', function (event) {
            const confirmation = confirm('Are you sure you want to delete your account? This action cannot be undone.');
            if (!confirmation) {
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>
 
</body>
</html>