<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'db.php';

if (!isset($_SESSION['user_email'])) {
    echo "<script>alert('Session not set. Redirecting to login.'); window.location.href='resident_login.php';</script>";
    exit();
}

$email = $_SESSION['user_email'];

// Fetching details from the database
$accountSQL = "SELECT ra.resident_id, ra.full_name, ra.unit_number, ra.email, rp.nick_name FROM resident_account ra LEFT JOIN resident_profile rp ON ra.resident_id = rp.resident_id WHERE ra.email = ?";
$accountStmt = $pdo->prepare($accountSQL);
$accountStmt->bindParam(1, $email);
$accountStmt->execute();
$account = $accountStmt->fetch();

if (!$account) {
    echo "<script>alert('Account details not found.'); window.history.back();</script>";
    exit();
}

// Determine the display name: nickname if available, otherwise full name
$displayName = !empty($account['nick_name']) ? $account['nick_name'] : $account['full_name'];


$_SESSION['resident_id'] = $resident_id = $account['resident_id']; // Set resident_id into session


// Fetch user's profile details
$profileSQL = "SELECT full_name, unit_number, email FROM resident_account WHERE resident_id = ?";
$profileStmt = $pdo->prepare($profileSQL);
$profileStmt->bindParam(1, $resident_id);
$profileStmt->execute();
$row = $profileStmt->fetch(); // Fetch data without conditional check

function insertVisitor($data) {
    global $pdo;
    $sql = "INSERT INTO visitors (
        resident_id, visitor_name, phone_number, nric, vehicle_registration_number, 
        company_name, number_of_visitors, purpose_of_visit, date_of_visit, time_of_visit, status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([
            $data['resident_id'],
            $data['visitor_name'],
            $data['phone_number'],
            $data['nric'],
            $data['vehicle_registration_number'],
            $data['company_name'],
            $data['number_of_visitors'],
            $data['purpose_of_visit'],
            $data['date_of_visit'],
            $data['time_of_visit']
        ]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return 'Database error: ' . $e->getMessage();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $visitorData = [
        'resident_id' => $resident_id,
        'visitor_name' => $_POST['visitor_name'],
        'phone_number' => $_POST['phone_number'],
        'nric' => $_POST['nric'],
        'vehicle_registration_number' => $_POST['vehicle_registration_number'],
        'company_name' => $_POST['company_name'],
        'number_of_visitors' => $_POST['number_of_visitors'],
        'purpose_of_visit' => $_POST['purpose_of_visit'],
        'date_of_visit' => $_POST['date_of_visit'],
        'time_of_visit' => $_POST['time_of_visit']
    ];

    $result = insertVisitor($visitorData);
    if (is_numeric($result)) {
        echo "<script>alert('Visitor registered successfully with ID: $result');</script>";
    } else {
        echo "<script>alert('Error registering visitor: " . $result . "'); window.history.back();</script>";
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="visitor_registration.css">
    <title>Visitor Registration</title>
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
                        <div class="unit_no"><?= htmlspecialchars($account['unit_number']); ?></div>
                     </div>
                </div>
                <button type="button" name="logout" id="log_out" class='bx bx-log-out' onclick="location.href='resident_login.php';" style="border:none;"></button>
            </div>
        </div>
    </div>
    
    <div class="container">
        <header>Visitor Registration</header>

        <form id="visitorForm" action="process_visitor_registration.php" method="post">
            <div class="form first">

                <div class="personal details">
                    <span class="section title">Personal Details</span>

                    <div class="fields">
                    <input type="hidden" name="resident_id" value="<?php echo $resident_id; ?>">
                        <div class="input-field">
                            <label for="full_name">Full Name:</label>
                            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($row['full_name']); ?>" readonly>
                        </div>

                        <div class="input-field">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" readonly>
                        </div>

                        <div class="input-field">
                            <label for="unit_number">Unit Number:</label>
                            <input type="text" id="unit_number" name="unit_number" value="<?php echo htmlspecialchars($row['unit_number']); ?>" readonly>
                        </div>
                    </div>

                <div class="visitor details">
                    <span class="section title">Visitor Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label for="visitor_name">Full Name</label>
                            <input type="text" id="visitor_name" name="visitor_name" placeholder="e.g Abu bin Ali" required>
                        </div>

                        <div class="input-field">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" id="hone_number" name="phone_number" placeholder="e.g. 012-3456 789" required>
                        </div>

                        <div class="input-field">
                            <label for="nric">NRIC</label>
                            <input type="text" id="nric" name="nric" placeholder="e.g. 001131-10-1234" required>
                        </div>

                        <div class="input-field">
                            <label for="vehicle_registration_number">Vehicle Registration Number</label>
                            <input type="text" id="vehicle_registration_number" name="vehicle_registration_number" placeholder="e.g. ABC 1234" required>
                        </div>

                        <div class="input-field">
                            <label for="company_name">Company Name</label>
                            <input type="text" id="company_name" name="company_name" placeholder="e.g. Company A" required>
                        </div>

                        <div class="input-field">
                            <label for="number_of_visitors">Number of Visitor</label>
                            <input type="number" id="number_of_visitors" name="number_of_visitors" placeholder="e.g. 012-3456 789" required>
                        </div>

                        <div class="input-field">
                            <label for="purpose_of_visit">Purpose of Visit</label>
                            <input type="text" id="purpose_of_visit" name="purpose_of_visit" placeholder="e.g. Wi-FI Installation" required>
                        </div>

                        <div class="input-field">
                            <label for="date_of_visit">Date of Visit</label>
                            <input type="date" id="date_of_visit" name="date_of_visit" required>
                        </div>

                        <div class="input-field">
                            <label for="time_of_visit">Time of Visit</label>
                            <input type="time" id="time_of_visit" name="time_of_visit" required>
                        </div>
                    </div>

                    <div class="button-container">
                    <button class="submitBtn" onclick="submitButton()" type="submit" name="submit">
                        <span class="btnText">Submit</span>
                    </button>

                    <button type="button" class="resetBtn" onclick="resetForm();">
                        <span class="btnText">Reset</span>
                    </button>
                    <button class="nextBtn" onclick="checkStatus()">
                        <span class="btnText">Check Status</span>
                    </button>
                </div>
                </div>
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

        function resetForm() {
            document.getElementById('visitorForm').reset();
        }
    
        function checkStatus() {
            window.location.href = 'visitor_status.php'; 
        }
       
    </script>
</body>
</html>