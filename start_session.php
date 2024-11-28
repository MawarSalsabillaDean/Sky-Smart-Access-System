<?php
session_start();
require 'db.php';

if (!isset($_SESSION['resident_id'])) {
    header("Location: resident_login.php"); // Redirect back to login if the session isn't set
    exit;
}
// Continue with the script if the session variable exists
$amenity_name = $_GET['amenity_name'];
$resident_id = $_SESSION['resident_id'];

$stmt = $pdo->prepare("INSERT INTO amenity_usage (resident_id, amenity_name, start_time) VALUES (?, ?, NOW())");
$stmt->execute([$resident_id, $amenity_name]);
$session_id = $pdo->lastInsertId();

header("Location: amenities_timer.php?session_id=$session_id");
exit;
?>
