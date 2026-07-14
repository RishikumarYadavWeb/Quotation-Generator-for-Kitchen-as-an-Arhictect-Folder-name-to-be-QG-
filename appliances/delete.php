<?php
include '../includes/auth.php';
include '../db.php';
if(!can('appliances_delete')){
    die('Access Denied');
}
/** @var mysqli $conn */
$id = (int)($_GET['id'] ?? 0);
if($id <= 0){
    die('Invalid Appliance ID');
}
mysqli_query(
    $conn,
    "
    DELETE
    FROM appliances
    WHERE id = '$id'
    LIMIT 1
    "
);
header('Location: manage.php');
exit;