<?php
    require '../db.php';
    /** @var mysqli $conn */
    if(
        !isset($_POST['category_id']) ||
        empty($_POST['category_id'])
    ){
        exit;
    }
    $categoryId = (int) $_POST['category_id'];
    $query = mysqli_query(
        $conn,
        "
        SELECT
            id,
            material_type,
            price_per_sqft
        FROM shutter_materials
        WHERE category_id = '$categoryId'
        AND status = 1
        ORDER BY material_type ASC
        "
    );
    while($row = mysqli_fetch_assoc($query)){
?>
    <option value="<?= $row['id'] ?>" data-price="<?= $row['price_per_sqft'] ?>"><?= $row['material_type'] ?></option>
<?php } ?>