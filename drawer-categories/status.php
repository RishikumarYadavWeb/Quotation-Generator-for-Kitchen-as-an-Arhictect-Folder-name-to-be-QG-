<?php
    include '../db.php';
    /** @var mysqli $conn */
    $id = (int) ($_GET['id'] ?? 0);
    $status = (int) ($_GET['status'] ?? 0);
    mysqli_query($conn,"UPDATE drawer_categories SET status = '$status' WHERE id = '$id'");
    header('Location: manage.php');
?>