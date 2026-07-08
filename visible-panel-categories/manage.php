<?php
include '../includes/auth.php';
include '../db.php';

if(!can('visible_panel_view')){
    die('Access Denied');
}

/** @var mysqli $conn */

include '../includes/header.php';
include '../includes/sidebar.php';

$query = mysqli_query(
    $conn,
    "SELECT *
    FROM visible_panel_categories
    ORDER BY id ASC"
);
?>

<div class="page-card">

    <div class="page-header">
        <h1>Visible Panel Categories</h1>

        <?php if(can('visible_panel_create')){ ?>
            <a href="create.php" class="theme-btn">
                + Add Category
            </a>
        <?php } ?>

    </div>

    <table class="custom-table">

        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Status</th>
                <th width="180">Action</th>
            </tr>
        </thead>

        <tbody>

        <?php
        $srNo = 1;

        while($row = mysqli_fetch_assoc($query)){
        ?>

            <tr>

                <td data-label="Sr No:"><?= $srNo++ ?></td>

                <td data-label="Category:">
                    <?= htmlspecialchars($row['category_name']) ?>
                </td>

                <td data-label="Status:">
                    <?php if($row['status'] == 1){ ?>
                        <span class="status-active">Active</span>
                    <?php }else{ ?>
                        <span class="status-inactive">Inactive</span>
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
                            onclick="return confirm('Are you sure you want to delete this category?');">
                            Delete
                        </a>
                    <?php } ?>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

<?php include '../includes/footer.php'; ?>