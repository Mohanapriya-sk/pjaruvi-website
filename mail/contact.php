<?php
require '../vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(500);
    exit();
}
echo $_POST["name"];

$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$m_subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));

$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->isSMTP();                                     
    $mail->Host = 'smtp.gmail.com';                    
    $mail->SMTPAuth = true;                              
    $mail->Username = 'pjaruvi@gmail.com';          
    $mail->Password = '';                   
    $mail->SMTPSecure = 'tls';                           
    $mail->Port = 587;                                   

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->setFrom($email, $name);
    $mail->addAddress('pjaruvi@gmail.com');     

    $mail->SMTPDebug = 2;     
    $mail->isHTML(false);                               
    $mail->Subject = "$m_subject:  $name";
    $mail->Body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email\n\nSubject: $m_subject\n\nMessage: $message";

    $mail->send();
} catch (Exception $e) {
    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    http_response_code(500);
}
?>
