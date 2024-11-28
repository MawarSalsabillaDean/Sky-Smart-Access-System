
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


$_SESSION['resident_id'] = $resident_id = $account['resident_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $targetDir = "uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    $allowTypes = array('jpg', 'png', 'jpeg');
    if (!in_array($fileType, $allowTypes)) {
        echo "<script>alert('Sorry, only JPG, JPEG & PNG files are allowed.'); window.history.back();</script>";
        exit;
    }

    if ($_FILES["image"]["size"] > 500000) {
        echo "<script>alert('Sorry, your file is too large.'); window.history.back();</script>";
        exit;
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        // Set the image path for DB insertion
        $_POST['image_path'] = $targetFilePath;
        include 'process_complaint_report.php';
    } else {
        echo "<script>alert('Sorry, there was an error uploading your file. Error Code: " . $_FILES["image"]["error"] . "'); window.history.back();</script>";
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
    <link rel="stylesheet" href="complaint_report.css">
    <title>Report Form</title>
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
        <header>Complaint Report</header>

        <form id="reportForm" action="complaint_report.php" method="post" enctype="multipart/form-data">
            <div class="form first">

                <div class="personal details">
                    <span class="section title">Personal Details</span>

                    <div class="fields">
                    <input type="hidden" name="resident_id" value="<?php echo $resident_id; ?>">
                    <div class="input-field">
                        <label for="full_name">Full Name:</label>
                        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($account['full_name']); ?>" readonly>
                    </div>

                    <div class="input-field">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($account['email']); ?>" readonly>
                    </div>

                    <div class="input-field">
                        <label for="unit_number">Unit Number:</label>
                        <input type="text" id="unit_number" name="unit_number" value="<?php echo htmlspecialchars($account['unit_number']); ?>" readonly>
                    </div>
                    </div>
                </div>

                <div class="visitor details">
                    <span class="section title">Problem Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label for="problem_title">Title</label>
                            <input type="text" id="problem_title" name="problem_title" placeholder="e.g. Elevator Breakdown" required>
                        </div>

                        <div class="input-field">
                            <label for="date_occurrence">Date of Occurrence</label>
                            <input type="date" id="date_occurrence" name="date_occurrence" required>
                        </div>

                        <div class="input-field">
                            <label for="time_occurrence">Time of Occurrence</label>
                            <input type="time" id="time_occurrence" name="time_occurrence" required>
                        </div>

                        <div class="full-width-field">
                            <label for="problem_desc">Description</label>
                            <textarea id="problem_desc" name="problem_desc" placeholder="Provide a detailed description" required></textarea>
                        </div>
                    
                        <div class="form-field">
                            <label for="file-upload-input">Upload Image</label>
                            <div class="upload-area" onclick="document.getElementById('file-upload-input').click()">
                                <input type="file" id="file-upload-input" name="image" accept=".jpg, .jpeg, .png" style="display: none;">
                                <img id="preview" src="#" alt="Image Preview" style="display: none; max-width: 300px; max-height: 300px;">
                                <div class="icon-text" onclick="document.getElementById('file-upload-input').click()">
                                    <i class="bx bx-cloud-upload"></i>
                                    <span>Choose photo</span>
                                </div>
                            </div>
                        </div>

                    <div class="button-container">
                    <button class="submitBtn" onclick="submitButton()" type="submit" name="submit" value="Submit Form">
                        <span class="btnText">Submit</span>
                    </button>

                    <button type="button" class="resetBtn" onclick="resetForm()">
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

        document.getElementById('file-upload-input').addEventListener('change', handleFileSelect);

        function handleFileSelect(event) {
            var file = event.target.files[0];
            var preview = document.getElementById('preview');
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Make the preview visible
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none'; // Hide the preview if no file selected
            }
        }

        function resetForm() {
            document.getElementById('reportForm').reset();
            document.getElementById('preview').style.display = 'none'; // Hide the preview
            document.getElementById('file-upload-input').value = ''; // Clear the file input
        }

        document.querySelector('.resetBtn').addEventListener('click', resetForm); // Make sure reset is hooked up
    
        function checkStatus() {
            window.location.href = 'complaint_status.php'; 
        }
    </script>
</body>
</html>