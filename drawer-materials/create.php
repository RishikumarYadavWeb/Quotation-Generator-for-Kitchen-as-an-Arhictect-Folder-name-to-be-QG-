<?php
include '../includes/auth.php';
include '../db.php';
if(!can('drawers_create')){
    die('Access Denied');
}
/** @var mysqli $conn */
include '../includes/header.php';
include '../includes/sidebar.php';
$categoryQuery = mysqli_query($conn,"SELECT * FROM drawer_categories WHERE status = 1");
?>
<div class="form-card">
    <h1>Add Drawer Material</h1>
    <form method="POST" action="save.php">
        <div class="mb-3">
            <label>Drawer Category</label>
            <select name="category_id" class="modern-input" required>
                <option value="">Select Category</option>
                <?php while($cat = mysqli_fetch_assoc($categoryQuery)){ ?>
                    <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Material Name</label>
            <input type="text" name="material_name" class="modern-input" required>
        </div>
        <div class="mb-3">
            <label>Price/Sq.Ft</label>
            <input type="number" step="0.01" name="price_per_sqft" class="modern-input" required>
        </div>
        <button type="submit" class="theme-btn">Save Material</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>