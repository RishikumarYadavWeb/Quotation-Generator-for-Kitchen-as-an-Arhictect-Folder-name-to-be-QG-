<?php
include '../includes/auth.php';
include '../db.php';
if(!can('appliances_view')){
    die('Access Denied');
}
/** @var mysqli $conn */
include '../includes/header.php';
include '../includes/sidebar.php';
$limit = 15;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$search = mysqli_real_escape_string($conn,trim($_GET['search'] ?? ''));
$where = "";
if($search != ""){
    $where = "
    WHERE
        appliance_name LIKE '%$search%'
        OR company_name LIKE '%$search%'
        OR description LIKE '%$search%'
    ";
}
$totalQuery = mysqli_query(
    $conn,
    "
    SELECT COUNT(*) total
    FROM appliances
    $where
    "
);
$totalRecords = mysqli_fetch_assoc($totalQuery)['total'];
$totalPages = ceil($totalRecords / $limit);
$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM appliances $where
    ORDER BY appliance_name,company_name,description
    LIMIT $limit OFFSET $offset
    "
);
?>
<div class="page-card">
    <div class="page-header">
        <div>
            <h1>Appliances</h1>
            <p>Manage Appliance Catalogue</p>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <?php if(can('appliances_import')){ ?>
            <a href="import.php" class="theme-btn"><i class="fa-solid fa-file-import"></i>Import CSV</a>
            <?php } ?>
            <?php if(can('appliances_export')){ ?>
            <a href="export.php" class="theme-btn"><i class="fa-solid fa-file-export"></i>Export CSV</a>
            <?php } ?>
            <?php if(can('appliances_create')){ ?>
            <a href="create.php" class="theme-btn"><i class="fa-solid fa-plus"></i>Add Appliance</a>
            <?php } ?>
        </div>
    </div>
    <form method="GET" style="margin-bottom:20px;">
        <div style="display:flex;gap:10px;">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search Appliance...">
            <button class="theme-btn">Search</button>
        </div>
    </form>
    <div class="table-wrapper">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Appliance</th>
                    <th>Company</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Price</th>
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
                    <td data-label="Sr No"><?= $srNo++ ?></td>
                    <td data-label="Appliance"><?= htmlspecialchars($row['appliance_name']) ?></td>
                    <td data-label="Company"><?= htmlspecialchars($row['company_name']) ?></td>
                    <td data-label="Description"><?= htmlspecialchars($row['description']) ?></td>
                    <td data-label="Unit"><?= htmlspecialchars($row['unit']) ?></td>
                    <td data-label="Price">₹ <?= number_format($row['price'],2) ?></td>
                    <td data-label="Status">
                        <?php if($row['status']==1){ ?>
                            <span class="status-active">Active</span>
                        <?php }else{ ?>
                            <span class="status-inactive">Inactive</span>
                        <?php } ?>
                    </td>
                    <td data-label="Action">
                        <div class="action-btns">
                            <?php if(can('appliances_edit')){ ?>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                            <?php } ?>
                            <?php if(can('appliances_delete')){ ?>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete Appliance?')">Delete</a>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            <?php
                }
            }else{
            ?>
                <tr>
                    <td colspan="8" style="text-align:center;">No Appliances Found</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php if($totalPages > 1){ ?>
    <div class="pagination">
        <?php if($page > 1){ ?>
            <a href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">&laquo; Prev</a>
        <?php } ?>
        <?php
        $start = max(1,$page-2);
        $end = min($totalPages,$page+2);
        for($i=$start;$i<=$end;$i++){
        ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="<?= $page==$i ? 'active' : '' ?>"><?= $i ?></a>
        <?php } ?>
        <?php if($page < $totalPages){ ?>
            <a href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>">Next &raquo;</a>
        <?php } ?>
    </div>
    <?php } ?>
</div>
<?php include '../includes/footer.php'; ?>