<?php

include '../db.php';
/** @var mysqli $conn */

$token = $_GET['token'] ?? '';

if($token == ''){
    die('Invalid reset link.');
}

$query = mysqli_query(
    $conn,
    "
    SELECT
        id,
        name,
        email,
        reset_token_expiry
    FROM users
    WHERE reset_token = '$token'
    LIMIT 1
    "
);

if(mysqli_num_rows($query) == 0){
    die('Invalid or expired reset link.');
}

$user = mysqli_fetch_assoc($query);

if(
    strtotime($user['reset_token_expiry']) < time()
){
    die('This reset link has expired.');
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Reset Password - QG ERP</title>

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <link
        rel="stylesheet"
        href="../assets/css/style.css"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    >

</head>

<body class="login-body">

<div class="login-container">

    <div class="login-left">

        <img
            src="../assets/images/crafted-logo.png"
            class="login-logo-large"
        >

        <h1>
            Reset Password
        </h1>

        <p>

            Hello
            <strong><?= htmlspecialchars($user['name']) ?></strong>

            <br><br>

            Enter your new password below.

        </p>

    </div>

    <div class="login-right">

        <form
            action="update-password.php"
            method="POST"
            class="login-form"
        >

            <input
                type="hidden"
                name="token"
                value="<?= htmlspecialchars($token) ?>"
            >

            <div class="login-title">
                Create New Password
            </div>

            <div class="login-group">

                <label>New Password</label>

                <div class="login-input-wrapper">

                    <i class="fa-solid fa-lock"></i>

                    <input
                        type="password"
                        name="password"
                        required
                        minlength="8"
                        placeholder="Enter new password"
                    >

                </div>

            </div>

            <div class="login-group">

                <label>Confirm Password</label>

                <div class="login-input-wrapper">

                    <i class="fa-solid fa-lock"></i>

                    <input
                        type="password"
                        name="confirm_password"
                        required
                        minlength="8"
                        placeholder="Confirm password"
                    >

                </div>

            </div>

            <button
                type="submit"
                class="login-btn"
            >
                Reset Password
            </button>

        </form>

    </div>

</div>

</body>

</html>