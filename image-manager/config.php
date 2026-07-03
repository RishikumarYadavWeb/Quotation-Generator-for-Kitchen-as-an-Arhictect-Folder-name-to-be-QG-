<?php

/**
 * -------------------------------------------------------
 * IMAGE MANAGER CONFIGURATION
 * -------------------------------------------------------
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Upload Settings
    |--------------------------------------------------------------------------
    */

    'upload' => [

        // Maximum upload size (MB)
        'max_size' => 30,

        // Allowed extensions
        'extensions' => [
            'jpg',
            'jpeg',
            'png',
            'webp'
        ],

        // Allowed MIME Types
        'mime_types' => [
            'image/jpeg',
            'image/png',
            'image/webp'
        ],

        // Maximum Width
        'max_width' => 10000,

        // Maximum Height
        'max_height' => 10000,

        // Temporary Upload Folder
        'temp_path' => __DIR__ . '/../uploads/temp/',

        // Permanent Upload Folder
        'quotation_path' => __DIR__ . '/../uploads/quotations/',
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Types
    |--------------------------------------------------------------------------
    */

    'types' => [

        'render',

        'floorplan',

        'elevation'

    ],

    /*
    |--------------------------------------------------------------------------
    | AI Enhancement
    |--------------------------------------------------------------------------
    */

    'ai' => [

        'enabled' => true,

        'provider' => 'openai',

        'output_format' => 'png',

        'quality' => 100,

    ],

    /*
    |--------------------------------------------------------------------------
    | Cleanup
    |--------------------------------------------------------------------------
    */

    'cleanup' => [

        // Delete temp files older than
        // minutes
        'temp_expiry' => 120,

    ],

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    */

    'logging' => [

        'enabled' => true,

        'path' => __DIR__ . '/logs/',

    ]

];