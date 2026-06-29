<?php
include('../db.php');
/** @var mysqli $conn */
/* GET FORM DATA */
$customer_name = mysqli_real_escape_string($conn,$_POST['customer_name']);
$delivery_date = mysqli_real_escape_string($conn,$_POST['delivery_date']);
/* F&R DETAILS */
$fr_value = (int) $_POST['fr_value'];
$delivery = (int) $_POST['delivery'];
$fr_installation = (int) $_POST['fr_installation'];
/* F&R CALCULATIONS */
$total_pre_gst = $fr_value + $delivery + $fr_installation;
$gst_amount = round($total_pre_gst * 0.18);
$total_project = $total_pre_gst + $gst_amount;
/* PAYMENT DETAILS */
$fr_payment = (int) $_POST['fr_payment'];
$balance_payment = $total_project - $fr_payment;
/* GROSS MARGIN */
$gross_margin_pre_gst = (int) $_POST['gross_margin_pre_gst'];
/* CR DETAILS */
$cr_amount = (int) $_POST['cr_amount'];
$cr_transport = (int) $_POST['cr_transport'];
$cr_installation = (int) $_POST['cr_installation'];
$cr_total_pre_gst = $cr_amount + $cr_transport + $cr_installation;
$cr_gst = round($cr_total_pre_gst * 0.18);
$cr_total_project = $cr_total_pre_gst + $cr_gst;
/* FROM F&R */
$cr_payment_done = (int) $_POST['cr_payment_done'];
$cr_balance = $cr_total_project - $cr_payment_done;
/* INSERT QUERY */
$query = mysqli_query($conn, "
INSERT INTO financial_reports (
    customer_name,
    delivery_date,
    fr_value,
    delivery,
    fr_installation,
    total_pre_gst,
    gst_amount,
    total_project,
    fr_payment,
    balance_payment,
    gross_margin_pre_gst,
    cr_amount,
    cr_transport,
    cr_installation,
    cr_total_pre_gst,
    cr_gst,
    cr_total_project,
    cr_payment_done,
    cr_balance
)
VALUES (
    '$customer_name',
    '$delivery_date',
    '$fr_value',
    '$delivery',
    '$fr_installation',
    '$total_pre_gst',
    '$gst_amount',
    '$total_project',
    '$fr_payment',
    '$balance_payment',
    '$gross_margin_pre_gst',
    '$cr_amount',
    '$cr_transport',
    '$cr_installation',
    '$cr_total_pre_gst',
    '$cr_gst',
    '$cr_total_project',
    '$cr_payment_done',
    '$cr_balance'
)
");
/* REDIRECT */
if($query){
    header('Location:manage.php');
    exit;
}else{
    echo "Something Went Wrong";
}
?>
