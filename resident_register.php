<?php
session_start(); // Start the session to use session variables

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ssas";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    $_SESSION['registerMessage'] = 'Connection failed: ' . $conn->connect_error;
    header("Location: resident_register.php"); // Redirect to the registration page
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT email FROM resident_account WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        $_SESSION['registerMessage'] = 'Email already exists. Please use a different email.';
        header("Location: resident_register.php");
        $checkEmail->close();
        exit();
    }
    $checkEmail->close();

    // Insert new account data into the database
    $fullName = $conn->real_escape_string($_POST['fullName']);
    $phoneNumber = $conn->real_escape_string($_POST['phoneNumber']);
    $unitNumber = $conn->real_escape_string($_POST['unitNumber']);
    $password = $conn->real_escape_string($_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO resident_account (full_name, phone_number, unit_number, email, password) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssss", $fullName, $phoneNumber, $unitNumber, $email, $hashedPassword);
        if ($stmt->execute()) {
            $_SESSION['registerMessage'] = 'Registration successful. Please log in.';
        } else {
            $_SESSION['registerMessage'] = 'Error: ' . $stmt->error;
        }        
        $stmt->close();
    } else {
        $_SESSION['registerMessage'] = 'Error preparing statement: ' . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="resident_register.css">
</head>
<body>
    <div class="form-container">
        <div class="col col-1">
            <div class="image-layer">
                <img src="pictures/woman working.png" class="form-image-main">
            </div>
            <p class="featured-words">Let’s get you set up! Register to access all our features and more.</p>
        </div>

        <div class="col col-2">
            <form method="POST" action="resident_register.php">
                <div class="btn-box">
                    <button type="button" class="btn btn-1" id="login" onclick="goToPage('resident_login.php')">Sign In</button>
                    <button type="button" class="btn btn-2" id="register">Sign Up</button>
                </div>

                <div class="login-form">
                    <div class="form-title">
                        <span>Create An Account</span>
                    </div>
                    <div class="form-inputs">
                        <div class="input-box">
                            <input type="text" class="input-field" name="fullName" placeholder="Full Name" required>
                            <i class="bx bx-user icon"></i>
                        </div>
                        <div class="input-box">
                            <input type="text" class="input-field" name="phoneNumber" placeholder="No Phone" required>
                            <i class="bx bx-phone icon"></i>
                        </div>
                        <div class="input-box">
                            <input type="text" class="input-field" name="unitNumber" placeholder="Unit Number" required>
                            <i class="bx bx-home icon"></i>
                        </div>
                        <div class="input-box">
                            <input type="email" class="input-field" name="email" placeholder="Email" required>
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
                                <span>Sign Up</span>
                                <i class="bx bx-right-arrow-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        window.onload = function() {
            // Check if there is a registration message to display
            <?php if (isset($_SESSION['registerMessage'])): ?>
                alert("<?= $_SESSION['registerMessage']; ?>");
                // Redirect to the login page after showing the alert
                window.location.href = 'resident_login.php';
                <?php unset($_SESSION['registerMessage']); ?>
            <?php endif; ?>
        };

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var toggleIcon = document.getElementById('toggleIcon');
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.className = 'bx bx-hide';
            } else {
                passwordInput.type = "password";
                toggleIcon.className = 'bx bx-show';
            }
        }

        function goToPage(pageUrl) {
            window.location.href = pageUrl;
        }
</script>
</body>
</html>
