<?php
include '../db.php';
/** @var mysqli $conn */
$id =(int)($_POST['id'] ?? 0);
$role_name = trim($_POST['role_name'] ?? '');
mysqli_query($conn,
"UPDATE roles
SET role_name='$role_name'
WHERE id='$id'");
mysqli_query($conn,
"DELETE FROM role_permissions
WHERE role_id='$id'");
if(isset($_POST['permissions'])){
    foreach($_POST['permissions'] as $permission_id){
        mysqli_query($conn,

        "INSERT INTO role_permissions(
            role_id,
            permission_id
        )
        VALUES(
            '$id',
            '$permission_id'
        )");
    }
}
header("Location: manage.php");