<?php

include '../db.php';
/** @var mysqli $conn */

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM standard_accessory_categories
    WHERE id='$id'
    "
);

$row = mysqli_fetch_assoc($query);

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="page-card">

<form
action="update-category.php"
method="POST"
>

<input
type="hidden"
name="id"
value="<?= $row['id'] ?>"
>

<label>Name</label>

<input
type="text"
name="category_name"
value="<?= $row['category_name'] ?>"
class="form-control"
>

<button class="theme-btn">
Update
</button>

</form>

</div>

<?php include '../includes/footer.php'; ?>