<?php
namespace Recursos;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
class Mail
{
    public $mail;
    function __construct($correo, $pass, $nombre) { 
        $this->mail = new PHPMailer;
        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 2;
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->Port = 587;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $correo;
        $this->mail->Password = $pass;
        $this->mail->setFrom($correo, $nombre);
        $this->mail->CharSet = 'UTF-8';
    }
    public function enviarCorreo($mail) { 
        $this->mail->Subject = $mail["title"];
        $this->mail->isHTML(true);
        $this->mail->Body = $mail["body"];
        $this->mail->addAddress($mail["para"]);

        if ($mail["cco"]) {
            foreach ($mail["cco"] as $k) {
                $this->mail->addBCC($k);
            }
        }

        if (!$this->mail->send()) {
            echo "Mailer Error: " . $this->mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }
}