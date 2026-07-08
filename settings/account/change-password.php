<?php
include '../../includes/auth.php';
include '../../db.php';
$pageTitle="Change Password";
include '../../includes/header.php';
include '../../includes/sidebar.php';
?>
<link rel="stylesheet" href="../assets/style.css">
<div class="profile-page">
    <div class="profile-header">
        <div>
            <h1><i class="fa-solid fa-key"></i>Change Password</h1>
            <p>Keep your account secure by updating your password regularly.</p>
        </div>
        <a href="../index.php" class="btn btn-dark"><i class="fa-solid fa-arrow-left"></i>Back</a>
    </div>
    <div class="profile-card">
        <div class="profile-card-header">
            <h3><i class="fa-solid fa-lock"></i>Password Details</h3>
        </div>
        <div class="profile-body">
            <form action="update-password.php" method="POST" id="passwordForm">
                <div class="form-group">
                    <label>Current Password</label>
                    <div class="password-group">
                        <input type="password" name="current_password" id="current_password" class="form-control" required>
                        <button type="button" class="toggle-password" data-target="current_password"><i class="fa-solid fa-eye"></i></button>
                    </div> 
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <div class="password-group">
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                        <button type="button" class="toggle-password" data-target="new_password"><i class="fa-solid fa-eye"></i></button>
                    </div>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <div class="password-group">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        <button type="button" class="toggle-password" data-target="confirm_password"><i class="fa-solid fa-eye"></i></button>
                    </div>
                </div>
                <div class="password-strength">
                    <div class="strength-header">
                        <span>Password Strength</span>
                        <span id="strengthText">Weak</span>
                    </div>
                    <div class="strength-bar">
                        <div id="strengthFill"></div>
                    </div>
                </div>
                <div class="password-rules">
                    <div id="ruleLength"><i class="fa-solid fa-circle"></i>Minimum 8 characters</div>
                    <div id="ruleUpper"><i class="fa-solid fa-circle"></i>One uppercase letter</div>
                    <div id="ruleLower"><i class="fa-solid fa-circle"></i>One lowercase letter</div>
                    <div id="ruleNumber"><i class="fa-solid fa-circle"></i>One number</div>
                    <div id="ruleSpecial"><i class="fa-solid fa-circle"></i>One special character</div>
                    <div id="ruleMatch"><i class="fa-solid fa-circle"></i>Passwords match</div>
                </div>
                <div class="profile-actions">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../assets/change-password.js"></script>
<?php if(isset($_SESSION['success'])){ ?>
    <script>alert("<?= addslashes($_SESSION['success']); ?>");</script>
<?php unset($_SESSION['success']); } ?>
<?php if(isset($_SESSION['error'])){ ?>
    <script>alert("<?= addslashes($_SESSION['error']); ?>");</script>
<?php unset($_SESSION['error']); } ?>
<?php include '../../includes/footer.php';?>