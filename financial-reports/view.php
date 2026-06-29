<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    include '../includes/header.php';
    include '../includes/sidebar.php';
    if(!can('drawers_view')){
        die('Access Denied');
    }
    $id = (int) $_GET['id'];
    $query = mysqli_query($conn, "
    SELECT * FROM financial_reports
    WHERE id = '$id'
    ");
    $report = mysqli_fetch_assoc($query);
    if(!$report){
        die("Financial Report Not Found");
    }
?>
<style>
    .page-title{
        font-size:30px;
        font-weight:700;
        margin-bottom:25px;
        color:#111827;
    }
    .view-card{
        background:#fff;
        padding:30px;
        border-radius:14px;
        box-shadow:0 4px 20px rgba(0,0,0,0.08);
        border:1px solid #e5e7eb;
        margin-bottom:30px;
    }
    .section-title{
        font-size:18px;
        font-weight:700;
        margin-bottom:20px;
        color:#1e293b;
        border-bottom:2px solid #e5e7eb;
        padding-bottom:10px;
    }
    .details-grid{
        display:grid;
        grid-template-columns:repeat(4, 1fr);
        gap:20px;
    }
    .detail-box{
        background:#f9fafb;
        border:1px solid #e5e7eb;
        border-radius:10px;
        padding:18px;
    }
    .detail-label{
        font-size:12px;
        font-weight:600;
        color:#6b7280;
        margin-bottom:8px;
        text-transform:uppercase;
    }
    .detail-value{
        font-size:18px;
        font-weight:700;
        color:#111827;
        word-break:break-word;
    }
    .amount{
        color:#16a34a;
    }
    .amount-red{
        color:red;
    }
    .action-bar{
        margin-top:30px;
        display:flex;
        gap:15px;
    }
    .action-btn{
        padding:12px 20px;
        border-radius:8px;
        text-decoration:none;
        font-size:14px;
        font-weight:600;
        color:#fff;
    }
    .edit-btn{
        background:#2563eb;
    }
    .back-btn{
        background:#6b7280;
    }
    @media(max-width:1200px){
        .details-grid{
            grid-template-columns:repeat(2, 1fr);
        }
    }
    @media(max-width:768px){
        .details-grid{
            grid-template-columns:1fr;
        }
    }
</style>

<div class="page-card">
    <h2 class="page-title">Financial Report Details</h2>
    <div class="view-card">
        <div class="section-title">Customer Details</div>
        <div class="details-grid">
            <div class="detail-box">
                <div class="detail-label">Customer Name</div>
                <div class="detail-value"><?= $report['customer_name'] ?></div>
            </div>
            <div class="detail-box">
                <div class="detail-label">Delivery Date</div>
                <div class="detail-value"><?= $report['delivery_date'] ?></div>
            </div>
            <div class="detail-box">
                <div class="detail-label">Created At</div>
                <div class="detail-value"><?= date('d M Y', strtotime($report['created_at'])) ?></div>
            </div>
        </div>
    </div>
    <div class="view-card">
        <div class="section-title">Pre GST Details (F&R)</div>
        <div class="details-grid">
            <div class="detail-box">
                <div class="detail-label">FR Value</div>
                <div class="detail-value amount">₹<?= number_format($report['fr_value']) ?></div>
            </div>
            <div class="detail-box">
                <div class="detail-label">Delivery</div>
                <div class="detail-value amount">₹<?= number_format($report['delivery']) ?></div>
            </div>
            <div class="detail-box">
                <div class="detail-label">Installation</div>
                <div class="detail-value amount">₹<?= number_format($report['fr_installation']) ?></div>
            </div>
            <div class="detail-box">
                <div class="detail-label">Total Pre GST</div>
                <div class="detail-value amount">₹<?= number_format($report['total_pre_gst']) ?></div>
            </div>
            <div class="detail-box">
                <div class="detail-label">GST (18%)</div>
                <div class="detail-value amount">₹<?= number_format($report['gst_amount']) ?></div>
            </div>
            <div class="detail-box">
                <div class="detail-label">Total Project</div>
                <div class="detail-value amount">₹<?= number_format($report['total_project']) ?></div>
            </div>
        </div>
    </div>
    <div class="view-card">
        <div class="section-title">Payment Details (F&R)</div>
        <div class="details-grid">
            <div class="detail-box">
                <div class="detail-label">FR Payment</div>
                <div class="detail-value amount">₹<?= number_format($report['fr_payment']) ?></div>
            </div>
            <div class="detail-box">
                <div class="detail-label">Balance Payment</div>
                <div class="detail-value amount-red">₹<?= number_format($report['balance_payment']) ?></div>
            </div>
            <div class="detail-box">
                <div class="detail-label">Gross Margin</div>
                <div class="detail-value amount">₹<?= number_format($report['gross_margin_pre_gst']) ?></div>
            </div>
        </div>
    </div>
    <div class="view-card">
        <div class="section-title">Pre GST Details (CR)</div>
        <div class="details-grid">
            <div class="detail-box">
                <div class="detail-label">CR Amount</div>
                <div class="detail-value amount">₹<?= number_format($report['cr_amount']) ?></div>
            </div>
            <div class="detail-box">
                <div class="detail-label">CR Transport</div>
                <div class="detail-value amount">₹<?= number_format($report['cr_transport']) ?></div>
            </div>
            <div class="detail-box">
                <div class="detail-label">CR Installation</div>
                <div class="detail-value amount">₹<?= number_format($report['cr_installation']) ?></div>
            </div>
            <div class="detail-box">
                <div class="detail-label">CR Total Pre GST</div>
                <div class="detail-value amount">₹<?= number_format($report['cr_total_pre_gst']) ?></div>
            </div>
            <div class="detail-box">
                <div class="detail-label">CR GST</div>
                <div class="detail-value amount">₹<?= number_format($report['cr_gst']) ?></div>
            </div>
            <div class="detail-box">
                <div class="detail-label">CR Total Project</div>
                <div class="detail-value amount">₹<?= number_format($report['cr_total_project']) ?></div>
            </div>
        </div>
    </div>
    <div class="view-card">
        <div class="section-title">From F&R</div>
        <div class="details-grid">
            <div class="detail-box">
                <div class="detail-label">CR Payment Done</div>
                <div class="detail-value amount">₹<?= number_format($report['cr_payment_done']) ?></div>
            </div>
            <div class="detail-box">
                <div class="detail-label">CR Balance</div>
                <div class="detail-value amount-red">₹<?= number_format($report['cr_balance']) ?></div>
            </div>
        </div>
    </div>
    <div class="d-flex">
        <a href="edit.php?id=<?= $report['id'] ?>"  class="edit-btn text-white">Edit Report</a>
        <a href="manage.php"  class="action-btn back-btn">Back</a>
    </div>
</div>
<?php include('../includes/footer.php'); ?>