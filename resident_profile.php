<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_email'])) {
    header('Location: resident_login.php');
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


// Fetching user's account details
$accountSQL = "SELECT * FROM resident_account WHERE email = :email";
$accountStmt = $pdo->prepare($accountSQL);
if (!$accountStmt->execute(['email' => $email])) {
    echo "Error fetching account details.";
    exit();
}
$account = $accountStmt->fetch(PDO::FETCH_ASSOC);

if (!$account) {
    echo "Account details not found.";
    exit();
}

// Fetching last five login times
$loginsSQL = "SELECT login_time FROM login_history WHERE resident_id = :resident_id ORDER BY login_time DESC LIMIT 5";
$loginsStmt = $pdo->prepare($loginsSQL);
$loginsStmt->execute(['resident_id' => $account['resident_id']]);
$logins = $loginsStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetching user's profile details
$profileSQL = "SELECT * FROM resident_profile WHERE resident_id = :resident_id";
$profileStmt = $pdo->prepare($profileSQL);
if (!$profileStmt->execute(['resident_id' => $account['resident_id']])) {
    echo "Error fetching profile details.";
    exit();
}
$profile = $profileStmt->fetch(PDO::FETCH_ASSOC);

if (!$profile) {
    // Insert a placeholder profile if not found
    $insertProfileSQL = "INSERT INTO resident_profile (resident_id, nick_name, ic_number, age, gender, race, number_of_occupants) VALUES (:resident_id, '', '', 0, '', '', 0)";
    $insertProfileStmt = $pdo->prepare($insertProfileSQL);
    if (!$insertProfileStmt->execute(['resident_id' => $account['resident_id']])) {
        echo "Failed to create profile, please contact support.";
        exit();
    }
    // Fetch the profile again after insertion
    $profileStmt->execute(['resident_id' => $account['resident_id']]);
    $profile = $profileStmt->fetch(PDO::FETCH_ASSOC);
}

$user = array_merge($account, $profile ?: []);

// Debug output to see what's inside $user
// Remove this in production
echo "<pre>"; print_r($user); echo "</pre>";

// Handling form submission for profile updates
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Collect all input data
    $nickName = $_POST['nickName'] ?? '';
    $icNumber = $_POST['icNumber'] ?? '';
    $age = $_POST['age'] ?? 0;
    $gender = $_POST['gender'] ?? '';
    $race = $_POST['race'] ?? '';
    $numberOfOccupants = $_POST['numberOfOccupants'] ?? 0;

    // Prepare to update the profile details
    $updateProfileSQL = "UPDATE resident_profile SET 
        nick_name = :nick_name, 
        ic_number = :ic_number, 
        age = :age, 
        gender = :gender, 
        race = :race, 
        number_of_occupants = :number_of_occupants 
        WHERE resident_id = :resident_id";

    $profileStmt = $pdo->prepare($updateProfileSQL);
    $updateResult = $profileStmt->execute([
        'nick_name' => $nickName,
        'ic_number' => $icNumber,
        'age' => $age,
        'gender' => $gender,
        'race' => $race,
        'number_of_occupants' => $numberOfOccupants,
        'resident_id' => $account['resident_id']
    ]);

    if ($updateResult) {
        echo "<script>alert('Profile updated successfully.'); window.location.href='resident_profile.php';</script>";
    } else {
        echo "Error updating profile.";
    }
    exit();
}
// If the form is not submitted, or there are no updates made, display the profile form with the current details.
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
    <link rel="stylesheet" href="resident_profile.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Resident Profile</title>
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
                    <!-- Display dynamic nickname and unit number -->
                    <div class="name"><?= htmlspecialchars($displayName); ?></div>
                    <div class="unit_no"><?= htmlspecialchars($account['unit_number']); ?></div>
                </div>
            </div>
            <!-- Logout button -->
            <form method="post">
                <button type="button" name="logout" id="log_out" class='bx bx-log-out' onclick="location.href='resident_login.php';" style="border:none;"></button>
            </form>
        </div>
    </div>
    </div>
    
    <div class="container">
        <header>User Profile</header>
        <div class="sections">
            <div class="personal-details" id="personalDetails">
                <h2>Personal Details</h2>
                <div class="detail-row">
                    <div class="detail-block">
                        <span class="detail-title">Full Name</span>
                        <span class="detail-info"><?= !empty($user['full_name']) ? htmlspecialchars($user['full_name']) : "Not provided"; ?></span>
                        </div>
                    <div class="detail-block">
                        <span class="detail-title">Nick Name</span>
                        <span class="detail-info"><?= !empty($user['nick_name']) ? htmlspecialchars($user['nick_name']) : "Not provided"; ?></span>
                        </div>
                </div>
                <div class="detail-row">
                    <div class="detail-block">
                        <span class="detail-title">IC Number</span>
                        <span class="detail-info"><?= !empty($user['ic_number']) ? htmlspecialchars($user['ic_number']) : "Not provided"; ?></span>
                        </div>
                    <div class="detail-block">
                        <span class="detail-title">Phone Number</span>
                        <span class="detail-info"><?= !empty($user['phone_number']) ? htmlspecialchars($user['phone_number']) : "Not provided"; ?></span>
                        </div>
                </div>
                <div class="detail-row">
                    <div class="detail-block">
                        <span class="detail-title">Unit Number</span>
                        <span class="detail-info"><?= !empty($user['unit_number']) ? htmlspecialchars($user['unit_number']) : "Not provided"; ?></span>
                        </div>
                    <div class="detail-block">
                        <span class="detail-title">Email</span>
                        <span class="detail-info"><?= !empty($user['email']) ? htmlspecialchars($user['email']) : "Not provided"; ?></span>
                        </div>
                </div>
                <div class="detail-row">
                    <div class="detail-block">
                        <span class="detail-title">Age</span>
                        <span class="detail-info"><?= !empty($user['age']) ? htmlspecialchars($user['age']) : "Not provided"; ?></span>
                        </div>
                    <div class="detail-block">
                        <span class="detail-title">Gender</span>
                        <span class="detail-info"><?= !empty($user['gender']) ? htmlspecialchars($user['gender']) : "Not provided"; ?></span>
                        </div>
                </div>
                <div class="detail-row">
                    <div class="detail-block">
                        <span class="detail-title">Race</span>
                        <span class="detail-info"><?= !empty($user['race']) ? htmlspecialchars($user['race']) : "Not provided"; ?></span>
                        </div>
                    <div class="detail-block">
                        <span class="detail-title">Number of Occupants</span>
                        <span class="detail-info"><?= !empty($user['number_of_occupants']) ? htmlspecialchars($user['number_of_occupants']) : "Not provided"; ?></span>
                        </div>
                </div>
                <button class="edit-profile" onclick="openForm()">Edit Profile</button>
            </div>
            <!-- Login History Section -->
            <div class="login-history">
                <h2>Login History</h2>
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                    <?php if (!empty($logins)): ?>
                        <?php foreach ($logins as $login): ?>
                        <tr>
                            <td><?= date("d M Y", strtotime($login['login_time'])); ?></td>
                            <td><?= date("H:i:s", strtotime($login['login_time'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="2">No recent logins found.</td></tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

<!-- Popup Form for Editing Profile -->
<div class="popup-form" id="popupForm" style="display:none;"> <!-- Ensure this is initially hidden -->
    <form action="resident_profile.php" method="post" class="form-container">
        <span class="close-btn" onclick="closeForm()"><i class="fas fa-times"></i></span>
        <h2>Edit Profile</h2>
        <div class="form-group">
            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" name="fullName" value="<?= htmlspecialchars($user['full_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="nickName">Nick Name</label>
            <input type="text" id="nickName" name="nickName" value="<?= htmlspecialchars($user['nick_name']); ?>" placeholder="e.g Ali">
        </div>
        <div class="form-group">
            <label for="icNumber">IC Number</label>
            <input type="text" id="icNumber" name="icNumber" value="<?= htmlspecialchars($user['ic_number']); ?>" placeholder="e.g. 111111-11-1111">
        </div>
        <div class="form-group">
            <label for="phoneNumber">Phone Number</label>
            <input type="text" id="phoneNumber" name="phoneNumber" value="<?= htmlspecialchars($user['phone_number']); ?>" required>
        </div>
        <div class="form-group">
            <label for="propertyUnitNumber">Unit Number</label>
            <input type="text" id="propertyUnitNumber" name="propertyUnitNumber" value="<?= htmlspecialchars($user['unit_number']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" id="age" name="age" value="<?= htmlspecialchars($user['age']); ?>" placeholder="e.g. 23">
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender">
                <option value="Male" <?= strtolower($user['gender']) == 'male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?= strtolower($user['gender']) == 'female' ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="race">Race</label>
            <input type="text" id="race" name="race" value="<?= htmlspecialchars($user['race']); ?>" placeholder="e.g. Malay">
        </div>
        <div class="form-group">
            <label for="numberOfOccupants">Number of Occupants</label>
            <input type="number" id="numberOfOccupants" name="numberOfOccupants" value="<?= htmlspecialchars($user['number_of_occupants']); ?>" placeholder="e.g. 3">
        </div>
        <div class="form-actions">
            <button type="button" class="close" onclick="closeForm()">Close</button>
            <button type="submit" class="save">Save Changes</button>
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

        /* Make sure the popup is visible when needed */
        function openForm() {
            document.getElementById('popupForm').style.display = 'flex';
        }

        function closeForm() {
            document.getElementById('popupForm').style.display = 'none';
        }
    
    </script>
</body>
</html>