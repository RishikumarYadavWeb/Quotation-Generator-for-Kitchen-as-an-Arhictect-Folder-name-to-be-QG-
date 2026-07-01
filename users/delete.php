<?php
include '../includes/auth.php';
include '../db.php';
/** @var mysqli $conn */
if(!can('users_delete')){
    die('Access Denied');
}
$id = (int) ($_GET['id'] ?? 0);
if(!$id){header('Location: manage.php');exit;}
$query = "
    SELECT
        users.*,
        roles.role_name
    FROM users
    LEFT JOIN roles
    ON users.role_id = roles.id
    WHERE users.id = '$id'
    LIMIT 1
";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
if(!$user){
    header('Location: manage.php');
    exit;
}
if(
    $_SESSION['user_id'] == $user['id']
){
    die('You cannot delete your own account.');
}
if(
    $user['role_name'] == 'Super Admin'
){
    die('Super Admin cannot be deleted.');
}
$deleteQuery = "
DELETE FROM users
WHERE id = '$id'
";
mysqli_query($conn,$deleteQuery);
header('Location: manage.php');
exit;