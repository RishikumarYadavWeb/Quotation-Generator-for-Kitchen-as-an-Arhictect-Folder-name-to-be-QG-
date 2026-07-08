<?php
include '../includes/auth.php';
if(!can('visible_side_create')){
    die('Access Denied');
}
include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="page-card">

    <h1>Add Visible Side Category</h1>

    <form method="POST" action="save.php">

        <div class="mb-3">
            <label>Category Name</label>
            <input
                type="text"
                name="category_name"
                class="modern-input"
                placeholder="Enter Visible Side Category"
                required
            >
        </div>

        <button type="submit" class="theme-btn">
            Save Category
        </button>

    </form>

</div>

<?php include '../includes/footer.php'; ?>