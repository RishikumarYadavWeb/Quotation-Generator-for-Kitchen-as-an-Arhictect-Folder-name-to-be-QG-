<?php
    include '../includes/auth.php';
    if(!can('drawers_create')){
        die('Access Denied');
    }
    include '../includes/header.php';
    include '../includes/sidebar.php';
?>
<div class="form-card">
    <h1>Add Drawer Category</h1>
    <form method="POST" action="save.php">
        <div class="mb-3">
            <label>Category Name</label>
            <input type="text" name="category_name" class="modern-input" required>
        </div>
        <button type="submit" class="theme-btn">Save Category</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>