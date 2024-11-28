<?php
session_start(); // Start the session to use $_SESSION
include 'db.php'; // Database connection

$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? ''; // Get the status from the query string

$sql = "SELECT c.complaint_id, c.problem_title, c.date_occurrence, c.time_occurrence, c.problem_desc, c.image_path, c.submitted_at, c.status, c.comment, r.full_name, r.email, r.unit_number
        FROM complaints c
        JOIN resident_account r ON c.resident_id = r.resident_id
        WHERE (c.problem_title LIKE :search
            OR r.full_name LIKE :search
            OR r.unit_number LIKE :search
            OR c.problem_desc LIKE :search
            OR c.date_occurrence LIKE :search
            OR c.time_occurrence LIKE :search)";

if ($status) {
    $sql .= " AND c.status = :status"; // Add a condition for the status
}

$sql .= " ORDER BY c.submitted_at DESC"; // Place ORDER BY after all WHERE conditions

$stmt = $pdo->prepare($sql);
$searchTerm = "%{$search}%";
$stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);

if ($status) {
    $stmt->bindParam(':status', $status, PDO::PARAM_STR); // Bind the status parameter if it is not empty
}

$stmt->execute(); // Execute the query
$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'search_complaints_layout.php'; // Include a layout file to render the results

?>
