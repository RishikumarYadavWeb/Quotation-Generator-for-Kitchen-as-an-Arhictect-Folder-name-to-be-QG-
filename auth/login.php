<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        header('Location: ../dashboard.php');
        exit;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login - QG ERP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/css/style.css" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    </head>
    <body class="login-body">
        <div class="login-container">
            <div class="login-left">
                <img src="../assets/images/crafted-logo.png" class="login-logo-large">
                <h1>Welcome Back</h1>
                <p>Login to access your quotation management system, project workflows, costing architecture and ERP operations.</p>
            </div>
            <div class="login-right">
                <form action="process-login.php" method="POST" class="login-form">
                    <div class="login-title">Sign In</div>
                    <div class="login-group">
                        <label>Email</label>
                        <div class="login-input-wrapper">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="email" required placeholder="Enter email">
                        </div>
                    </div>
                    <div class="login-group">
                        <label>Password</label>
                        <div class="login-input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" name="password" required placeholder="Enter password">
                        </div>
                    </div>
                    <button type="submit" class="login-btn">Login</button>
                </form>
            </div>
        </div>
    </body>
</html>