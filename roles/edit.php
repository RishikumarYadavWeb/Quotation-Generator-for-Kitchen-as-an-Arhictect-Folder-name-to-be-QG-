<?php
    include '../db.php';
    if(!can('roles_edit')){
        die('Access Denied');
    }
    /** @var mysqli $conn */
    include '../includes/header.php';
    include '../includes/sidebar.php';
    $id = (int) ($_GET['id'] ?? 0);
    $role = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM roles WHERE id='$id'"));
    $permissions = mysqli_query($conn,"SELECT * FROM permissions ORDER BY module ASC");
    $selected_permissions = [];
    $rp =
    mysqli_query(
        $conn,
        "SELECT permission_id
        FROM role_permissions
        WHERE role_id='$id'"
    );
    while($row = mysqli_fetch_assoc($rp)){$selected_permissions[] = $row['permission_id'];}
    $grouped = [];
    while($row = mysqli_fetch_assoc($permissions)){$grouped[$row['module']][] = $row;}
?>
<style>
.page-content{padding:30px;width:100%}.top-bar{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px}.top-bar h2{margin:0;font-size:28px;font-weight:700;color:#111827}.btn{display:inline-flex;align-items:center;justify-content:center;background:#111827;color:#fff;padding:12px 22px;border-radius:12px;border:none;text-decoration:none;font-size:14px;font-weight:600;cursor:pointer;transition:0.3s ease}.btn:hover{transform:translateY(-2px);opacity:.92}.role-form-card{background:#fff;border-radius:20px;padding:35px;box-shadow:0 4px 20px rgb(0 0 0 / .06)}.form-group{margin-bottom:25px}.form-group label{display:block;margin-bottom:10px;font-size:14px;font-weight:600;color:#374151}.form-control{width:100%;height:54px;border:1px solid #d1d5db;border-radius:12px;padding:0 16px;font-size:14px;transition:0.3s ease}.form-control:focus{outline:none;border-color:#111827;box-shadow:0 0 0 4px rgb(17 24 39 / .08)}.permission-wrapper{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:22px;margin-top:30px}.permission-group{background:#f9fafb;border:1px solid #e5e7eb;border-radius:18px;padding:22px;transition:0.3s ease}.permission-group:hover{transform:translateY(-3px);box-shadow:0 4px 18px rgb(0 0 0 / .05)}.permission-group h3{margin:0 0 18px 0;font-size:18px;font-weight:700;color:#111827;padding-bottom:12px;border-bottom:1px solid #e5e7eb}.permission-items{display:flex;flex-direction:column;gap:14px}.permission-items label{display:flex;align-items:center;gap:12px;font-size:14px;color:#4b5563;cursor:pointer}.permission-items input{width:17px;height:17px;accent-color:#111827}.submit-btn{margin-top:35px}@media(max-width:768px){.page-content{padding:20px}.top-bar{flex-direction:column;align-items:flex-start;gap:15px}.role-form-card{padding:22px}.permission-wrapper{grid-template-columns:1fr}}
</style>
<div class="page-card">
    <div class="top-bar">
        <h2>Edit Role</h2>
        <a href="manage.php" class="theme-btn">Back</a>
    </div>
    <div class="">
        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?= $role['id'] ?>">
            <div class="form-group">
                <label>Role Name</label>
                <input type="text" name="role_name" class="form-control" value="<?= $role['role_name'] ?>" required>
            </div>
            <div class="permission-wrapper">
                <?php foreach($grouped as $module => $items) { ?>
                    <div class="permission-group">
                        <h3><?= ucfirst($module) ?></h3>
                        <div class="permission-items">
                            <?php foreach($items as $permission) { ?>
                                <label>
                                    <input type="checkbox" name="permissions[]" value="<?= $permission['id'] ?>" <?= in_array($permission['id'],$selected_permissions) ? 'checked' : '' ?>>
                                    <?= $permission['permission_name'] ?>
                                </label>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <button type="submit" class="theme-btn mt-5">Update Role</button>
        </form>
    </div>
</div>
<?php include '../includes/footer.php'; ?>