<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    include '../includes/header.php';
    include '../includes/sidebar.php';
    if(!can('shelves_view')){
        die('Access Denied');
    }
    $query = mysqli_query(
        $conn,
        "SELECT *
        FROM shelf_categories
        ORDER BY id ASC"
    );
?>
<div class="page-card">
    <div class="page-header">
        <h1>Shelf Categories</h1>
        <?php if(can('shelves_edit')){ ?>
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
                        <?php if(can('shelves_edit')){ ?>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                        <?php } ?>
                        <?php if(can('shelves_edit')){ ?>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn">Delete</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>