<?php

include '../../includes/auth.php';
include '../../db.php';

if(!can('settings_view')){
    die("Access Denied");
}

$pageTitle="Report Viewer";

$report=$_GET['report'] ?? '';
$entity=$_GET['entity'] ?? '';
$user=$_GET['user'] ?? '';
$from=$_GET['from'] ?? '';
$to=$_GET['to'] ?? '';
$format=$_GET['format'] ?? 'view';

if($format!='view'){

    $_GET['report']=$report;
    $_GET['entity']=$entity;
    $_GET['user']=$user;
    $_GET['from']=$from;
    $_GET['to']=$to;

    include 'export.php';
    exit;

}

$reportTitles=[

    'quotation'=>'Quotation Report',

    'quotation_summary'=>'Quotation Analytics',

    'client'=>'Client Report',

    'user'=>'User Report',

    'material'=>'Material Report'

];

$title=$reportTitles[$report] ?? 'Report';

$where=[];

if($from!=''){

    $where[]="DATE(created_at)>='".mysqli_real_escape_string($conn,$from)."'";

}

if($to!=''){

    $where[]="DATE(created_at)<='".mysqli_real_escape_string($conn,$to)."'";

}

include '../../includes/header.php';
include '../../includes/sidebar.php';

?>

<link rel="stylesheet" href="../assets/style.css">


<div class="profile-page">

<div class="profile-header">

<div>

<h1>

<i class="fa-solid fa-chart-column"></i>

<?= $title ?>

</h1>

<p>

Generated Report Preview

</p>

</div>

<a
href="audit-reports.php"
class="btn btn-dark"
>

<i class="fa-solid fa-arrow-left"></i>

Back

</a>

</div>
<?php

switch($report){

/* ==========================================================
   QUOTATION REPORT
========================================================== */

case "quotation":

$sql="

SELECT

q.proforma_no,
q.project_type,
q.total_sqft,
q.grand_total,
q.special_discount,
q.final_customer_price,
q.created_at,

c.client_name,

u.name created_by,

e.entity_name

FROM quotations q

LEFT JOIN clients c
ON c.id=q.client_id

LEFT JOIN users u
ON u.id=q.created_by

LEFT JOIN entities e
ON e.id=q.entity_id

";

$conditions=[];

if($entity!=""){
    $conditions[]="q.entity_id=".(int)$entity;
}

if($user!=""){
    $conditions[]="q.created_by=".(int)$user;
}

if($from!=""){
    $conditions[]="DATE(q.created_at)>='$from'";
}

if($to!=""){
    $conditions[]="DATE(q.created_at)<='$to'";
}

if(count($conditions)>0){

    $sql.=" WHERE ".implode(" AND ",$conditions);

}

$sql.=" ORDER BY q.created_at DESC";

$result=mysqli_query($conn,$sql);

?>

<div class="profile-card">

<div class="profile-card-header">

<h3>

Quotation Report

</h3>

</div>

<div class="profile-body">

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>PI No.</th>

<th>Client</th>

<th>Project</th>

<th>Entity</th>

<th>Created By</th>

<th>Sqft</th>

<th>Grand Total</th>

<th>Discount</th>

<th>Final Price</th>

<th>Date</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td>

<?= htmlspecialchars($row['proforma_no']) ?>

</td>

<td>

<?= htmlspecialchars($row['client_name']) ?>

</td>

<td>

<?= htmlspecialchars($row['project_type']) ?>

</td>

<td>

<?= htmlspecialchars($row['entity_name']) ?>

</td>

<td>

<?= htmlspecialchars($row['created_by']) ?>

</td>

<td class="text-end">

<?= number_format($row['total_sqft'],2) ?>

</td>

<td class="text-end">

₹ <?= number_format($row['grand_total'],2) ?>

</td>

<td class="text-end">

<?= $row['special_discount'] ?> %

</td>

<td class="text-end">

₹ <?= number_format($row['final_customer_price'],2) ?>

</td>

<td>

<?= date("d M Y",strtotime($row['created_at'])) ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<?php

break;
/* ==========================================================
   CLIENT REPORT
========================================================== */

case "client":

$sql="

SELECT

c.*,

COUNT(q.id) total_quotations,

COALESCE(SUM(q.final_customer_price),0) total_business

FROM clients c

LEFT JOIN quotations q
ON q.client_id=c.id

";

$conditions=[];

if($entity!=""){
    $conditions[]="c.entity_id=".(int)$entity;
}

if($from!=""){
    $conditions[]="DATE(c.created_at)>='$from'";
}

if($to!=""){
    $conditions[]="DATE(c.created_at)<='$to'";
}

if(count($conditions)>0){

    $sql.=" WHERE ".implode(" AND ",$conditions);

}

$sql.="

GROUP BY c.id

ORDER BY c.client_name

";

$result=mysqli_query($conn,$sql);

?>

<div class="profile-card">

<div class="profile-card-header">

<h3>

Client Report

</h3>

</div>

<div class="profile-body">

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>Client</th>

<th>Phone</th>

<th>Email</th>

<th>GST</th>

<th>PAN</th>

<th>Total Quotations</th>

<th>Total Business</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= htmlspecialchars($row['client_name']) ?></td>

<td><?= htmlspecialchars($row['phone']) ?></td>

<td><?= htmlspecialchars($row['email']) ?></td>

<td><?= htmlspecialchars($row['gst_number']) ?></td>

<td><?= htmlspecialchars($row['pan_number']) ?></td>

<td class="text-end">

<?= number_format($row['total_quotations']) ?>

</td>

<td class="text-end">

₹ <?= number_format($row['total_business'],2) ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<?php

break;
/* ==========================================================
   USER REPORT
========================================================== */

case "user":

$sql="

SELECT

u.id,
u.name,
u.email,
u.status,
r.role_name,
e.entity_name,
COUNT(q.id) total_quotations

FROM users u

LEFT JOIN roles r
ON r.id=u.role_id

LEFT JOIN entities e
ON e.id=u.entity_id

LEFT JOIN quotations q
ON q.created_by=u.id

";

$conditions=[];

if($entity!=""){
    $conditions[]="u.entity_id=".(int)$entity;
}

if($user!=""){
    $conditions[]="u.id=".(int)$user;
}

if(count($conditions)>0){
    $sql.=" WHERE ".implode(" AND ",$conditions);
}

$sql.="

GROUP BY u.id

ORDER BY u.name

";

$result=mysqli_query($conn,$sql);

?>

<div class="profile-card">

<div class="profile-card-header">

<h3>

User Report

</h3>

</div>

<div class="profile-body">

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>Name</th>

<th>Email</th>

<th>Role</th>

<th>Entity</th>

<th>Status</th>

<th>Quotations</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= htmlspecialchars($row['name']) ?></td>

<td><?= htmlspecialchars($row['email']) ?></td>

<td><?= htmlspecialchars($row['role_name']) ?></td>

<td><?= htmlspecialchars($row['entity_name']) ?></td>

<td><?= htmlspecialchars($row['status']) ?></td>

<td class="text-end">

<?= number_format($row['total_quotations']) ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<?php

break;
/* ==========================================================
   MATERIAL REPORT
========================================================== */

case "material":

?>

<div class="profile-card">

<div class="profile-card-header">

<h3>

Material Report

</h3>

</div>

<div class="profile-body">

<h5 class="mb-3">

Carcass Materials

</h5>

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>Category</th>

<th>Material</th>

<th>Price / Sqft</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php

$result=mysqli_query(
    $conn,
    "
    SELECT
        cc.category_name,
        cm.material_name,
        cm.price_per_sqft,
        cm.status
    FROM carcass_materials cm
    LEFT JOIN carcass_categories cc
        ON cc.id=cm.category_id
    ORDER BY cc.category_name,cm.material_name
    "
);

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td><?= htmlspecialchars($row['category_name']) ?></td>

<td><?= htmlspecialchars($row['material_name']) ?></td>

<td class="text-end">

₹ <?= number_format($row['price_per_sqft'],2) ?>

</td>

<td><?= htmlspecialchars($row['status']) ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<hr>

<h5 class="mb-3">

Shutter Materials

</h5>

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>Category</th>

<th>Material</th>

<th>Price / Sqft</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php

$result=mysqli_query(
    $conn,
    "
    SELECT
        sc.category_name,
        sm.material_type,
        sm.price_per_sqft,
        sm.status
    FROM shutter_materials sm
    LEFT JOIN shutter_categories sc
        ON sc.id=sm.category_id
    ORDER BY sc.category_name,sm.material_type
    "
);

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td><?= htmlspecialchars($row['category_name']) ?></td>

<td><?= htmlspecialchars($row['material_type']) ?></td>

<td class="text-end">

₹ <?= number_format($row['price_per_sqft'],2) ?>

</td>

<td><?= htmlspecialchars($row['status']) ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<?php

break;
/* ==========================================================
   QUOTATION ANALYTICS
========================================================== */

case "quotation_summary":

$sql="

SELECT

COUNT(*) total_quotations,

COALESCE(SUM(grand_total),0) total_grand_total,

COALESCE(SUM(final_customer_price),0) total_sales,

COALESCE(SUM(total_sqft),0) total_sqft,

COALESCE(AVG(final_customer_price),0) average_sale,

COALESCE(MAX(final_customer_price),0) highest_sale,

COALESCE(MIN(final_customer_price),0) lowest_sale,

COALESCE(SUM(packing_charge),0) packing,

COALESCE(SUM(installation_charge),0) installation,

COALESCE(AVG(special_discount),0) average_discount

FROM quotations

";

$conditions=[];

if($entity!=""){
    $conditions[]="entity_id=".(int)$entity;
}

if($user!=""){
    $conditions[]="created_by=".(int)$user;
}

if($from!=""){
    $conditions[]="DATE(created_at)>='$from'";
}

if($to!=""){
    $conditions[]="DATE(created_at)<='$to'";
}

if(count($conditions)>0){
    $sql.=" WHERE ".implode(" AND ",$conditions);
}

$result=mysqli_query($conn,$sql);

$data=mysqli_fetch_assoc($result);

?>

<div class="profile-card">

<div class="profile-card-header">

<h3>

Quotation Analytics

</h3>

</div>

<div class="profile-body">

<div class="profile-item">

<div class="profile-label">Total Quotations</div>

<div class="profile-value">

<?= number_format($data['total_quotations']) ?>

</div>

</div>

<div class="profile-item">

<div class="profile-label">Total Revenue</div>

<div class="profile-value">

₹ <?= number_format($data['total_sales'],2) ?>

</div>

</div>

<div class="profile-item">

<div class="profile-label">Grand Total</div>

<div class="profile-value">

₹ <?= number_format($data['total_grand_total'],2) ?>

</div>

</div>

<div class="profile-item">

<div class="profile-label">Average Quotation</div>

<div class="profile-value">

₹ <?= number_format($data['average_sale'],2) ?>

</div>

</div>

<div class="profile-item">

<div class="profile-label">Highest Quotation</div>

<div class="profile-value">

₹ <?= number_format($data['highest_sale'],2) ?>

</div>

</div>

<div class="profile-item">

<div class="profile-label">Lowest Quotation</div>

<div class="profile-value">

₹ <?= number_format($data['lowest_sale'],2) ?>

</div>

</div>

<div class="profile-item">

<div class="profile-label">Total Sq.Ft.</div>

<div class="profile-value">

<?= number_format($data['total_sqft'],2) ?>

</div>

</div>

<div class="profile-item">

<div class="profile-label">Packing Charges</div>

<div class="profile-value">

₹ <?= number_format($data['packing'],2) ?>

</div>

</div>

<div class="profile-item">

<div class="profile-label">Installation Charges</div>

<div class="profile-value">

₹ <?= number_format($data['installation'],2) ?>

</div>

</div>

<div class="profile-item">

<div class="profile-label">Average Discount</div>

<div class="profile-value">

<?= number_format($data['average_discount'],2) ?> %

</div>

</div>

</div>

</div>

<?php

break;

/* ==========================================================
   DEFAULT
========================================================== */

default:

?>

<div class="profile-card">

<div class="profile-body">

<h4>

No report selected.

</h4>

</div>

</div>

<?php

break;

}

?>

</div>


<?php include '../../includes/footer.php'; ?>