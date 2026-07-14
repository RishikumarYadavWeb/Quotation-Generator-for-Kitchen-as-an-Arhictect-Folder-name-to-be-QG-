<?php
include '../includes/auth.php';
include '../db.php';
if(!can('appliances_create')){
    die('Access Denied');
}
/** @var mysqli $conn */
include '../includes/header.php';
include '../includes/sidebar.php';
?>
<div class="page-card">
    <div class="page-header">
        <div>
            <h1>Create Appliance</h1>
            <p>Add a new appliance manually.</p>
        </div>
        <a href="manage.php" class="theme-btn"><i class="fa-solid fa-arrow-left"></i>Back</a>
    </div>
    <div style="background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af;padding:15px;border-radius:10px;margin-bottom:25px;">
        <strong>Note:</strong>
        The appliance catalogue is primarily maintained through CSV import.
        Use this page only for adding individual appliances when necessary.
    </div>
    <form action="save.php" method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label>Appliance Name</label>
                <input type="text" name="appliance_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Company Name</label>
                <input type="text" name="company_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Unit</label>
                <input type="text" name="unit" class="form-control" placeholder="Eg. Nos, Set, Kit" required>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" class="form-control" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
        <div style="margin-top:25px;">
            <button type="submit" class="theme-btn"><i class="fa-solid fa-floppy-disk"></i>Save Appliance</button>
        </div>
    </form>
</div>
<?php include '../includes/footer.php'; ?>