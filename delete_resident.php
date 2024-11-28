<?php
include 'db.php'; // Include your database connection

if (isset($_GET['resident_id'])) {
    $resident_id = $_GET['resident_id'];

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Begin Transaction
        $pdo->beginTransaction();

        // Delete records from amenity_usage first
        $stmt_amenity_usage = $pdo->prepare("DELETE FROM amenity_usage WHERE resident_id = ?");
        $stmt_amenity_usage->execute([$resident_id]);

        // Delete profile (if necessary)
        $stmt_profile = $pdo->prepare("DELETE FROM resident_profile WHERE resident_id = ?");
        $stmt_profile->execute([$resident_id]);

        // Then delete the account
        $stmt_account = $pdo->prepare("DELETE FROM resident_account WHERE resident_id = ?");
        $stmt_account->execute([$resident_id]);

        // Commit the transaction
        $pdo->commit();
        
        echo "<script>alert('Deletion successful!'); window.location.href='userdata_management.php';</script>";
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "<script>alert('Deletion failed: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('No resident ID provided!'); window.history.back();</script>";
}
?>
