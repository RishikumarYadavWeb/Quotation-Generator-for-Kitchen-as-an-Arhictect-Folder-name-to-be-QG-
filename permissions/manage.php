<?php
    include '../db.php';
    /** @var mysqli $conn */
    include '../includes/header.php';
    include '../includes/sidebar.php';
    if(!can('permissions_manage')){
        die('Access Denied');
    }
    $permissions = mysqli_query($conn,"SELECT * FROM permissions ORDER BY module ASC");
?>
<div class="page-card">
    <div class="top-bar">
        <h2>View Permissions Table</h2>
    </div>
    <table class="custom-table">
        <thead>
            <th>ID</th>
            <th>Module</th>
            <th>Permission</th>
        </thead>
        <?php while($row = mysqli_fetch_assoc($permissions)) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['module'] ?></td>
                <td><?= $row['permission_name'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>