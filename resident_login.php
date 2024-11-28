<?php
session_start();
include 'db.php'; // Include your database connection settings
include 'loginFunctions.php'; // Include the file where checkLogin function is defined

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Call the checkLogin function from loginFunctions.php
    if (checkLogin($email, $password)) {
        header("Location: resident_menu.html"); // Redirect to the main menu page if login is successful
        exit();
    } else {
        $_SESSION['loginMessage'] = "Invalid credentials, please try again."; // Set error message if login fails
    }
}

if (isset($_SESSION['loginMessage'])) {
    echo "<script>sessionStorage.setItem('loginMessage', '" . addslashes($_SESSION['loginMessage']) . "');</script>";
    unset($_SESSION['loginMessage']); // Clear the session message after setting it in sessionStorage
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="resident_login.css">
</head>
<body>
    <div class="form-container">
        <div class="col col-1">
            <div class="image-layer">
                <img src="pictures/woman working.png" class="form-image-main">
            </div>
            <p class="featured-words">Welcome back! Enter your details to pick up where you left off.</p>
        </div>

        <div class="col col-2">
            <form action="resident_login.php" method="post">
            <div class="btn-box">
                <button type="button" class="btn btn-1" id="login">Sign In</button>
                <button type="button" class="btn btn-2" id="register" onclick="goToPage('resident_register.php')">Sign Up</button>
            </div>
            
            <div class="login-form">
                <div class="form-title">
                    <span>Sign In</span>
                </div>
                <div class="form-inputs">
                    <div class="input-box">
                        <input type="email" name="email" class="input-field" placeholder="Email" required>
                        <i class="bx bx-envelope icon"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" id="password" class="input-field" placeholder="Password" required>
                        <button type="button" onclick="togglePasswordVisibility()" class="toggle-password">
                            <i class="bx bx-show" id="toggleIcon"></i>
                        </button>
                    </div>
                    <div class="input-box">
                        <button type="submit" class="input-submit">
                            <span>Sign In</span>
                            <i class="bx bx-right-arrow-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>           
        </div>
    </div>
</body>
<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var toggleIcon = document.getElementById('toggleIcon');
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.className = 'bx bx-hide'; // Change icon to 'hide'
        } else {
            passwordInput.type = "password";
            toggleIcon.className = 'bx bx-show'; // Change icon back to 'show'
        }
    }

    window.onload = function() {
        const message = sessionStorage.getItem('loginMessage');
        if (message) {
            alert(message);  // Display the message as an alert or use your custom modal logic here
            sessionStorage.removeItem('loginMessage');  // Clear the message after displaying it
        }
    };

    function goToPage(pageUrl) {
        window.location.href = pageUrl;
    }
</script>
</html>
