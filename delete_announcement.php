<?php
session_start();
include 'db.php';

$announcementId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($announcementId > 0) {
    try {
        $pdo->beginTransaction();

        $stmtUnits = $pdo->prepare("DELETE FROM announcement_units WHERE announcement_id = ?");
        $stmtUnits->execute([$announcementId]);

        $stmt = $pdo->prepare("DELETE FROM announcements WHERE announcement_id = ?");
        $stmt->execute([$announcementId]);

        $pdo->commit();
        echo "<script>alert('Announcement deleted successfully.'); window.location.href='announcements_history.php';</script>";
    } catch (PDOException $e) {
        $pdo->rollback();
        echo "<script>alert('Error deleting announcement: " . addslashes($e->getMessage()) . "'); window.location.href='announcements_history.php';</script>";
    }
} else {
    echo "<script>alert('Invalid announcement ID.'); window.location.href='announcements_history.php';</script>";
}
exit;
?>
