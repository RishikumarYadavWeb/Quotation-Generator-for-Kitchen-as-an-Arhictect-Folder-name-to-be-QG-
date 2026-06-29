<?php
include('../db.php');
/** @var mysqli $conn */
if(!isset($_POST['id'])){die("Invalid Request");}
$id = (int) $_POST['id'];
$customer_name = mysqli_real_escape_string($conn,$_POST['customer_name']);
$delivery_date = mysqli_real_escape_string($conn,$_POST['delivery_date']);
$fr_value = (int) $_POST['fr_value'];
$delivery = (int) $_POST['delivery'];
$fr_installation = (int) $_POST['fr_installation'];
$total_pre_gst = $fr_value + $delivery + $fr_installation;
$gst_amount = round($total_pre_gst * 0.18);
$total_project = $total_pre_gst + $gst_amount;
$fr_payment = (int) $_POST['fr_payment'];
$balance_payment = $total_project - $fr_payment;
$gross_margin_pre_gst = (int) $_POST['gross_margin_pre_gst'];
$cr_amount = (int) $_POST['cr_amount'];
$cr_transport = (int) $_POST['cr_transport'];
$cr_installation = (int) $_POST['cr_installation'];
$cr_total_pre_gst = $cr_amount + $cr_transport + $cr_installation;
$cr_gst = round($cr_total_pre_gst * 0.18);
$cr_total_project = $cr_total_pre_gst + $cr_gst;
$cr_payment_done = (int) $_POST['cr_payment_done'];
$cr_balance = $cr_total_project - $cr_payment_done;
$query = mysqli_query($conn, "
    UPDATE financial_reports SET
        customer_name = '$customer_name',
        delivery_date = '$delivery_date',
        fr_value = '$fr_value',
        delivery = '$delivery',
        fr_installation = '$fr_installation',
        total_pre_gst = '$total_pre_gst',
        gst_amount = '$gst_amount',
        total_project = '$total_project',
        fr_payment = '$fr_payment',
        balance_payment = '$balance_payment',
        gross_margin_pre_gst = '$gross_margin_pre_gst',
        cr_amount = '$cr_amount',
        cr_transport = '$cr_transport',
        cr_installation = '$cr_installation',
        cr_total_pre_gst = '$cr_total_pre_gst',
        cr_gst = '$cr_gst',
        cr_total_project = '$cr_total_project',
        cr_payment_done = '$cr_payment_done',
        cr_balance = '$cr_balance'
    WHERE id = '$id'
");
if($query){
    header('Location:manage.php');
    exit;
}else{
    echo "Something Went Wrong";
}
?>