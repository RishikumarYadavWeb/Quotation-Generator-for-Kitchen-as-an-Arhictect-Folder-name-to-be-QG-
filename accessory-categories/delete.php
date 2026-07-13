<?php
include '../includes/auth.php';
include '../db.php';

if (!can('accessories_category_delete')) {
    die('Access Denied');
}

/** @var mysqli $conn */

$id = (int)$_GET['id'];

/* Check Accessory Makes */
$makeCheck = mysqli_query(
    $conn,
    "
    SELECT COUNT(*) AS total
    FROM accessory_makes
    WHERE category_id = '$id'
    "
);

$makeCount = mysqli_fetch_assoc($makeCheck)['total'];

/* Check Accessory Materials */
$materialCheck = mysqli_query(
    $conn,
    "
    SELECT COUNT(*) AS total
    FROM accessory_materials
    WHERE category_id = '$id'
    "
);

$materialCount = mysqli_fetch_assoc($materialCheck)['total'];

if ($makeCount > 0 || $materialCount > 0) {

    echo "
    <script>
        alert('Cannot delete this category because it is linked with accessory makes or materials.');
        window.location='manage.php';
    </script>
    ";

    exit;
}

/* Delete Category */
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