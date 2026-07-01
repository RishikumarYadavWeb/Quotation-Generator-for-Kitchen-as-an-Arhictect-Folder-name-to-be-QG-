<?php
include '../../../db.php';
/** @var mysqli $conn */
$id = (int) ($_POST['id'] ?? 0);
$category_name = trim($_POST['category_name'] ?? '');
$status = (int)($_POST['status'] ?? 1);
mysqli_query(
    $conn,
    "UPDATE carcass_categories
    SET
        category_name = '$category_name',
        status = '$status'
    WHERE id = '$id'"
);
header('Location: manage.php');