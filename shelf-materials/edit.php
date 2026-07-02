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
        FROM shelf_materials
        WHERE id = '$id'
        LIMIT 1
        "
    );
    $row = mysqli_fetch_assoc($query);
    if(!$row){
        die('Shelf Material Not Found');
    }
    $categoryQuery = mysqli_query(
        $conn,
        "
        SELECT *
        FROM shelf_categories
        WHERE status = 1
        ORDER BY category_name ASC
        "
    );
    include '../includes/header.php';
    include '../includes/sidebar.php';
?>
<div class="page-card">
    <div class="page-header mb-4">
        <div>
            <h1 class="page-title">Edit Shelf Material</h1>
            <p class="page-subtitle">Update shelf material details</p>
        </div>
    </div>
    <form method="POST" action="update.php">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <div class="mb-3">
            <label>Shelf Category</label>
            <select name="category_id" class="modern-input" required>
                <?php while($cat = mysqli_fetch_assoc($categoryQuery)){ ?>
                    <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $row['category_id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['category_name']) ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Material Name</label>
            <input type="text" name="material_name" class="modern-input" value="<?= htmlspecialchars($row['material_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Price / Sq.Ft</label>
            <input type="number" step="0.01" name="price_per_sqft" class="modern-input" value="<?= $row['price_per_sqft'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="modern-input" required>
                <option value="1" <?= $row['status'] == 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= $row['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        <button type="submit" class="theme-btn">Update Material</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>