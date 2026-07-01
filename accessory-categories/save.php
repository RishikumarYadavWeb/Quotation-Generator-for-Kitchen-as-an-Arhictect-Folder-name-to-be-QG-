<?php
include '../db.php';
/** @var mysqli $conn */
$categoryName = mysqli_real_escape_string($conn,$_POST['category_name']);
$status = (int)$_POST['status'];
mysqli_query(
    $conn,
    "
    INSERT INTO accessory_categories(
        category_name,
        status
    )
    VALUES(
        '$categoryName',
        '$status'
    )
    "
);
header('Location: manage.php');
exit;