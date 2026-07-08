<?php

header("Content-Type: application/json");

require_once __DIR__."/../helpers/validator.php";
require_once __DIR__."/../helpers/prompt.php";
require_once __DIR__."/../helpers/OpenAI.php";
require_once __DIR__."/../helpers/storage.php";
require_once __DIR__."/../helpers/logger.php";

/* ==========================================================
   IMAGE EXISTS
========================================================== */

if(!isset($_FILES["image"])){

    echo json_encode([

        "status"=>false,

        "message"=>"No image uploaded."

    ]);

    exit;

}

$image = $_FILES["image"];

/* ==========================================================
   VALIDATE IMAGE
========================================================== */

$validation = validateImage($image);

if(!$validation["status"]){

    writeLog(

        "VALIDATION",

        $validation["message"]

    );

    echo json_encode($validation);

    exit;

}

/* ==========================================================
   PROMPT
========================================================== */

$prompt = getRenderEnhancementPrompt();

/* ==========================================================
   GEMINI
========================================================== */

$result = enhanceWithGemini(

    $image["tmp_name"],

    $prompt

);

if(!$result["status"]){

    writeLog(

        "GEMINI",

        "Image enhancement failed.",

        $result

    );

    echo json_encode($result);

    exit;

}

/* ==========================================================
   SAVE IMAGE
========================================================== */

$saved = saveGeminiImage(

    $result["data"],

    $image["name"]

);

if(!$saved["status"]){

    writeLog(

        "STORAGE",

        $saved["message"]

    );

    echo json_encode($saved);

    exit;

}

/* ==========================================================
   SUCCESS
========================================================== */

writeLog(

    "SUCCESS",

    "Image enhanced successfully.",

    [

        "original"=>$image["name"],

        "enhanced"=>$saved["relative_path"]

    ]

);

echo json_encode([

    "status"=>true,

    "message"=>"Image enhanced successfully.",

    "image"=>$saved["relative_path"]

]);