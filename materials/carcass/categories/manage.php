
<?php
include '../../../includes/auth.php';
include '../../../db.php';
if(!can('carcass_view')){
    die('Access Denied');
}
/** @var mysqli $conn */
include '../../../includes/header.php';
include '../../../includes/sidebar.php';
$query = mysqli_query(
    $conn,
    "SELECT *
    FROM carcass_categories
    ORDER BY id ASC"
);
?>
<div class="page-card">
    <div class="page-header">
        <h1>Carcass Categories</h1>
        <?php if(can('carcass_create')){ ?>
            <a href="create.php" class="theme-btn">+ Add Material</a>
        <?php } ?>
    </div>
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $srNo=1; while($row = mysqli_fetch_assoc($query)){ ?>
                <tr>
                    <td><?= $srNo++ ?></td>
                    <td><?= $row['category_name'] ?></td>
                    <td>
                        <?php if($row['status'] == 1){ ?>
                            <span class="status-active">Active</span>
                        <?php }else{ ?>
                            <span class="status-inactive">Inactive</span>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if(can('carcass_edit')){ ?>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                        <?php } ?>
                        <?php if(can('carcass_delete')){ ?>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete Category?')">Delete</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include '../../../includes/footer.php'; ?>