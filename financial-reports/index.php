<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    include '../includes/header.php';
    include '../includes/sidebar.php';
    if(!can('pr_create')){
        die('Access Denied');
    }
?>
<style>
.page-title{font-size:30px;font-weight:700;margin-bottom:25px;color:#111827}.form-container{background:#fff;padding:30px;border-radius:14px;box-shadow:0 4px 20px rgb(0 0 0 / .08);border:1px solid #e5e7eb}.section-title{font-size:18px;font-weight:700;margin-bottom:20px;color:#1e293b;border-bottom:2px solid #e5e7eb;padding-bottom:10px}.form-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:35px}.form-group{display:flex;flex-direction:column}.form-group label{font-size:13px;font-weight:600;margin-bottom:8px;color:#374151}.form-group input{padding:12px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;outline:none;transition:0.3s}.form-group input:focus{border-color:#2563eb;box-shadow:0 0 5px rgb(37 99 235 / .3)}.form-group input[readonly]{background:#f3f4f6;font-weight:600}.submit-btn{background:#16a34a;color:#fff;border:none;padding:14px 28px;border-radius:10px;font-size:15px;font-weight:600;cursor:pointer}.submit-btn:hover{background:#15803d}@media(max-width:1200px){.form-grid{grid-template-columns:repeat(2,1fr)}}@media(max-width:768px){.form-grid{grid-template-columns:1fr}}
</style>
<div class="page-card">
    <h2 class="page-title">Create Financial Report</h2>
    <form action="save.php" method="POST">
        <div class="section-title">Customer Details</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Customer Name</label>
                <input type="text" name="customer_name" required>
            </div>
            <div class="form-group">
                <label>Delivery Date</label>
                <input type="text" name="delivery_date">
            </div>
        </div>
        <div class="section-title">Pre GST Details (F&R)</div>
        <div class="form-grid">
            <div class="form-group">
                <label>FR Value</label>
                <input type="number" step="0.01" name="fr_value" id="fr_value">
            </div>
            <div class="form-group">
                <label>Delivery</label>
                <input type="number" step="0.01" name="delivery" id="delivery">
            </div>
            <div class="form-group">
                <label>Installation</label>
                <input type="number" step="0.01" name="fr_installation" id="fr_installation">
            </div>
            <div class="form-group">
                <label>Total Pre GST</label>
                <input type="text" name="total_pre_gst" id="total_pre_gst" readonly>
            </div>
            <div class="form-group">
                <label>GST (18%)</label>
                <input type="text" name="gst_amount" id="gst_amount" readonly>
            </div>
            <div class="form-group">
                <label>Total Project with 18% GST</label>
                <input type="text" name="total_project" id="total_project" readonly>
            </div>
        </div>
        <div class="section-title">Payment Details (F&R)</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Received FR Payment</label>
                <input type="number" step="0.01" name="fr_payment" id="fr_payment">
            </div>
            <div class="form-group">
                <label>Balance FR Payment</label>
                <input type="text" name="balance_payment" id="balance_payment" readonly>
            </div>
        </div>
        <div class="section-title">Gross Margin Pre GST</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Gross Margin Pre GST</label>
                <input type="text" name="gross_margin_pre_gst" id="gross_margin_pre_gst">
            </div>
        </div>
        <div class="section-title">Pre GST Details (CR)</div>
        <div class="form-grid">
            <div class="form-group">
                <label>CR Amount</label>
                <input type="number" step="0.01" name="cr_amount" id="cr_amount">
            </div>
            <div class="form-group">
                <label>CR Transport</label>
                <input type="number" step="0.01" name="cr_transport" id="cr_transport">
            </div>
            <div class="form-group">
                <label>Installation</label>
                <input type="number" step="0.01" name="cr_installation" id="cr_installation">
            </div>
            <div class="form-group">
                <label>CR Total Pre GST</label>
                <input type="text" name="cr_total_pre_gst" id="cr_total_pre_gst" readonly>
            </div>
            <div class="form-group">
                <label>GST (18%)</label>
                <input type="text" name="cr_gst" id="cr_gst" readonly>
            </div>
            <div class="form-group">
                <label>Total Project with 18% GST</label>
                <input type="text" name="cr_total_project" id="cr_total_project" readonly>
            </div>
        </div>
        <div class="section-title">From F&R</div>
        <div class="form-grid">
            <div class="form-group">
                <label>CR Payment Done (Advance w/o GST)</label>
                <input type="number" step="0.01" name="cr_payment_done" id="cr_payment_done">
            </div>
            <div class="form-group">
                <label>Balance</label>
                <input type="text" name="cr_balance" id="cr_balance" readonly>
            </div>
        </div>
        <button type="submit" class="submit-btn">Save Financial Report</button>
    </form>
</div>
<script>

function calculateFinancials(){
    let frValue = parseFloat(document.getElementById('fr_value').value) || 0;
    let delivery = parseFloat(document.getElementById('delivery').value) || 0;
    let fr_installation = parseFloat(document.getElementById('fr_installation').value) || 0;
    let frPayment = parseFloat(document.getElementById('fr_payment').value) || 0;
    let crAmount = parseFloat(document.getElementById('cr_amount').value) || 0;
    let crTransport = parseFloat(document.getElementById('cr_transport').value) || 0;
    let crPaymentDone = parseFloat(document.getElementById('cr_payment_done').value) || 0;
    let cr_installation = parseFloat(document.getElementById('cr_installation').value) || 0;
    /* F&R CALCULATIONS */
    let totalPreGST = frValue + delivery + fr_installation;
    let gstAmount = totalPreGST * 0.18;
    let totalProject = totalPreGST + gstAmount;
    let balancePayment = totalProject - frPayment;
    /* CR CALCULATIONS */
    let crTotalPreGST = crAmount + crTransport + cr_installation;
    let crGST = crTotalPreGST * 0.18;
    let crTotalProject = crTotalPreGST + crGST;
    let crBalance = crTotalProject - crPaymentDone;
    /* SET VALUES */
    document.getElementById('total_pre_gst').value = Math.round(totalPreGST);
    document.getElementById('gst_amount').value = Math.round(gstAmount);
    document.getElementById('total_project').value = Math.round(totalProject);
    document.getElementById('balance_payment').value = Math.round(balancePayment);
    document.getElementById('cr_total_pre_gst').value = Math.round(crTotalPreGST);
    document.getElementById('cr_gst').value = Math.round(crGST);
    document.getElementById('cr_total_project').value = Math.round(crTotalProject);
    document.getElementById('cr_balance').value = Math.round(crBalance);
}
/* AUTO CALCULATE */
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('input', calculateFinancials);
});
</script>
<?php include('../includes/footer.php'); ?>