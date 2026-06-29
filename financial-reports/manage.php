<?php
include '../includes/auth.php';
include '../db.php';
/** @var mysqli $conn */
include '../includes/header.php';
include '../includes/sidebar.php';

if(!can('pr_view')){
    die('Access Denied');
}

/* PAGINATION */

$limit = 10;

$page = isset($_GET['page'])
    ? (int)$_GET['page']
    : 1;

$page = max($page, 1);

$offset = ($page - 1) * $limit;

/* TOTAL RECORDS */

$totalQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM financial_reports "
);

$totalRecords = mysqli_fetch_assoc(
    $totalQuery
)['total'];

$totalPages = ceil($totalRecords / $limit);

/* FETCH REPORTS */

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM financial_reports
    ORDER BY id ASC
    LIMIT $limit OFFSET $offset
    "
);
?>
<style>
.page-title{font-size:30px;font-weight:700;margin-bottom:25px;color:#111827}.top-bar{display:flex;justify-content:space-between;align-items:center;margin-bottom:25px}.add-btn{background:#16a34a;color:#fff;text-decoration:none;padding:12px 18px;border-radius:8px;font-size:14px;font-weight:600}.add-btn:hover{background:#15803d}.table-wrapper{background:#fff;border-radius:14px;overflow:auto;box-shadow:0 4px 20px rgb(0 0 0 / .08);border:1px solid #e5e7eb}thead th{text-align:center;border-right:1px solid #374151;white-space:nowrap}tbody td{border-top:1px solid #e5e7eb;text-align:center;white-space:nowrap;border-right:1px solid #374151}tbody tr:nth-child(even){background:#f9fafb}tbody tr:hover{background:#f3f4f6}.amount{font-weight:600;color:#111827}.no-data{text-align:center;padding:30px;font-size:15px;font-weight:600;color:#6b7280}.table-wrapper::-webkit-scrollbar{height:10px}.table-wrapper::-webkit-scrollbar-thumb{background:#9ca3af;border-radius:10px}.table-wrapper::-webkit-scrollbar-track{background:#e5e7eb}
</style>
<div class="page-card">

    <div class="top-bar">
        <h2 class="page-title">Financial Reports</h2>

        <?php if(can('pr_create')){ ?>
            <a href="index.php" class="add-btn">
                + Create Report
            </a>
        <?php } ?>
    </div>

    <div class="table-wrapper">

        <table class="custom-table mt-0">

            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Customer</th>
                    <th>Delivery Date</th>
                    <th>FR Value</th>
                    <th>Delivery</th>
                    <th>FR Installation</th>
                    <th>Total Pre GST</th>
                    <th>GST 18%</th>
                    <th>Total Project with 18% GST</th>
                    <th>Received FR Payment</th>
                    <th>Balance FR Payment</th>
                    <th>Gross Margin Pre GST</th>
                    <th>CR Amount</th>
                    <th>CR Transport</th>
                    <th>CR Installation</th>
                    <th>CR Total Pre GST</th>
                    <th>GST 18%</th>
                    <th>Total Project with 18% GST</th>
                    <th>From F&R - CR Payment Done</th>
                    <th>Balance</th>
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

                    <td><?= $row['customer_name'] ?></td>
                    <td><?= $row['delivery_date'] ?></td>

                    <td class="amount">
                        ₹<?= number_format($row['fr_value']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['delivery']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['fr_installation']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['total_pre_gst']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['gst_amount']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['total_project']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['fr_payment']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['balance_payment']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['gross_margin_pre_gst']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['cr_amount']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['cr_transport']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['cr_installation']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['cr_total_pre_gst']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['cr_gst']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['cr_total_project']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['cr_payment_done']) ?>
                    </td>

                    <td class="amount">
                        ₹<?= number_format($row['cr_balance']) ?>
                    </td>

                    <td class="action-links">

                        <a
                            href="view.php?id=<?= $row['id'] ?>"
                            class="edit-btn"
                        >
                            View
                        </a>

                        <?php if(can('pr_edit')){ ?>
                            <a
                                href="edit.php?id=<?= $row['id'] ?>"
                                class="edit-btn"
                            >
                                Edit
                            </a>
                        <?php } ?>

                        <?php if(can('pr_delete')){ ?>
                            <a
                                href="delete.php?id=<?= $row['id'] ?>"
                                class="delete-btn"
                                onclick="return confirm('Delete this report?')"
                            >
                                Delete
                            </a>
                        <?php } ?>

                    </td>

                </tr>

                <?php
                    }
                }else{
                ?>

                <tr>
                    <td colspan="21" class="no-data">
                        No Financial Reports Found
                    </td>
                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

    <?php if($totalPages > 1){ ?>

    <div class="pagination">

        <?php if($page > 1){ ?>
            <a href="?page=<?= $page - 1 ?>">
                &laquo; Prev
            </a>
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

            <a
                href="?page=<?= $i ?>"
                class="<?= ($i == $page) ? 'active' : '' ?>"
            >
                <?= $i ?>
            </a>

        <?php } ?>

        <?php if($page < $totalPages - 2){ ?>

            <?php if($page < $totalPages - 3){ ?>
                <span class="pagination-dots">...</span>
            <?php } ?>

            <a href="?page=<?= $totalPages ?>">
                <?= $totalPages ?>
            </a>

        <?php } ?>

        <?php if($page < $totalPages){ ?>
            <a href="?page=<?= $page + 1 ?>">
                Next &raquo;
            </a>
        <?php } ?>

    </div>

    <?php } ?>

</div>

<?php include('../includes/footer.php'); ?>