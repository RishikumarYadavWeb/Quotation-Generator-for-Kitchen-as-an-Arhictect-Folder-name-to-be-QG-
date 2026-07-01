<?php
    include '../../../includes/auth.php';
    include '../../../db.php';
    if(!can('shutter_edit')){
        die('Access Denied');
    }
    /** @var mysqli $conn */
    $id = (int)($_GET['id'] ?? 0);
    $query = mysqli_query(
        $conn,
        "
        SELECT *
        FROM shutter_categories
        WHERE id = '$id'
        LIMIT 1
        "
    );
    $row = mysqli_fetch_assoc($query);
    if(!$row){
        die('Category Not Found');
    }
    include '../../../includes/header.php';
    include '../../../includes/sidebar.php';
?>
<div class="form-card">
    <div class="page-header mb-4">
        <div>
            <h1 class="page-title">Edit Shutter Category</h1>
            <p class="page-subtitle">Update shutter category details</p>
        </div>
    </div>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $row['id']; ?>">
        <div class="mb-3">
            <label>Category Name</label>
            <input type="text" name="category_name" class="modern-input" value="<?= htmlspecialchars($row['category_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="modern-input" required>
                <option value="1" <?= $row['status'] == 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= $row['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        <button type="submit" class="theme-btn">Update Category</button>
    </form>
</div>
<?php include '../../../includes/footer.php'; ?>