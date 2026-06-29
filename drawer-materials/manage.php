<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    include '../includes/header.php';
    include '../includes/sidebar.php';
    if(!can('drawers_view')){
        die('Access Denied');
    }
    $query =
    mysqli_query(
        $conn,
        "SELECT
            drawer_materials.*,
            drawer_categories.category_name
        FROM drawer_materials
        LEFT JOIN drawer_categories
        ON drawer_categories.id = drawer_materials.category_id
        ORDER BY drawer_materials.id DESC"
    );
?>
<div class="page-card">
    <div class="page-header">
        <h1>Drawer Materials</h1>
        <?php if(can('drawers_create')){ ?>
            <a href="create.php" class="theme-btn">+ Add Material</a>
        <?php } ?>
    </div>
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Material</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($query)){ ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['category_name'] ?></td>
                    <td><?= $row['material_name'] ?></td>
                    <td>₹ <?= number_format($row['price_per_sqft'],2) ?></td>
                    <td>
                        <?php if($row['status'] == 1){ ?>
                            <span class="status-active">Active</span>
                        <?php }else{ ?>
                            <span class="status-inactive">Inactive</span>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if(can('drawers_edit')){ ?>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                        <?php } ?>
                        <?php if(can('drawers_delete')){ ?>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn">Delete</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>