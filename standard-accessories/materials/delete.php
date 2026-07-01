<?php
include '../../includes/auth.php';
include '../../db.php';
if(!can('standard_accessories_delete')){
    die('Access Denied');
}
/** @var mysqli $conn */
$id=(int)$_GET['id'];
mysqli_query(
    $conn,
    "
    DELETE FROM
    standard_accessory_materials
    WHERE id='$id'
    "
);
header('Location:index.php');
