<?php
include '../includes/auth.php';
include '../db.php';
$pageTitle = "Settings";
include '../includes/header.php';
include '../includes/sidebar.php';
?>
<div class="page-header">
    <div>
        <h1><i class="fa-solid fa-gear"></i> Settings</h1>
        <p>Manage your account, application configuration and system utilities.</p>
    </div>
</div>
<div class="settings-grid">
    <div class="setting-card">
        <div class="card-content">
            <div class="d-flex">
                <div class="card-icon blue">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <h3 class="m20">Account</h3>
                    <p>Manage your profile and security.</p>
                </div>
            </div>
            <ul>
                <li><a href="account/profile.php">Profile<i class="fa-solid fa-chevron-right"></i></a></li>
                <li><a href="account/change-password.php">Change Password<i class="fa-solid fa-chevron-right"></i></a></li>
            </ul>
        </div>
    </div>
    <!-- <div class="setting-card">
        <div class="card-content">
            <div class="d-flex">
                <div class="card-icon orange">
                    <i class="fa-solid fa-toolbox"></i>
                </div>
                <div>
                    <h3 class="m20">Administration</h3>
                    <p>Backup, audit and deleted records.</p>
                </div>
            </div>
            <ul>
                <li><a href="administration/backup.php">Backup<i class="fa-solid fa-chevron-right"></i></a></li>
                <li><a href="administration/activity-log.php">Activity Log<i class="fa-solid fa-chevron-right"></i></a></li>
                <li><a href="administration/trash-bin.php">Trash Bin<i class="fa-solid fa-chevron-right"></i></a></li>
            </ul>
        </div>
    </div> -->
    <div class="setting-card">
        <div class="card-content">
            <div class="d-flex">
                <div class="card-icon green">
                    <i class="fa-solid fa-server"></i>
                </div>
                <div>
                    <h3 class="m20">System</h3>
                    <p>Server and storage management.</p>
                </div>
            </div>
            <ul>
                <li><a href="system/system-information.php">System Information<i class="fa-solid fa-chevron-right"></i></a></li>
                <li><a href="system/database-health.php">Database Health<i class="fa-solid fa-chevron-right"></i></a></li>
                <!-- <li><a href="system/storage-usage.php">Storage Usage<i class="fa-solid fa-chevron-right"></i></a></li> -->
            </ul>
        </div>
    </div>
    <!-- <div class="setting-card">
        <div class="card-content">
            <div class="d-flex">
                <div class="card-icon purple">
                    <i class="fa-solid fa-chart-column"></i>
                </div>
                <div>
                    <h3 class="m20">Reports</h3>
                    <p>Generate exports and audit reports.</p>
                </div>
            </div>
            <ul>
                <li><a href="reports/audit-reports.php">Audit Reports<i class="fa-solid fa-chevron-right"></i></a></li>
                <li><a href="reports/data-export.php">Data Export<i class="fa-solid fa-chevron-right"></i></a></li>
            </ul>
        </div>
    </div> -->
    <!-- <div class="setting-card full-width">
        <div class="card-content">
            <div class="d-flex">
                <div class="card-icon red">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div>
                    <h3 class="m20">Logs</h3>
                    <p>Monitor application activities and server logs.</p>
                </div>
            </div>
            <ul>
                <li><a href="logs/error-logs.php">Error Logs<i class="fa-solid fa-chevron-right"></i></a></li>
                <li><a href="logs/application-logs.php">Application Logs<i class="fa-solid fa-chevron-right"></i></a></li>
            </ul>
        </div>
    </div> -->
</div>
<link rel="stylesheet" href="assets/style.css">
<script src="assets/script.js"></script>
<?php include '../includes/footer.php'; ?>