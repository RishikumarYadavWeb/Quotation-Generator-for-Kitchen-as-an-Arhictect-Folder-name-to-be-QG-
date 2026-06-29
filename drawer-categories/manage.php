<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    include '../includes/header.php';
    include '../includes/sidebar.php';
    if(!can('drawers_view')){
        die('Access Denied');
    }
    $query = mysqli_query($conn,"SELECT * FROM drawer_categories ORDER BY id DESC");
?>
<div class="page-card">
    <div class="page-header">
        <h1>Drawer Categories</h1>
        <?php if(can('crdashboard_view')){ ?>
            <a href="create.php" class="theme-btn">+ Add Category</a>
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
                        <?php if(can('crdashboard_view')){ ?>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                        <?php } ?>
                        <?php if(can('crdashboard_view')){ ?>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn">Delete</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>