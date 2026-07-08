<?php

$config = require __DIR__ . "/../config.php";

/* ==========================================================
   WRITE LOG
========================================================== */

function writeLog(
    $type,
    $message,
    $data = []
){

    global $config;

    $logDirectory = $config["directories"]["logs"];

    if(!is_dir($logDirectory)){
        mkdir($logDirectory,0775,true);
    }

    $logFile = $logDirectory .
               date("Y-m-d") .
               ".log";

    $log = [];

    $log[] = "======================================================";
    $log[] = "Time : ".date("Y-m-d H:i:s");
    $log[] = "Type : ".$type;
    $log[] = "Message : ".$message;

    if(!empty($data)){

        $log[] = "Data :";
        $log[] = print_r($data,true);

    }

    $log[] = "";
    $log[] = "";

    file_put_contents(

        $logFile,

        implode(PHP_EOL,$log),

        FILE_APPEND

    );

}