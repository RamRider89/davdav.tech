<?php

  //Import PHPMailer classes into the global namespace
  //These must be at the top of your script, not inside a function
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  //Load Composer's autoloader
  require 'vendor/autoload.php';

  //Create an instance; passing `true` enables exceptions
  $mailService = new PHPMailer(true);

  $ajax = true;

  $to_email = 'hola@davdav.tech';
  $to_name = 'DavDav';
  $from_email = isset($_POST['email']) ? $_POST['email'] : null;
  $subject = isset($_POST['subject']) ? $_POST['subject'] : null;
  $from_name = isset($_POST['name']) ? $_POST['name'] : null;
  $message = isset($_POST['message']) ? $_POST['message'] : null;

  $response = new stdClass();
  $response->status = "success";

  try {
      //Server settings
      $mailService->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
      
      //Recipients
      $mailService->setFrom($from_email, $from_name);
      $mailService->addAddress($to_email, $to_name);     //Add a recipient

      //Content
      $mailService->isHTML(true);                                  //Set email format to HTML
      $mailService->Subject = $subject;
      $mailService->Body    = $message;

      $mailService->send();

      $response->ok = true;
      $response->message = "El correo electronico se envio correctamente.";

  } catch (Exception $e) {

      $response->ok = false;
      $response->message = "El correo electronico no se pudo enviar: {$e}";
  }
        
  echo json_encode($response);

?>