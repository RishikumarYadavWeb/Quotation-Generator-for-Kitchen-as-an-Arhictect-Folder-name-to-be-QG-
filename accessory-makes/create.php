<?php
include '../includes/auth.php';
include '../db.php';

if (!can('accessories_create')) {
    die('Access Denied');
}

/** @var mysqli $conn */

include '../includes/header.php';
include '../includes/sidebar.php';

$categories = mysqli_query(
    $conn,
    "
    SELECT *
    FROM accessory_categories
    WHERE status = 1
    ORDER BY category_name
    "
);
?>

<div class="page-card">

    <div class="page-header">
        <div>
            <h1>Accessory Makes</h1>
            <p>Add New Accessory Make</p>
        </div>
    </div>

    <form action="save.php" method="POST">

        <div class="form-group">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">Select Category</option>

                <?php while($row=mysqli_fetch_assoc($categories)){ ?>

                    <option value="<?= $row['id'] ?>">
                        <?= htmlspecialchars($row['category_name']) ?>
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
                required>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <button class="theme-btn">
            Save Make
        </button>

    </form>

</div>

<?php include '../includes/footer.php'; ?>
