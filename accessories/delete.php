<?php
include '../includes/auth.php';
include '../db.php';

/** @var mysqli $conn */

if (!can('accessories_delete')) {
    die('Access Denied');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die('Invalid Accessory ID');
}

$check = mysqli_query(
    $conn,
    "
    SELECT id
    FROM accessories
    WHERE id = '$id'
    "
);

if (mysqli_num_rows($check) == 0) {
    die('Accessory Not Found');
}

mysqli_query(
    $conn,
    "
    DELETE
    FROM accessories
    WHERE id = '$id'
    LIMIT 1
    "
);

header('Location: manage.php');
exit;