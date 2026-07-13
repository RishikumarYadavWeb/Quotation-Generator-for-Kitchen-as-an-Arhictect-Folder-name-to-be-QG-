<?php
include '../includes/auth.php';
include '../db.php';

if (!can('accessories_category_edit')) {
    die('Access Denied');
}

/** @var mysqli $conn */

include '../includes/header.php';
include '../includes/sidebar.php';

$id = (int)$_GET['id'];

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM accessory_categories
    WHERE id = '$id'
    "
);

$row = mysqli_fetch_assoc($query);
?>

<div class="page-card">

    <div class="page-header">
        <h1>Edit Accessory Category</h1>
    </div>

    <form action="update.php" method="POST">

        <input
            type="hidden"
            name="id"
            value="<?= $row['id'] ?>">

        <div class="form-group">
            <label>Category Name</label>
            <input
                type="text"
                name="category_name"
                class="form-control"
                value="<?= htmlspecialchars($row['category_name']) ?>"
                required>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select
                name="status"
                class="form-control">

                <option
                    value="1"
                    <?= $row['status'] == 1 ? 'selected' : '' ?>>
                    Active
                </option>

                <option
                    value="0"
                    <?= $row['status'] == 0 ? 'selected' : '' ?>>
                    Inactive
                </option>

            </select>
        </div>

        <button
            type="submit"
            class="theme-btn">
            Update Category
        </button>

    </form>

</div>

<?php include '../includes/footer.php'; ?>