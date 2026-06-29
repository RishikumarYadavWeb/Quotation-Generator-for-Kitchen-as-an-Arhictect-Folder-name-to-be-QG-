<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    include '../includes/header.php';
    include '../includes/sidebar.php';
    if(!can('shelves_edit')){
        die('Access Denied');
    }
    $id = (int) ($_GET['id'] ?? 0);
    $query = mysqli_query(
        $conn,
        "SELECT *
        FROM shelf_materials
        WHERE id = '$id'"
    );
    $row = mysqli_fetch_assoc($query);
    $categoryQuery = mysqli_query(
        $conn,
        "SELECT *
        FROM shelf_categories
        WHERE status = 1"
    );
?>
<div class="form-card">
    <h1>Edit Shelf Material</h1>
    <form method="POST" action="update.php">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <div class="mb-3">
            <label>Shelf Category</label>
            <select name="category_id" class="modern-input" required>
                <?php while($cat = mysqli_fetch_assoc($categoryQuery)){ ?>
                    <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $row['category_id']) ? 'selected' : '' ?>>
                        <?= $cat['category_name'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Material Name</label>
            <input type="text" name="material_name" class="modern-input" value="<?= $row['material_name'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Price/Sq.Ft</label>
            <input type="number" step="0.01" name="price_per_sqft" class="modern-input" value="<?= $row['price_per_sqft'] ?>" required >
        </div>
        <button type="submit" class="theme-btn">Update Material</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>