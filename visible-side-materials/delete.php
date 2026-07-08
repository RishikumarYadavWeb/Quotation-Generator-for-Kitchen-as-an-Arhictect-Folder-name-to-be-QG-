<?php
include '../includes/auth.php';
include '../db.php';

/** @var mysqli $conn */

if(!can('visible_side_delete')){
    die('Access Denied');
}

$id = (int)($_GET['id'] ?? 0);

if($id <= 0){
    die('Invalid Material');
}

mysqli_query(
    $conn,
    "
    DELETE FROM visible_side_materials
    WHERE id = '$id'
    "
);

header('Location: manage.php');
exit;