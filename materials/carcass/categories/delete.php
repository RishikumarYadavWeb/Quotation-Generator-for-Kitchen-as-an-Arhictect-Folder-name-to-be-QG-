<?php
include '../../../includes/auth.php';
include '../../../db.php';
if(!can('carcass_delete')){
    die('Access Denied');
}
/** @var mysqli $conn */
$id = (int) ($_GET['id'] ?? 0);
mysqli_query(
    $conn,
    "DELETE FROM carcass_categories
    WHERE id = '$id'"
);
header('Location: manage.php');