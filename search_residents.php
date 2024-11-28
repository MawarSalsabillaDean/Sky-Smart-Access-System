<?php
include 'db.php'; // Include your database connection

$search = $_GET['search'] ?? ''; // Get the search term from the URL

// Prepare a SQL query to search the resident database including additional fields
$sql = "
    SELECT a.resident_id, a.full_name, a.phone_number, a.unit_number, a.email, 
               p.ic_number, p.age, p.gender, p.race, p.number_of_occupants
    FROM resident_account a
    LEFT JOIN resident_profile p ON a.resident_id = p.resident_id
    WHERE a.full_name LIKE :search OR 
          a.phone_number LIKE :search OR 
          a.unit_number LIKE :search OR 
          p.ic_number LIKE :search OR 
          p.race LIKE :search OR 
          p.gender LIKE :search
    ORDER BY a.created_at DESC"; // You can sort by name or any other attribute

$stmt = $pdo->prepare($sql);
$searchTerm = "%{$search}%";
$stmt->bindParam(':search', $searchTerm);
$stmt->execute();
$residents = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'search_residents_layout.php'; // Include a layout file that will render these results
?>
