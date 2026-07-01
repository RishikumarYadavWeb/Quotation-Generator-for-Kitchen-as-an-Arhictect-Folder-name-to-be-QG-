<?php
include '../includes/auth.php';
include '../db.php';
/** @var mysqli $conn */
$id = (int) ($_POST['id'] ?? 0);
$company_name = trim($_POST['company_name'] ?? '');
$registered_address = trim($_POST['registered_address'] ?? '');
$admin_address = trim($_POST['admin_address'] ?? '');
$pan_number = strtoupper(trim($_POST['pan_number'] ?? ''));
$gst_number = strtoupper(trim($_POST['gst_number'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''),FILTER_VALIDATE_EMAIL);
$landline_number = trim($_POST['landline_number'] ?? '');
$cin_number = strtoupper( trim($_POST['cin_number'] ?? ''));
$check = mysqli_query($conn, "SELECT * FROM company LIMIT 1");
if(mysqli_num_rows($check) > 0){
    mysqli_query($conn, "
        UPDATE company SET
        company_name='$company_name',
        registered_address='$registered_address',
        admin_address='$admin_address',
        pan_number='$pan_number',
        gst_number='$gst_number',
        email='$email',
        landline_number='$landline_number',
        cin_number='$cin_number'
        WHERE id='$id'
    ");
}else{
    mysqli_query($conn, "
        INSERT INTO company (
            company_name,
            registered_address,
            admin_address,
            pan_number,
            gst_number,
            email,
            landline_number,
            cin_number
        ) VALUES (
            '$company_name',
            '$registered_address',
            '$admin_address',
            '$pan_number',
            '$gst_number',
            '$email',
            '$landline_number',
            '$cin_number'
        )
    ");
}
header("Location:view.php");
exit;
