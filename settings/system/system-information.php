<?php

include '../../includes/auth.php';
include '../../db.php';
/** @var mysqli $conn */
$pageTitle="System Information";
$userId=(int)$_SESSION['user_id'];
$userQuery=mysqli_query(
    $conn,
    "
    SELECT u.name, r.role_name, e.entity_name
    FROM users u
    LEFT JOIN roles r ON r.id=u.role_id
    LEFT JOIN entities e ON e.id=u.entity_id
    WHERE u.id='$userId'
    LIMIT 1
    "
);
$user=mysqli_fetch_assoc($userQuery);
$totalUsers = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM users"))[0];
$totalClients = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM clients"))[0];
$totalQuotations = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM quotations"))[0];
include '../../includes/header.php';
include '../../includes/sidebar.php';
?>
<link rel="stylesheet" href="../assets/style.css">
<div class="profile-page">
    <div class="profile-header">
        <div>
            <h1><i class="fa-solid fa-server"></i>System Information</h1>
            <p>View server, application and PHP configuration.</p>
        </div>
        <a href="../index.php" class="btn btn-dark"><i class="fa-solid fa-arrow-left"></i>Back</a>
    </div>
    <div class="profile-grid">
        <div class="profile-card">
            <div class="profile-card-header">
                <h3><i class="fa-solid fa-server"></i>Server Information</h3>
            </div>
            <div class="profile-body">
                <div class="profile-item d-flex">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-brands fa-php" style="margin-right: 10px;"></i>PHP Version:</span>
                    </div>
                    <div class="profile-value"><?= phpversion(); ?></div>
                </div>
                <div class="profile-item ">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-globe" style="margin-right: 10px;"></i>Server Software:</span>
                    </div>
                    <div class="profile-value"><?= $_SERVER['SERVER_SOFTWARE']; ?></div>
                </div>
                <div class="profile-item d-flex">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-network-wired" style="margin-right: 10px;"></i>Server Name:</span>
                    </div>
                    <div class="profile-value"><?= $_SERVER['SERVER_NAME']; ?></div>
                </div>
                <div class="profile-item d-flex">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-location-dot" style="margin-right: 10px;"></i>Server IP:</span>
                    </div>
                    <div class="profile-value"><?= $_SERVER['SERVER_ADDR'] ?? 'N/A'; ?></div>
                </div>
                <div class="profile-item">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-folder-open" style="margin-right: 10px;"></i>Document Root:</span>
                    </div>
                    <div class="profile-value"><?= $_SERVER['DOCUMENT_ROOT']; ?></div>
                </div>
            </div>
        </div>
        <div class="profile-card">
            <div class="profile-card-header">
                <h3><i class="fa-solid fa-sliders"></i>PHP Configuration</h3>
            </div>
            <div class="profile-body">
                <div class="profile-item d-flex">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-memory" style="margin-right: 10px;"></i>Memory Limit:</span>
                    </div>
                    <div class="profile-value"><?= ini_get('memory_limit'); ?></div>
                </div>
                <div class="profile-item d-flex">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-upload" style="margin-right: 10px;"></i>Upload Max Filesize:</span>
                    </div>
                    <div class="profile-value"><?= ini_get('upload_max_filesize'); ?></div>
                </div>
                <div class="profile-item">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-calendar-days" style="margin-right: 10px;"></i>Current Server Time:</span>
                    </div>
                    <div class="profile-value"><?= date('d M Y h:i:s A'); ?></div>
                </div>
                <div class="profile-item d-flex">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-language" style="margin-right: 10px;"></i>Default Charset:</span>
                    </div>
                    <div class="profile-value"><?= ini_get('default_charset'); ?></div>
                </div>
                <div class="profile-item d-flex">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-compress" style="margin-right: 10px;"></i>Output Buffering:</span>
                    </div>
                    <div class="profile-value"><?= ini_get('output_buffering'); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../../includes/footer.php'; ?>