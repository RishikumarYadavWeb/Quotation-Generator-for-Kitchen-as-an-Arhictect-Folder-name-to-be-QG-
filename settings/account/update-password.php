<?php
include '../../includes/auth.php';
include '../../db.php';
/** @var mysqli $conn */
$userId=(int)$_SESSION['user_id'];
$currentPassword=$_POST['current_password'] ?? '';
$newPassword=$_POST['new_password'] ?? '';
$confirmPassword=$_POST['confirm_password'] ?? '';
if(
    empty($currentPassword) || empty($newPassword) || empty($confirmPassword)
){
    $_SESSION['error']="All fields are required.";
    header("Location: change-password.php");
    exit;
}
$userQuery=mysqli_query(
    $conn,
    "
    SELECT password
    FROM users
    WHERE id='$userId'
    LIMIT 1
    "
);
$user=mysqli_fetch_assoc($userQuery);
if(!$user){
    $_SESSION['error']="User not found.";
    header("Location: change-password.php");
    exit;
}
if(
    !password_verify($currentPassword,$user['password'])
){
    $_SESSION['error']="Current password is incorrect.";
    header("Location: change-password.php");
    exit;
}
if($newPassword!==$confirmPassword){
    $_SESSION['error']="Passwords do not match.";
    header("Location: change-password.php");
    exit;
}
if(strlen($newPassword)<8){
    $_SESSION['error']="Password must be at least 8 characters.";
    header("Location: change-password.php");
    exit;
}
if(!preg_match('/[A-Z]/',$newPassword)){
    $_SESSION['error']="Password must contain at least one uppercase letter.";
    header("Location: change-password.php");
    exit;
}
if(!preg_match('/[a-z]/',$newPassword)){
    $_SESSION['error']="Password must contain at least one lowercase letter.";
    header("Location: change-password.php");
    exit;
}
if(!preg_match('/[0-9]/',$newPassword)){
    $_SESSION['error']="Password must contain at least one number.";
    header("Location: change-password.php");
    exit;
}
if(!preg_match('/[^A-Za-z0-9]/',$newPassword)){
    $_SESSION['error']="Password must contain at least one special character.";
    header("Location: change-password.php");
    exit;
}
if(password_verify($newPassword,$user['password'])){
    $_SESSION['error']="New password cannot be the same as the current password.";
    header("Location: change-password.php");
    exit;
}
$newHash = password_hash($newPassword,PASSWORD_DEFAULT);
mysqli_query(
    $conn,
    "
    UPDATE users
    SET
        password='$newHash'
    WHERE id='$userId'
    "
);
$_SESSION['success']="Password changed successfully.";
header("Location: change-password.php");
exit;
?>