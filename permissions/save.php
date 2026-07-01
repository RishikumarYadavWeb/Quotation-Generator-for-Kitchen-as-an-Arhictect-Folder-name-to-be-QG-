<?php
include '../db.php';
/** @var mysqli $conn */
$module = trim($_POST['module'] ?? '');
$permission_name = trim($_POST['permission_name'] ?? '');
mysqli_query($conn,
"INSERT INTO permissions(
    module,
    permission_name
)
VALUES(
    '$module',
    '$permission_name'
)");
header('Location: manage.php');
