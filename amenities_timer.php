<?php
session_start();
include 'db.php'; // Ensure this file sets up $pdo correctly

if (!isset($_SESSION['user_email'])) {
    echo "<script>alert('Session not set. Redirecting to login.'); window.location.href='resident_login.php';</script>";
    exit();
}

if (!isset($_SESSION['resident_id'])) {
    echo "<script>alert('Resident ID not set in session. Please login again.'); window.location.href='resident_login.php';</script>";
    exit();
}

$resident_id = $_SESSION['resident_id']; // assuming resident_id is stored in session

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
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage()); // For debugging, should be logged in production
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300..900&display=swap">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="amenities_timer.css"> <!-- Make sure this path is correct -->
</head>
<body>
    <!-- sidebar -->
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

    <div class="timer-container">
        <header>Amenities Timer</header>
        <div class="timer-image">
            <img alt="A simple icon representing a timer or clock" src="pictures/timer.png"/>
        </div>
        <div class="timer-display" id="timer">00:00:00</div>
        <button id="stopTimer">Stop Timer</button>
    </div>

    <form id="endSessionForm" action="end_session.php" method="post" style="display:none;">
        <input type="hidden" name="session_id" value="<?= htmlspecialchars($_GET['session_id']); ?>">
    </form>
    <script>
        // Sidebar Toggle JavaScript
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
        
        document.addEventListener('DOMContentLoaded', function () {
            let startTime; // This will store the start time
            let timer;
            const timerDisplay = document.getElementById('timer');
            const stopButton = document.getElementById('stopTimer');

            function updateDisplay(seconds) {
                const hrs = Math.floor(seconds / 3600).toString().padStart(2, '0');
                const mins = Math.floor((seconds % 3600) / 60).toString().padStart(2, '0');
                const secs = (seconds % 60).toString().padStart(2, '0');
                timerDisplay.textContent = `${hrs}:${mins}:${secs}`;
            }

            function startTimer() {
                startTime = Date.now();
                timer = setInterval(() => {
                    const seconds = Math.floor((Date.now() - startTime) / 1000);
                    updateDisplay(seconds);
                }, 1000);
            }

            stopButton.addEventListener('click', function() {
                clearInterval(timer); // Stop the timer
                const seconds = Math.floor((Date.now() - startTime) / 1000);
                updateDisplay(seconds); // Update display immediately after stopping
                document.getElementById('endSessionForm').submit(); // Submit the form
            });

            startTimer(); // Start the timer
        });

    </script>
</body>
</html>