<?php
include '../includes/auth.php';
include '../db.php';

if(!can('visible_panel_view')){
    die('Access Denied');
}

/** @var mysqli $conn */

include '../includes/header.php';
include '../includes/sidebar.php';

$limit = 10;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);

$offset = ($page - 1) * $limit;

$totalRecordsQuery = mysqli_query(
    $conn,
    "
    SELECT COUNT(*) AS total
    FROM visible_panel_materials
    "
);

$totalRecords = mysqli_fetch_assoc($totalRecordsQuery)['total'];
$totalPages = ceil($totalRecords / $limit);

$query = mysqli_query(
    $conn,
    "
    SELECT
        visible_panel_materials.*,
        visible_panel_categories.category_name
    FROM visible_panel_materials

    LEFT JOIN visible_panel_categories
    ON visible_panel_categories.id =
    visible_panel_materials.category_id

    ORDER BY visible_panel_materials.id ASC

    LIMIT $limit OFFSET $offset
    "
);
?>

<div class="page-card">

    <div class="page-header">

        <h1>Visible Panel Materials</h1>

        <?php if(can('visible_panel_create')){ ?>
            <a href="create.php" class="theme-btn">
                + Add Material
            </a>
        <?php } ?>

    </div>

    <table class="custom-table">

        <thead>
            <tr>
                <th>Sr No.</th>
                <th>Category</th>
                <th>Material</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        <?php
        $srNo = $offset + 1;

        while($row = mysqli_fetch_assoc($query)){
        ?>

            <tr>

                <td data-label="Sr No:">
                    <?= $srNo++ ?>
                </td>

                <td data-label="Category:">
                    <?= htmlspecialchars($row['category_name']) ?>
                </td>

                <td data-label="Material:">
                    <?= htmlspecialchars($row['material_name']) ?>
                </td>

                <td data-label="Price:">
                    ₹ <?= number_format($row['price_per_sqft'],2) ?>
                </td>

                <td data-label="Status:">

                    <?php if($row['status']==1){ ?>

                        <span class="status-active">
                            Active
                        </span>

                    <?php }else{ ?>

                        <span class="status-inactive">
                            Inactive
                        </span>

                    <?php } ?>

                </td>

                <td data-label="Action:">

                    <?php if(can('visible_panel_edit')){ ?>
                        <a
                            href="edit.php?id=<?= $row['id'] ?>"
                            class="edit-btn">
                            Edit
                        </a>
                    <?php } ?>

                    <?php if(can('visible_panel_delete')){ ?>
                        <a
                            href="delete.php?id=<?= $row['id'] ?>"
                            class="delete-btn"
                            onclick="return confirm('Are you sure?')">
                            Delete
                        </a>
                    <?php } ?>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

    <?php if($totalPages > 1){ ?>

        <div class="pagination">

            <?php if($page > 1){ ?>
                <a href="?page=<?= $page-1 ?>">
                    &laquo; Prev
                </a>
            <?php } ?>

            <?php if($page > 3){ ?>
                <a href="?page=1">1</a>

                <?php if($page > 4){ ?>
                    <span class="pagination-dots">...</span>
                <?php } ?>

            <?php } ?>

            <?php
            $start = max(1,$page-2);
            $end   = min($totalPages,$page+2);

            for($i=$start;$i<=$end;$i++){
            ?>

                <a
                    href="?page=<?= $i ?>"
                    class="<?= ($i==$page)?'active':'' ?>">
                    <?= $i ?>
                </a>

            <?php } ?>

            <?php if($page < $totalPages-2){ ?>

                <?php if($page < $totalPages-3){ ?>
                    <span class="pagination-dots">...</span>
                <?php } ?>

                <a href="?page=<?= $totalPages ?>">
                    <?= $totalPages ?>
                </a>

            <?php } ?>

            <?php if($page < $totalPages){ ?>

                <a href="?page=<?= $page+1 ?>">
                    Next &raquo;
                </a>

            <?php } ?>

        </div>

    <?php } ?>

</div>

<?php include '../includes/footer.php'; ?>