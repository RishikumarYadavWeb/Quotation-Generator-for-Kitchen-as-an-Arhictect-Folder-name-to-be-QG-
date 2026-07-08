<?php

$config = require __DIR__ . "/../config.php";
// function createDirectory($directory)
// {
//     if (!is_dir($directory)) {
//         mkdir($directory, 0775, true);
//     }
// }

// function saveEnhancedImage($base64Image, $originalFilename)
// {
//     global $config;

//     $directory = $config["directories"]["enhanced"];

//     createDirectory($directory);

//     $extension = strtolower(
//         pathinfo($originalFilename, PATHINFO_EXTENSION)
//     );

//     if ($extension == "") {
//         $extension = "png";
//     }

//     $filename = uniqid("enhanced_") . "." . $extension;

//     $filepath = $directory . $filename;

//     file_put_contents(
//         $filepath,
//         base64_decode($base64Image)
//     );

//     return [

//         "status" => true,

//         "filename" => $filename,

//         "filepath" => $filepath,

//         "relative_path" => "uploads/enhanced/" . $filename

//     ];
// }

// function deleteEnhancedImage($path)
// {
//     if (
//         !empty($path) &&
//         file_exists($path)
//     ) {
//         unlink($path);
//     }
// }


/* ==========================================================
   CREATE DIRECTORY
========================================================== */

function createDirectory($directory){

    if(!is_dir($directory)){

        mkdir($directory,0775,true);

    }

}

/* ==========================================================
   SAVE GEMINI IMAGE
========================================================== */

function saveGeminiImage($geminiResponse,$originalFilename)
{

    global $config;

    if(

        empty(
            $geminiResponse["candidates"][0]["content"]["parts"]
        )

    ){

        return [

            "status"=>false,

            "message"=>"No image returned by Gemini."

        ];

    }

    $base64=null;

    $mime="image/png";

    foreach(

        $geminiResponse["candidates"][0]["content"]["parts"]

        as

        $part

    ){

        if(

            isset($part["inlineData"])

        ){

            $base64=

            $part["inlineData"]["data"];

            $mime=

            $part["inlineData"]["mimeType"] ?? "image/png";

            break;

        }

    }

    if(!$base64){

        return [

            "status"=>false,

            "message"=>"Gemini returned text only."

        ];

    }

    $directory=

    $config["directories"]["enhanced"];

    createDirectory($directory);

    $extension="png";

    switch($mime){

        case "image/jpeg":

            $extension="jpg";

            break;

        case "image/webp":

            $extension="webp";

            break;

    }

    $filename=

    uniqid("enhanced_")

    .".".

    $extension;

    $filepath=

    $directory.

    $filename;

    file_put_contents(

        $filepath,

        base64_decode($base64)

    );

    return [

        "status"=>true,

        "filename"=>$filename,

        "filepath"=>$filepath,

        "relative_path"=>"uploads/enhanced/".$filename

    ];

}