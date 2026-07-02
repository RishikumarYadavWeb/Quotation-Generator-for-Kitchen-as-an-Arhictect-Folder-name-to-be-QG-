<?php 
    include '../../../includes/auth.php';
    include '../../../db.php'; 
    if(!can('shutter_view')){
        die('Access Denied');
    }
    /** @var mysqli $conn */
    include '../../../includes/header.php'; 
    include '../../../includes/sidebar.php'; 
?>
<div class="container">
    <div class="top-bar">
        <h2>Manage Categories</h2>
        <?php if(can('shutter_create')){ ?>
            <a href="category.php" class="theme-btn">+ Add Category</a>
        <?php } ?>
    </div>
    <div>
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
                <?php
                    $query = "SELECT * FROM shutter_categories ORDER BY id ASC";
                    $result = mysqli_query($conn, $query);
                    $srNo=1;
                    while($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td data-label="Sr No:"><?= $srNo++ ?></td>
                        <td data-label="Category:"><?= $row['category_name']; ?></td>
                        <td data-label="Status:">
                            <?php if($row['status'] == 1){ ?>
                                <span class="status-active">Active</span>
                            <?php }else{ ?>
                                <span class="status-inactive">Inactive</span>
                            <?php } ?>
                        </td>
                        <td data-label="Action:" class="d-flex">
                            <?php if(can('shutter_edit')){ ?>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                            <?php } ?>
                            <?php if(can('shutter_delete')){ ?>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete Category?')">Delete</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../../../includes/footer.php'; ?>