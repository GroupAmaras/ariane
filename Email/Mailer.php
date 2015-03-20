<?php
/**
 * Created by PhpStorm.
 * User: ArseneLeQuebecois
 * Date: 16/03/2015
 * Time: 21:26
 */
require("Class/PHPMailerAutoload.php");
class Mailer {

     public function send($subjet,$msg,$email){
         /**********************SENDING EMAIL TO CLT**********/
         $mail2 = new PHPMailer(); // create a new object
         $mail2->CharSet = 'utf-8';
         $mail2->IsSMTP(); // enable SMTP
         $mail2->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
         $mail2->SMTPAuth = true; // authentication enabled
         $mail2->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
         $mail2->Host = "smtp.gmail.com";
         $mail2->Port = 587; // or 587
         $mail2->IsHTML(true);
         $mail2->Username = "travelstarariane@gmail.com";
         $mail2->AddReplyTo("infos@ariane.ci","ESN - ARIANE");
         $mail2->Password = "ariane2015";
         $mail2->SetFrom("infos@ariane.ci","ESN - ARIANE");
         $mail2->Subject = $subjet;
         $mail2->Body = " $msg <br/>
                  ---------------<br/>
		 Ceci est un mail automatique, Merci de ne pas y répondre.";
         $mail2->addAddress($email);
         $mail2->send();
         /*********END SENDING EMAIL TO CLT*********/
     }
} 