<?php
session_start();
include 'db.php'; // Ensure this file sets up $pdo correctly

function insertVisitor($data) {
    global $pdo;
    $sql = "INSERT INTO visitors (
        resident_id, visitor_name, phone_number, nric, vehicle_registration_number, 
        company_name, number_of_visitors, purpose_of_visit, date_of_visit, time_of_visit, status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([
            $data['resident_id'],
            $data['visitor_name'],
            $data['phone_number'],
            $data['nric'],
            $data['vehicle_registration_number'],
            $data['company_name'],
            $data['number_of_visitors'],
            $data['purpose_of_visit'],
            $data['date_of_visit'],
            $data['time_of_visit']
        ]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return 'Database error: ' . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    $visitorData = [
        'resident_id' => $_SESSION['resident_id'] ?? null, // Assuming resident_id is stored in session upon login
        'visitor_name' => $_POST['visitor_name'] ?? null,
        'phone_number' => $_POST['phone_number'] ?? null,
        'nric' => $_POST['nric'] ?? null,
        'vehicle_registration_number' => $_POST['vehicle_registration_number']  ?? null,
        'company_name' => $_POST['company_name'] ?? null,
        'number_of_visitors' => $_POST['number_of_visitors'] ?? null,
        'purpose_of_visit' => $_POST['purpose_of_visit'] ?? null,
        'date_of_visit' => $_POST['date_of_visit'] ?? null,
        'time_of_visit' => $_POST['time_of_visit'] ?? null
    ];

    // Check for null values which are mandatory
    if (in_array(null, $visitorData, true)) {
        echo "<script>alert('All fields must be filled.'); window.history.back();</script>";
    } else {
        // Proceed with inserting into the database
        $result = insertVisitor($visitorData);
        if (is_numeric($result)) {
            echo "<script>alert('Visitor registration successful!'); window.location.href='visitor_status.php';</script>";
        } else {
            echo "<script>alert('Error registering visitor: " . $result . "'); window.history.back();</script>";
        }       
    }
}
?>

