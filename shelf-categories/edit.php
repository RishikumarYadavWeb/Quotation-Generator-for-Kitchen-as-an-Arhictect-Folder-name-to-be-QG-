<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    include '../includes/header.php';
    include '../includes/sidebar.php';
    if(!can('shelves_edit')){
        die('Access Denied');
    }
    $id = (int) ($_GET['id'] ?? 0);
    $query = mysqli_query(
        $conn,
        "SELECT *
        FROM shelf_categories
        WHERE id = '$id'"
    );
    $row = mysqli_fetch_assoc($query);
?>
<div class="form-card">
    <h1>Edit Shelf Category</h1>
    <form method="POST" action="update.php">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <div class="mb-3">
            <label>Category Name</label>
            <input type="text" name="category_name" class="modern-input" value="<?= $row['category_name'] ?>" required>
        </div>
        <button type="submit" class="theme-btn">Update Category</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>