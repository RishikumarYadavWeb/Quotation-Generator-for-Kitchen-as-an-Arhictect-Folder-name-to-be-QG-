<?php
include '../db.php';

/** @var mysqli $conn */

$category_name = trim($_POST['category_name'] ?? '');

if ($category_name == '') {
    die('Category Name is required.');
}

$stmt = $conn->prepare("
    INSERT INTO visible_side_categories (
        category_name
    ) VALUES (
        ?
    )
");

$stmt->bind_param("s", $category_name);
$stmt->execute();
$stmt->close();

header("Location: manage.php");
exit;