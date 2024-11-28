<?php
session_start(); // Start the session to use $_SESSION
include 'db.php'; // Database connection

$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? ''; // Get the status from the query string

// Prepare the SQL with placeholders for dynamic data
$sql = "SELECT v.visitor_id, v.visitor_name, v.phone_number, v.nric, v.vehicle_registration_number, v.company_name, v.number_of_visitors, v.purpose_of_visit, v.date_of_visit, v.time_of_visit, v.registration_timestamp, v.status, v.comments, r.full_name, r.email, r.unit_number
        FROM visitors v
        JOIN resident_account r ON v.resident_id = r.resident_id
        WHERE (v.visitor_name LIKE :search
            OR r.full_name LIKE :search
            OR r.unit_number LIKE :search
            OR v.purpose_of_visit LIKE :search
            OR v.date_of_visit LIKE :search
            OR v.time_of_visit LIKE :search)";

if ($status) {
    $sql .= " AND v.status = :status"; // Add a condition for the status
}

$sql .= " ORDER BY v.registration_timestamp DESC"; // Ensure results are sorted by date

$stmt = $pdo->prepare($sql);
$searchTerm = "%{$search}%";
$stmt->bindParam(':search', $searchTerm);

if ($status) {
    $stmt->bindParam(':status', $status); // Bind the status parameter if it is not empty
}

$stmt->execute(); // Execute the query
$visitors = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'search_visitor_layout.php'; // Include a layout file to render the results
?>
