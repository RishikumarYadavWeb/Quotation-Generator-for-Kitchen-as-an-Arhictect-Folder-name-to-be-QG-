<?php
include '../includes/auth.php';
include '../db.php';

if (!can('accessories_edit')) {
    die('Access Denied');
}

/** @var mysqli $conn */

include '../includes/header.php';
include '../includes/sidebar.php';

$id=(int)$_GET['id'];

$make=mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT * FROM accessory_makes WHERE id='$id'"
)
);

$categories=mysqli_query(
$conn,
"
SELECT *
FROM accessory_categories
WHERE status=1
ORDER BY category_name
"
);
?>

<div class="page-card">

<div class="page-header">
<h1>Edit Make</h1>
</div>

<form action="update.php" method="POST">

<input
type="hidden"
name="id"
value="<?= $make['id'] ?>">

<div class="form-group">

<label>Category</label>

<select
name="category_id"
class="form-control">

<?php while($cat=mysqli_fetch_assoc($categories)){ ?>

<option
value="<?= $cat['id'] ?>"
<?= $cat['id']==$make['category_id']?'selected':'' ?>>

<?= htmlspecialchars($cat['category_name']) ?>

</option>

<?php } ?>

</select>

</div>

<div class="form-group">

<label>Make Name</label>

<input
type="text"
name="make_name"
class="form-control"
value="<?= htmlspecialchars($make['make_name']) ?>"
required>

</div>

<div class="form-group">

<label>Status</label>

<select
name="status"
class="form-control">

<option
value="1"
<?= $make['status']==1?'selected':'' ?>>
Active
</option>

<option
value="0"
<?= $make['status']==0?'selected':'' ?>>
Inactive
</option>

</select>

</div>

<button class="theme-btn">
Update Make
</button>

</form>

</div>

<?php include '../includes/footer.php'; ?>