<?php

$config = require __DIR__."/config.php";

$url = "https://generativelanguage.googleapis.com/v1beta/models?key=".$config["gemini_api_key"];

$ch = curl_init($url);

curl_setopt_array($ch,[

    CURLOPT_RETURNTRANSFER=>true

]);

$response = curl_exec($ch);

curl_close($ch);

echo "<pre>";

print_r(json_decode($response,true));