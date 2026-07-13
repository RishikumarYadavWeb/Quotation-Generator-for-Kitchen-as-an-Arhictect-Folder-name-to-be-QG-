<?php
include '../db.php';
/** @var mysqli $conn */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid Request');
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
    INSERT INTO accessories
    (
        category_id,
        make_id,
        unit_id,
        material_name,
        price,
        status
    )
    VALUES
    (
        '$categoryId',
        '$makeId',
        '$unitId',
        '$materialName',
        '$price',
        '$status'
    )
    "
);

header('Location: manage.php');
exit;