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

    // Fetch visitor requests including comments
    $stmt = $pdo->prepare("SELECT visitor_name, purpose_of_visit, date_of_visit, registration_timestamp, status, comments FROM visitors WHERE resident_id = ? ORDER BY registration_timestamp DESC");
    $stmt->execute([$resident_id]);
    $visitor_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage()); // For debugging, should be logged in production
}

// Example of using DateTime to format a date
$rawDate = '2024-10-27 14:35:00'; // Example date from your database
$dateTime = new DateTime($rawDate);
$formattedDate = $dateTime->format('d M Y, H:i'); // Format: Day Month Year, Hour:Minute
echo $formattedDate; // Output: 27 Oct 2024, 14:35

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="visitor_status.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>Visitor Tracking Status</title>
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

    <!-- table -->
    <div class="container">
        <h1>Visitor Tracking Status</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Visitor Name</th>
                        <th>Purpose of Visit</th>
                        <th>Date of Visit</th>
                        <th>Submitted At</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($visitor_requests as $request): ?>
                    <tr>
                        <td data-label="Visitor Name"><?= htmlspecialchars($request['visitor_name']) ?></td>
                        <td data-label="Purpose of Visit"><?= htmlspecialchars($request['purpose_of_visit']) ?></td>
                        <td data-label="Date of Visit"><?= htmlspecialchars((new DateTime($request['date_of_visit']))->format('d M Y')) ?></td>
                        <td data-label="Submitted At"><?= htmlspecialchars((new DateTime($request['registration_timestamp']))->format('d M Y, H:i')) ?></td>
                        <td data-label="Status"><span class="status <?= strtolower($request['status']) ?>"><?= htmlspecialchars(strtoupper($request['status'])) ?></span></td>
                        <td data-label="Remarks" class="remarks-cell">
                            <?= $request['status'] == 'Rejected' ? htmlspecialchars($request['comments']) : '-' ?>
                        </td>                    
                    </tr>
                    <?php endforeach; ?>
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

    </script>
</body>
</html>