<?php
include '../includes/auth.php';
include '../db.php';
if(!can('appliances_create')){
    die('Access Denied');
}
/** @var mysqli $conn */
if($_SERVER['REQUEST_METHOD'] != 'POST'){
    die('Invalid Request');
}
$applianceName = mysqli_real_escape_string($conn,trim($_POST['appliance_name'] ?? ''));
$companyName = mysqli_real_escape_string($conn,trim($_POST['company_name'] ?? ''));
$description = mysqli_real_escape_string($conn,trim($_POST['description'] ?? ''));
$unit = mysqli_real_escape_string($conn,trim($_POST['unit'] ?? ''));
$price = (float)($_POST['price'] ?? 0);
$status = (int)($_POST['status'] ?? 1);
/* Validation */
if(empty($applianceName)){ die('Appliance Name is required.'); }
if(empty($companyName)){ die('Company Name is required.'); }
if(empty($description)){ die('Description is required.'); }
if(empty($unit)){ die('Unit is required.'); }
if($price <= 0){ die('Invalid Price.'); }
/* Check Duplicate */
$check = mysqli_query(
    $conn,
    "
    SELECT id
    FROM appliances
    WHERE
        appliance_name = '$applianceName'
        AND company_name = '$companyName'
        AND description = '$description'
    LIMIT 1
    "
);
if(mysqli_num_rows($check) > 0){ die('This appliance already exists.'); }
/* Save */
mysqli_query(
    $conn,
    "
    INSERT INTO appliances
    (
        appliance_name,
        company_name,
        description,
        unit,
        price,
        status
    )
    VALUES
    (
        '$applianceName',
        '$companyName',
        '$description',
        '$unit',
        '$price',
        '$status'
    )
    "
);
header('Location: manage.php');
exit;