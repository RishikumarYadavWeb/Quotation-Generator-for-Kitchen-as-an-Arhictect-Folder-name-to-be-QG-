<?php
require '../db.php';
/** @var mysqli $conn */
$categoryId = (int)($_POST['category_id'] ?? 0);
$query = mysqli_query(
    $conn,
    "
    SELECT
        id,
        accessory_name,
        price
    FROM accessories
    WHERE category_id = '$categoryId'
    AND status = 'active'
    ORDER BY accessory_name
    "
);
while($row = mysqli_fetch_assoc($query)){
    echo
        '<option value="'.$row['id'].'" data-price="'.$row['price'].'">'.htmlspecialchars($row['accessory_name']).'</option>';
}