<?php

include '../db.php';
/** @var mysqli $conn */

$id=$_POST['id'];

$name=$_POST['category_name'];

mysqli_query(
    $conn,
    "
    UPDATE
    standard_accessory_categories
    SET
    category_name='$name'
    WHERE id='$id'
    "
);

header(
    'Location:index.php'
);
?>