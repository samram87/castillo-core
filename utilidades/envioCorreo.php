<?php
        require_once("../lib/phpmailer/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "10.10.1.27";
        $mail->CharSet = "UTF-8";
        $mail->From = $_GET['from'];
        $mail->FromName = $_GET['nombreFrom'];
        $mail->IsHTML(true);
        $mail->Subject =$_GET['asunto'];
        $mail->AltBody = $_GET['mensaje'];
        $mail->Body = $_GET['mensaje'];
        $destinatario=$_GET['destinatario'];
        $mail->AddAddress($destinatario,$destinatario);
        if(!$mail->Send()) {
            return false;
        } else {
            return true;
        }
?>
