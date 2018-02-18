<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                                                    // Passing `true` enables exceptions
$fields = array('name' => 'Name', 'email' => 'Email', 'message' => 'Message');  // array variable name => Text to appear in email

$emailText = "<h1>You have new message from contact form</h1><h1>=====================</h1>";

foreach ($_POST as $key => $value) {

    if (isset($fields[$key])) {
        $emailText .= "<h3 style='text-transform: capitalize; margin-bottom: 0'>$fields[$key]:</h3><div>$value</div>";
    }
}

try {
  //Server settings
  $mail->SMTPDebug = 2;                                 // Enable verbose debug output
  $mail->isSMTP();                                      // Set mailer to use SMTP
  $mail->Host = 'mail.nelsonoi.com';                    // Specify main and backup SMTP servers
  $mail->SMTPAuth = true;                               // Enable SMTP authentication
  $mail->Username = 'nelson@nelsonoi.com';              // SMTP username
  $mail->Password = 'EMAILphp';                         // SMTP password
  $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
  $mail->Port = 25;                                     // TCP port to connect to

  // https://stackoverflow.com/questions/3477766/phpmailer-smtp-error-could-not-connect-to-smtp-host
  $mail->SMTPOptions = array(
    'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
    )
  );

  //Recipients
  $mail->setFrom('nelson@nelsonoi.com', $_POST['name']);
  $mail->addAddress('ncoidev@gmail.com');                // Add a recipient

  //Content
  $mail->Subject = 'New email from nelsonoi.com';
  $mail->isHTML(true);                                   // Set email format to HTML    
  $mail->Body = $emailText;

  $mail->send();
  echo 'Message has been sent';
} catch (Exception $e) {
  echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}