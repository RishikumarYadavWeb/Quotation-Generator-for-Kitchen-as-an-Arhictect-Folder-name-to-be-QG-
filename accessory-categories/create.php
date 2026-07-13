<?php
include '../includes/auth.php';
include '../db.php';

if (!can('accessories_category_create')) {
    die('Access Denied');
}

/** @var mysqli $conn */

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="page-card">

    <div class="page-header">
        <div>
            <h1>Accessory Categories</h1>
            <p>Add New Accessory Category</p>
        </div>
    </div>

    <form action="save.php" method="POST">

        <div class="form-group">
            <label>Category Name <span class="required">*</span></label>
            <input
                type="text"
                name="category_name"
                class="form-control"
                placeholder="Enter Category Name"
                required>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select
                name="status"
                class="form-control">

                <option value="1">Active</option>
                <option value="0">Inactive</option>

            </select>
        </div>

        <button
            type="submit"
            class="theme-btn">
            Save Category
        </button>

    </form>

</div>

<?php include '../includes/footer.php'; ?>