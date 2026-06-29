<?php
    require '../db.php';
    /** @var mysqli $conn */
    $query = mysqli_query(
        $conn,
        "
        SELECT
            id,
            category_name
        FROM shelf_categories
        WHERE status = 1
        ORDER BY category_name ASC
        "
    );
    while($row = mysqli_fetch_assoc($query)){
?>
    <option value="<?= $row['id'] ?>">
        <?= $row['category_name'] ?>
    </option>
<?php } ?>