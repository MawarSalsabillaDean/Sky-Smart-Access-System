<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $vehicleId = $_POST['vehicle_id'];
    $deleteSql = "DELETE FROM vehicles WHERE vehicle_id = ?";
    $deleteStmt = $pdo->prepare($deleteSql);
    $result = $deleteStmt->execute([$vehicleId]);

    if ($result) {
        echo "<script>
                alert('Record deleted successfully');
                window.location.href='parking_management.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to delete record');
                window.location.href='parking_management.php';
              </script>";
    }
    exit();
}
?>
