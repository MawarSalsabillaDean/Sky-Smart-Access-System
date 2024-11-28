<?php
session_start(); 

// Logout logic
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    // Clear the session array
    $_SESSION = array();
    // Destroy the session
    session_destroy();
    // Redirect to the login page
    header('Location: admin_login.php');
    exit;
}

// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: admin_login.php?error=notloggedin');
    exit;
}

include 'db.php'; // Include your database connection

// Assuming you pass the resident_id via GET request for editing
$resident_id = $_GET['id'] ?? null;

if ($resident_id) {
    // Fetch data for the resident
    $query = "SELECT ra.*, rp.ic_number, rp.age, rp.gender, rp.race, rp.number_of_occupants
              FROM resident_account ra
              LEFT JOIN resident_profile rp ON ra.resident_id = rp.resident_id
              WHERE ra.resident_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$resident_id]);
    $resident = $stmt->fetch();

    if (!$resident) {
        die('No resident found with that ID.');
    }
} else {
    die('No resident ID provided.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@22,300,0,-25&icon_names=dashboard" />    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="update_resident_layout.css">
    <title>Edit Resident Data</title>
</head>
<body>

    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <img src="pictures/SSA_logo2.png" alt="Sky Smart Access" class="SSA_logo">
                <div class="logo_name">Sky Smart Access</div>
            </div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav_list">
            <li>
                <a href="admin_dashboard.php">
                    <span class="material-symbols-outlined" class="dashboard">dashboard</span>
                    <span class="links_name">Dashboard</span>
                </a>
                 <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="userdata_management.php">
                    <i class='bx bx-user'></i>                   
                    <span class="links_name">User Data Management</span>
                </a>
                 <span class="tooltip">User Data</span>
            </li>
            <li>
                <a href="visitor_management.php">
                    <i class='bx bx-id-card'></i>
                    <span class="links_name">Visitor Management</span>
                </a>
                 <span class="tooltip">Visitor</span>
            </li>
            <li>
                <a href="parking_management.php">
                    <i class='bx bx-car'></i>
                    <span class="links_name">Parking Management</span>
                </a>
                 <span class="tooltip">Parking</span>
            </li>
            <li>
                <a href="amenities_management.php">
                    <i class='bx bx-qr'></i>
                    <span class="links_name">Amenities Management</span>
                </a>
                 <span class="tooltip">Amenities</span>
            </li>
            <li>
                <a href="announcement_management.php">
                    <i class='bx bx-news' ></i>
                    <span class="links_name">News Management</span>
                </a>
                 <span class="tooltip">News</span>
            </li>
            <li>
                <a href="report_management.php">
                    <i class='bx bx-edit' ></i>
                    <span class="links_name">Report Management</span>
                </a>
                 <span class="tooltip">Report</span>
            </li>
        </ul>
        <div class="profile_content">
            <div class="profile">
                <div class="profile_details">
                    <img src="pictures/user.png" alt="User Icon" class="user_icon">
                     <div class="user_details">
                        <div class="name">Admin</div>
                        <div id="greeting" class="greeting">Good day!</div>
                     </div>
                </div>
                <button type="button" name="logout" id="log_out" class='bx bx-log-out' onclick="location.href='update_resident_layout.php?logout=true';"></button>
                </div>
        </div>
    </div> 
    
    <div class="container">
        <header>Edit Resident Data</header>
        <form action="update_resident.php" method="post" class="form-container">
            <input type="hidden" name="resident_id" value="<?= htmlspecialchars($resident['resident_id']) ?>">
            <div class="form-row">
                <div class="form-group">
                    <label for="full_name">Resident Name</label>
                    <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($resident['full_name']) ?>" placeholder="Enter resident name" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="tel" id="phone_number" name="phone_number" value="<?= htmlspecialchars($resident['phone_number']) ?>" placeholder="Enter phone number" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="unit_number">Unit Number</label>
                    <input type="text" id="unit_number" name="unit_number" value="<?= htmlspecialchars($resident['unit_number']) ?>" placeholder="Enter unit number" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($resident['email']) ?>" placeholder="Enter email address" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="ic_number">IC Number</label>
                    <input type="text" id="ic_number" name="ic_number" value="<?= htmlspecialchars($resident['ic_number']) ?>" placeholder="Enter IC number" required>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" value="<?= htmlspecialchars($resident['age']) ?>" placeholder="Enter age" required>
                </div>
            </div>
            <div class="form-row gender-race">
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male" <?= $resident['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $resident['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="race">Race</label>
                    <input type="text" id="race" name="race" value="<?= htmlspecialchars($resident['race']) ?>" placeholder="Enter race" required>
                </div>
            </div>
            <div class="form-group">
                <label for="number_of_occupants">Number of Occupants</label>
                <input type="number" id="number_of_occupants" name="number_of_occupants" value="<?= htmlspecialchars($resident['number_of_occupants']) ?>" placeholder="Enter number of occupants" required>
            <div class="form-group">
                <button type="submit">Save</button>
            </div>
        </form>
    </div>
    <script>
        let btn = document.querySelector('#btn');
        let sidebar = document.querySelector('.sidebar');

        btn.onclick = function() {
            sidebar.classList.toggle("active");
        }

        document.addEventListener('DOMContentLoaded', function() {
            let touchstartX = 0;
            let touchendX = 0;
            const sensitivity = 50; // Minimum swipe distance

            function handleSwipeGesture() {
                if (touchendX > touchstartX + sensitivity) { // Right swipe
                    sidebar.classList.add("active");
                } else if (touchstartX > touchendX + sensitivity) { // Left swipe to hide
                    sidebar.classList.remove("active");
                }
            }

            document.addEventListener('touchstart', e => {
                touchstartX = e.changedTouches[0].screenX;
            }, false);

            document.addEventListener('touchend', e => {
                touchendX = e.changedTouches[0].screenX;
                handleSwipeGesture();
            }, false);
        });

        function updateGreeting() {
        const date = new Date();
        const hour = date.getHours();
        let greeting;

        if (hour < 12) {
            greeting = "Good morning!";
        } else if (hour < 18) {
            greeting = "Good afternoon!";
        } else {
            greeting = "Good evening!";
        }

        document.getElementById('greeting').innerText = greeting;
    }

    window.onload = updateGreeting; // Update the greeting when the page loads
    </script>
</body>
</html>