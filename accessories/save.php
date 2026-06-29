<?php
    include '../db.php';
    /** @var mysqli $conn */
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        die('Invalid Request');
    }
    $name = mysqli_real_escape_string($conn,trim($_POST['accessory_name'] ?? ''));
    $category = mysqli_real_escape_string($conn,trim($_POST['category'] ?? ''));
    $unit = mysqli_real_escape_string($conn,trim($_POST['unit'] ?? ''));
    $price = (float) ($_POST['price'] ?? 0);
    if(empty($name)){
        die('Accessory Name Required');
    }
    mysqli_query(
        $conn,
        "
        INSERT INTO accessories(
            accessory_name,
            category,
            unit,
            price
        )
        VALUES(
            '$name',
            '$category',
            '$unit',
            '$price'
        )
        "
    );
    header('Location: manage.php');
    exit;
?>