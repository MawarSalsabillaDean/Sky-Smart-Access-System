<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $complaintId = $_POST['complaint_id'];
    $deleteSql = "DELETE FROM complaints WHERE complaint_id = ?";
    $deleteStmt = $pdo->prepare($deleteSql);
    $result = $deleteStmt->execute([$complaintId]);

    if ($result) {
        echo "<script>
                alert('Record deleted successfully!');
                window.location.href='report_management.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to delete record!');
                window.location.href='report_management.php';
              </script>";
    }
    exit();
}
?>
