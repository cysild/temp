
<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';



file_put_contents('./log_'.date("j.n.Y").'.log', $_POST, FILE_APPEND);

if($_POST['send'] == true){
$data['from'] =    $_POST['from'];
$data['name'] = $_POST['name'];
$data['to'] = $_POST['to'];
$data['subject'] = $_POST['subject'];
$data['message'] = $_POST['message'];
Sendmail($data);
}


function Sendmail($data){



// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtpout.europe.secureserver.net';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'auth@recruiting-hub.com';                     // SMTP username
    $mail->Password   = 'recruitinghub';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 80;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom($data['from'],$data['name']);
    $mail->addAddress($data['to']);     // Add a recipient
  //  $mail->addAddress('ellen@example.com');               // Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
   // $mail->addCC('cc@example.com');
  //  $mail->addBCC('bcc@example.com');

    // Attachments
  //  $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
  //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $data['subject'];
    $mail->Body    = $data['message'];
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}


?>