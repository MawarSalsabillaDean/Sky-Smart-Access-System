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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="userdata_management.css">
    <title>Resident Data Management</title>
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
                    <span class="links_name">Visitors Management</span>
                </a>
                 <span class="tooltip">Visitors</span>
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
                <button type="button" name="logout" id="log_out" class='bx bx-log-out' onclick="location.href='search_residents_layout.php?logout=true';"></button>
                </div>
        </div>
    </div>
    
    <div class="container">
        <header>Resident Data Management</header>
        <div class="controls">
        <div class="search-container">
            <form action="search_residents.php" method="GET">
                <input type="text" name="search" placeholder="Search">
                <button type="submit" id="searchBtn">Search</button>
                <button type="button" id="refreshBtn" onclick="window.location='userdata_management.php';">Refresh</button>
            </form>
        </div>
        </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                <th>Resident Name</th>
                <th>Phone Number</th>
                <th>Unit Number</th>
                <th>Email</th>
                <th>IC number</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Race</th>
                <th>No. of Occupant</th>
                <th>Edit</th>
                <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach ($residents as $resident): ?>
                    <tr>
                        <td><?= htmlspecialchars($resident['full_name']) ?: 'Not provided' ?></td>
                        <td><?= htmlspecialchars($resident['phone_number']) ?: 'Not provided' ?></td>
                        <td><?= htmlspecialchars($resident['unit_number']) ?: 'Not provided' ?></td>
                        <td><?= htmlspecialchars($resident['email']) ?: 'Not provided' ?></td>
                        <td><?= htmlspecialchars($resident['ic_number']) ?: 'Not provided' ?></td>
                        <td><?= $resident['age'] ? htmlspecialchars($resident['age']) : 'Not provided' ?></td>
                        <td><?= htmlspecialchars($resident['gender']) ?: 'Not provided' ?></td>
                        <td><?= htmlspecialchars($resident['race']) ?: 'Not provided' ?></td>
                        <td><?= $resident['number_of_occupants'] ? htmlspecialchars($resident['number_of_occupants']) : 'Not provided' ?></td>
                        <td>
                            <button class="updateBtn" style="width: 70px;" onclick="window.location.href='update_resident_layout.php?id=<?= $resident['resident_id'] ?>'">Edit</button>
                        </td>
                        <td>
                            <button class="deleteBtn" onclick="confirmDeletion(<?= $resident['resident_id']; ?>)">Delete</button>
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

    function confirmDeletion(residentId) {
        if (confirm('Are you sure you want to delete this resident?')) {
            window.location.href = 'delete_resident.php?resident_id=' + residentId;
        }
    }

    document.querySelector('.search-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission
        const formData = new FormData(this);
        fetch('search_residents.php?' + new URLSearchParams(formData))
        .then(response => response.text())
        .then(html => document.getElementById('search-results').innerHTML = html)
        .catch(error => console.error('Error fetching the search results:', error));
    });
    </script>
</body>
</html>