<!DOCTYPE html>
<html>

<head>

    <title>Forgot Password - QG ERP</title>

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

    <!-- LEFT PANEL -->

    <div class="login-left">

        <img
            src="../assets/images/crafted-logo.png"
            class="login-logo-large"
        >

        <h1>
            Reset Password
        </h1>

        <p>
            Forgot your password?
            Enter your registered email address and we'll send you a secure
            password reset link.
        </p>

    </div>

    <!-- RIGHT PANEL -->

    <div class="login-right">

        <form
            action="send-reset-link.php"
            method="POST"
            class="login-form"
        >

            <div class="login-title">
                Forgot Password
            </div>

            <div class="login-group">

                <label>Email Address</label>

                <div class="login-input-wrapper">

                    <i class="fa-solid fa-envelope"></i>

                    <input
                        type="email"
                        name="email"
                        placeholder="Enter your registered email"
                        required
                    >

                </div>

            </div>

            <button
                type="submit"
                class="login-btn"
            >
                <i class="fa-solid fa-paper-plane" style="margin-right: 10px;"></i>
                Send Reset Link
            </button>

            <div
                style="
                    margin-top:20px;
                    text-align:center;
                "
            >

                <a
                    href="login.php"
                    style="
                        color:#fff;
                        text-decoration:none;
                        font-weight:500;
                    "
                >
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Login
                </a>

            </div>

        </form>

    </div>

</div>

</body>

</html>