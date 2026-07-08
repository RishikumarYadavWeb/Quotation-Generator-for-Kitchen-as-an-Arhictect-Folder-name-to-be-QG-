<?php
include '../db.php';

/** @var mysqli $conn */

$category_id = (int)($_POST['category_id'] ?? 0);
$material_name = trim($_POST['material_name'] ?? '');
$price_per_sqft = (float)($_POST['price_per_sqft'] ?? 0);

mysqli_query(
    $conn,
    "
    INSERT INTO visible_side_materials(
        category_id,
        material_name,
        price_per_sqft
    ) VALUES(
        '$category_id',
        '$material_name',
        '$price_per_sqft'
    )
    "
);

header('Location: manage.php');
exit;