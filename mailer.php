<?php
if($Result1){
    $mail = new PHPMailer(); // create a new object
    $mail->CharSet = 'utf-8';
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = "arianegroupamaras@gmail.com ";
    $mail->AddReplyTo("infos@ariane.ci","Alerte voyage - ariane");
    $mail->Password = "@ri@ne2015";
    $mail->SetFrom("infos@ariane.ci");
    $mail->Subject = "Démande en attente d'activation - Alerte Voyage";
    $mail->Body = "Le client $nom_prenoms_clt désire soumettre une demande d'alertes voyages.Sa requête est en attente de traitement !<br/>
                  ---------------<br/>
		Ceci est un mail automatique, Merci de ne pas y répondre.";

    if($totalSuperAdmin > 0 ){
        do{
            $mail->addAddress($row_rsOperations['email']);
        }while($row_rsOperations = mysql_fetch_assoc($rsOperations));
    }
    if(!$mail->Send())
    {
        ?>
        <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>La transmission de votre demande a échoué... Veuillez recommencer !</div>
    <?php
    }else{

        /************** SENDING SMS **********************/
        $sms = new API();
        $sms->SendSMS("0e2db6ba","9514f30f",$cel,$msg);
        /************** SENDING SMS END**********************/

    }
}