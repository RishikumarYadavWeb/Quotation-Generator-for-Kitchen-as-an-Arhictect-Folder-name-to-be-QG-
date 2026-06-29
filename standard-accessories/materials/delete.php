<?php

include '../../db.php';
/** @var mysqli $conn */

$id=(int)$_GET['id'];

mysqli_query(
    $conn,
    "
    DELETE FROM
    standard_accessory_materials
    WHERE id='$id'
    "
);

header(
    'Location:index.php'
);
?>