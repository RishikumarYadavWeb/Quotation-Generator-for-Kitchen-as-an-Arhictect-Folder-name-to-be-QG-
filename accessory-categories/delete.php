<?php
include '../db.php';
if(!can('accessories_category_delete')){
    die('Access Denied');
}
/** @var mysqli $conn */
$id = (int)$_GET['id'];
mysqli_query(
    $conn,
    "
    DELETE
    FROM accessory_categories
    WHERE id = '$id'
    "
);
header('Location: manage.php');
exit;