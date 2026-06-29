<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    if(!can('users_edit')){
        die('Access Denied');
    }
    $id = (int) ($_GET['id'] ?? 0);
    $userQuery = "
        SELECT *
        FROM users
        WHERE id = '$id'
        LIMIT 1
    ";
    $userResult = mysqli_query($conn, $userQuery);
    $user = mysqli_fetch_assoc($userResult);
    $rolesQuery = "
        SELECT *
        FROM roles
        ORDER BY role_name ASC
    ";
    $rolesResult = mysqli_query($conn, $rolesQuery);
    $entityQuery = "
        SELECT *
        FROM entities
        ORDER BY entity_name ASC
    ";
    $entityResult = mysqli_query($conn,$entityQuery);
    if(isset($_POST['update_user'])){
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $role_id = (int) ($_POST['role_id'] ?? 0);
        $entity_id = (int) ($_POST['entity_id'] ?? 0);
        $status = $_POST['status'];
        $password = trim($_POST['password']);
        if(empty($password)){
            $updateQuery = "
                UPDATE users
                SET
                    name = '$name',
                    email = '$email',
                    role_id = '$role_id',
                    entity_id = '$entity_id',
                    status = '$status'
                WHERE id = '$id'
            ";
        }
        else{
            $hashedPassword = password_hash($password,PASSWORD_DEFAULT );
            $updateQuery = "
                UPDATE users
                SET
                    name = '$name',
                    email = '$email',
                    password = '$hashedPassword',
                    role_id = '$role_id',
                    entity_id = '$entity_id',
                    status = '$status'
                WHERE id = '$id'
            ";
        }
        mysqli_query( $conn, $updateQuery );
        header('Location: manage.php');
        exit;
    }
    include '../includes/header.php';
    include '../includes/sidebar.php';
?>

<div class="page-card">
    <div class="create-user-header">
        <div>
            <h1>Edit User</h1>
            <p>Update ERP user information</p>
        </div>
    </div>
    <div class="">
        <form method="POST">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label> Full Name </label>
                    <input type="text" name="name" class="modern-input" required value="<?= $user['name']; ?>">
                </div>
                <div class="col-md-6 mb-4">
                    <label> Email </label>
                    <input type="email" name="email" class="modern-input" required value="<?= $user['email']; ?>">
                </div>
                <div class="col-md-6 mb-4">
                    <label>New Password</label>
                    <input type="password" name="password" class="modern-input" placeholder="Leave blank to keep old password">
                </div>
                <div class="col-md-6 mb-4">
                    <label>Role</label>
                    <select name="role_id" class="modern-input" required>
                        <?php 
                            while($role = mysqli_fetch_assoc( $rolesResult ))
                        {?>
                            <option
                                value="<?= $role['id']; ?>"
                                <?= $user['role_id'] == $role['id'] ? 'selected' : ''; ?>>
                                <?= $role['role_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6 mb-4">
                    <label>Entity </label>
                    <select name="entity_id" class="modern-input" required >
                        <option value="">Select Entity </option>
                        <?php
                            while( $entity = mysqli_fetch_assoc( $entityResult ) )
                        {?>
                        <option value="<?= $entity['id']; ?>"
                            <?= $user['entity_id'] == $entity['id'] ? 'selected' : ''; ?> >
                            <?= $entity['entity_name']; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6 mb-4">
                    <label> Status </label>
                    <select name="status" class="modern-input" >
                        <option value="Active" <?= $user['status'] == 'Active' ? 'selected' : ''; ?> >Active</option>
                        <option value="Inactive" <?= $user['status'] == 'Inactive' ? 'selected' : ''; ?> >Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" name="update_user" class="btn btn-success" >
                <i class="fa-solid fa-floppy-disk"></i>
                Update User
            </button>
        </form>
    </div>
</div>
<?php include '../includes/footer.php'; ?>