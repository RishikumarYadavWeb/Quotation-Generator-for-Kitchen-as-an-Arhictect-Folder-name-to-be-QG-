<?php
    include '../includes/auth.php';
    /** @var mysqli $conn */
    include '../db.php';
    $company = mysqli_query($conn, "SELECT * FROM company LIMIT 1");
    $data = mysqli_fetch_assoc($company);
    include '../includes/header.php';
    include '../includes/sidebar.php';
?>
<style>
.page-content{padding:30px;background:#f5f5f5;min-height:100vh}.company-card{background:#fff;padding:30px;border-radius:10px}.form-group{margin-bottom:20px}label{display:block;margin-bottom:8px;font-weight:600}input,textarea{width:100%;padding:12px;border:1px solid #ccc;border-radius:5px}button{background:#000;color:#fff;border:none;padding:12px 20px;border-radius:5px;cursor:pointer}.modal{display:none;position:fixed;left:0;top:0;width:100%;height:100%;background:rgb(0 0 0 / .5);z-index:9999}.modal-content{background:#fff;width:400px;margin:15% auto;padding:25px;border-radius:10px;text-align:center}.modal-buttons{margin-top:20px;display:flex;justify-content:center;gap:10px}.cancel-btn{background:red}
</style>

<div class="page-content">
    <div class="company-card">
        <img src="../assets/images/crafted-logo.png" alt="Company Logo" style="width:250px;display: block; margin-bottom:20px; margin-left: auto; margin-right: auto;">
        <h2>Edit Company Details</h2>
        <form id="companyForm" action="update.php" method="POST">
            <input type="hidden" name="id" value="<?= $data['id'] ?? '' ?>">
            <div class="form-group">
                <label>Company Name</label>
                <input type="text" name="company_name" value="<?= $data['company_name'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>Registered Address</label>
                <textarea name="registered_address"><?= $data['registered_address'] ?? '' ?></textarea>
            </div>
            <div class="form-group">
                <label>Admin Address</label>
                <textarea name="admin_address"><?= $data['admin_address'] ?? '' ?></textarea>
            </div>
            <div class="form-group">
                <label>PAN Number</label>
                <input type="text" name="pan_number" value="<?= $data['pan_number'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>GST Number</label>
                <input type="text" name="gst_number" value="<?= $data['gst_number'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= $data['email'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>Landline Number</label>
                <input type="text" name="landline_number" value="<?= $data['landline_number'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label>CIN Number</label>
                <input type="text" name="cin_number" value="<?= $data['cin_number'] ?? '' ?>">
            </div>
            <button type="button" onclick="openModal()">Save Details</button>
        </form>
    </div>
</div>
<!-- Modal -->
<div class="modal" id="confirmModal">
    <div class="modal-content">
        <h3>Confirm Save</h3>
        <p>Are you sure you want to save changes?</p>
        <div class="modal-buttons">
            <button onclick="submitForm()">Yes Save</button>
            <button class="cancel-btn" onclick="closeModal()">Cancel</button>
        </div>
    </div>
</div>

<script>
function openModal(){
    document.getElementById('confirmModal').style.display='block';
}
function closeModal(){
    document.getElementById('confirmModal').style.display='none';
}
function submitForm(){
    document.getElementById('companyForm').submit();
}
</script>
<?php include '../includes/footer.php';?>