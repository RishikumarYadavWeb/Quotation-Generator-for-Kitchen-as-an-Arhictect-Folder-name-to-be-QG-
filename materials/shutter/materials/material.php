<?php
    include '../../../includes/auth.php';
    include '../../../db.php';
    if(!can('shutter_create')){
        die('Access Denied');
    }
    /** @var mysqli $conn */
    include '../../../includes/header.php'; 
    include '../../../includes/sidebar.php'
?>
<div class="container">
    <div class="top-bar">
        <h2>Shutter Materials</h2>
        <a href="manage.php" class="btn">Manage Materials</a>
    </div>
    <form action="save.php" method="POST">
        <div class="form-group">
            <label>Select Category</label>
            <select name="category_id" required>
                <option value="">Select Category</option>
                <?php
                    $query =
                    "SELECT * FROM shutter_categories
                    WHERE status='1'";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_assoc($result)) {
                ?>
                    <option value="<?= $row['id']; ?>"><?= $row['category_name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Material Type</label>
            <input type="text" name="material_type" placeholder="Enter material type" required>
        </div>
        <div class="form-group">
            <label>Price Per Sqft</label>
            <input type="number" step="0.01" name="price_per_sqft" required>
        </div>
        <button type="submit">Save Material</button>
    </form>
</div>
<?php include '../../../includes/footer.php'; ?>