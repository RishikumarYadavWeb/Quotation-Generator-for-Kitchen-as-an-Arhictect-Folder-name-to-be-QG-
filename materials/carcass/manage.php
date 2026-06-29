<?php
    include '../../includes/auth.php';
    include '../../db.php';
    /** @var mysqli $conn */
    include '../../includes/header.php';
    include '../../includes/sidebar.php';
    $query = mysqli_query(
        $conn,
        "SELECT
            carcass_materials.*,
            carcass_categories.category_name
        FROM carcass_materials
        LEFT JOIN carcass_categories
        ON carcass_categories.id =
        carcass_materials.category_id
        ORDER BY carcass_materials.id ASC"
    );
?>
<div class="page-card">
    <div class="page-header">
        <h1>Carcass Materials</h1>
        <a href="material.php" class="theme-btn">+ Add Material</a>
    </div>
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>SR No.</th>
                    <th>Category</th>
                    <th>Material</th>
                    <th>Price/Sq.Ft</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $srNo = 1; while($row = mysqli_fetch_assoc($query)){ ?>
                    <tr>
                        <td><?= $srNo++ ?></td>
                        <td><?= $row['category_name'] ?></td>
                        <td><?= $row['material_name'] ?></td>
                        <td>₹<?= number_format($row['price_per_sqft'],2) ?></td>
                        <td>
                            <?php if($row['status'] == 1){ ?>
                                <span class="status-active">Active</span>
                            <?php }else{ ?>
                                <span class="status-inactive">Inactive</span>
                            <?php } ?>
                        </td>
                        <td class="d-flex">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete Material?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../../includes/footer.php'; ?>