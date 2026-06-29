<?php

include '../db.php';
/** @var mysqli $conn */

$id = $_GET['id'];

mysqli_query(
    $conn,
    "
    DELETE FROM
    standard_accessory_categories
    WHERE id='$id'
    "
);

header(
    'Location:index.php'
);
?>