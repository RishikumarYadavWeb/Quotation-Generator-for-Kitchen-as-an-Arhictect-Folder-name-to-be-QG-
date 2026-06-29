<?php
    session_start();
    include '../db.php';
    /** @var mysqli $conn */
    include '../roles/permission.php';
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if(
        empty($email)
        ||
        empty($password)
    ){
        die('Email and Password required');
    }
    $email = mysqli_real_escape_string($conn,$email);
    $query = "
    SELECT
        users.*,
        roles.role_name
    FROM users
    LEFT JOIN roles
    ON users.role_id = roles.id
    WHERE users.email = '$email'
    LIMIT 1
    ";
    $result = mysqli_query($conn,$query);
    if(
        mysqli_num_rows($result) < 1
    ){
        die('Invalid Email');
    }
    $user = mysqli_fetch_assoc($result);
    if(
        !password_verify($password,$user['password'])
    ){
        die('Invalid Password');
    }
    if(
        $user['status'] != 'Active'
    ){
        die('User Inactive');
    }
    $permissionQuery = "
    SELECT
        permissions.permission_name
    FROM role_permissions
    LEFT JOIN permissions
    ON role_permissions.permission_id = permissions.id
    WHERE role_permissions.role_id = '".$user['role_id']."'
    ";
    $permissionResult = mysqli_query($conn,$permissionQuery);
    $permissions = [];
    while(
        $permission = mysqli_fetch_assoc($permissionResult)
    ){
        $permissions[] = $permission['permission_name'];
    }
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role_id'] = $user['role_id'];
    $_SESSION['entity_id'] = $user['entity_id'];
    $_SESSION['role_name'] = $user['role_name'];
    $_SESSION['permissions'] = $permissions;
    if(
        in_array('dashboard_view',$permissions)
    ){
        header('Location: ../dashboard.php');
    }else{
        header('Location: ../quotations/create.php');
    }
    exit;
?>