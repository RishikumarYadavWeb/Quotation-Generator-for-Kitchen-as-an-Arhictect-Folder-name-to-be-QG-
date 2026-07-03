<?php
session_start();

require_once '../db.php';

header('Content-Type: application/json');

$response = [
    'status' => false,
    'images' => [
        'render' => [],
        'floorplan' => [],
        'elevations' => []
    ]
];

$baseDir = "../uploads/temp/";

if(!is_dir($baseDir)){
    mkdir($baseDir,0777,true);
}

function uploadFiles($files,$folder){

    global $baseDir;

    $saved=[];

    $targetDir=$baseDir.$folder."/";

    if(!is_dir($targetDir)){
        mkdir($targetDir,0777,true);
    }

    foreach($files['tmp_name'] as $index=>$tmpName){

        if(empty($tmpName)) continue;

        $extension=strtolower(pathinfo($files['name'][$index],PATHINFO_EXTENSION));

        $filename=uniqid().".".$extension;

        move_uploaded_file(
            $tmpName,
            $targetDir.$filename
        );

        $imageInfo = getimagesize($targetDir.$filename);

$saved[] = [
    "original_name" => $files['name'][$index],
    "stored_name"   => $filename,
    "image_path"    => $folder."/".$filename,
    "file_size"     => filesize($targetDir.$filename),
    "mime_type"     => mime_content_type($targetDir.$filename),
    "image_width"   => $imageInfo[0] ?? 0,
    "image_height"  => $imageInfo[1] ?? 0
];

    }

    return $saved;

}

/* -------------------------------
   Render Images
-------------------------------- */

if(isset($_FILES['render_images'])){

    $response['images']['render']=uploadFiles(
        $_FILES['render_images'],
        "render"
    );

}

/* -------------------------------
   Floor Plan Images
-------------------------------- */

if(isset($_FILES['floorplan_images'])){

    $response['images']['floorplan']=uploadFiles(
        $_FILES['floorplan_images'],
        "floorplan"
    );

}

/* -------------------------------
   Elevation Images
-------------------------------- */

if(isset($_FILES['elevation_images'])){

    foreach($_FILES['elevation_images']['tmp_name'] as $elevationIndex=>$images){

        $saved=[];

        foreach($images as $imageIndex=>$tmpName){

            if(empty($tmpName)) continue;

            $extension=strtolower(
                pathinfo(
                    $_FILES['elevation_images']['name'][$elevationIndex][$imageIndex],
                    PATHINFO_EXTENSION
                )
            );

            $folder="elevation_".$elevationIndex;

            $targetDir=$baseDir.$folder."/";

            if(!is_dir($targetDir)){
                mkdir($targetDir,0777,true);
            }

            $filename=uniqid().".".$extension;

            move_uploaded_file(
                $tmpName,
                $targetDir.$filename
            );

            $imageInfo = getimagesize($targetDir.$filename);

$saved[] = [
    "original_name" => $_FILES['elevation_images']['name'][$elevationIndex][$imageIndex],
    "stored_name"   => $filename,
    "image_path"    => $folder."/".$filename,
    "file_size"     => filesize($targetDir.$filename),
    "mime_type"     => mime_content_type($targetDir.$filename),
    "image_width"   => $imageInfo[0] ?? 0,
    "image_height"  => $imageInfo[1] ?? 0
];

        }

        $response['images']['elevations'][$elevationIndex]=$saved;

    }

}

$response['status']=true;

echo json_encode($response);