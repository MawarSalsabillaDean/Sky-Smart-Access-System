<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $vehicleId = $_POST['vehicle_id'];
    $status = $_POST['status'];
    $comments = $_POST['comments'] ?? '';

    $updateSql = "UPDATE vehicles SET status = ?, comments = ? WHERE vehicle_id = ?";
    $updateStmt = $pdo->prepare($updateSql);
    if ($updateStmt->execute([$status, $comments, $vehicleId])) {
        $_SESSION['message'] = "Update successful!";
    } else {
        $_SESSION['message'] = "Update failed!";
    }
    
    header("Location: parking_management.php");
    exit();
}
