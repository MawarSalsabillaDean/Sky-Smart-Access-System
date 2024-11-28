<?php
include 'db.php'; // Include your database connection

$search = $_GET['search'] ?? ''; // Get the search term from the query string

try {
    $query = "
        SELECT 
            a.announcement_id, 
            a.title, 
            a.file_name, 
            a.send_to_all, 
            a.created_at, 
            GROUP_CONCAT(ra.unit_number ORDER BY ra.unit_number SEPARATOR ', ') AS unit_numbers
        FROM 
            announcements a
            LEFT JOIN announcement_units au ON a.announcement_id = au.announcement_id
            LEFT JOIN resident_account ra ON au.resident_id = ra.resident_id
        WHERE 
            a.title LIKE :search OR ra.unit_number LIKE :search
        GROUP BY 
            a.announcement_id
        ORDER BY 
            a.created_at DESC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['search' => '%' . $search . '%']); // Bind the search term with wildcards for partial matching
    $announcements = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

include 'search_announcements_layout.php'; // Include the layout file to display the results
?>

