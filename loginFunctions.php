<?php
include 'db.php'; // Ensure this file contains your database connection settings

// Function to verify user credentials and handle session
function checkLogin($email, $password) {
    global $pdo;

    // Prepare and execute query to check if the user exists
    $stmt = $pdo->prepare("SELECT resident_id, password FROM resident_account WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // User authenticated
        session_regenerate_id();  // Regenerate session ID to prevent session fixation
        $_SESSION['user_email'] = $email;
        $_SESSION['resident_id'] = $user['resident_id'];

        // Update last login and record the login
        updateLastLogin($user['resident_id']);
        recordLogin($user['resident_id']);

        return true; // Successful login
    }

    return false; // Login failed
}

// Function to update last login time
function updateLastLogin($residentId) {
    global $pdo;
    $updateStmt = $pdo->prepare("UPDATE resident_account SET last_login = NOW() WHERE resident_id = ?");
    $updateStmt->execute([$residentId]);
}

// Function to record login into login_history table
function recordLogin($residentId) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO login_history (resident_id, login_time) VALUES (?, NOW())");
    $stmt->execute([$residentId]);
}

?>
