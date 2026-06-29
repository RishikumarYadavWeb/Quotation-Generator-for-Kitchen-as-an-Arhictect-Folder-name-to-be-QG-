<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    if(!can('accessories_edit')){
        die('Access Denied');
    }
    $id = (int) ($_GET['id'] ?? 0);
    $get = mysqli_query(
        $conn,
        "
        SELECT
            id,
            accessory_name,
            category,
            unit,
            price
        FROM accessories
        WHERE id = '$id'
        LIMIT 1
        "
    );
    $data = mysqli_fetch_assoc($get);
    if(!$data){
        die('Accessory Not Found');
    }
    include '../includes/header.php';
    include '../includes/sidebar.php';
?>
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Accessory</h1>
        <p class="page-subtitle">Update accessory details, category, unit and pricing.</p>
    </div>
    <a href="manage.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i>Back</a>
</div>
<div class="card">
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <div class="form-grid">
            <div class="form-group">
                <label> Accessory Name </label>
                <input type="text" name="accessory_name" class="form-control" value="<?= htmlspecialchars($data['accessory_name']) ?>" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($data['category']) ?>">
            </div>
            <div class="form-group">
                <label>Unit</label>
                <input type="text" name="unit" class="form-control" value="<?= htmlspecialchars($data['unit']) ?>">
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" step="0.01" name="price" class="form-control" value="<?= $data['price'] ?>">
            </div>
        </div>
        <div style="margin-top:25px;">
            <button type="submit" class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i>Update Accessory</button>
        </div>
    </form>
</div>
<?php include '../includes/footer.php'; ?>