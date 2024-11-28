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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $sendToAll = isset($_POST['sendToAll']) ? 1 : 0;
    $unitsInput = $_POST['units'];

    $targetDir = "uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
        $query = "INSERT INTO announcements (title, file_name, send_to_all) VALUES (?, ?, ?)";
        
        $stmt = $pdo->prepare($query);
        if ($stmt->execute([$title, $fileName, $sendToAll])) {
            $announcement_id = $pdo->lastInsertId();
            if (!$sendToAll) {
                $units = explode(',', $unitsInput);
                foreach ($units as $unit) {
                    $unit = trim($unit);
                    // Adjust this query based on your actual database schema
                    $query = "INSERT INTO announcement_units (announcement_id, resident_id) SELECT ?, resident_id FROM resident_account WHERE unit_number = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$announcement_id, $unit]);
                }                
            }
            echo "<script type='text/javascript'>alert('Announcement uploaded successfully!'); window.location.href='announcements_history.php';</script>";
        } else {
            echo "<script type='text/javascript'>alert('Error uploading announcement!'); window.location.href='announcement_management.php';</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Sorry, there was an error uploading your file!'); window.location.href='announcement_management.php';</script>";
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="announcement_management.css">
    <title>Announcement Management</title>
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
                <button type="button" name="logout" id="log_out" class='bx bx-log-out' onclick="location.href='announcement_management.php?logout=true';"></button>
                </div>
        </div>
    </div> 
    <div class="container">
        <header>Announcements Management</header>
        <form action="announcement_management.php" method="post" enctype="multipart/form-data">
            <label for="title" style="margin-top: 30px;">Title</label>
            <input type="text" id="title" name="title" placeholder="Enter announcement title">
            
            <label for="file">Upload Image/PDF</label>
            <input type="file" id="file" name="file">
            
            <label for="units">Enter Unit House Numbers (comma separated):</label>
            <input type="text" id="units" name="units" placeholder="e.g., 19-10, 20-05, 21-12">
            
            <div class="checkbox-container">
                <input type="checkbox" id="sendToAll" name="sendToAll">
                <label for="sendToAll">Send to all unit house numbers</label>
            </div>
            
            <div class="buttons">
                <button type="submit" class="send">Send Announcement</button>
                <button type="button" class="history" onclick="location.href='announcements_history.php';">Go to Announcements History</button>
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