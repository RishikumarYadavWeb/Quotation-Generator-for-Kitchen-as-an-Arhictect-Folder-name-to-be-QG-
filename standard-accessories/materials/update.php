<?php

include '../../db.php';
/** @var mysqli $conn */

$id=(int)$_POST['id'];

$category_id=
(int)$_POST['category_id'];

$material_name=
$_POST['material_name'];

$unit=
$_POST['unit'];

$price=
(float)$_POST['price'];

mysqli_query(
    $conn,
    "
    UPDATE
    standard_accessory_materials

    SET

    category_id='$category_id',
    material_name='$material_name',
    unit='$unit',
    price='$price'

    WHERE id='$id'
    "
);

header(
    'Location:index.php'
);
?>