<?php

$config = require __DIR__ . "/../config.php";

// function enhanceWithOpenAI($imagePath, $prompt)
// {
//     global $config;

//     if (!file_exists($imagePath)) {

//         return [
//             "status" => false,
//             "message" => "Image not found."
//         ];

//     }

//     $curlFile = new CURLFile(
//         $imagePath,
//         mime_content_type($imagePath),
//         basename($imagePath)
//     );

//     $postFields = [

//         "model" => $config["model"],

//         "prompt" => $prompt,

//         "image" => $curlFile

//     ];

//     $ch = curl_init("https://api.openai.com/v1/images/edits");

//     curl_setopt_array($ch,[

//         CURLOPT_RETURNTRANSFER=>true,

//         CURLOPT_POST=>true,

//         CURLOPT_HTTPHEADER=>[

//             "Authorization: Bearer ".$config["openai_api_key"]

//         ],

//         CURLOPT_POSTFIELDS=>$postFields,

//         CURLOPT_TIMEOUT=>$config["timeout"]

//     ]);

//     $response = curl_exec($ch);

//     $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);

//     $error = curl_error($ch);

//     curl_close($ch);

//     if($error){

//         return [

//             "status"=>false,

//             "message"=>$error

//         ];

//     }

//     $json = json_decode($response,true);

//     if($httpCode!=200){

//         return [

//             "status"=>false,

//             "message"=>$json

//         ];

//     }

//     return [

//     "status" => false,

//     "message" => $json["error"]["message"] ?? "Unknown OpenAI error.",

//     "code" => $json["error"]["code"] ?? "",

//     "http_code" => $httpCode

// ];

// }


function enhanceWithGemini($imagePath,$prompt)
{

    global $config;

    if(!file_exists($imagePath)){

        return [

            "status"=>false,

            "message"=>"Image not found."

        ];

    }

    $mime = mime_content_type($imagePath);

    $image = base64_encode(

        file_get_contents($imagePath)

    );

    $payload = [

        "contents"=>[

            [

                "parts"=>[

                    [

                        "inlineData"=>[

                            "mimeType"=>$mime,

                            "data"=>$image

                        ]

                    ],

                    [

                        "text"=>$prompt

                    ]

                ]

            ]

        ]

    ];

    $url =

    "https://generativelanguage.googleapis.com/v1beta/models/".
    $config["model"].
    ":generateContent?key=".
    $config["gemini_api_key"];

    $ch = curl_init($url);

    curl_setopt_array(

        $ch,

        [

            CURLOPT_RETURNTRANSFER=>true,

            CURLOPT_POST=>true,

            CURLOPT_HTTPHEADER=>[

                "Content-Type: application/json"

            ],

            CURLOPT_POSTFIELDS=>json_encode($payload),

            CURLOPT_TIMEOUT=>$config["timeout"]

        ]

    );

    $response = curl_exec($ch);

    $http = curl_getinfo(

        $ch,

        CURLINFO_HTTP_CODE

    );

    $error = curl_error($ch);

    curl_close($ch);

    if($error){

        return [

            "status"=>false,

            "message"=>$error

        ];

    }

    $json = json_decode(

        $response,

        true

    );

    if($http!=200){

        return [

            "status"=>false,

            "message"=>$json,

            "http"=>$http

        ];

    }

    return [

        "status"=>true,

        "data"=>$json

    ];

}