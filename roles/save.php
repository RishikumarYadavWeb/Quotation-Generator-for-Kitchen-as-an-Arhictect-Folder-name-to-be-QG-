<?php
    include '../db.php';
    /** @var mysqli $conn */
    $role_name = trim($_POST['role_name'] ?? '');
    mysqli_query($conn,
    "INSERT INTO roles(role_name)
    VALUES('$role_name')");
    $role_id = mysqli_insert_id($conn);
    if(isset($_POST['permissions'])){
        foreach($_POST['permissions'] as $permission_id){
            mysqli_query($conn,
            "INSERT INTO role_permissions(
                role_id,
                permission_id
            )
            VALUES(
                '$role_id',
                '$permission_id'
            )");
        }
    }
    header("Location: manage.php");
?>