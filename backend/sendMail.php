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
  /*
  // form data
  $from_email = isset($_POST['email']) ? $_POST['email'] : null;
  $subject = isset($_POST['subject']) ? $_POST['subject'] : null;
  $from_name = isset($_POST['name']) ? $_POST['name'] : null;
  $message = isset($_POST['message']) ? $_POST['message'] : null;
  */


  // json post
  $json = file_get_contents('php://input');
  $data = json_decode($json);

  $from_email = isset($data->email) ? $data->email : null;
  $subject = isset($data->subject) ? $data->subject : null;
  $from_name = isset($data->name) ? $data->name : null;
  $message = isset($data->message) ? $data->message : null;

  $response = new stdClass();
  $response->status = "success";

  try {
      //Server settings
       $mailService->IsSMTP(); // enable SMTP
      $mailService->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
      $mailService->SMTPAuth = true; // authentication enabled
      $mailService->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GmailService
      $mailService->Host = "mail.davdav.tech";
      $mailService->Port = 465; // or 587
      $mailService->Username = "hola@davdav.tech";
      $mailService->Password = "65JrLKv6g5mdHVU";
      
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