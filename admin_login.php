<?php
session_start(); // Start the session to ensure session variable can be set later

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Example credentials, replace with your actual credentials checking mechanism
    $correctUsername = 'admin';
    $correctPassword = 'password123';

    if ($username === $correctUsername && $password === $correctPassword) {
        // Set logged in session
        $_SESSION['loggedin'] = true;
        // Redirect to admin menu if login is successful
        header('Location: admin_menu.html');
        exit();
    } else {
        // Set error message to display on failed login attempt
        $_SESSION['loginError'] = 'Incorrect username or password! Please try again.';
    }
}

// Check if redirected with an error message
if (isset($_GET['error']) && $_GET['error'] == 'notloggedin') {
    echo "<script>alert('You must log in first to access the system.');</script>";
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
    <link rel="stylesheet" href="admin_login.css">
</head>
<body>
    <div class="form-container">
        <div class="col col-1">
            <div class="image-layer">
                <img src="pictures/officemates.png" class="form-image-main">
            </div>
            <p class="featured-words">Welcome back! Let's get started on today's adventure!</p>
        </div>

        <div class="col col-2">
            <form action="admin_login.php" method="post">
                <div class="login-form">
                    <div class="form-title">
                        <span>Sign In</span>
                    </div>
                    <div class="form-inputs">
                        <div class="input-box">
                            <input type="text" name="username" class="input-field" placeholder="Username" required>
                            <i class="bx bx-user icon"></i>
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
                        <?php
                        if (isset($_SESSION['loginError'])) {
                            echo "<p class='error-message'>" . $_SESSION['loginError'] . "</p>";
                            unset($_SESSION['loginError']);
                        }
                        ?>
                    </div>
                </div>           
            </form>
        </div>
    </div>

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
    </script>
</body>
</html>
