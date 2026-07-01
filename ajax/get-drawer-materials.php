<?php
include '../db.php';
/** @var mysqli $conn */
if(
    !isset($_POST['category_id']) ||
    empty($_POST['category_id'])
){
    exit;
}
$category_id = (int) $_POST['category_id'];
$query = mysqli_query(
    $conn,
    "
    SELECT
        id,
        material_name,
        price_per_sqft
    FROM drawer_materials
    WHERE category_id = '$category_id'
    AND status = 1
    ORDER BY material_name ASC
    "
);
if(mysqli_num_rows($query) > 0){
while($row = mysqli_fetch_assoc($query)){
?>
    <option value="<?= $row['id'] ?>" data-price="<?= $row['price_per_sqft'] ?>"><?= $row['material_name'] ?></option>
<?php }
}else{ ?>
    <option value="">No Material Found</option>
<?php } ?>