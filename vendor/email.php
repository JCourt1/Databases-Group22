<?php
/*
Using the class PHPMailer and tutorial found at
https://github.com/PHPMailer/PHPMailer/wiki/Tutorial
*/
use \phpmailer\phpmailer\PHPMailer;
use \phpmailer\phpmailer\Exception;

//Load composer's autoloader
require '/autoload.php';
require '/phpmailer/phpmailer/src/Exception.php';
require '/phpmailer/phpmailer/src/PHPMailer.php';
require '/phpmailer/phpmailer/src/SMTP.php';
require '/league/oauth2-google/src/Provider/Google.php';
require '/league/oauth2-google/src/Provider/GoogleUser.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 1;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                        // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'uclteam22@gmail.com';                 // SMTP username
    $mail->Password = 'ILoveCS17';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;    //465 or 587                                // TCP port to connect to

    //Recipients
    $mail->setFrom('uclteam22@gmail.com', 'Ibe Auction Website');
    $mail->Subject = "Test";
    $mail->Body = "hello";
    $mail->AddAddress("ucabmjb@ucl.ac.uk");
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
