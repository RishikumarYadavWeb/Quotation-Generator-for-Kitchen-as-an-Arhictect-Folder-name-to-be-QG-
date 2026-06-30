<?php

include '../../includes/auth.php';
include '../../db.php';
/** @var mysqli $conn */
include '../../includes/header.php';
include '../../includes/sidebar.php';

$query = mysqli_query(
    $conn,
    "
    SELECT
        standard_accessory_materials.*,
        standard_accessory_categories.category_name

    FROM standard_accessory_materials

    LEFT JOIN standard_accessory_categories

    ON standard_accessory_categories.id =
    standard_accessory_materials.category_id

    ORDER BY
    standard_accessory_materials.id DESC
    "
);

?>

<div class="page-card">

<div class="page-header">

<h1>
Standard Accessory Materials
</h1>

<a
href="create.php"
class="theme-btn"
>
Add Material
</a>

</div>

<table class="custom-table">

<thead>

<tr>

<th>Sr No</th>
<th>Category</th>
<th>Material</th>
<th>status</th>
<th>Unit</th>
<th>Price</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php

$srNo=1;

while(
$row=
mysqli_fetch_assoc($query)
){

?>

<tr>

<td><?= $srNo++ ?></td>

<td>
<?= $row['category_name'] ?>
</td>

<td>
<?= $row['material_name'] ?>
</td>

                        <td>
                            <?php if($row['status'] == 1){ ?>
                                <span class="status-active">Active</span>
                            <?php }else{ ?>
                                <span class="status-inactive">Inactive</span>
                            <?php } ?>
                        </td>
<td>
<?= $row['unit'] ?>
</td>

<td>
₹ <?= number_format(
$row['price'],
2
) ?>
</td>

<td>

<a
href="edit.php?id=<?= $row['id'] ?>"
class="edit-btn"
>
Edit
</a>

<a
href="delete.php?id=<?= $row['id'] ?>"
class="delete-btn"
>
Delete
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<?php include '../../includes/footer.php'; ?>