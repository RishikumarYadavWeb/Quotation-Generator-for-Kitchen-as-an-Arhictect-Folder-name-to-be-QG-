<?php
    include '../includes/auth.php';
    include '../db.php';
    if(!can('standard_accessories_edit')){
        die('Access Denied');
    }
    /** @var mysqli $conn */
    if(!can('accessories_edit')){
        die('Access Denied');
    }
    $id = (int)($_GET['id'] ?? 0);
    $query = mysqli_query(
        $conn,
        "
        SELECT *
        FROM standard_accessory_categories
        WHERE id = '$id'
        LIMIT 1
        "
    );
    $row = mysqli_fetch_assoc($query);
    if(!$row){
        die('Category Not Found');
    }
    include '../includes/header.php';
    include '../includes/sidebar.php';
?>
<div class="page-card">
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Standard Accessory Category</h1>
            <p class="page-subtitle">Update category details</p>
        </div>
        <a href="manage-categories.php" class="theme-btn">Back</a>
    </div>
    <form action="update-category.php" method="POST">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <div class="form-grid">
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="category_name" value="<?= htmlspecialchars($row['category_name']) ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" <?= $row['status'] == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= $row['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>
        <div style="margin-top:25px;">
            <button class="theme-btn">Update Category</button>
        </div>
    </form>
</div>
<?php include '../includes/footer.php'; ?>