<?php
include '../db.php';

/** @var mysqli $conn */

$id = (int)($_POST['id'] ?? 0);
$categoryName = trim($_POST['category_name'] ?? '');
$status = (int)($_POST['status'] ?? 1);

$stmt = $conn->prepare("
    UPDATE visible_panel_categories
    SET
        category_name = ?,
        status = ?
    WHERE id = ?
");

$stmt->bind_param(
    "sii",
    $categoryName,
    $status,
    $id
);

$stmt->execute();
$stmt->close();

header("Location: manage.php");
exit;