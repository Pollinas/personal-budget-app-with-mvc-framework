<?php

namespace App;

use App\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


/**
 * Mail
 *
 * PHP version 7.4
 */
class Mail
{

    /**
     * Send a message
     *
     * @param string $to Recipient
     * @param string $subject Subject
     * @param string $text Text-only content of the message
     * @param string $html HTML content of the message
     *
     * @return mixed
     */
    public static function send($to, $subject, $text, $html)
    {
        $mail = new PHPMailer(true);

        try {
    
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Username = Config::EMAIL_USERNAME;
            $mail->Password = Config::EMAIL_PASSWORD;
           

        
            $mail->addAddress($to);    
            $mail->isHTML(true);  
            $mail->Subject=$subject;
            $mail->AltBody=$text;
            $mail->Body=$html;

            $mail->send();
            // echo '<div class="alert alert-info alert-dismissible text-center" role="alert"> Wiadomość e-mail została wysłana.
            // <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
