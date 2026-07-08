<?php

// return [

//     "openai_api_key" => "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",

//     "model" => "gpt-image-1",

//     "max_file_size" => 20 * 1024 * 1024,

//     "allowed_extensions" => [

//         "jpg",
//         "jpeg",
//         "png",
//         "webp"

//     ],

//     "allowed_mime_types" => [

//         "image/jpeg",
//         "image/png",
//         "image/webp"

//     ],

//     "output_quality" => 90,

//     "timeout" => 300,


//     "directories" => [

//         "temp" => __DIR__."/../uploads/temp/",

//         "enhanced" => __DIR__."/../uploads/enhanced/",

//         "logs" => __DIR__."/logs/"

//     ]

// ];


return [

    /*
    |--------------------------------------------------------------------------
    | AI Provider
    |--------------------------------------------------------------------------
    */

    "provider" => "gemini",

    /*
    |--------------------------------------------------------------------------
    | Google AI Studio
    |--------------------------------------------------------------------------
    */

    "gemini_api_key" => "AQ.Ab8RN6KDsuTRkl_dSFAfPi0XnIrrSPmlZVaj83oo59sRWB6BlA",

    "model" => "gemini-2.5-flash-image",

    /*
    |--------------------------------------------------------------------------
    | Upload Settings
    |--------------------------------------------------------------------------
    */

    "max_file_size" => 20 * 1024 * 1024,

    "allowed_extensions" => [

        "jpg",
        "jpeg",
        "png",
        "webp"

    ],

    "allowed_mime_types" => [

        "image/jpeg",
        "image/png",
        "image/webp"

    ],

    /*
    |--------------------------------------------------------------------------
    | Output
    |--------------------------------------------------------------------------
    */

    "output_quality" => 90,

    "timeout" => 300,

    /*
    |--------------------------------------------------------------------------
    | Directories
    |--------------------------------------------------------------------------
    */

    "directories" => [

        "temp" => __DIR__."/../uploads/temp/",

        "enhanced" => __DIR__."/../uploads/enhanced/",

        "logs" => __DIR__."/logs/"

    ]

];