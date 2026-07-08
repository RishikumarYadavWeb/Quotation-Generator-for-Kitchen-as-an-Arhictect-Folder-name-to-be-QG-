<?php

include '../../includes/auth.php';
include '../../db.php';

if(!can('settings_view')){
    die("Access Denied");
}

$pageTitle="Audit Reports";

/* -----------------------------
   REPORT TYPES
------------------------------*/

$reportTypes=[

    "quotation"=>"Quotation Report",

    "client"=>"Client Report",

    "user"=>"User Report",

    "material"=>"Material Report",

    "quotation_summary"=>"Quotation Analytics"

];

/* -----------------------------
   ENTITIES
------------------------------*/

$entities=[];

$q=mysqli_query(
    $conn,
    "SELECT id,entity_name
     FROM entities
     WHERE status=1
     ORDER BY entity_name"
);

while($row=mysqli_fetch_assoc($q)){
    $entities[]=$row;
}

/* -----------------------------
   USERS
------------------------------*/

$users=[];

$q=mysqli_query(
    $conn,
    "SELECT
        id,
        name
     FROM users
     WHERE status='Active'
     ORDER BY name"
);

while($row=mysqli_fetch_assoc($q)){
    $users[]=$row;
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<link rel="stylesheet" href="../assets/style.css">
<style>
    /* ==========================================================
   AUDIT REPORTS
========================================================== */

.form-label{
    font-weight:600;
    color:#374151;
    margin-bottom:8px;
}

.form-control,
.form-select{
    height:48px;
    border:1px solid #dcdfe5;
    border-radius:12px;
    padding:0 15px;
    font-size:14px;
    background:#fff;
    transition:.2s;
}

.form-control:focus,
.form-select:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,.12);
    outline:none;
}

.btn-primary{
    height:48px;
    border-radius:12px;
    font-weight:600;
}

.btn-primary i{
    margin-right:8px;
}
</style>

<div class="profile-page">

<div class="profile-header">

    <div>

        <h1>

            <i class="fa-solid fa-chart-column"></i>

            Audit Reports

        </h1>

        <p>

            Generate dynamic reports across the ERP.

        </p>

    </div>

    <a
        href="../index.php"
        class="btn btn-dark"
    >

        <i class="fa-solid fa-arrow-left"></i>

        Back

    </a>

</div>

<div class="profile-card">

<div class="profile-card-header">

<h3>

<i class="fa-solid fa-filter"></i>

Report Filters

</h3>

</div>

<div class="profile-body">

<form
    action="report-view.php"
    method="GET"
>

<div class="row">
    <div class="col-md-4 mb-4">

    <label class="form-label">

        Report Type

    </label>

    <select
        name="report"
        class="form-control"
        required
    >

        <option value="">

            Select Report

        </option>

        <?php foreach($reportTypes as $key=>$value){ ?>

            <option value="<?= $key; ?>">

                <?= $value; ?>

            </option>

        <?php } ?>

    </select>

</div>

<div class="col-md-4 mb-4">

    <label class="form-label">

        Entity

    </label>

    <select
        name="entity"
        class="form-control"
    >

        <option value="">

            All Entities

        </option>

        <?php foreach($entities as $entity){ ?>

            <option value="<?= $entity['id']; ?>">

                <?= htmlspecialchars($entity['entity_name']); ?>

            </option>

        <?php } ?>

    </select>

</div>

<div class="col-md-4 mb-4">

    <label class="form-label">

        User

    </label>

    <select
        name="user"
        class="form-control"
    >

        <option value="">

            All Users

        </option>

        <?php foreach($users as $user){ ?>

            <option value="<?= $user['id']; ?>">

                <?= htmlspecialchars($user['name']); ?>

            </option>

        <?php } ?>

    </select>

</div>

<div class="col-md-3 mb-4">

    <label class="form-label">

        From Date

    </label>

    <input
        type="date"
        name="from"
        class="form-control"
    >

</div>

<div class="col-md-3 mb-4">

    <label class="form-label">

        To Date

    </label>

    <input
        type="date"
        name="to"
        class="form-control"
    >

</div>

<div class="col-md-3 mb-4">

    <label class="form-label">

        Export Format

    </label>

    <select
        name="format"
        class="form-control"
    >

        <option value="view">

            Preview Report

        </option>

        <option value="csv">

            CSV

        </option>

        <option value="excel">

            Excel

        </option>

        <option value="pdf">

            PDF

        </option>

    </select>

</div>

<div class="col-md-3 mb-4">

    <label class="form-label">

        &nbsp;

    </label>

    <button
        type="submit"
        class="btn btn-primary w-100"
    >

        <i class="fa-solid fa-chart-line"></i>

        Generate Report

    </button>

</div>
</div>

</form>

</div>

</div>

</div>


<?php include '../../includes/footer.php'; ?>