<?php

include '../db.php';
/** @var mysqli $conn */

$token = $_POST['token'] ?? '';

$password = $_POST['password'] ?? '';

$confirmPassword = $_POST['confirm_password'] ?? '';

if($password != $confirmPassword){

    die('Passwords do not match.');

}

$query = mysqli_query(
    $conn,
    "
    SELECT id
    FROM users
    WHERE reset_token = '$token'
    LIMIT 1
    "
);

if(mysqli_num_rows($query) == 0){

    die('Invalid reset token.');

}

$user = mysqli_fetch_assoc($query);

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);

mysqli_query(
    $conn,
    "
    UPDATE users
    SET
        password = '$hashedPassword',
        reset_token = NULL,
        reset_token_expiry = NULL
    WHERE id = '{$user['id']}'
    "
);

echo "

<script>

alert('Password changed successfully.');

window.location='login.php';

</script>

";