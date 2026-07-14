<?php
include '../includes/auth.php';
include '../db.php';
if(!can('appliances_edit')){
    die('Access Denied');
}
/** @var mysqli $conn */
$id = (int)($_GET['id'] ?? 0);
if($id <= 0){
    die('Invalid Appliance ID');
}
$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM appliances
    WHERE id = '$id'
    LIMIT 1
    "
);
if(mysqli_num_rows($query) == 0){
    die('Appliance Not Found');
}
$data = mysqli_fetch_assoc($query);
include '../includes/header.php';
include '../includes/sidebar.php';
?>
<div class="alert alert-info" style="margin-bottom:20px;">
    <strong>Note:</strong> Appliance details are maintained through CSV import. Only <strong>Price</strong> and <strong>Status</strong> can be edited manually.
</div>
<div class="page-card">
    <div class="page-header">
        <div>
            <h1>Edit Appliance</h1>
            <p>Update appliance details.</p>
        </div>
        <a href="manage.php" class="theme-btn"><i class="fa-solid fa-arrow-left"></i>Back</a>
    </div>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <div class="form-grid">
            <div class="form-group">
                <label>Appliance Name</label>
                <input type="text" name="appliance_name" class="form-control" value="<?= htmlspecialchars($data['appliance_name']) ?>" required disabled>
            </div>
            <div class="form-group">
                <label>Company Name</label>
                <input type="text" name="company_name" class="form-control" value="<?= htmlspecialchars($data['company_name']) ?>" required disabled>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3" required disabled><?= htmlspecialchars($data['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label>Unit</label>
                <input type="text" name="unit" class="form-control" value="<?= htmlspecialchars($data['unit']) ?>" required disabled>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" class="form-control" step="0.01" min="0" value="<?= $data['price'] ?>" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" <?= $data['status'] == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= $data['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>
        <div style="margin-top:25px;">
            <button type="submit" class="theme-btn">
                <i class="fa-solid fa-floppy-disk"></i>
                Update Appliance
            </button>
        </div>
    </form>
</div>
<?php include '../includes/footer.php'; ?>