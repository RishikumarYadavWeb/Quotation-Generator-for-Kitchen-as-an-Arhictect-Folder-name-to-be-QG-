<?php
    include '../includes/auth.php';
    include '../db.php';
    if(!can('quotation_view')){
        die('Access Denied');
    }
    /** @var mysqli $conn */
    include '../includes/header.php';
    include '../includes/sidebar.php';
    $isEdit = false;
    $quotationId = 0;
    $user_id = $_SESSION['user_id'];
    $role_name = $_SESSION['role_name'];
    $limit = 15;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max($page, 1);
    $offset = ($page - 1) * $limit;
    if(can('quotation_view_all')){
        $countQuery = "
            SELECT COUNT(*) AS total
            FROM quotations
        ";
    }else{
        $countQuery = "
            SELECT COUNT(*) AS total
            FROM quotations
            WHERE created_by = '$user_id'
        ";
    }
    $countResult = mysqli_query($conn, $countQuery);
    $totalRecords = mysqli_fetch_assoc($countResult)['total'];
    $totalPages = ceil($totalRecords / $limit);
    if(can('quotation_view_all')){
        $query = "
        SELECT
            quotations.id,
            quotations.project_type,
            quotations.total_sqft,
            quotations.grand_total,
            quotations.final_customer_price,
            quotations.created_by,
            clients.client_name,
            clients.phone,
            clients.email,
            users.name AS created_user_name
        FROM quotations
        LEFT JOIN clients
        ON quotations.client_id = clients.id
        LEFT JOIN users
        ON quotations.created_by = users.id
        ORDER BY quotations.id DESC
        LIMIT $limit OFFSET $offset
        ";
    }else{
        $query = "
        SELECT
            quotations.id,
            quotations.total_sqft,
            quotations.project_type,
            quotations.grand_total,
            quotations.final_customer_price,
            quotations.created_by,
            clients.client_name,
            clients.phone,
            clients.email,
            users.name AS created_user_name
        FROM quotations
        LEFT JOIN clients
        ON quotations.client_id = clients.id
        LEFT JOIN users
        ON quotations.created_by = users.id
        WHERE quotations.created_by = '$user_id'
        ORDER BY quotations.id DESC
        LIMIT $limit OFFSET $offset
        ";
    }
    $result = mysqli_query($conn, $query);
?>
<div class="page-card">
    <div class="top-header mb-4">
        <div>
            <h2 class="page-title">Manage Quotations</h2>
            <p class="page-subtitle">View all saved quotations</p>
        </div>
        <a href="create.php" class="theme-btn" style="text-decoration:none;display:flex;align-items:center;justify-content:center;max-width:220px;">Create New Quotation</a>
    </div>
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Client</th>
                    <th>Project Type</th>
                    <th>Created By</th>
                    <th>Total Sq.Ft</th>
                    <th>Grand Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $srNo = $totalRecords - $offset;
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                ?>
                    <tr>
                        <td><?= $srNo-- ?></td>
                        <td><?= htmlspecialchars($row['client_name']) ?></td>
                        <td><?= htmlspecialchars($row['project_type']) ?></td>
                        <td><?= htmlspecialchars($row['created_user_name']) ?></td>
                        <td><?= number_format($row['total_sqft'],2) ?></td>
                        <td>₹ <?= number_format($row['final_customer_price'],2) ?></td>
                        <td>
                            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                                <a href="view.php?id=<?= $row['id']; ?>" class="edit-btn">View</a>
                                <?php if(can('quotation_edit')){ ?>
                                    <a href="edit.php?id=<?= $row['id']; ?>" class="edit-btn">Edit</a>
                                <?php } ?>
                                <?php if(can('quotation_delete')){ ?>
                                    <a href="delete.php?id=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this quotation?')">Delete</a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php
                        }
                    }else{
                ?>
                    <tr>
                        <td colspan="7" class="text-center">No Quotations Found</td>
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