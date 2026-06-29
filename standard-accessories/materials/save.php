<?php

include '../../db.php';
/** @var mysqli $conn */

$category_id = (int)$_POST['category_id'];

$material_name = trim(
    $_POST['material_name']
);

$unit = trim(
    $_POST['unit']
);

$price = (float)
$_POST['price'];

mysqli_query(
    $conn,
    "
    INSERT INTO
    standard_accessory_materials(

        category_id,
        material_name,
        unit,
        price

    )

    VALUES(

        '$category_id',
        '$material_name',
        '$unit',
        '$price'

    )
    "
);

header(
    'Location:index.php'
);
?>