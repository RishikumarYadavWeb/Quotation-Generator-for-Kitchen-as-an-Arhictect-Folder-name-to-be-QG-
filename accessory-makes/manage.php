<?php
include '../includes/auth.php';
include '../db.php';

if (!can('accessories_view')) {
    die('Access Denied');
}

/** @var mysqli $conn */

include '../includes/header.php';
include '../includes/sidebar.php';

$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$totalQuery = mysqli_query(
    $conn,
    "
    SELECT COUNT(*) AS total
    FROM accessory_makes
    "
);

$totalRecords = mysqli_fetch_assoc($totalQuery)['total'];
$totalPages = ceil($totalRecords / $limit);

$query = mysqli_query(
    $conn,
    "
    SELECT
        m.*,
        c.category_name
    FROM accessory_makes m
    INNER JOIN accessory_categories c
        ON c.id = m.category_id
    ORDER BY c.category_name ASC, m.make_name ASC
    LIMIT $limit OFFSET $offset
    "
);
?>

<div class="page-card">

    <div class="page-header">

        <div>
            <h1>Accessory Makes</h1>
        </div>

        <?php if (can('accessories_create')) { ?>
            <a href="create.php" class="theme-btn">
                <i class="fa-solid fa-plus"></i>
                Add Make
            </a>
        <?php } ?>

    </div>

    <table class="custom-table">

        <thead>
            <tr>
                <th>Sr No</th>
                <th>Category</th>
                <th>Make</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            <?php
            $srNo = $offset + 1;

            if (mysqli_num_rows($query) > 0) {

                while ($row = mysqli_fetch_assoc($query)) {
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

                    <td data-label="Status">

                        <?php if ($row['status'] == 1) { ?>

                            <span class="status-active">Active</span>

                        <?php } else { ?>

                            <span class="status-inactive">Inactive</span>

                        <?php } ?>

                    </td>

                    <td data-label="Action">

                        <div class="action-btns">

                            <?php if (can('accessories_edit')) { ?>
                                <a
                                    href="edit.php?id=<?= $row['id'] ?>"
                                    class="edit-btn">
                                    Edit
                                </a>
                            <?php } ?>

                            <?php if (can('accessories_delete')) { ?>
                                <a
                                    href="delete.php?id=<?= $row['id'] ?>"
                                    class="delete-btn"
                                    onclick="return confirm('Delete Make?')">
                                    Delete
                                </a>
                            <?php } ?>

                        </div>

                    </td>

                </tr>

            <?php
                }

            } else {
            ?>

                <tr>
                    <td colspan="5" style="text-align:center;">
                        No Accessory Makes Found
                    </td>
                </tr>

            <?php } ?>

        </tbody>

    </table>

    <?php if ($totalPages > 1) { ?>

        <div class="pagination">

            <?php if ($page > 1) { ?>
                <a href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
            <?php } ?>

            <?php if ($page > 3) { ?>
                <a href="?page=1">1</a>
                <?php if ($page > 4) { ?>
                    <span class="pagination-dots">...</span>
                <?php } ?>
            <?php } ?>

            <?php
            $start = max(1, $page - 2);
            $end = min($totalPages, $page + 2);

            for ($i = $start; $i <= $end; $i++) {
            ?>

                <a
                    href="?page=<?= $i ?>"
                    class="<?= ($i == $page) ? 'active' : '' ?>">
                    <?= $i ?>
                </a>

            <?php } ?>

            <?php if ($page < $totalPages - 2) { ?>

                <?php if ($page < $totalPages - 3) { ?>
                    <span class="pagination-dots">...</span>
                <?php } ?>

                <a href="?page=<?= $totalPages ?>">
                    <?= $totalPages ?>
                </a>

            <?php } ?>

            <?php if ($page < $totalPages) { ?>
                <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
            <?php } ?>

        </div>

    <?php } ?>

</div>

<?php include '../includes/footer.php'; ?>