<?php
if(!can('shelves_create')){
    die('Access Denied');
}
include '../db.php';
/** @var mysqli $conn */
$id = (int) ($_GET['id'] ?? 0);
$status = (int) ($_GET['status'] ?? 0);
mysqli_query(
    $conn,
    "UPDATE shelf_materials
    SET status = '$status'
    WHERE id = '$id'"
);
header('Location: manage.php');
?>