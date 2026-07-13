<?php
include '../includes/auth.php';
include '../db.php';

/** @var mysqli $conn */

$categoryId = isset($_GET['category_id'])
    ? (int)$_GET['category_id']
    : 0;

echo '<option value="">Select Make</option>';

if ($categoryId > 0) {

    $query = mysqli_query(
        $conn,
        "
        SELECT
            id,
            make_name
        FROM accessory_makes
        WHERE
            category_id = '$categoryId'
            AND status = 1
        ORDER BY make_name ASC
        "
    );

    while ($row = mysqli_fetch_assoc($query)) {

        echo '
            <option value="' . $row['id'] . '">
                ' . htmlspecialchars($row['make_name']) . '
            </option>
        ';
    }
}