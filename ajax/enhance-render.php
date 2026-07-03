<?php

header('Content-Type: application/json');

$response = [
    "status" => false,
    "message" => "",
    "image" => ""
];

if(!isset($_FILES['image'])){
    $response["message"] = "No image uploaded.";
    echo json_encode($response);
    exit;
}

$tempFile = $_FILES['image']['tmp_name'];

$uploadDir = dirname(__DIR__) . "/uploads/enhanced/";

if(!is_dir($uploadDir)){
    mkdir($uploadDir,0777,true);
}

$extension = strtolower(pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION));

$fileName = uniqid("enhanced_") . ".png";

$outputFile = $uploadDir . $fileName;

/*
|--------------------------------------------------------------------------
| TEMPORARY TESTING
|--------------------------------------------------------------------------
|
| For now we simply copy the image.
| Later this section will call OpenAI.
|
*/

copy($tempFile,$outputFile);

$response["status"] = true;
$response["image"] = "uploads/enhanced/".$fileName;

echo json_encode($response);