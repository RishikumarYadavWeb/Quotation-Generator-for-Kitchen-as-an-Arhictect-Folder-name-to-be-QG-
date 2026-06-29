<?php 
    include '../../../includes/auth.php';
    include '../../../db.php'; 
    include '../../../includes/header.php'; 
    include '../../../includes/sidebar.php';
?>
<div class="container">
    <div class="top-bar">
        <h2>Shutter Categories</h2>
        <a href="manage.php" class="btn">Manage Categories</a>
    </div>
    <form action="save.php" method="POST">
        <div class="form-group">
            <label>Category Name</label>
            <input type="text" name="category_name" placeholder="Enter category name" required>
        </div>
        <button type="submit">Save Category</button>
    </form>
</div>
<?php include '../../../includes/footer.php'; ?>