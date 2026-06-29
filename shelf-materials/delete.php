<?php
    if(!can('shelves_delete')){
        die('Access Denied');
    }
    include '../db.php';
    /** @var mysqli $conn */
    $id = (int) ($_GET['id'] ?? 0);
    mysqli_query(
        $conn,
        "DELETE FROM shelf_materials
        WHERE id = '$id'"
    );
    header('Location: manage.php');
?>