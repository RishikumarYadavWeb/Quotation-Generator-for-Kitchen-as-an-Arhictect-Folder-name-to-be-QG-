<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    if(!can('roles_view')){
        die('Access Denied');
    }
    $roles = mysqli_query($conn,"SELECT * FROM roles ORDER BY id DESC");
    include '../includes/header.php';
    include '../includes/sidebar.php';
?>
<style>
.page-content{padding:30px;width:100%}.top-bar{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px}.top-bar h2{margin:0;font-size:28px;font-weight:700;color:#111827}.btn{display:inline-flex;align-items:center;justify-content:center;background:#111827;color:#fff;padding:12px 22px;border-radius:12px;border:none;text-decoration:none;font-size:14px;font-weight:600;cursor:pointer;transition:0.3s ease}.btn:hover{transform:translateY(-2px);opacity:.92}.table-wrapper{background:#fff;border-radius:18px;overflow:hidden;box-shadow:0 4px 20px rgb(0 0 0 / .06)}.table{width:100%;border-collapse:collapse}.table th{background:#f9fafb;padding:18px;text-align:left;font-size:14px;font-weight:700;color:#374151;border-bottom:1px solid #e5e7eb}.table td{padding:18px;font-size:14px;color:#555;border-bottom:1px solid #f3f4f6}.table tr:last-child td{border-bottom:none}.action-links{display:flex;align-items:center;gap:15px}.edit-link{color:#2563eb;text-decoration:none;font-weight:600}.delete-link{color:#dc2626;text-decoration:none;font-weight:600}@media(max-width:768px){.page-content{padding:20px}.top-bar{flex-direction:column;align-items:flex-start;gap:15px}.table{min-width:600px}.table-wrapper{overflow-x:auto}}
</style>
<div class="page-card">
    <div class="top-bar">
        <h2>Roles Management</h2>
        <?php if(can('roles_create')){ ?>
            <a href="create.php" class="theme-btn">Add Role</a>
        <?php } ?>
    </div>
    <div class="">
        <table class="custom-table">
            <thead>
                <th>ID</th>
                <th>Role Name</th>
                <th>Action</th>
            </thead>
            <?php while($row = mysqli_fetch_assoc($roles)) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['role_name'] ?></td>
                    <td>
                        <div class="action-links">
                            <?php if(can('roles_edit')){ ?>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                            <?php } ?>
                            <?php if(can('roles_delete')){ ?>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete Role?')">Delete</a>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php include '../includes/footer.php'; ?>