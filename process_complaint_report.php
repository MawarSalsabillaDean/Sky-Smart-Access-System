<?php
// Database insertion script
include 'db.php';

$resident_id = $_SESSION['resident_id'];  // Make sure this is already set in the session
$problem_title = $_POST['problem_title'];
$date_occurrence = $_POST['date_occurrence'];
$time_occurrence = $_POST['time_occurrence'];
$problem_desc = $_POST['problem_desc'];
$image_path = $_POST['image_path'] = $targetFilePath;  // Assign the target file path from the form handling script

// Prepare the SQL statement
$sql = "INSERT INTO complaints (resident_id, problem_title, date_occurrence, time_occurrence, problem_desc, image_path) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$resident_id, $problem_title, $date_occurrence, $time_occurrence, $problem_desc, $image_path]);

if($stmt->rowCount()) {
    echo "<script>alert('Complaint submitted successfully!'); window.location.href='complaint_status.php';</script>";
} else {
    echo "<script>alert('Error submit the complaint.'); window.history.back();</script>";
}
?>
