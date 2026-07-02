<?php

include '../includes/auth.php';
include '../db.php';
if(!can('standard_accessories_view')){
    die('Access Denied');
}
/** @var mysqli $conn */
include '../includes/header.php';
include '../includes/sidebar.php';
$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM standard_accessory_categories
    ORDER BY id ASC
    "
);
?>
<div class="page-card">
    <div class="page-header">
        <h1>Standard Accessory Categories</h1>
        <?php if(can('standard_accessories_create')){ ?>
            <a href="create-category.php" class="theme-btn">+ Add Category</a>
        <?php } ?>
    </div>
    <table class="custom-table">
        <thead>
            <tr>
                <th>Sr No</th>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $srNo=1;
            while($row= mysqli_fetch_assoc($query)){
        ?>
            <tr>
                <td data-label="Sr No:"><?= $srNo++ ?></td>
                <td data-label="Category:"><?= $row['category_name'] ?></td>
                <td data-label="Status:">
                    <?php if($row['status'] == 1){ ?>
                        <span class="status-active">Active</span>
                    <?php }else{ ?>
                        <span class="status-inactive">Inactive</span>
                    <?php } ?>
                </td>
                <td data-label="Action:">
                    <?php if(can('standard_accessories_edit')){ ?>
                        <a href="edit-category.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                    <?php } ?>
                    <?php if(can('standard_accessories_delete')){ ?>
                        <a href="delete-category.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete Category?')">Delete</a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>