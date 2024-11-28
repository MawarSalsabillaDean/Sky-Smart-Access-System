<?php
session_start();
include 'db.php';  // Ensure this file sets up your PDO connection to the MySQL database

// Helper function to format duration
function formatDuration($seconds) {
    if ($seconds === NULL) {
        return 'Not Available';
    }
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;
    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
}

// Helper function to format the datetime
function formatDate($datetime) {
    return date("d M Y, H:i", strtotime($datetime));
}

$search = $_GET['search'] ?? '';  // Get the search term from the URL parameter

// Build the SQL query
$sql = "SELECT au.usage_id, ra.full_name, ra.phone_number, ra.unit_number, au.amenity_name, au.start_time, au.end_time, au.duration
        FROM amenity_usage au
        INNER JOIN resident_account ra ON au.resident_id = ra.resident_id";

if (!empty($search)) {
    $sql .= " WHERE ra.full_name LIKE :searchTerm OR ra.phone_number LIKE :searchTerm OR ra.unit_number LIKE :searchTerm OR au.amenity_name LIKE :searchTerm";
}

$sql .= " ORDER BY au.usage_id DESC";

try {
    $stmt = $pdo->prepare($sql);
    if (!empty($search)) {
        $searchTerm = '%' . $search . '%';
        $stmt->bindParam(':searchTerm', $searchTerm);
    }
    $stmt->execute();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@22,300,0,-25&icon_names=dashboard" />    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="amenities_management.css">
    <title>Residents Amenities Usage</title>
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
                    <span class="links_name">Visitors Management</span>
                </a>
                 <span class="tooltip">Visitors</span>
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
                <button type="button" name="logout" id="log_out" class='bx bx-log-out' onclick="location.href='admin_login.php';"></button>
                </div>
        </div>
    </div>
    
    <div class="container">
        <header>Residents Amenities Usage</header>
        <div class="controls">
        <div class="search-container">
            <form action="search_amenities.php" method="GET">
                <input type="text" name="search" placeholder="Search" value="<?= htmlspecialchars($search) ?>">
                <button type="submit" id="searchBtn">Search</button>
                <button type="button" id="refreshBtn" onclick="window.location='amenities_management.php';">Refresh</button>
            </form>
        </div>
        </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                <th>Usage ID</th>
                <th>Resident Name</th>
                <th>Phone Number</th>
                <th>Unit Number</th>
                <th>Amenities Name</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td data-title="Usage ID"><?= htmlspecialchars($row['usage_id']) ?></td>
                        <td data-title="Resident Name"><?= htmlspecialchars($row['full_name']) ?></td>
                        <td data-title="Phone Number"><?= htmlspecialchars($row['phone_number']) ?></td>
                        <td data-title="Unit Number"><?= htmlspecialchars($row['unit_number']) ?></td>
                        <td data-title="Amenities Name"><?= htmlspecialchars($row['amenity_name']) ?></td>
                        <td data-title="Start Time"><?= formatDate($row['start_time']) ?></td>
                        <td data-title="End Time"><?= formatDate($row['end_time']) ?></td>
                        <td data-title="Duration"><?= formatDuration($row['duration']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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