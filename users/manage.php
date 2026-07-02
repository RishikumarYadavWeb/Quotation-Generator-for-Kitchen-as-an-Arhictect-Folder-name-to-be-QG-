<?php
include '../includes/auth.php';
include '../db.php';
 if(!can('users_view')){
    die('Access Denied');
}
/** @var mysqli $conn */
include '../includes/header.php';
include '../includes/sidebar.php';
$limit = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;
$totalUsersQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM users"
);
$totalRecords = mysqli_fetch_assoc($totalUsersQuery)['total'];
$totalPages = ceil($totalRecords / $limit);
$query = "
    SELECT
        users.*,
        roles.role_name
    FROM users
    LEFT JOIN roles
    ON users.role_id = roles.id
    ORDER BY users.id DESC
    LIMIT $limit OFFSET $offset
";
$result = mysqli_query($conn, $query);
?>
<div class="page-card">
    <div class="users-page-header">
        <div>
            <h1>Manage Users</h1>
            <p>Create and manage ERP users</p>
        </div>
        <?php if(can('users_create')){ ?>
            <a href="create.php" class="theme-btn"><i class="fa-solid fa-plus" style="margin-right:10px;"></i>Create User</a>
        <?php } ?>
    </div>
    <table class="custom-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($user = mysqli_fetch_assoc($result)){ ?>
                <tr>
                    <td data-label="Name:">
                        <div class="user-name-cell">
                            <div class="user-avatar"><?= strtoupper(substr($user['name'],0,1)); ?></div>
                            <div><?= htmlspecialchars($user['name']); ?></div>
                        </div>
                    </td>
                    <td data-label="E-mail:"><?= htmlspecialchars($user['email']); ?></td>
                    <td data-label="Role:">
                        <span class="role-badge"><?= htmlspecialchars($user['role_name']); ?></span>
                    </td>
                    <td data-label="Status:">
                        <span class="status-badge <?= $user['status'] == 'Active' ? 'status-active' : 'status-inactive'; ?>"><?= $user['status']; ?></span>
                    </td>
                    <td data-label="Date Created:"><?= date('d M Y',strtotime($user['created_at'])); ?></td>
                    <td data-label="Action:">
                        <div class="table-actions">
                            <?php if(can('users_edit')){ ?>
                                <a href="edit.php?id=<?= $user['id']; ?>" class="edit-btn">Edit</a>
                            <?php } ?>
                            <?php if(can('users_delete')){ ?>
                                <a href="delete.php?id=<?= $user['id']; ?>" class="delete-btn" onclick="return confirm('Delete this user?')">Delete</a>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php if($totalPages > 1){ ?>
        <div class="pagination">
            <?php if($page > 1){ ?>
                <a href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
            <?php } ?>
            <?php if($page > 3){ ?>
                <a href="?page=1">1</a>
                <?php if($page > 4){ ?>
                    <span class="pagination-dots">...</span>
                <?php } ?>
            <?php } ?>
            <?php
                $start = max(1, $page - 2);
                $end = min($totalPages, $page + 2);
                for($i = $start; $i <= $end; $i++){
            ?>
                <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
            <?php } ?>
            <?php if($page < $totalPages - 2){ ?>
                <?php if($page < $totalPages - 3){ ?>
                    <span class="pagination-dots">...</span>
                <?php } ?>
                <a href="?page=<?= $totalPages ?>"><?= $totalPages ?></a>
            <?php } ?>
            <?php if($page < $totalPages){ ?>
                <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<?php include '../includes/footer.php'; ?>