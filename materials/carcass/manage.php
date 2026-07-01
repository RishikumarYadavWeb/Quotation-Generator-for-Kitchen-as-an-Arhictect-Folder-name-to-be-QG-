<?php
    include '../../includes/auth.php';
    include '../../db.php';
    if(!can('carcass_view')){
        die('Access Denied');
    }
    /** @var mysqli $conn */
    include '../../includes/header.php';
    include '../../includes/sidebar.php';
    $limit = 10;
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offset = ($page - 1) * $limit;
    $totalQuery = mysqli_query(
        $conn,
        "
        SELECT COUNT(*) AS total
        FROM carcass_materials
        "
    );
    $totalRecords = mysqli_fetch_assoc($totalQuery)['total'];
    $totalPages = ceil($totalRecords / $limit);
    $query = mysqli_query(
        $conn,
        "
        SELECT
            carcass_materials.*,
            carcass_categories.category_name
        FROM carcass_materials
        LEFT JOIN carcass_categories
        ON carcass_categories.id =
        carcass_materials.category_id
        ORDER BY carcass_materials.id DESC
        LIMIT $limit OFFSET $offset
        "
    );
?>
<div class="page-card">
    <div class="page-header">
        <h1>Carcass Materials</h1>
        <?php if(can('carcass_create')){ ?>
            <a href="material.php" class="theme-btn">+ Add Material</a>
        <?php } ?>
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
                <?php
                    $srNo = $offset + 1;
                    if(mysqli_num_rows($query) > 0){while($row = mysqli_fetch_assoc($query)){
                ?>
                    <tr>
                        <td><?= $srNo++ ?></td>
                        <td><?= htmlspecialchars($row['category_name']) ?></td>
                        <td><?= htmlspecialchars($row['material_name']) ?></td>
                        <td>₹ <?= number_format($row['price_per_sqft'],2) ?></td>
                        <td>
                            <?php if($row['status'] == 1){ ?>
                                <span class="status-active">Active</span>
                            <?php }else{ ?>
                                <span class="status-inactive">Inactive</span>
                            <?php } ?>
                        </td>
                        <td class="d-flex">
                            <?php if(can('carcass_edit')){ ?>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                            <?php } ?>
                            <?php if(can('carcass_delete')){ ?>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete Category?')">Delete</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php
                        }
                    }else{
                ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">No Materials Found</td>
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
<?php include '../../includes/footer.php'; ?>