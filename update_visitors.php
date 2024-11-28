<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $visitorId = $_POST['visitor_id'];
    $status = $_POST['status'];
    $comments = $_POST['comments'] ?? '';

    $updateSql = "UPDATE visitors SET status = ?, comments = ? WHERE visitor_id = ?";
    $updateStmt = $pdo->prepare($updateSql);
    if ($updateStmt->execute([$status, $comments, $visitorId])) {
        $_SESSION['message'] = "Update successful!";
    } else {
        $_SESSION['message'] = "Update failed!";
    }
    
    header("Location: visitor_management.php");
    exit();
}
