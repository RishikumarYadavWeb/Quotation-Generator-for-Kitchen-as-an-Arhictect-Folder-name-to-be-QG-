<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    $company = mysqli_query($conn, "SELECT * FROM company LIMIT 1");
    $data = mysqli_fetch_assoc($company);
    include '../includes/header.php';
    include '../includes/sidebar.php';
?>
<style>
.page-content{padding:30px;background:#f5f5f5;min-height:100vh}.company-card{background:#fff;padding:30px;border-radius:10px}.company-card h2{margin-bottom:25px}.detail-box{margin-bottom:20px}.label{font-weight:600;margin-bottom:5px}.value{background:#f2f2f2;padding:12px;border-radius:5px}.edit-btn{display:inline-block;background:#000;color:#fff;padding:12px 20px;border-radius:5px;text-decoration:none}
</style>
<div class="page-content">
    <div class="company-card">
        <!-- <img src="../assets/images/crafted-logo.png" alt="Company Logo" style="width:250px;display: block; margin-bottom:20px; margin-left: auto; margin-right: auto;"> -->
        <div class="detail-box">
            <div class="label">Company Name</div>
            <div class="value"><?= $data['company_name'] ?? '' ?></div>
        </div>
        <div class="detail-box">
            <div class="label">Registered Address</div>
            <div class="value"><?= $data['registered_address'] ?? '' ?></div>
        </div>
        <div class="detail-box">
            <div class="label">Admin Address</div>
            <div class="value"><?= $data['admin_address'] ?? '' ?></div>
        </div>
        <div class="detail-box">
            <div class="label">PAN Number</div>
            <div class="value"><?= $data['pan_number'] ?? '' ?></div>
        </div>
        <div class="detail-box">
            <div class="label">GST Number</div>
            <div class="value"><?= $data['gst_number'] ?? '' ?></div>
        </div>
        <div class="detail-box">
            <div class="label">Email</div>
            <div class="value"><?= $data['email'] ?? '' ?></div>
        </div>
        <div class="detail-box">
            <div class="label">Landline Number</div>
            <div class="value"><?= $data['landline_number'] ?? '' ?></div>
        </div>
        <div class="detail-box">
            <div class="label">CIN Number</div>
            <div class="value"><?= $data['cin_number'] ?? '' ?></div>
        </div>
        <?php if(can('company_edit')){ ?>
            <a href="edit.php" class="edit-btn">Edit Details</a>
        <?php } ?>
    </div>
</div>
<?php include '../includes/footer.php';?>