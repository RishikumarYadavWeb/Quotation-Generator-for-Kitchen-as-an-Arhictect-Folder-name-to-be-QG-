<?php
include '../db.php';
/** @var mysqli $conn */

$categoryId=(int)$_POST['category_id'];
$makeName=mysqli_real_escape_string($conn,trim($_POST['make_name']));
$status=(int)$_POST['status'];

mysqli_query(
    $conn,
    "
    INSERT INTO accessory_makes
    (
        category_id,
        make_name,
        status
    )
    VALUES
    (
        '$categoryId',
        '$makeName',
        '$status'
    )
    "
);

header("Location: manage.php");
exit;