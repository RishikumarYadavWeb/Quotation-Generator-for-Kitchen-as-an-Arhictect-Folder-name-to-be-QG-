<?php
    include '../../../db.php';
    /** @var mysqli $conn */
    $id = (int) ($_GET['id'] ?? 0);
    $status = (int) ($_GET['status'] ?? 0);
    $query = "UPDATE shutter_categories SET status='$status' WHERE id='$id'";
    mysqli_query($conn, $query);
    header("Location: manage.php");
?>