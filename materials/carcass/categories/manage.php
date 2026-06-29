
<?php
include '../../../includes/auth.php';
include '../../../db.php';
/** @var mysqli $conn */
include '../../../includes/header.php';
include '../../../includes/sidebar.php';
$query = mysqli_query(
    $conn,
    "SELECT *
    FROM carcass_categories
    ORDER BY id DESC"
);
?>
<div class="page-card">
    <div class="page-header">
        <h1>Carcass Categories</h1>
        <a href="create.php" class="theme-btn">+ Add Category</a>
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
            <?php while($row = mysqli_fetch_assoc($query)){ ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['category_name'] ?></td>
                    <td>
                        <?php if($row['status'] == 1){ ?>
                            <span class="status-active">Active</span>
                        <?php }else{ ?>
                            <span class="status-inactive">Inactive</span>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include '../../../includes/footer.php'; ?>