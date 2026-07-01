<?php
include '../includes/auth.php';
include '../db.php';
/** @var mysqli $conn */
if(!can('shelves_delete')){
    die('Access Denied');
}
$id = (int)($_GET['id'] ?? 0);

if($id <= 0){
    die('Invalid Category');
}
$check = mysqli_query(
    $conn,
    "
    SELECT COUNT(*) AS total
    FROM shelf_materials
    WHERE category_id = '$id'
    "
);
$used = mysqli_fetch_assoc($check);
if($used['total'] > 0){
    echo "
    <script>
        alert('Cannot delete this category because it is assigned to one or more shelf materials.');
        window.location='manage.php';
    </script>";
    exit;
}
mysqli_query(
    $conn,
    "
    DELETE FROM shelf_categories
    WHERE id = '$id'
    "
);
header("Location: manage.php");
exit;