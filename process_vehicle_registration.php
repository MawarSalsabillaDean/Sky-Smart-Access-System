<?php
// Database insertion script
include 'db.php';

$resident_id = $_SESSION['resident_id'];  // Make sure this is already set in the session
$brand = $_POST['brand'];
$model = $_POST['model'];
$car_color = $_POST['car_color'];
$vehicle_registration_number = $_POST['vehicle_registration_number'];
$vehicle_type = $_POST['vehicle_type'];
$parking_spot = $_POST['parking_spot'];
$image_path = $_POST['image_path'] = $targetFilePath;  // Assign the target file path from the form handling script

// Prepare the SQL statement
$sql = "INSERT INTO vehicles (resident_id, brand, model, car_color, vehicle_registration_number, vehicle_type, parking_spot, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$resident_id, $brand, $model, $car_color, $vehicle_registration_number, $vehicle_type, $parking_spot, $image_path]);

if($stmt->rowCount()) {
    echo "<script>alert('Vehicle registered successfully!'); window.location.href='vehicle_status.php';</script>";
} else {
    echo "<script>alert('Error registering vehicle.'); window.history.back();</script>";
}
?>
