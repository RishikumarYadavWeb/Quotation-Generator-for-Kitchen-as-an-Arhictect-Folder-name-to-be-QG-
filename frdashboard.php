<?php
include 'db.php';
/** @var mysqli $conn */
include 'includes/header.php';
include 'includes/sidebar.php';

if(!can('frdashboard_view')){
    die('Access Denied');
}
$entityId = 1;

/* =========================================
   TOTAL QUOTATIONS
========================================= */

$totalQuotationQuery = mysqli_query(
    $conn,
    "
    SELECT COUNT(*) as total
    FROM quotations
    WHERE entity_id='$entityId'
    "
);

$totalQuotation =
mysqli_fetch_assoc(
    $totalQuotationQuery
);

/* =========================================
   TOTAL REVENUE
========================================= */

$totalRevenueQuery = mysqli_query(
    $conn,
    "
    SELECT
        COALESCE(
            SUM(final_customer_price),
            0
        ) as revenue
    FROM quotations
    WHERE entity_id='$entityId'
    "
);

$totalRevenue =
mysqli_fetch_assoc(
    $totalRevenueQuery
);
// PAGINATION

$limit = 15;

$page = isset($_GET['page'])
    ? (int)$_GET['page']
    : 1;

$page = max($page, 1);

$offset = ($page - 1) * $limit;

// TOTAL RECORDS

$totalQuotationPages = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "
        SELECT COUNT(*) as total
        FROM quotations
        WHERE entity_id='$entityId'
        "
    )
);

$totalRecords = $totalQuotationPages['total'];
$totalPages = ceil($totalRecords / $limit);
/* =========================================
   QUOTATIONS
========================================= */

$quotationQuery = mysqli_query(
    $conn,
    "
    SELECT
        quotations.*,
        users.name AS created_user_name
    FROM quotations

    LEFT JOIN users
    ON quotations.created_by = users.id

    WHERE quotations.entity_id='$entityId'

    ORDER BY quotations.id DESC

    LIMIT $limit OFFSET $offset
    "
);

/* =========================================
   TOTAL SQFT
========================================= */

$totalSqftQuery = mysqli_query(
    $conn,
    "
    SELECT
        COALESCE(
            SUM(total_sqft),
            0
        ) as total_sqft
    FROM quotations
    WHERE entity_id='$entityId'
    "
);

$totalSqft =
mysqli_fetch_assoc(
    $totalSqftQuery
);
?>

<style>
    .dashboard-title{
        font-size:38px;
        font-weight:700;
        color:#111827;
        margin-bottom:35px;
    }
    .stats-wrapper{
        display:flex;
        gap:25px;
        flex-wrap:wrap;
        margin-bottom:40px;
    }
    .stat-card{
        background:#ffffff;
        border-radius:18px;
        padding:28px;
        min-width:280px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition:0.3s ease;
    }
    .stat-card:hover{
        transform:translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }
    .stat-card h3{
        font-size:16px;
        color:#6b7280;
        margin-bottom:15px;
    }
    .stat-card h1{
        font-size:42px;
        color:#111827;
    }
    .chart-wrapper{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:25px;
        margin-bottom:40px;
    }
    .chart-card{
        background:#ffffff;
        border-radius:18px;
        padding:25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .table-card{
        background:#ffffff;
        border-radius:18px;
        padding:25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .dashboard-table{
        width:100%;
        border-collapse:collapse;
    }
    .dashboard-table thead{
        background:#f9fafb;
    }
    .dashboard-table th{
        text-align:left;
        padding:18px 16px;
        font-size:14px;
        color:#374151;
        border-bottom:1px solid #e5e7eb;
    }
    .dashboard-table td{
        padding:18px 16px;
        border-bottom:1px solid #f1f5f9;
        font-size:14px;
    }
    .dashboard-table tbody tr:hover{
        background:#f9fafb;
    }
    .pdf-btn{
        display:inline-block;
        padding:10px 18px;
        border-radius:10px;
        background:#2563eb;
        color:#ffffff;
        text-decoration:none;
        font-size:13px;
        font-weight:600;
        transition:0.3s ease;
    }
    .pdf-btn:hover{
        background:#1d4ed8;
    }
    @media(max-width:900px){
        .chart-wrapper{
            grid-template-columns:1fr;
        }
    }
</style>

<div class="dashboard-wrapper">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-main-title">F&R Kitchens And Wardrobe Dashboard</h1>
            <p class="dashboard-subtitle">Executive overview of quotation system</p>
        </div>
        <div class="dashboard-date">
            <i class="fa-solid fa-calendar-days" style="margin-right: 10px;"></i><?= date('d M Y'); ?>
        </div>
    </div>
    
    <div class="dashboard-wrapper">
        <div class="dashboard-kpi-grid" style="grid-template-columns: repeat(3, 1fr);">
            <div class="dashboard-kpi-card">
                <div class="kpi-icon blue-gradient">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div class="kpi-content">
                    <div class="kpi-label">Total Quotations</div>
                    <div class="kpi-value">
                        <?= $totalQuotation['total'] ?? 0; ?>
                    </div>
                </div>
            </div>
            <div class="dashboard-kpi-card">
                <div class="kpi-icon green-gradient">
                    <i class="fa-solid fa-indian-rupee-sign"></i>
                </div>
                <div class="kpi-content">
                    <div class="kpi-label">Total Revenue</div>
                    <div class="kpi-value">
                        ₹  <?= number_format($totalRevenue['revenue']) ?>
                    </div>
                </div>
            </div>
            <div class="dashboard-kpi-card">
                <div class="kpi-icon purple-gradient">
                    <i class="fa-solid fa-ruler-combined"></i>
                </div>
                <div class="kpi-content">
                    <div class="kpi-label">Total Sq.Ft</div>
                    <div class="kpi-value">
                        <?= number_format(
                            $totalSqft['total_sqft'] ?? 0,
                            0
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-card">
        <div class="analytics-title">Project Analytics</div>
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Project Type</th>
                    <th>Created By</th>
                    <th>Total SQFT</th>
                    <th>Grand Total</th>
                    <th>View PDF</th>
                </tr>
            </thead>
            <tbody>
                <?php while($quotation = mysqli_fetch_assoc($quotationQuery)): ?>
                <tr>
                    <td><?= $quotation['project_type'] ?></td>
                    <td><?= $quotation['created_user_name'] ?></td>
                    <td><?= $quotation['total_sqft'] ?></td>
                    <td>₹  <?= number_format($quotation['final_customer_price'] ?? 0) ?></td>
                    <td>
                        <a class="edit-btn" href="/QG/export-pdf.php?id=<?= $quotation['id'] ?>&details=yes" target="_blank">
                            Detailed PDF
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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
            class="<?= ($i == $page)
                ? 'active'
                : '' ?>"
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
</div>
<?php include 'includes/footer.php'; ?>