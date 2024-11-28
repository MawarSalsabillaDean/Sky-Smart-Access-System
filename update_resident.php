<?php
include 'db.php'; // Database connection

if ($_POST) {
    // Extract and sanitize the data
    $resident_id = isset($_POST['resident_id']) ? $_POST['resident_id'] : null;
    $full_name = isset($_POST['full_name']) ? $_POST['full_name'] : '';
    $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';
    $unit_number = isset($_POST['unit_number']) ? $_POST['unit_number'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $ic_number = isset($_POST['ic_number']) ? $_POST['ic_number'] : '';
    $age = isset($_POST['age']) ? intval($_POST['age']) : 0;  // Ensure default to 0 if not provided
    $gender = isset($_POST['gender']) ? $_POST['gender'] : 'Not Specified';
    $race = isset($_POST['race']) ? $_POST['race'] : 'Not Specified';
    $number_of_occupants = isset($_POST['number_of_occupants']) ? intval($_POST['number_of_occupants']) : 0;

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();

        // Update or insert into resident_account
        $stmt = $pdo->prepare("UPDATE resident_account SET full_name = ?, phone_number = ?, unit_number = ?, email = ? WHERE resident_id = ?");
        $stmt->execute([$full_name, $phone_number, $unit_number, $email, $resident_id]);

        // Check if profile exists
        $profile_check = $pdo->prepare("SELECT 1 FROM resident_profile WHERE resident_id = ?");
        $profile_check->execute([$resident_id]);
        $exists = $profile_check->fetchColumn();

        if ($exists) {
            // Update existing profile
            $stmt_profile = $pdo->prepare("UPDATE resident_profile SET ic_number = ?, age = ?, gender = ?, race = ?, number_of_occupants = ? WHERE resident_id = ?");
            $stmt_profile->execute([$ic_number, $age, $gender, $race, $number_of_occupants, $resident_id]);
        } else {
            // Insert new profile
            $stmt_profile = $pdo->prepare("INSERT INTO resident_profile (resident_id, ic_number, age, gender, race, number_of_occupants) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt_profile->execute([$resident_id, $ic_number, $age, $gender, $race, $number_of_occupants]);
        }

        $pdo->commit();
        echo "<script>alert('Update successful!'); window.location.href='userdata_management.php';</script>";
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "<script>alert('Update failed: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('No data to process!'); window.history.back();</script>";
}
?>
