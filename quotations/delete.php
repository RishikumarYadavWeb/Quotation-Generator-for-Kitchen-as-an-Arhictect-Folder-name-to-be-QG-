<?php
include '../includes/auth.php';
include '../db.php';
if(!can('quotation_delete')){
    die('Access Denied');
}
/** @var mysqli $conn */
$id = (int)($_GET['id'] ?? 0);
if(!$id){die('Invalid Quotation ID');}
$quotationQuery = mysqli_query(
    $conn,
    "
    SELECT client_id , proforma_no
    FROM quotations
    WHERE id = '$id'
    LIMIT 1
    "
);
$quotation = mysqli_fetch_assoc($quotationQuery);
if(!$quotation){die('Quotation not found');}
$clientId = $quotation['client_id'] ?? 0;
$proformaNo = preg_replace(
    '/[^A-Za-z0-9_-]/',
    '_',
    $quotation['proforma_no'] ?? ''
);
$imageQuery = mysqli_query(
    $conn,
    "
    SELECT eli.image_path
    FROM elevation_line_images eli
    INNER JOIN elevations e
        ON eli.elevation_id = e.id
    WHERE e.quotation_id = '$id'
    "
);
while($image = mysqli_fetch_assoc($imageQuery)){
    if(!empty($image['image_path'])){
        $filePath = "../uploads/line-images/" . $image['image_path'];
        if(file_exists($filePath)){
            unlink($filePath);
        }
    }
}
/* ==========================================================
   DELETE PROJECT IMAGES
========================================================== */

$projectImageQuery = mysqli_query(
    $conn,
    "
    SELECT image_path
    FROM quotation_images
    WHERE quotation_id = '$id'
    "
);

while($image = mysqli_fetch_assoc($projectImageQuery)){

    if(empty($image['image_path'])){
        continue;
    }

    $filePath = "../uploads/" . $image['image_path'];

    if(file_exists($filePath)){
        unlink($filePath);
    }

}
mysqli_query(
    $conn,
    "
    DELETE eli
    FROM elevation_line_images eli
    INNER JOIN elevations e
        ON eli.elevation_id = e.id
    WHERE e.quotation_id = '$id'
    "
);
mysqli_query(
    $conn,
    "
    DELETE FROM quotation_images
    WHERE quotation_id = '$id'
    "
);
mysqli_query(
    $conn,
    "
    DELETE FROM drawers_data
    WHERE quotation_id = '$id'
    "
);
mysqli_query(
    $conn,
    "
    DELETE FROM shelves_data
    WHERE quotation_id = '$id'
    "
);
mysqli_query(
    $conn,
    "
    DELETE FROM quotation_accessories
    WHERE quotation_id = '$id'
    "
);
mysqli_query(
    $conn,
    "
    DELETE u
    FROM units u
    INNER JOIN elevations e
        ON u.elevation_id = e.id
    WHERE e.quotation_id = '$id'
    "
);
mysqli_query(
    $conn,
    "
    DELETE FROM elevations
    WHERE quotation_id = '$id'
    "
);
mysqli_query(
    $conn,
    "
    DELETE FROM quotations
    WHERE id = '$id'
    "
);
if($clientId){
    $checkClient = mysqli_query(
        $conn,
        "
        SELECT COUNT(*) AS total
        FROM quotations
        WHERE client_id = '$clientId'
        "
    );
    $clientData = mysqli_fetch_assoc($checkClient);
    if(($clientData['total'] ?? 0) == 0){
        mysqli_query(
            $conn,
            "
            DELETE FROM clients
            WHERE id = '$clientId'
            "
        );
    }
}
/* ==========================================================
   DELETE EMPTY QUOTATION FOLDER
========================================================== */

function deleteFolder($folder){

    if(!is_dir($folder)){
        return;
    }

    $items = array_diff(scandir($folder), ['.','..']);

    foreach($items as $item){

        $path = $folder . "/" . $item;

        if(is_dir($path)){
            deleteFolder($path);
        }else{
            unlink($path);
        }

    }

    rmdir($folder);

}

if($proformaNo){

    deleteFolder(
        "../uploads/quotations/".$proformaNo
    );

}

header('Location: manage.php');
exit;