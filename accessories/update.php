<?php
include '../db.php';
/** @var mysqli $conn */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid Request');
}

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
    die('Invalid Accessory ID');
}

$categoryId = (int)($_POST['category_id'] ?? 0);
$makeId     = (int)($_POST['make_id'] ?? 0);
$unitId     = (int)($_POST['unit_id'] ?? 0);

$materialName = mysqli_real_escape_string(
    $conn,
    trim($_POST['material_name'] ?? '')
);

$price = (float)($_POST['price'] ?? 0);
$status = (int)($_POST['status'] ?? 1);

if (
    $categoryId <= 0 ||
    $makeId <= 0 ||
    $unitId <= 0 ||
    empty($materialName)
) {
    die('Please fill all required fields.');
}

mysqli_query(
    $conn,
    "
    UPDATE accessories
    SET
        category_id = '$categoryId',
        make_id = '$makeId',
        unit_id = '$unitId',
        material_name = '$materialName',
        price = '$price',
        status = '$status'
    WHERE id = '$id'
    LIMIT 1
    "
);

header('Location: manage.php');
exit;