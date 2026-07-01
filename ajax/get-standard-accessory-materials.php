<?php
require '../db.php';
/** @var mysqli $conn */
$category_id = (int)($_POST['category_id'] ?? 0);
$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM standard_accessory_materials
    WHERE category_id='$category_id'
    AND status=1
    ORDER BY material_name ASC
    "
);
while($row = mysqli_fetch_assoc($query)){
    echo '
    <option value="'.$row['id'].'" data-price="'.$row['price'].'">'.$row['material_name'].'</option>';
}