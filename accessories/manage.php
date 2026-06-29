<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    if(!can('accessories_view')){
        die('Access Denied');
    }
    $getAccessories = mysqli_query(
        $conn,
        "
        SELECT
            id,
            accessory_name,
            category,
            unit,
            price
        FROM accessories
        ORDER BY id DESC
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
        <?php if(can('crdashboard_view')){ ?>
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
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($getAccessories)){ ?>
                    <tr>
                        <td>#<?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['accessory_name']) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td><?= htmlspecialchars($row['unit']) ?></td>
                        <td>₹ <?= number_format($row['price'],2) ?></td>
                        <td>
                            <div class="action-btns">
                                <?php if(can('crdashboard_view')){ ?>
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                                <?php } ?>
                                <?php if(can('crdashboard_view')){ ?>
                                    <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this accessory?')">Delete</a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../includes/footer.php'; ?>