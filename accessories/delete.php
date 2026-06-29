<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    if(!can('accessories_delete')){
        die('Access Denied');
    }
    $id = (int) ($_GET['id'] ?? 0);
    if($id <= 0){
        die('Invalid Accessory ID');
    }
    mysqli_query(
        $conn,
        "
        DELETE FROM accessories
        WHERE id = '$id'
        LIMIT 1
        "
    );
    header('Location: manage.php');
    exit;
?>