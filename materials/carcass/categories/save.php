<?php
    include '../../../db.php';
    /** @var mysqli $conn */
    $category_name = trim($_POST['category_name'] ?? '');
    mysqli_query(
        $conn,
        "INSERT INTO carcass_categories(
            category_name
        ) VALUES(
            '$category_name'
        )"
    );
    header('Location: manage.php');
?>