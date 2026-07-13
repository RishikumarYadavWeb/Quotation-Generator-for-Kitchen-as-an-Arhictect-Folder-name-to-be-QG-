
<?php
include '../db.php';
/** @var mysqli $conn */

$id=(int)$_POST['id'];
$categoryId=(int)$_POST['category_id'];
$makeName=mysqli_real_escape_string($conn,trim($_POST['make_name']));
$status=(int)$_POST['status'];

mysqli_query(
$conn,
"
UPDATE accessory_makes
SET
category_id='$categoryId',
make_name='$makeName',
status='$status'
WHERE id='$id'
"
);

header("Location: manage.php");
exit;