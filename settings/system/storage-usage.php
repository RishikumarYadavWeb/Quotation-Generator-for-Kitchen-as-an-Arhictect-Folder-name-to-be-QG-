<?php

include '../../includes/auth.php';
include '../../db.php';

if(!can('settings_view')){
    die("Access Denied");
}

$pageTitle="Storage Usage";

function folderSize($dir){

    $size=0;

    if(!is_dir($dir)){
        return 0;
    }

    foreach(
        new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $dir,
                FilesystemIterator::SKIP_DOTS
            )
        ) as $file
    ){

        $size+=$file->getSize();

    }

    return $size;

}

function formatBytes($bytes){

    $units=['B','KB','MB','GB','TB'];

    $i=0;

    while($bytes>=1024 && $i<count($units)-1){

        $bytes/=1024;
        $i++;

    }

    return round($bytes,2)." ".$units[$i];

}

$uploadPath=dirname(__DIR__,2)."/uploads";

$folders=[

    "Quotations"=>$uploadPath."/quotations",

    "Temp"=>$uploadPath."/temp",
    

];

$totalSize=0;

$data=[];

foreach($folders as $name=>$path){

    $size=folderSize($path);

    $totalSize+=$size;

    $data[]=[
        "name"=>$name,
        "path"=>$path,
        "size"=>$size
    ];

}

$diskTotal=disk_total_space(dirname(__DIR__,2));

$diskFree=disk_free_space(dirname(__DIR__,2));

$diskUsed=$diskTotal-$diskFree;

include '../../includes/header.php';
include '../../includes/sidebar.php';

?>

<link rel="stylesheet" href="../assets/style.css">

<div class="profile-page">

<div class="profile-header">

<div>

<h1>

<i class="fa-solid fa-hard-drive"></i>

Storage Usage

</h1>

<p>

Monitor application storage usage and disk utilization.

</p>

</div>

<a
    href="../index.php"
    class="btn btn-dark"
>

<i class="fa-solid fa-arrow-left"></i>

Back

</a>

</div>

<div class="profile-grid">
    <div class="profile-card">

    <div class="profile-card-header">

        <h3>

            <i class="fa-solid fa-hard-drive"></i>

            Disk Summary

        </h3>

    </div>

    <div class="profile-body">

        <div class="profile-item">

            <div class="profile-label">

                <i class="fa-solid fa-database"></i>

                Total Application Storage

            </div>

            <div class="profile-value">

                <?= formatBytes($totalSize); ?>

            </div>

        </div>

        <div class="profile-item">

            <div class="profile-label">

                <i class="fa-solid fa-server"></i>

                Total Disk Space

            </div>

            <div class="profile-value">

                <?= formatBytes($diskTotal); ?>

            </div>

        </div>

        <div class="profile-item">

            <div class="profile-label">

                <i class="fa-solid fa-hdd"></i>

                Used Disk Space

            </div>

            <div class="profile-value">

                <?= formatBytes($diskUsed); ?>

            </div>

        </div>

        <div class="profile-item">

            <div class="profile-label">

                <i class="fa-solid fa-circle-check"></i>

                Free Disk Space

            </div>

            <div class="profile-value">

                <?= formatBytes($diskFree); ?>

            </div>

        </div>

    </div>

</div>

<div class="profile-card">

    <div class="profile-card-header">

        <h3>

            <i class="fa-solid fa-folder-tree"></i>

            Folder Usage

        </h3>

    </div>

    <div class="profile-body">

        <?php foreach($data as $folder){ ?>

        <?php

            $percentage = $totalSize > 0
                ? ($folder['size'] / $totalSize) * 100
                : 0;

        ?>

        <div class="storage-item">

            <div class="storage-header">

                <span>

                    <?= $folder['name']; ?>

                </span>

                <strong>

                    <?= formatBytes($folder['size']); ?>

                </strong>

            </div>

            <div class="storage-bar">

                <div
                    class="storage-fill"
                    style="width:<?= round($percentage,2); ?>%;"
                ></div>

            </div>

            <small>

                <?= htmlspecialchars($folder['path']); ?>

            </small>

        </div>

        <?php } ?>

    </div>

</div>
</div>


<?php include '../../includes/footer.php'; ?>