<?php
include '../../includes/auth.php';
include '../../db.php';
if(!can('standard_accessories_create')){
    die('Access Denied');
}
/** @var mysqli $conn */
include '../../includes/header.php';
include '../../includes/sidebar.php';
$categories = mysqli_query(
    $conn,
    "SELECT *
    FROM standard_accessory_categories
    WHERE status=1
    ORDER BY category_name ASC"
);
?>
<div class="page-card">
    <div class="page-header">
        <h1>Add Standard Accessory Material</h1>
    </div>
    <form action="save.php" method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label>Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php while($category=mysqli_fetch_assoc($categories)){ ?>
                        <option value="<?= $category['id'] ?>"><?= $category['category_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Material Name</label>
                <input type="text" name="material_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Unit</label>
                <select name="unit" class="form-control" required>
                    <option value="Nos">Nos</option>
                    <option value="Meter">Meter</option>
                </select>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" step="1" name="price" class="form-control" required>
            </div>
        </div>
        <button class="theme-btn">Save Material</button>
    </form>
</div>
<?php include '../../includes/footer.php'; ?>