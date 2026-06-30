<?php
include '../db.php';
/** @var mysqli $conn */
$id = (int) ($_GET['id'] ?? 0);
mysqli_query($conn,"DELETE FROM drawer_categories WHERE id = '$id'");
header('Location: manage.php');
?>