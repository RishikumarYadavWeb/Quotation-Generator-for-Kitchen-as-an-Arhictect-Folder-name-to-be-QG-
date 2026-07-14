<?php
include '../includes/auth.php';
include '../db.php';
if(!can('appliances_import')){
    die('Access Denied');
}
/** @var mysqli $conn */
include '../includes/header.php';
include '../includes/sidebar.php';
?>
<div class="page-card">
    <div class="page-header">
        <div>
            <h1>Import Appliances</h1>
            <p>Upload appliance catalogue using CSV.</p>
        </div>
    </div>
    <form action="import-save.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>CSV File</label>
            <input type="file" name="csv_file" class="form-control" accept=".csv" required>
        </div>
        <button class="theme-btn" type="submit">
            Import CSV
        </button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>