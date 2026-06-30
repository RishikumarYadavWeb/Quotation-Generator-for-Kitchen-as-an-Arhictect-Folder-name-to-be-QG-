<?php
include '../db.php';
/** @var mysqli $conn */
$id = (int)$_POST['id'];
$categoryName = mysqli_real_escape_string($conn,$_POST['category_name']);
$status = (int)$_POST['status'];
mysqli_query(
    $conn,
    "
    UPDATE accessory_categories
    SET
        category_name = '$categoryName',
        status = '$status'
    WHERE id = '$id'
    "
);
header('Location: manage.php');
exit;