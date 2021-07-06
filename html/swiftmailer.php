<?php
require_once '../vendor/autoload.php';

try {

// Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
        ->setUsername('lora.brituck@gmail.com')
        ->setPassword('password')
    ;

// Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

// Create a message
    $message = (new Swift_Message('Тема письма'))
        ->setFrom(['lora.brituck@gmail.com' => 'lora.brituck@gmail.com'])
        ->setTo(['evgenii17pershin@gmail.com'])
        ->setBody('Текст письма')
    ;

// Send the message
    $result = $mailer->send($message);
    var_dump(['res' => $result]);
} catch (Exception $e) {
    var_dump($e->getMessage());
    echo '<pre>' . print_r($e->getTrace(), 1);
}