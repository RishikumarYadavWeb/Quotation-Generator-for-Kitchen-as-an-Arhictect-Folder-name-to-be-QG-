<?php
    include '../../../includes/auth.php';
    include '../../../db.php';
    /** @var mysqli $conn */
    include '../../../includes/header.php';
    include '../../../includes/sidebar.php';
    $id = (int) ($_GET['id'] ?? 0);
    $query = "SELECT * FROM shutter_categories WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
?>
<div class="container">
    <div class="top-bar">
        <h2>Edit Category</h2>
    </div>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $row['id']; ?>">
        <div class="form-group">
            <label>Category Name</label>
            <input type="text" name="category_name" value="<?= $row['category_name']; ?>" required>
        </div>
        <button type="submit">Update Category</button>
    </form>
</div>
<?php include '../../../includes/footer.php'; ?>