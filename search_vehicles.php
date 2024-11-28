<?php
session_start(); // Start the session to use $_SESSION
include 'db.php'; // Database connection

$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? ''; // Get the status from the query string

// Prepare the SQL with placeholders for dynamic data
$sql = "SELECT v.vehicle_id, v.brand, v.model, v.car_color, v.vehicle_registration_number, v.vehicle_type, v.parking_spot, v.image_path, v.registration_timestamp, v.status, v.comments, r.full_name, r.email, r.unit_number
        FROM vehicles v
        JOIN resident_account r ON v.resident_id = r.resident_id
        WHERE (v.brand LIKE :search
            OR r.full_name LIKE :search
            OR r.unit_number LIKE :search
            OR v.model LIKE :search
            OR v.vehicle_type LIKE :search
            OR v.parking_spot LIKE :search)";

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
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'search_vehicle_layout.php'; // Include a layout file to render the results
?>
