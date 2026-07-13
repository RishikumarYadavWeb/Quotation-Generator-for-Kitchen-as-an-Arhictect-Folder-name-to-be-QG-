<?php
require '../db.php';
/** @var mysqli $conn */

$categoryId = (int)($_POST['category_id'] ?? 0);
$makeId = (int)($_POST['make_id'] ?? 0);

$query = mysqli_query(
    $conn,
    "
    SELECT
        id,
        material_name,
        price
    FROM accessories
    WHERE
        category_id = '$categoryId'
        AND make_id = '$makeId'
        AND status = 1
    ORDER BY material_name ASC
    "
);

while ($row = mysqli_fetch_assoc($query)) {

    echo '
        <option
            value="'.$row['id'].'"
            data-price="'.$row['price'].'">

            '.htmlspecialchars($row['material_name']).'

        </option>
    ';
}