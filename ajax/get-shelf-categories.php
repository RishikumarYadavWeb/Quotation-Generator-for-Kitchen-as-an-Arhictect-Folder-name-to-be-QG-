<?php

include '../db.php';
/** @var mysqli $conn */

$unitType = $_GET['unit_type'] ?? '';

$sql = "
SELECT *
FROM shelf_categories
WHERE status = 1
";

switch($unitType){

    case 'Tall':
        $sql .= " AND category_name LIKE 'Tall%'";
        break;

    case 'Upper':
        $sql .= " AND category_name LIKE 'Wall%'";
        break;

    case 'Bottom':
        $sql .= " AND category_name LIKE 'Base%'";
        break;

    case 'Loft':
        $sql .= " AND category_name LIKE 'Wall%'";
        break;

}

$sql .= " ORDER BY category_name ASC";

$query = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($query)){

?>

<option value="<?= $row['id'] ?>">
    <?= htmlspecialchars($row['category_name']) ?>
</option>

<?php } ?>