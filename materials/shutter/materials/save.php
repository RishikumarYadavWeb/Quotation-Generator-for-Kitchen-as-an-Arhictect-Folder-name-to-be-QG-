<?php
    include '../../../db.php';
    /** @var mysqli $conn */
    $category_id = (int) ($_POST['category_id'] ?? 0);
    $material_type = (int) ($_POST['material_type'] ?? 0);
    $price_per_sqft = (float) ($_POST['price_per_sqft'] ?? 0);
    /* CHECK DUPLICATE */
    $checkQuery = "SELECT id FROM shutter_materials WHERE category_id='$category_id' AND material_type='$material_type'";
    $checkResult = mysqli_query($conn, $checkQuery);
    if(mysqli_num_rows($checkResult) > 0){
        echo "
            <script>
                alert('Material already exists in this category');
                window.location='material.php';
            </script>
        ";
        exit;
    }
    /* INSERT */
    $query =
    "INSERT INTO shutter_materials
    (
        category_id,
        material_type,
        price_per_sqft
    )

    VALUES

    (
        '$category_id',
        '$material_type',
        '$price_per_sqft'
    )";
    mysqli_query($conn, $query);
    header("Location: manage.php");
?>