<?php
    include '../../../includes/auth.php';
    include '../../../db.php';
    /** @var mysqli $conn */
    include '../../../includes/header.php';
    include '../../../includes/sidebar.php';
    $id = (int) ($_GET['id'] ?? 0);
    $query = "SELECT * FROM shutter_materials WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
?>
<div class="container">
    <div class="top-bar">
        <h2>Edit Shutter Material</h2>
    </div>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $row['id']; ?>">
        <div class="form-group">
            <label>Select Category</label>
            <select name="category_id" required>
                <?php
                    $catQuery = "SELECT * FROM shutter_categories WHERE status='1'";
                    $catResult = mysqli_query($conn, $catQuery);
                    while($cat = mysqli_fetch_assoc($catResult)) {
                ?>
                    <option value="<?= $cat['id']; ?>" <?= ($cat['id'] == $row['category_id']) ? 'selected' : ''; ?>>
                        <?= $cat['category_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Material Type</label> 
            <input type="text" name="material_type" value="<?= $row['material_type']; ?>" required>
        </div>
        <div class="form-group">
            <label>Price Per Sqft</label>
            <input type="number" step="0.01" name="price_per_sqft" value="<?= $row['price_per_sqft']; ?>" required>
        </div>
        <button type="submit">Update Material</button>
    </form>
</div>
<?php include '../../../includes/footer.php'; ?>