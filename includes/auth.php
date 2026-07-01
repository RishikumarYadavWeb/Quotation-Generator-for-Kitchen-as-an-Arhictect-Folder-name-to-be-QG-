<?php
session_start();
if(
    !isset($_SESSION['user_id'])
){
    header('Location: /QG/auth/login.php');
    exit;
}
require_once __DIR__ . '/../roles/permission.php';