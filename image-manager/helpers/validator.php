<?php

$config = require __DIR__ . "/../config.php";

/* ==========================================================
   VALIDATE IMAGE
========================================================== */

function validateImage($file)
{
    global $config;

    if (!isset($file)) {

        return [
            "status" => false,
            "message" => "No file uploaded."
        ];

    }

    if ($file["error"] !== UPLOAD_ERR_OK) {

        return [
            "status" => false,
            "message" => "Upload failed."
        ];

    }

    if ($file["size"] <= 0) {

        return [
            "status" => false,
            "message" => "Empty image."
        ];

    }

    if ($file["size"] > $config["max_file_size"]) {

        return [
            "status" => false,
            "message" => "Image exceeds maximum upload size."
        ];

    }

    $extension = strtolower(
        pathinfo(
            $file["name"],
            PATHINFO_EXTENSION
        )
    );

    if (
        !in_array(
            $extension,
            $config["allowed_extensions"]
        )
    ) {

        return [
            "status" => false,
            "message" => "Unsupported image extension."
        ];

    }

    $mime = mime_content_type(
        $file["tmp_name"]
    );

    if (
        !in_array(
            $mime,
            $config["allowed_mime_types"]
        )
    ) {

        return [
            "status" => false,
            "message" => "Unsupported image format."
        ];

    }

    $imageInfo = @getimagesize(
        $file["tmp_name"]
    );

    if ($imageInfo === false) {

        return [
            "status" => false,
            "message" => "Invalid image."
        ];

    }

    return [

        "status" => true,

        "message" => "Valid image.",

        "width" => $imageInfo[0],

        "height" => $imageInfo[1],

        "mime" => $mime,

        "extension" => $extension

    ];

}