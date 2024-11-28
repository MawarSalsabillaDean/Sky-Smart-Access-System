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

include 'db.php'; // Make sure this includes your database connection settings

function getVisitorsToday() {
    global $pdo; 
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM visitors WHERE DATE(registration_timestamp) = CURDATE()");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getVehicleRequestsToday() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM vehicles WHERE DATE(registration_timestamp) = CURDATE()");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getComplaintsToday() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM complaints WHERE DATE(submitted_at) = CURDATE()");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getLoginsToday() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM login_history WHERE DATE(login_time) = CURDATE()");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getAmenitiesUsageToday() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM amenity_usage WHERE DATE(start_time) = CURDATE()");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function fetchRecentLogins() {
    global $pdo;
    // SQL query to fetch the latest four logins
    $sql = "SELECT ra.full_name, lh.login_time
            FROM login_history lh
            JOIN resident_account ra ON lh.resident_id = ra.resident_id
            ORDER BY lh.login_time DESC
            LIMIT 4";  // Limit to the last four logins
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$vehicleRequestsToday = getVehicleRequestsToday();
$complaintsToday = getComplaintsToday();
$loginsToday = getLoginsToday();
$amenitiesUsageToday = getAmenitiesUsageToday();
$visitorsToday = getVisitorsToday();
$recentLogins = fetchRecentLogins();

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
    <link rel="stylesheet" href="admin_dashboard.css">
    <title>Admin Dashboard</title>
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
                <button type="button" name="logout" id="log_out" class='bx bx-log-out' onclick="location.href='admin_dashboard.php?logout=true';"></button>
                </div>
        </div>
    </div>
    
    <div class="container">
        <header>Admin Dashboard</header>
        <!-- Add this inside the <body> tag -->
        <div class="reset-button-container">
            <button class="reset-button" onclick="location.reload();">
                <i class='bx bx-reset'></i>Refresh
            </button>
        </div>
        <div class="dashboard">
            <div class="row">
                <a class="card" href="visitor_management.php">
                    <img alt="Icon representing visitor parking requests" height="60" src="pictures/repair.png" width="60"/>
                    <h3>Visitor Requests Today</h3>
                    <p><?= $visitorsToday ?></p>
                </a>
                <a class="card" href="parking_management.php">
                    <img alt="Icon representing vehicle parking requests" height="60" src="pictures/motorbike.png" width="60"/>
                    <h3>Parking Requests Today</h3>
                    <p><?= $vehicleRequestsToday ?></p> <!-- Ensure correct variable is displayed -->
                </a>
                <a class="card" href="report_management.php">
                    <img alt="Icon representing complaints today" height="60" src="pictures/bell.png" width="60"/>
                    <h3>Complaints Today</h3>
                    <p><?= $complaintsToday ?></p>
                </a>
            </div>
            <div class="row">
                <a class="card card-full" href="resident_logins_today.php">
                    <img alt="Icon representing logins today" height="60" src="pictures/login.png" width="60"/>
                    <h3>Resident Logins Today</h3>
                    <p><?= $loginsToday ?></p>
                </a>
                <a class="card card-full" href="amenities_management.php">
                    <img alt="Icon representing amenities usage today" height="60" src="pictures/dumbbell.png" width="60"/>
                    <h3>Amenities Usage Today</h3>
                    <p><?= $amenitiesUsageToday ?></p> <!-- Display dynamic data here -->
                </a>
            </div>
        </div>
        <div class="activity-feed">
            <h2>Recent Resident Logins</h2>
            <?php foreach ($recentLogins as $login): ?>
                <div class="activity-item">
                    <p><?= htmlspecialchars($login['full_name']) ?> logged in</p>
                    <p><?= date('d M Y, H:i', strtotime($login['login_time'])) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
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