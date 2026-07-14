<?php
include '../includes/auth.php';
include '../db.php';
if(!can('appliances_edit')){
    die('Access Denied');
}
/** @var mysqli $conn */
if($_SERVER['REQUEST_METHOD'] != 'POST'){
    die('Invalid Request');
}
$id = (int)($_POST['id'] ?? 0);
$price = (float)($_POST['price'] ?? 0);
$status = (int)($_POST['status'] ?? 1);
if($id <= 0){
    die('Invalid Appliance ID');
}
if($price <= 0){
    die('Invalid Price');
}
mysqli_query(
    $conn,
    "
    UPDATE appliances
    SET
        price = '$price',
        status = '$status'
    WHERE id = '$id'
    LIMIT 1
    "
);
header('Location: manage.php');
exit;