
<?php
    include '../../../includes/auth.php';
    include '../../../db.php';
    /** @var mysqli $conn */
    include '../../../includes/header.php'; 
    include '../../../includes/sidebar.php';
?>
<div class="container">
    <div class="top-bar">
        <h2>Manage Shutter Materials</h2>
        <a href="material.php" class="theme-btn">+ Add Material</a>
    </div>
    <div>
        <table class="custom-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Material Type</th>
                    <th>Price/Sqft</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $query =
                    "SELECT shutter_materials.*,
                            shutter_categories.category_name
                    FROM shutter_materials
                    LEFT JOIN shutter_categories
                    ON shutter_materials.category_id =
                        shutter_categories.id
                    ORDER BY shutter_materials.id DESC";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['category_name']; ?></td>
                        <td><?= $row['material_type']; ?></td>
                        <td>₹ <?= number_format($row['price_per_sqft'],2); ?></td>
                        <td>
                            <?php if($row['status'] == 1) { ?>
                                <a href="status.php?id=<?= $row['id']; ?>&status=0" class="badge badge-active">Active</a>
                            <?php } else { ?>
                                <a href="status.php?id=<?= $row['id']; ?>&status=1" class="badge badge-inactive">Inactive</a>
                            <?php } ?>
                        </td>
                        <td class="d-flex">
                            <a href="edit.php?id=<?= $row['id']; ?>" class="edit-btn">Edit</a>
                            <a href="delete.php?id=<?= $row['id']; ?>" class="delete-btn">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../../../includes/footer.php'; ?>