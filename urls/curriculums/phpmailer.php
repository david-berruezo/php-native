<?php use PHPMailer\PHPMailer\PHPMailer; ?>
<?php use PHPMailer\PHPMailer\Exception; ?>
<?php
//Load Composer's autoloader
require 'vendor/autoload.php';
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    // Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    //$mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.davidberruezo.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'davidberruezo@davidberruezo.com';                 // SMTP username
    $mail->Password = 'Berruezin23';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 25;                                    // TCP port to connect to
    // Recipients
    $mail->setFrom('davidberruezo@davidberruezo.com', 'David Berruezo');
    $mail->addAddress('davidberruezo@davidberruezo.com', 'David Berruezo');     // Add a recipient
    //$mail->addAddress('davidberruezo@ecommercebarcelona360.com');               // Name is optional
    //$mail->addReplyTo('davidberruezo@ecommercebarcelona360.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');
    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Buscando trabajo en Barcelona';
    //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->Body = file_get_contents('curriculum/index_es.html');
    $mail->AltBody = 'Buscando trabajo en | Barcelona';
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
?>
