<?php
session_start();
include 'db.php'; // Ensure this file sets up $pdo correctly

// Check if the user is logged in and has a valid email, otherwise redirect to login page
if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] == '' || !isset($_SESSION['resident_id'])) {
    echo "<script>alert('Please log in to view this page.'); window.location.href='resident_login.php';</script>";
    exit();
}

$resident_id = $_SESSION['resident_id'];

try {
    // Fetch user's profile details
    $stmt = $pdo->prepare("SELECT ra.full_name, ra.unit_number, rp.nick_name FROM resident_account ra 
                            LEFT JOIN resident_profile rp ON ra.resident_id = rp.resident_id 
                            WHERE ra.resident_id = ?");
    $stmt->bindParam(1, $resident_id, PDO::PARAM_INT);
    $stmt->execute();
    $userDetails = $stmt->fetch();

    if (!$userDetails) {
        echo "<script>alert('No user details found. Please complete your profile.'); window.location.href='profile.php';</script>";
        exit();
    }

    // Determine display name: nickname if available, otherwise full name
    $displayName = !empty($userDetails['nick_name']) ? $userDetails['nick_name'] : $userDetails['full_name'];

    // Fetch announcements relevant to the user
    $annStmt = $pdo->prepare("SELECT a.* FROM announcements a
                              LEFT JOIN announcement_units au ON a.announcement_id = au.announcement_id
                              WHERE a.send_to_all = 1 OR au.resident_id = ?
                              ORDER BY a.created_at DESC");
    $annStmt->bindParam(1, $resident_id, PDO::PARAM_INT);
    $annStmt->execute();
    $announcements = $annStmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="news_feed.css">
    <title>News Feed</title>
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
                <a href="resident_profile.php">
                    <i class='bx bx-user'></i>                   
                    <span class="links_name">Profile Management</span>
                </a>
                 <span class="tooltip">Profile</span>
            </li>
            <li>
                <a href="visitor_registration.php">
                    <i class='bx bx-id-card'></i>
                    <span class="links_name">Visitor Registration</span>
                </a>
                 <span class="tooltip">Visitor</span>
            </li>
            <li>
                <a href="vehicle_registration.php">
                    <i class='bx bx-car'></i>
                    <span class="links_name">Parking Registration</span>
                </a>
                 <span class="tooltip">Parking</span>
            </li>
            <li>
                <a href="amenities_access.php">
                    <i class='bx bx-qr'></i>
                    <span class="links_name">Amenities Access</span>
                </a>
                 <span class="tooltip">Amenities</span>
            </li>
            <li>
                <a href="news_feed.php">
                    <i class='bx bx-news' ></i>
                    <span class="links_name">News Feed</span>
                </a>
                 <span class="tooltip">News Feed</span>
            </li>
            <li>
                <a href="complaint_report.php">
                    <i class='bx bx-edit' ></i>
                    <span class="links_name">Report Form</span>
                </a>
                 <span class="tooltip">Report</span>
            </li>
        </ul>
        <div class="profile_content">
            <div class="profile">
                <div class="profile_details">
                    <img src="pictures/user.png" alt="User Icon" class="user_icon">
                     <div class="user_details">
                        <div class="name"><?= htmlspecialchars($displayName); ?></div>
                        <div class="unit_no"><?= htmlspecialchars($userDetails['unit_number']); ?></div>
                     </div>
                </div>
                <button type="button" name="logout" id="log_out" class='bx bx-log-out' onclick="location.href='resident_login.php';" style="border:none;"></button>
            </div>
        </div>
    </div>
    
    <div class="container">
        <header>News Feed</header>
        <div class="card-container">
            <?php if (!empty($announcements)): ?>
                <?php foreach ($announcements as $announcement): ?>
                    <div class="card">
                        <img alt="Announcements" height="150" src="pictures/announcements.png" width="250"/>
                        <div class="card-content">
                        <h3><?= htmlspecialchars($announcement['title']) ?></h3>
                        <p>Posted on: <?= date('d M Y, H:i', strtotime($announcement['created_at'])) ?></p>
                        <?php if (!empty($announcement['file_name'])): ?>
                            <button><a href="uploads/<?= htmlspecialchars($announcement['file_name']) ?>" target="_blank">VIEW NOTICE</a></button>
                        <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
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


       
    </script>
</body>
</html>