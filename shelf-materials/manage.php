<?php
include '../includes/auth.php';
include '../db.php';
if(!can('shelves_view')){
    die('Access Denied');
}
/** @var mysqli $conn */
include '../includes/header.php';
include '../includes/sidebar.php';
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;
$totalRecordsQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM shelf_materials"
);
$totalRecords = mysqli_fetch_assoc($totalRecordsQuery)['total'];
$totalPages = ceil($totalRecords / $limit);
$query = mysqli_query(
    $conn,
    "SELECT
        shelf_materials.*,
        shelf_categories.category_name
    FROM shelf_materials
    LEFT JOIN shelf_categories
    ON shelf_categories.id =
    shelf_materials.category_id
    ORDER BY shelf_materials.id ASC
    LIMIT $limit OFFSET $offset"
);
?>
<div class="page-card">
    <div class="page-header">
        <h1>Shelf Materials</h1>
        <?php if(can('shelves_create')){ ?>
            <a href="create.php" class="theme-btn">+ Add Material</a>
        <?php } ?>
    </div>
    <table class="custom-table">
        <thead>
            <tr>
                <th>Sr No.</th>
                <th>Category</th>
                <th>Material</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $srNo = $offset + 1;
                while($row = mysqli_fetch_assoc($query)){
            ?>
                <tr>
                    <td><?= $srNo++ ?></td>
                    <td><?= htmlspecialchars($row['category_name']) ?></td>
                    <td><?= htmlspecialchars($row['material_name']) ?></td>
                    <td>₹ <?= number_format($row['price_per_sqft'], 2) ?></td>
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
                        <?php if(can('shelves_delete')){ ?>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                        <?php } ?>
                    </td>
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