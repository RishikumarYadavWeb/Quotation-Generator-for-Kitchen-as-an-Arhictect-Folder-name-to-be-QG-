<?php
include '../includes/auth.php';
include '../db.php';

/** @var mysqli $conn */

if (!can('accessories_view')) {
    die('Access Denied');
}

$limit = 15;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$offset = ($page - 1) * $limit;

$totalAccessoriesQuery = mysqli_query(
    $conn,
    "
    SELECT COUNT(*) AS total
    FROM accessories
    "
);

$totalRecords = mysqli_fetch_assoc($totalAccessoriesQuery)['total'];
$totalPages = ceil($totalRecords / $limit);

$getAccessories = mysqli_query(
    $conn,
    "
    SELECT
        a.*,
        c.category_name,
        m.make_name,
        u.unit_name
    FROM accessories a
    INNER JOIN accessory_categories c
        ON c.id = a.category_id
    INNER JOIN accessory_makes m
        ON m.id = a.make_id
    INNER JOIN accessory_units u
        ON u.id = a.unit_id
    ORDER BY a.id ASC
    LIMIT $limit OFFSET $offset
    "
);

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="page-card">

    <div class="page-header">

        <div>
            <h1 class="page-title">Accessories Management</h1>
            <p class="page-subtitle">Manage all accessories.</p>
        </div>

        <?php if(can('accessories_create')){ ?>
            <a href="create.php" class="theme-btn">
                <i class="fa-solid fa-plus"></i>
                Add Accessory
            </a>
        <?php } ?>

    </div>

    <div class="table-wrapper">

        <table class="custom-table">

            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Category</th>
                    <th>Make</th>
                    <th>Accessory</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <?php

                $srNo = $offset + 1;

                if(mysqli_num_rows($getAccessories) > 0){

                    while($row = mysqli_fetch_assoc($getAccessories)){

                ?>

                <tr>

                    <td data-label="Sr No">
                        <?= $srNo++ ?>
                    </td>

                    <td data-label="Category">
                        <?= htmlspecialchars($row['category_name']) ?>
                    </td>

                    <td data-label="Make">
                        <?= htmlspecialchars($row['make_name']) ?>
                    </td>

                    <td data-label="Accessory">
                        <?= htmlspecialchars($row['material_name']) ?>
                    </td>

                    <td data-label="Unit">
                        <?= htmlspecialchars($row['unit_name']) ?>
                    </td>

                    <td data-label="Price">
                        ₹ <?= number_format($row['price'],2) ?>
                    </td>

                    <td data-label="Status">

                        <?php if($row['status'] == 1){ ?>

                            <span class="status-active">Active</span>

                        <?php }else{ ?>

                            <span class="status-inactive">Inactive</span>

                        <?php } ?>

                    </td>

                    <td data-label="Action">

                        <div class="action-btns">

                            <?php if(can('accessories_edit')){ ?>
                                <a
                                    href="edit.php?id=<?= $row['id'] ?>"
                                    class="edit-btn">
                                    Edit
                                </a>
                            <?php } ?>

                            <?php if(can('accessories_delete')){ ?>
                                <a
                                    href="delete.php?id=<?= $row['id'] ?>"
                                    class="delete-btn"
                                    onclick="return confirm('Are you sure you want to delete this accessory?')">
                                    Delete
                                </a>
                            <?php } ?>

                        </div>

                    </td>

                </tr>

                <?php

                    }

                }else{

                ?>

                <tr>

                    <td colspan="8" style="text-align:center;">
                        No Accessories Found
                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

    <?php if($totalPages > 1){ ?>

        <div class="pagination">

            <?php if($page > 1){ ?>
                <a href="?page=<?= $page-1 ?>">&laquo; Prev</a>
            <?php } ?>

            <?php
            $start=max(1,$page-2);
            $end=min($totalPages,$page+2);

            for($i=$start;$i<=$end;$i++){
            ?>

                <a
                    href="?page=<?= $i ?>"
                    class="<?= $i==$page?'active':'' ?>">
                    <?= $i ?>
                </a>

            <?php } ?>

            <?php if($page<$totalPages){ ?>
                <a href="?page=<?= $page+1 ?>">Next &raquo;</a>
            <?php } ?>

        </div>

    <?php } ?>

</div>

<?php include '../includes/footer.php'; ?>