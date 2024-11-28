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

include 'db.php'; // Ensure your database connection file is included

try {
    $stmt = $pdo->query("
        SELECT 
            a.announcement_id, 
            a.title, 
            a.file_name, 
            a.send_to_all, 
            a.created_at, 
            GROUP_CONCAT(ra.unit_number ORDER BY ra.unit_number SEPARATOR ', ') AS unit_numbers
        FROM 
            announcements a
            LEFT JOIN announcement_units au ON a.announcement_id = au.announcement_id
            LEFT JOIN resident_account ra ON au.resident_id = ra.resident_id
        GROUP BY 
            a.announcement_id
        ORDER BY 
            a.created_at DESC
    ");
    $announcements = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Could not connect to the database :" . $e->getMessage());
}

include 'announcements_history_layout.php';  // Include the layout file for display
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">       
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="announcements_history.css">
    <title>Announcements History</title>
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
                    <span class="links_name">Users Data Management</span>
                </a>
                 <span class="tooltip">Users Data</span>
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
                    <span class="links_name">Parkings Management</span>
                </a>
                 <span class="tooltip">Parkings</span>
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
                    <span class="links_name">Reports Management</span>
                </a>
                 <span class="tooltip">Reports</span>
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
                <button type="button" name="logout" id="log_out" class='bx bx-log-out' onclick="location.href='announcements_history.php?logout=true';"></button>
                </div>
        </div>
    </div>
    
    <div class="container">
        <header>Announcements History</header>
        <div class="controls">
            <div class="search-container">
            <form action="search_announcements.php" method="GET">
            <input type="text" name="search" placeholder="Search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit" id="searchBtn">Search</button>
                <button type="button" id="refreshBtn" onclick="window.location='announcements_history.php';">Refresh</button>
            </form>
            </div>
        </div>
    <div class="table-container">
        
        <?php if (!empty($announcements)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>File</th>
                        <th>Send to All</th>
                        <th>Unit Numbers</th>
                        <th>Date Posted</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($announcements as $announcement): ?>
                    <tr>
                        <td><?= htmlspecialchars($announcement['title']) ?></td>
                        <td><a class="file-path" href="uploads/<?= htmlspecialchars($announcement['file_name']) ?>" target="_blank">View</a></td>
                        <td><?= $announcement['send_to_all'] ? 'Yes' : 'No' ?></td>
                        <td><?= $announcement['send_to_all'] ? '-' : htmlspecialchars($announcement['unit_numbers']) ?></td>
                        <td><?= date('d M Y, H:i', strtotime($announcement['created_at'])) ?></td>
                        <td><button class="delete-button" onclick="return confirmDelete(<?= $announcement['announcement_id'] ?>);">Delete</button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No announcements found.</p>
            <?php endif; ?>
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

        function confirmDelete(announcementId) {
            if(confirm("Are you sure you want to delete this announcement?")) {
                window.location.href = 'delete_announcement.php?id=' + announcementId;
                return true;
            }
            return false;
        }
    </script>
</body>
</html>