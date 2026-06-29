<?php
include '../includes/auth.php';
include '../db.php';
/** @var mysqli $conn */
include '../includes/header.php';
include '../includes/sidebar.php';
$isEdit = false;
$quotationId = 0;
/* GET QUOTATIONS */
$user_id = $_SESSION['user_id'];
$role_name = $_SESSION['role_name'];
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
    ";
}
$result = mysqli_query($conn, $query);
?>
<div class="page-card">
    <!-- PAGE HEADER -->
    <div class="top-header mb-4">
        <div>
            <h2 class="page-title">Manage Quotations</h2>
            <p class="page-subtitle">View all saved quotations</p>
        </div>
        <a href="create.php" class="theme-btn" style="text-decoration:none;display:flex;align-items:center;justify-content:center;max-width:220px;">Create New Quotation</a>
    </div>
    <!-- TABLE CARD -->
     <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
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
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td><?= $row['client_name']; ?></td>
                    <td><?= $row['project_type']; ?></td>
                    <td><?= $row['created_user_name'] ?></td>
                    <td><?= number_format($row['total_sqft'],2); ?></td>
                    <td>₹<?= number_format($row['final_customer_price'],2); ?></td>
                    <td>
                        <div style="display:flex;gap:10px;">
                            <a href="view.php?id=<?= $row['id']; ?>" class="edit-btn">View</a>
                            <a href="edit.php?id=<?= $row['id']; ?>" class="edit-btn">Edit</a>
                            <a href="delete.php?id=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this quotation?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php }
                }else{ ?>
                <tr>
                    <td colspan="9" class="text-center">No Quotations Found</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../includes/footer.php';?>