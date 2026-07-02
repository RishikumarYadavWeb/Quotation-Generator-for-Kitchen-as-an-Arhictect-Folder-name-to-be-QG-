<?php 
    include '../includes/auth.php';
    if(!can('accessories_create')){
        die('Access Denied');
    }
    include '../includes/header.php'; 
    include '../includes/sidebar.php'; 
?>
<div class="page-card">
    <div class="page-header">
        <div>
            <h1 class="page-title">Create Accessory</h1>
            <p class="page-subtitle">Add new accessories like shutters, handles, drawers, hinges etc.</p>
        </div>
        <a href="manage.php" class="btn btn-primary">
            <i class="fa-solid fa-arrow-left"></i>
            Back
        </a>
    </div>
    <form action="save.php" method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label>Accessory Name</label>
                <input type="text" name="accessory_name" class="form-control" placeholder="Enter accessory name" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <input type="text" name="category" class="form-control" placeholder="Enter category">
            </div>
            <div class="form-group">
                <label>Unit</label>
                <input type="text" name="unit" class="form-control" placeholder="Eg: pcs, sqft, set">
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" step="1" name="price" class="form-control" placeholder="Enter price">
            </div>
        </div>
        <div style="margin-top:25px;">
            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i>Save Accessory</button>
        </div>
    </form>
</div>
<?php include '../includes/footer.php'; ?>