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

include 'db.php'; // Ensure you have your database connection file included

$sql = "SELECT c.complaint_id, c.problem_title, c.date_occurrence, c.time_occurrence, c.problem_desc, c.image_path, c.submitted_at, c.status, c.comment, r.full_name, r.email, r.unit_number
        FROM complaints c
        JOIN resident_account r ON c.resident_id = r.resident_id
        ORDER BY c.submitted_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $complaintId = $_POST['complaint_id'];
    $status = $_POST['status'];
    $comment = $_POST['comment'] ?? ''; // Optional comments

    $updateSql = "UPDATE complaints SET status = ?, comment = ? WHERE complaint_id = ?";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->execute([$status, $comment, $complaintId]);

    header("Location: report_management.php"); // Redirect back to the management page
    exit();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">       
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="report_management.css">
    <title>Reports Management</title>
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
                <button type="button" name="logout" id="log_out" class='bx bx-log-out' onclick="location.href='report_management.php?logout=true';"></button>
                </div>
        </div>
    </div>
    
    <div class="container">
        <header>Report Management</header>
        <div class="controls">
            <div class="search-container">
            <form action="search_complaints.php" method="GET">
                <input type="text" name="search" placeholder="Search">
                <select name="status">
                    <option value="">All Statuses</option>
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Resolved">Resolved</option>
                    <option value="Rejected">Rejected</option>
                </select>
                <button type="submit" id="searchBtn">Search</button>
                <button type="button" id="refreshBtn" onclick="window.location='report_management.php';">Refresh</button>
            </form>
            </div>
        </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Resident Name</th>
                    <th>Email</th>
                    <th>Unit Number</th>
                    <th>Title</th>
                    <th>Date of Occurrence</th>
                    <th>Time of Occurrence</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Submitted At</th>
                    <th>Actions</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complaints as $complaint): ?>
                    <tr>
                        <td><?= htmlspecialchars($complaint['full_name']) ?></td>
                        <td><?= htmlspecialchars($complaint['email']) ?></td>
                        <td><?= htmlspecialchars($complaint['unit_number']) ?></td>
                        <td><?= htmlspecialchars($complaint['problem_title']) ?></td>
                        <td><?= htmlspecialchars((new DateTime($complaint['date_occurrence']))->format('d M Y')) ?></td>
                        <td><?= htmlspecialchars((new DateTime($complaint['time_occurrence']))->format('H:i')) ?></td>
                        <td><?= htmlspecialchars($complaint['problem_desc']) ?></td>
                        <td>
                            <!-- Check if there is an image path and display image -->
                            <?php if (!empty($complaint['image_path'])): ?>
                                <img src="<?= htmlspecialchars($complaint['image_path']) ?>" alt="Complaint Image" style="width: 150px; height: auto;">
                            <?php else: ?>
                                No Image Available
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars((new DateTime($complaint['submitted_at']))->format('d M Y, H:i')) ?></td>
                        <td>
                            <!-- Update form -->
                            <form method="post"  action="update_complaints.php">
                                <input type="hidden" name="complaint_id" value="<?= $complaint['complaint_id'] ?>">
                                <select name="status">
                                    <option value="Pending" <?= $complaint['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="In Progress" <?= $complaint['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                    <option value="Resolved" <?= $complaint['status'] === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                                    <option value="Rejected" <?= $complaint['status'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                </select>
                                <input type="text" name="comment" placeholder="Comments (if rejected)" value="<?= htmlspecialchars($complaint['comment']) ?>">
                                <button type="submit" name="update_status" class="updateBtn">Update</button>
                            </form>
                        </td>
                        <td>
                            <!-- Delete form -->
                            <form method="post" action="delete_complaints.php" onsubmit="return confirmDelete();">
                                <input type="hidden" name="complaint_id" value="<?= $complaint['complaint_id'] ?>">
                                <button type="submit" name="delete" class="deleteBtn" >Delete</button>
                            </form>
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

        function confirmDelete() {
            return confirm('Are you sure you want to delete this record?');
        }

        window.onload = function() {
                // Check if a session message is set and alert it
                <?php if (!empty($_SESSION['message'])): ?>
                    alert('<?= addslashes($_SESSION['message']) ?>');
                    <?php unset($_SESSION['message']); // Clear the message from session after displaying it ?>
                <?php endif; ?>
            };
    </script>
</body>
</html>