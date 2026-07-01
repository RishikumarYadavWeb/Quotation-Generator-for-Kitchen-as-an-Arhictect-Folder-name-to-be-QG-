<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    if(!can('accessories_view')){
        die('Access Denied');
    }
    $limit = 15;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max($page, 1);
    $offset = ($page - 1) * $limit;
    $totalAccessoriesQuery = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
        FROM accessories"
    );
    $totalRecords = mysqli_fetch_assoc($totalAccessoriesQuery)['total'];
    $totalPages = ceil($totalRecords / $limit);
    $getAccessories = mysqli_query(
        $conn,
        "
        SELECT
            a.*,
            ac.category_name
        FROM accessories a
        LEFT JOIN accessory_categories ac
        ON a.category_id = ac.id
        ORDER BY a.id DESC
        LIMIT $limit OFFSET $offset
        "
    );
    include '../includes/header.php';
    include '../includes/sidebar.php';
?>
<div class="page-card">
    <div class="page-header">
        <div>
            <h1 class="page-title">Accessories Management</h1>
            <p class="page-subtitle">Manage all accessories.</p>
        </div>
        <?php if(can('accessories_create')){ ?>
            <a href="create.php" class="theme-btn"><i class="fa-solid fa-plus"></i>Add Accessory</a>
        <?php } ?>
    </div>
    <div class="table-wrapper">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $srNo = $offset + 1;
                    while($row = mysqli_fetch_assoc($getAccessories)){
                ?>
                    <tr>
                        <td><?= $srNo++ ?></td>
                        <td><?= htmlspecialchars($row['accessory_name']) ?></td>
                        <td><?= htmlspecialchars($row['category_name']) ?></td>
                        <td>
                            <?php if($row['status'] == 'active'){ ?>
                                <span class="status-active">Active</span>
                            <?php }else{ ?>
                                <span class="status-inactive">Inactive</span>
                            <?php } ?>
                        </td>
                        <td><?= htmlspecialchars($row['unit']) ?></td>
                        <td>₹ <?= number_format($row['price'],2) ?></td>
                        <td>
                            <div class="action-btns">
                                <?php if(can('accessories_edit')){ ?>
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                                <?php } ?>
                                <?php if(can('accessories_delete')){ ?>
                                    <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn" onclick=" return confirm('Are you sure you want to delete this accessory?')">Delete</a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
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
                $end = min($totalPages, $page + 2);
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