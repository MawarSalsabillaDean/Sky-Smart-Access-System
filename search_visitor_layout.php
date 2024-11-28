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
    <link rel="stylesheet" href="visitor_management.css">
    <title>Visitors Management</title>
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
                <button type="button" name="logout" id="log_out" class='bx bx-log-out' onclick="location.href='search_visitor_layout.php?logout=true';"></button>
                </div>
        </div>
    </div>
    
    <div class="container">
        <header>Visitors Management</header>
        <div class="controls">
        <div class="search-container">
            <form action="search_visitors.php" method="GET" style="display: flex; align-items: center;">
                <input type="text" name="search" placeholder="Search" id="searchInput">
                <button type="submit" id="searchBtn">Search</button>
                <button type="button" id="refreshBtn" onclick="window.location='visitor_management.php';">Refresh</button>
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
                    <th>Visitor Name</th>
                    <th>Phone Number</th>
                    <th>IC Number</th>
                    <th>Plate Number</th>
                    <th>Company Name</th>
                    <th>Purpose</th>
                    <th>Date of Visit</th>
                    <th>Time of Visit</th>
                    <th>Submitted At</th>
                    <th>Actions</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($visitors as $visitor): ?>
                    <tr>
                        <td><?= htmlspecialchars($visitor['full_name']) ?></td>
                        <td><?= htmlspecialchars($visitor['email']) ?></td>
                        <td><?= htmlspecialchars($visitor['unit_number']) ?></td>
                        <td><?= htmlspecialchars($visitor['visitor_name']) ?></td>
                        <td><?= htmlspecialchars($visitor['phone_number']) ?></td>
                        <td><?= htmlspecialchars($visitor['nric']) ?></td> <!-- Make sure 'nric' is fetched correctly -->
                        <td><?= htmlspecialchars($visitor['vehicle_registration_number']) ?></td>
                        <td><?= htmlspecialchars($visitor['company_name']) ?></td>
                        <td><?= htmlspecialchars($visitor['purpose_of_visit']) ?></td>
                        <td><?= htmlspecialchars((new DateTime($visitor['date_of_visit']))->format('d M Y')) ?></td>
                        <td><?= htmlspecialchars((new DateTime($visitor['time_of_visit']))->format('H:i')) ?></td>
                        <td><?= htmlspecialchars((new DateTime($visitor['registration_timestamp']))->format('d M Y, H:i')) ?></td>
                        <td>
                            <form method="post"  action="update_visitors.php">
                                <input type="hidden" name="visitor_id" value="<?= $visitor['visitor_id'] ?>"> <!-- Corrected from id to visitor_id -->
                                <select name="status">
                                    <option value="Pending" <?= $visitor['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Approved" <?= $visitor['status'] === 'Approved' ? 'selected' : '' ?>>Approved</option>
                                    <option value="Rejected" <?= $visitor['status'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                </select>
                                <input type="text" name="comments" placeholder="Comments (if rejected)" value="<?= htmlspecialchars($visitor['comments']) ?>">
                                <button type="submit" name="update_status" class="updateBtn">Update</button>
                            </form>
                        </td>
                        <td>
                        <form method="post" action="delete_visitors.php" onsubmit="return confirmDelete();">
                            <input type="hidden" name="visitor_id" value="<?= $visitor['visitor_id'] ?>">
                            <button type="submit" name="delete" class="deleteBtn">Delete</button>
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