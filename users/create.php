<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    if(!can('users_create')){
        die('Access Denied');
    }
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
    if(isset($_POST['create_user'])){
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $role_id = (int) ($_POST['role_id'] ?? 0);
        $status = $_POST['status'];
        $entity_id = (int) ($_POST['entity_id'] ?? 0);
        $checkEmail = "
        SELECT *
        FROM users
        WHERE email = '$email'
        ";
        $checkResult = mysqli_query($conn, $checkEmail);
        if(mysqli_num_rows($checkResult) > 0){
            $error =
            "Email already exists";
        }
        else{
            /* HASH PASSWORD */
            $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

            /* INSERT USER */
            $insertQuery = "
            INSERT INTO users(
                name,
                email,
                password,
                role_id,
                entity_id,
                status
            )
            VALUES(
                '$name',
                '$email',
                '$hashedPassword',
                '$role_id',
                '$entity_id',
                '$status'
            )
            ";
            mysqli_query(
                $conn,
                $insertQuery
            );
            header('Location: manage.php');
            exit;
        }
    }
    include '../includes/header.php';
    include '../includes/sidebar.php';
?>
<div class="page-card">
    <div class="create-user-header">
        <div>
            <h1>Create User</h1>
            <p>Add new ERP system user</p>
        </div>
    </div>
    <div class="">
        <?php if(isset($error)){ ?>
            <div class="user-error">
                <?= $error; ?>
            </div>
        <?php } ?>
        <form method="POST">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label>Full Name</label>
                    <input type="text" name="name" class="modern-input" required>
                </div>
                <div class="col-md-6 mb-4">
                    <label>Email</label>
                    <input type="email" name="email" class="modern-input" required>
                </div>
                <div class="col-md-6 mb-4">
                    <label>Password</label>
                    <input type="password" name="password" class="modern-input" required>
                </div>
                <div class="col-md-6 mb-4">
                    <label>Role</label>
                    <select name="role_id" class="modern-input" required>
                        <option value="">Select Role</option>
                        <?php while($role =mysqli_fetch_assoc($rolesResult)){?>
                        <option value="<?= $role['id']; ?>">
                            <?= $role['role_name']; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6 mb-4">
                    <label>Entity</label>
                    <select name="entity_id" class="modern-input" required>
                        <option value="">Select Entity</option>
                        <?php while($entity =mysqli_fetch_assoc($entityResult)){?>
                            <option value="<?= $entity['id']; ?>">
                                <?= $entity['entity_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6 mb-4">
                    <label>Status</label>
                    <select name="status" class="modern-input" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" name="create_user" class="btn btn-success">
                <i class="fa-solid fa-floppy-disk"></i>
                Save User
            </button>
        </form>
    </div>
</div>
<?php include '../includes/footer.php';?>