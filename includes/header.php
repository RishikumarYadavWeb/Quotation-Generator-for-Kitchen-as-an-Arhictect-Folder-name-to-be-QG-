<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    include_once __DIR__ . '/../roles/permission.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quotation Generator</title>
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="/QG/assets/css/style.css">
        <link rel="stylesheet" href="/QG/assets/css/responsive.css">
        <link rel="icon" href="/QG/favicon/favicon.ico">
        <link rel="icon" type="image/svg+xml" href="/QG/favicon/favicon.svg">
        <link rel="icon" type="image/png" sizes="96x96" href="/QG/favicon/favicon-96x96.png">
        <link rel="apple-touch-icon" href="/QG/favicon/apple-touch-icon.png">
        <link rel="manifest" href="/QG/favicon/site.webmanifest">
    </head>
    <body>