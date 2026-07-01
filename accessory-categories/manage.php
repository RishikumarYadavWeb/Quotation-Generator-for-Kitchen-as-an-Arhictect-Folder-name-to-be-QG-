<?php
    include '../includes/auth.php';
    include '../db.php';
    if(!can('accessories_category_view')){
        die('Access Denied');
    }
    /** @var mysqli $conn */
    include '../includes/header.php';
    include '../includes/sidebar.php';
    $limit = 10;
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offset = ($page - 1) * $limit;
    $totalQuery = mysqli_query(
        $conn,
        "
        SELECT COUNT(*) AS total
        FROM accessory_categories
        "
    );
    $totalRecords = mysqli_fetch_assoc($totalQuery)['total'];
    $totalPages = ceil($totalRecords / $limit);
    $query = mysqli_query(
        $conn,
        "
        SELECT *
        FROM accessory_categories
        ORDER BY id ASC
        LIMIT $limit OFFSET $offset
        "
    );
?>
<div class="page-card">
    <div class="page-header">
        <div>
            <h1>Accessory Categories</h1>
        </div>
        <?php if(can('accessories_category_create')){ ?>
            <a href="create.php" class="theme-btn"><i class="fa-solid fa-plus"></i>Add Accessory</a>
        <?php } ?>
    </div>
    <table class="custom-table">
        <thead>
            <tr>
                <th>Sr No</th>
                <th>Category</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $srNo = $offset + 1;
                if(mysqli_num_rows($query) > 0){
                    while($row = mysqli_fetch_assoc($query)){
            ?>
            <tr>
                <td><?= $srNo++ ?></td>
                <td><?= htmlspecialchars($row['category_name']) ?></td>
                <td>
                    <?php if(
                        $row['status'] == 1
                    ){ ?>
                        <span class="status-active">Active</span>
                    <?php }else{ ?>
                        <span class="status-inactive">Inactive</span>
                    <?php } ?>
                </td>
                <td>
                    <div class="action-btns">
                        <?php if(can('accessories_category_edit')){ ?>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                        <?php } ?>
                        <?php if(can('accessories_category_delete')){ ?>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete Category?')">Delete</a>
                        <?php } ?>
                    </div>
                </td>
            </tr>
            <?php
                    }
                }else{
            ?>
            <tr>
                <td colspan="4" style="text-align:center;">No Categories Found</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php if($totalPages > 1){ ?>
    <div class="pagination">
        <?php if($page > 1){ ?>
            <a href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
        <?php } ?>
        <?php if($page > 3){ ?>
            <a href="?page=1">1</a>
            <?php if($page > 4){ ?>
                <span class="pagination-dots">...</span>
            <?php } ?>
        <?php } ?>
        <?php
            $start = max(1, $page - 2);
            $end   = min($totalPages, $page + 2);
            for($i = $start; $i <= $end; $i++){
        ?>
            <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
        <?php } ?>
        <?php if($page < $totalPages - 2){ ?>
            <?php if($page < $totalPages - 3){ ?>
                <span class="pagination-dots">...</span>
            <?php } ?>
            <a href="?page=<?= $totalPages ?>"><?= $totalPages ?></a>
        <?php } ?>
        <?php if($page < $totalPages){ ?>
            <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
        <?php } ?>
    </div>
    <?php } ?>
</div>
<?php include '../includes/footer.php'; ?>