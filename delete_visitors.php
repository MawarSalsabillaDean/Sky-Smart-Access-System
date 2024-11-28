<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $visitorId = $_POST['visitor_id'];
    $deleteSql = "DELETE FROM visitors WHERE visitor_id = ?";
    $deleteStmt = $pdo->prepare($deleteSql);
    $result = $deleteStmt->execute([$visitorId]);

    if ($result) {
        echo "<script>
                alert('Record deleted successfully');
                window.location.href='visitor_management.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to delete record');
                window.location.href='visitor_management.php';
              </script>";
    }
    exit();
}
?>
