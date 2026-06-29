<?php
    include('../db.php');
    /** @var mysqli $conn */
    if(!isset($_GET['id'])){die("Invalid Request");}
    $id = (int) $_GET['id'];
    $check = mysqli_query($conn, "
    SELECT id FROM financial_reports
    WHERE id = '$id'
    ");
    if(mysqli_num_rows($check) == 0){die("Financial Report Not Found");}
    $query = mysqli_query($conn, "
    DELETE FROM financial_reports
    WHERE id = '$id'
    ");
    if($query){
        header('Location:manage.php');
        exit;
    }else{
        echo "Something Went Wrong";
    }
?>