<?php
    include '../../db.php';
    /** @var mysqli $conn */
    $id = (int) ($_GET['id'] ?? 0);
    $query = "DELETE FROM carcass_materials WHERE id='$id'";
    mysqli_query($conn, $query);
    header("Location: manage.php");
?>