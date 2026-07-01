<?php
include '../db.php';
/** @var mysqli $conn */
$id = (int)$_POST['id'];
$categoryName = mysqli_real_escape_string($conn,$_POST['category_name']);
$status = (int)($_POST['status'] ?? 1);
mysqli_query(
    $conn,
    "
    UPDATE standard_accessory_categories
    SET
        category_name = '$categoryName',
        status = '$status'
    WHERE id = '$id'
    "
);
header('Location: index.php');
exit;