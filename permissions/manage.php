<?php
    include '../db.php';
    include '../includes/auth.php';
    if(!can('permissions_manage')){
        die('Access Denied');
    }
    /** @var mysqli $conn */
    
    include '../includes/header.php';
    include '../includes/sidebar.php';
    $limit = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max($page, 1);
    $offset = ($page - 1) * $limit;
    $totalPermissionsQuery = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
        FROM permissions
        ORDER BY module ASC"
    );
    $totalRecords = mysqli_fetch_assoc($totalPermissionsQuery)['total'];
    $totalPages = ceil($totalRecords / $limit);
    $permissions = mysqli_query(
        $conn,
        "
        SELECT *
        FROM permissions
        ORDER BY module ASC
        LIMIT $limit OFFSET $offset
        "
    );
?>
<div class="page-card">
    <div class="top-bar">
        <h2>View Permissions Table</h2>
    </div>
    <table class="custom-table">
        <thead>
            <tr>
                <th>Sr No.</th>
                <th>Module</th>
                <th>Permission</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $srNo = $offset + 1;
                while($row = mysqli_fetch_assoc($permissions)){
            ?>
                <tr>
                    <td><?= $srNo++ ?></td>
                    <td><?= htmlspecialchars($row['module']) ?></td>
                    <td><?= htmlspecialchars($row['permission_name']) ?></td>
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