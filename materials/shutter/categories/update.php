<?php
    include '../../../db.php';
    /** @var mysqli $conn */
    $id = (int) ($_POST['id'] ?? 0);
    $category_name = trim($_POST['category_name'] ?? '');
    $query =
    "UPDATE shutter_categories SET
    category_name='$category_name'
    WHERE id='$id'";
    mysqli_query($conn, $query);
    header("Location: manage.php");
?>