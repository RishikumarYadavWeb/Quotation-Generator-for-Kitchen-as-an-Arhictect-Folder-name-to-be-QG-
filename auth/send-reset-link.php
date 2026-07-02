<?php
include '../db.php';
require_once '../auth/mail.php';
/** @var mysqli $conn */
$email = trim($_POST['email'] ?? '');
if($email == ''){
    die('Email is required.');
}
$query = mysqli_query(
    $conn,
    "
    SELECT
        id,
        name,
        email
    FROM users
    WHERE email = '$email'
    LIMIT 1
    "
);
if(mysqli_num_rows($query) == 0){
    echo "
    <script>
        alert('No account found with this email.');
        window.location='forgot-password.php';
    </script>";
    exit;
}
$user = mysqli_fetch_assoc($query);
$token = bin2hex(random_bytes(32));
$expiry = date('Y-m-d H:i:s',strtotime('+10 minutes'));
mysqli_query(
    $conn,
    "
    UPDATE users
    SET
        reset_token = '$token',
        reset_token_expiry = '$expiry'
    WHERE id = '{$user['id']}'
    "
);
$resetLink = "http://localhost/QG/auth/reset-password.php?token=".$token;
try{
    $mail = getMailer();
    $mail->addAddress($user['email'],$user['name']);
    $mail->Subject = 'Reset Your Password';
    $mail->Body = "
        <h2>Hello {$user['name']},</h2>
        <p>We received a request to reset your password.</p>
        <p>
            <a
                href='$resetLink'
                style='background:#2563eb;color:#fff;padding:12px 20px;text-decoration:none;border-radius:6px;display:inline-block;'>
                Reset Password
            </a>
        </p>
        <p>This link will expire in<strong>10 minutes</strong>.</p>
        <p>If you didn't request this, simply ignore this email.</p>
        <br>
        <strong>QG ERP</strong>
    ";
    $mail->send();
    echo "
    <script>
        alert('Password reset link sent successfully.');
        window.location='login.php';
    </script>";
}
catch(Exception $e){
    echo $mail->ErrorInfo;
}