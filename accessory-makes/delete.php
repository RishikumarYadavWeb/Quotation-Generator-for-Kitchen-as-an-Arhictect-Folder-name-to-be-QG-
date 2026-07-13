<?php
include '../includes/auth.php';
include '../db.php';

if(!can('accessories_delete')){
    die('Access Denied');
}

/** @var mysqli $conn */

$id=(int)$_GET['id'];

$check=mysqli_query(
$conn,
"
SELECT COUNT(*) total
FROM accessory_materials
WHERE make_id='$id'
"
);

$row=mysqli_fetch_assoc($check);

if($row['total']>0){

echo "<script>
alert('Cannot delete. Make is linked with materials.');
window.location='manage.php';
</script>";

exit;

}

mysqli_query(
$conn,
"
DELETE
FROM accessory_makes
WHERE id='$id'
"
);

header("Location: manage.php");
exit;