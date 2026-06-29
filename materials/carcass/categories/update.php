<?php
    include '../../../db.php';
    /** @var mysqli $conn */
    $id = (int) ($_POST['id'] ?? 0);
    $category_name = trim($_POST['category_name'] ?? '');
    mysqli_query(
        $conn,
        "UPDATE carcass_categories
        SET
        category_name = '$category_name'
        WHERE id = '$id'"
    );
    header('Location: manage.php');
?>
