<?php
include '../../includes/auth.php';
include '../../db.php';
/** @var mysqli $conn */
$pageTitle = "My Profile";
$userId = (int)$_SESSION['user_id'];
$sql = mysqli_query(
    $conn,
    "
    SELECT
        u.*,
        r.role_name,
        e.entity_name
    FROM users u
    LEFT JOIN roles r
        ON r.id=u.role_id
    LEFT JOIN entities e
        ON e.id=u.entity_id
    WHERE u.id='$userId'
    LIMIT 1
    "
);
$user = mysqli_fetch_assoc($sql);
include '../../includes/header.php';
include '../../includes/sidebar.php';
?>
<link rel="stylesheet" href="../assets/style.css">
<div class="profile-page">
    <div class="profile-header">
        <div>
            <h1><i class="fa-solid fa-user"></i>My Profile</h1>
            <p>Manage your personal account settings.</p>
        </div>
        <a href="../index.php" class="btn btn-dark"><i class="fa-solid fa-arrow-left"></i>Back</a>
    </div>
    <div class="profile-hero">
        <div class="profile-avatar"><?= strtoupper(substr($user['name'],0,1)); ?></div>
        <div class="profile-details">
            <h2><?= htmlspecialchars($user['name']); ?></h2>
            <p><?= htmlspecialchars($user['email']); ?></p>
            <div class="profile-badges">
                <span class="badge-role">
                    <i class="fa-solid fa-user-shield"></i>
                    <?= htmlspecialchars($user['role_name']); ?>
                </span>
                <?php if(!empty($user['entity_name'])){ ?>
                    <span class="badge-entity">
                        <i class="fa-solid fa-building"></i>
                        <?= htmlspecialchars($user['entity_name']); ?>
                    </span>
                <?php } ?>
                <span class="badge-status">
                    <i class="fa-solid fa-circle-check"></i>
                    <?= $user['status']; ?>
                </span>
            </div>
        </div>
    </div>
    <div class="profile-card">
        <div class="profile-card-header">
            <h3><i class="fa-solid fa-id-card"></i>Personal Information</h3>
        </div>
        <div class="profile-body">
            <div class="profile-item d-flex">
                <div class="profile-label align-items-center">
                    <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-user"></i>Full Name:</span>
                </div>
                <div class="profile-value"><?= htmlspecialchars($user['name']); ?></div>
            </div>
            <div class="profile-item d-flex">
                <div class="profile-label align-items-center">
                    <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-envelope"></i></i>Email Address:</span>
                </div>
                <div class="profile-value"><?= htmlspecialchars($user['email']); ?></div>
            </div>
            <div class="profile-item d-flex">
                <div class="profile-label align-items-center">
                    <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-user-shield"></i></i>Roles</span>
                </div>
                <div class="profile-value"><?= htmlspecialchars($user['role_name']); ?></div>
            </div>
            <div class="profile-item d-flex">
                <div class="profile-label align-items-center">
                    <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-building"></i></i>Entity:</span>
                </div>
                <div class="profile-value"><?= htmlspecialchars($user['entity_name']); ?></div>
            </div>
            <div class="profile-item d-flex">
                <div class="profile-label align-items-center">
                    <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-check-circle"></i></i>Status:</span>
                </div>
                <div class="profile-value">
                    <span class="status-badge"><?= htmlspecialchars($user['status']); ?></span>
                </div>
            </div>
            <div class="profile-item d-flex">
                <div class="profile-label align-items-center">
                    <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-fingerprint"></i></i>User Id:</span>
                </div>
                <div class="profile-value">#<?= $user['id']; ?></div>
            </div>
            <div class="profile-item d-flex">
                <div class="profile-label align-items-center">
                    <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-calendar-days"></i></i>Created On:</span>
                </div>
                <div class="profile-value"><?= date('d M Y',strtotime($user['created_at'])); ?></div>
            </div>
        </div>
    </div>
</div>
<?php include '../../includes/footer.php';?>