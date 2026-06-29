
<?php
    include '../../../db.php';
    /** @var mysqli $conn */
    $id = (int) ($_POST['id'] ?? 0);
    $category_id = (int) ($_POST['category_id'] ?? 0);
    $material_type = (int) ($_POST['material_type'] ?? 0);
    $price_per_sqft = (float) ($_POST['price_per_sqft'] ?? 0);
    $query =
        "UPDATE shutter_materials 
        SET
        category_id='$category_id',
        material_type='$material_type',
        price_per_sqft='$price_per_sqft'
        WHERE id='$id'";
    mysqli_query($conn, $query);
    header("Location: manage.php");
?>