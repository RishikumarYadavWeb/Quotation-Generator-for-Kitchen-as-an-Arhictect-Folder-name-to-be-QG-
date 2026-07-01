<?php
include '../includes/auth.php';
if(!can('standard_accessories_create')){
    die('Access Denied');
}
include '../includes/header.php';
include '../includes/sidebar.php';
?>
<div class="page-card">
    <h2>Add Category</h2>
    <form action="save-category.php" method="POST">
        <div class="form-group">
            <label>Category Name</label>
            <input type="text" name="category_name" class="form-control" required>
        </div>
        <button class="theme-btn">Save Category</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>