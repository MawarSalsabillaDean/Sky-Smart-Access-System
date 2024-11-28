<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $complaintId = $_POST['complaint_id'];
    $status = $_POST['status'];
    $comment = $_POST['comment'] ?? '';

    $updateSql = "UPDATE complaints SET status = ?, comment = ? WHERE complaint_id = ?";
    $updateStmt = $pdo->prepare($updateSql);
    if ($updateStmt->execute([$status, $comment, $complaintId])) {
        $_SESSION['message'] = "Update successful!";
    } else {
        $_SESSION['message'] = "Update failed!";
    }
    
    header("Location: report_management.php");
    exit();
}
