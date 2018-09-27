<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    //Load composer's autoloader
    require 'vendor/autoload.php';

    function post_captcha($user_response) {
        $fields_string = '';
        $fields = array(
            'secret' => '6LeQXUcUAAAAABTR2PtomNuYtzEpyKohoq52gJAA',
            'response' => $user_response
        );
        foreach($fields as $key=>$value)
        $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    // Call the function post_captcha
    $res = post_captcha($_POST['g-recaptcha-response']);

    if (!$res['success']) {
      $responseArray = array('type' => 'warning', 'message' => 'Please make sure you check the security CAPTCHA box.', 'icon' => 'fa-exclamation-triangle');
      $encoded = json_encode($responseArray);
      header('Content-Type: application/json');
      echo $encoded;
    } else {
        // Import PHPMailer classes into the global namespace
        // These must be at the top of your script, not inside a function
        // use PHPMailer\PHPMailer\PHPMailer;
        // use PHPMailer\PHPMailer\Exception;

        // //Load composer's autoloader
        // require 'vendor/autoload.php';

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
          $mail->SMTPDebug = 0;                                 // Enable verbose debug output
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
          $responseArray = array('type' => 'success', 'message' => 'Your message has been sent successfully', 'icon' => 'fa-check');
          $encoded = json_encode($responseArray);
          header('Content-Type: application/json');
          echo $encoded;
        } catch (Exception $e) {
          $responseArray = array('type' => 'danger', 'message' => 'Message could not be sent. Please refresh page and try again', 'icon' => 'fa-exclamation-circle');
          $encoded = json_encode($responseArray);
          header('Content-Type: application/json');
          echo $encoded;
        }
    }
?>


<?php
// // Import PHPMailer classes into the global namespace
// // These must be at the top of your script, not inside a function
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// //Load composer's autoloader
// require 'vendor/autoload.php';

// $mail = new PHPMailer(true);                                                    // Passing `true` enables exceptions
// $fields = array('name' => 'Name', 'email' => 'Email', 'message' => 'Message');  // array variable name => Text to appear in email

// $emailText = "<h1>You have new message from contact form</h1><h1>=====================</h1>";

// foreach ($_POST as $key => $value) {

//     if (isset($fields[$key])) {
//         $emailText .= "<h3 style='text-transform: capitalize; margin-bottom: 0'>$fields[$key]:</h3><div>$value</div>";
//     }
// }

// try {
//   //Server settings
//   $mail->SMTPDebug = 2;                                 // Enable verbose debug output
//   $mail->isSMTP();                                      // Set mailer to use SMTP
//   $mail->Host = 'mail.nelsonoi.com';                    // Specify main and backup SMTP servers
//   $mail->SMTPAuth = true;                               // Enable SMTP authentication
//   $mail->Username = 'nelson@nelsonoi.com';              // SMTP username
//   $mail->Password = 'EMAILphp';                         // SMTP password
//   $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
//   $mail->Port = 25;                                     // TCP port to connect to

//   // https://stackoverflow.com/questions/3477766/phpmailer-smtp-error-could-not-connect-to-smtp-host
//   $mail->SMTPOptions = array(
//     'ssl' => array(
//       'verify_peer' => false,
//       'verify_peer_name' => false,
//       'allow_self_signed' => true
//     )
//   );

//   //Recipients
//   $mail->setFrom('nelson@nelsonoi.com', $_POST['name']);
//   $mail->addAddress('ncoidev@gmail.com');                // Add a recipient

//   //Content
//   $mail->Subject = 'New email from nelsonoi.com';
//   $mail->isHTML(true);                                   // Set email format to HTML
//   $mail->Body = $emailText;

//   $mail->send();
//   echo 'Message has been sent';
// } catch (Exception $e) {
//   echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
// }
