<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';
// OR require your mail/*.php files if not using Composer

function getMailer(){

    $mail = new PHPMailer(true);

    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';

    $mail->SMTPAuth = true;

    $mail->Username = 'abc@gmail.com';

    $mail->Password = 'app password';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->Port = 587;

    $mail->setFrom(
        'abc@gmail.com',
        'QG ERP'
    );

    $mail->isHTML(true);

    return $mail;

}
