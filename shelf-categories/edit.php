<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    if(!can('shelves_edit')){
        die('Access Denied');
    }
    $id = (int) ($_GET['id'] ?? 0);
    $query = mysqli_query(
        $conn,
        "
        SELECT *
        FROM shelf_categories
        WHERE id = '$id'
        LIMIT 1
        "
    );
    $row = mysqli_fetch_assoc($query);
    if(!$row){
        die('Shelf Category Not Found');
    }
    include '../includes/header.php';
    include '../includes/sidebar.php';
?>
<div class="page-card">
    <div class="page-header mb-4">
        <div>
            <h1 class="page-title">Edit Shelf Category</h1>
            <p class="page-subtitle">Update shelf category details</p>
        </div>
    </div>
    <form method="POST" action="update.php">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <div class="mb-3">
            <label>Category Name</label>
            <input type="text" name="category_name" class="modern-input" value="<?= htmlspecialchars($row['category_name']) ?>" required>
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
<?php include '../includes/footer.php'; ?>