<?php

$tempRoot = dirname(__DIR__) . "/uploads/temp";

$expiry = time() - (60 * 60); // Delete folders older than 1 hour

function deleteDirectory($dir){

    if(!is_dir($dir)){
        return;
    }

    foreach(array_diff(scandir($dir), ['.','..']) as $item){

        $path = $dir . "/" . $item;

        if(is_dir($path)){
            deleteDirectory($path);
        }else{
            @unlink($path);
        }

    }

    @rmdir($dir);

}

if(is_dir($tempRoot)){

    foreach(glob($tempRoot . "/*") as $folder){

        if(is_dir($folder) && filemtime($folder) < $expiry){

            deleteDirectory($folder);

        }

    }

}

echo "Temp cleanup completed.";