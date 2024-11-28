<?php
session_start();
require 'db.php';  // Ensure your database connection is correct

if (!isset($_POST['session_id'])) {
    die('Session ID is required.');  // Proper handling for missing session ID
}

$session_id = $_POST['session_id'];

// Update the end time in the database
$stmt = $pdo->prepare("UPDATE amenity_usage SET end_time = NOW() WHERE usage_id = ?");
if (!$stmt->execute([$session_id])) {
    die('Failed to record the end time.');  // Error handling if the update fails
}

// Retrieve the start time and end time to calculate duration
$stmt = $pdo->prepare("SELECT start_time, end_time FROM amenity_usage WHERE usage_id = ?");
$stmt->execute([$session_id]);
$times = $stmt->fetch();

if ($times && $times['start_time'] && $times['end_time']) {
    $start_time = new DateTime($times['start_time']);
    $end_time = new DateTime($times['end_time']);
    $duration = $start_time->diff($end_time);  // Calculate duration
    $duration_seconds = ($duration->days * 24 * 60 * 60) + 
                        ($duration->h * 60 * 60) + 
                        ($duration->i * 60) + 
                        $duration->s;  // Convert duration to total seconds

    // Update the duration in the database
    $stmt = $pdo->prepare("UPDATE amenity_usage SET duration = ? WHERE usage_id = ?");
    if (!$stmt->execute([$duration_seconds, $session_id])) {
        die('Failed to update the duration.');  // Error handling if the update fails
    }
} else {
    die('Failed to retrieve times for duration calculation.');  // Error handling if times cannot be fetched
}

// Redirect to the history page after all operations
header("Location: amenities_access_history.php");
exit;
?>
