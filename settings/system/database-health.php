<?php
include '../../includes/auth.php';
include '../../db.php';
/** @var mysqli $conn */
if(!can('settings_view')){
    die("Access Denied");
}
$pageTitle="Database Health";
$dbName = mysqli_fetch_row(mysqli_query($conn,"SELECT DATABASE()"))[0];
$mysqlVersion=mysqli_get_server_info($conn);
$tableResult = mysqli_query($conn,"SHOW TABLE STATUS");
$totalTables=0;
$totalRows=0;
$totalSize=0;
$largestTable="";
$largestSize=0;
$defaultEngine="";
$defaultCollation="";
$autoIncrementCount=0;
$tables=[];
while($table=mysqli_fetch_assoc($tableResult)){
    $totalTables++;
    $rows=(int)$table['Rows'];
    $size=(int)$table['Data_length']+(int)$table['Index_length'];
    $totalRows+=$rows;
    $totalSize+=$size;
    if($size>$largestSize){
        $largestSize=$size;
        $largestTable=$table['Name'];
    }
    if(empty($defaultEngine)){
        $defaultEngine=$table['Engine'];
    }
    if(empty($defaultCollation)){
        $defaultCollation=$table['Collation'];
    }
    if(!empty($table['Auto_increment'])){
        $autoIncrementCount++;
    }
    $tables[]=[
        'name'=>$table['Name'],
        'rows'=>$rows,
        'size'=>$size,
        'engine'=>$table['Engine'],
        'collation'=>$table['Collation']
    ];
}
$totalSizeMB=round($totalSize/1024/1024,2);
$healthScore=100;
if($totalTables==0){
    $healthScore-=30;
}
if($totalSizeMB>1024){
    $healthScore-=10;
}
$status="Healthy";
$statusColor="#198754";
if($healthScore<90){
    $status="Warning";
    $statusColor="#fd7e14";
}
if($healthScore<70){
    $status="Critical";
    $statusColor="#dc3545";
}
include '../../includes/header.php';
include '../../includes/sidebar.php';
?>
<link rel="stylesheet" href="../assets/style.css">
<div class="profile-page">
    <div class="profile-header">
        <div>
            <h1><i class="fa-solid fa-database"></i>Database Health</h1>
            <p>Monitor database status, storage and statistics.</p>
        </div>
        <a href="../index.php" class="btn btn-dark"><i class="fa-solid fa-arrow-left"></i>Back</a>
    </div>

    <div class="profile-grid">
        <div class="profile-card">
            <div class="profile-card-header">
                <h3><i class="fa-solid fa-chart-simple"></i>Database Statistics</h3>
            </div>
            <div class="profile-body">
                <div class="profile-item d-flex">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-database" style="margin-right: 10px;"></i>Database Name:</span>
                    </div>
                    <div class="profile-value"><?= htmlspecialchars($dbName); ?></div>
                </div>
                <div class="profile-item d-flex">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-gears" style="margin-right: 10px;"></i>Storage Engine:</span>
                    </div>
                    <div class="profile-value"><?= htmlspecialchars($defaultEngine); ?></div>
                </div>
                <div class="profile-item d-flex">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-language" style="margin-right: 10px;"></i>Database Collection:</span>
                    </div>
                    <div class="profile-value"><?= htmlspecialchars($defaultCollation); ?></div>
                </div>
                <div class="profile-item d-flex">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-server" style="margin-right: 10px;"></i>MySQL Version:</span>
                    </div>
                    <div class="profile-value"><?= htmlspecialchars($mysqlVersion); ?></div>
                </div>
                <div class="profile-item d-flex">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-hard-drive" style="margin-right: 10px;"></i>Database Size:</span>
                    </div>
                    <div class="profile-value"><?= number_format($totalSizeMB,2); ?> MB</div>
                </div>
            </div>
        </div>
        <div class="profile-card">
            <div class="profile-card-header">
                <h3><i class="fa-solid fa-heart-pulse"></i>Health Summary</h3>
            </div>
            <div class="profile-body">
                <div class="profile-item d-flex">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-circle-check" style="margin-right: 10px;"></i>Connection Status:</span>
                    </div>
                    <div class="profile-value"><span class="status-badge">Connected</span></div>
                </div>
                <div class="profile-item d-flex">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-heart" style="margin-right: 10px;"></i>Health Score:</span>
                    </div>
                    <div class="profile-value">
                        <span class="status-badge" style="background:<?= $statusColor ?>20;color:<?= $statusColor ?>;"><?= $healthScore ?>%</span>
                    </div>
                </div>
                <div class="profile-item d-flex">
                    <div class="profile-label align-items-center">
                        <span style="font-size:18px;margin-right: 10px;"><i class="fa-solid fa-shield-halved" style="margin-right: 10px;"></i>Overall Status:</span>
                    </div>
                    <div class="profile-value">
                        <span class="status-badge" style="background:<?= $statusColor ?>20;color:<?= $statusColor ?>;"><?= $status ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-card">
            <div class="profile-card-header">
                <h3><i class="fa-solid fa-table-list"></i>Table Statistics</h3>
            </div>
            <div class="profile-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Table</th>
                                <th class="text-end">Rows</th>
                                <th class="text-end">Size</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($tables as $table){ ?>
                            <tr>
                                <td><?= htmlspecialchars($table['name']); ?></td>
                                <td class="text-end"><?= number_format($table['rows']); ?></td>
                                <td class="text-end"><?= number_format($table['size']/1024/1024,2); ?> MB</td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../../includes/footer.php'; ?>