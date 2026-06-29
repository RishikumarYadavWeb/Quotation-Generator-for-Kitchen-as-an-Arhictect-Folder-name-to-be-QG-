<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    include '../includes/header.php';
    include '../includes/sidebar.php';
    $query = "
        SELECT
            users.*,
            roles.role_name
        FROM users
        LEFT JOIN roles
        ON users.role_id = roles.id
        ORDER BY users.id DESC
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
            <a href="create.php" class="theme-btn">
                <i class="fa-solid fa-plus" style="margin-right: 10px;"></i>
                Create User
            </a>
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
            <?php while($user =mysqli_fetch_assoc($result)){?>
                <tr>
                    <td>
                        <div class="user-name-cell">
                            <div class="user-avatar"><?= strtoupper( substr( $user['name'],0, 1 )); ?></div>
                            <div><?= $user['name']; ?></div>
                        </div>
                    </td>
                    <td><?= $user['email']; ?></td>
                    <td>
                        <span class="role-badge"><?= $user['role_name']; ?></span>
                    </td>
                    <td>
                        <span class="status-badge <?= $user['status'] == 'Active' ? 'status-active' : 'status-inactive'; ?>">
                            <?= $user['status']; ?>
                        </span>
                    </td>
                    <td><?= date( 'd M Y', strtotime( $user['created_at'] )); ?></td>
                    <td>
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
</div>
<?php include '../includes/footer.php';?>