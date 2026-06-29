<?php
    include '../db.php';
    /** @var mysqli $conn */
    if(!can('roles_delete')){
        die('Access Denied');
    }
    $id = (int) ($_GET['id'] ?? 0);
    mysqli_query($conn,"DELETE FROM role_permissions WHERE role_id='$id'");
    mysqli_query($conn,"DELETE FROM roles WHERE id='$id'");
    header("Location: manage.php");
?>