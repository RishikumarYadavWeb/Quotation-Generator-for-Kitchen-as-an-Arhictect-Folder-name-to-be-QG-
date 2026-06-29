<?php
    include '../db.php';
    /** @var mysqli $conn */
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        die('Invalid Request');
    }
    $id = (int) ($_POST['id'] ?? 0);
    if($id <= 0){
        die('Invalid Accessory ID');
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
        UPDATE accessories
        SET
            accessory_name = '$name',
            category = '$category',
            unit = '$unit',
            price = '$price'
        WHERE id = '$id'
        LIMIT 1
        "
    );
    header('Location: manage.php');
    exit; 
?>