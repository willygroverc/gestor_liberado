<?php
include ('mail.inc.php');
$mimemail = new nxs_mimemail(); 

$mimemail->set_from("master@yanapti.com", "Sistema");
$mimemail->set_to("wchambi@yanapti.com");
$mimemail->set_subject("Sistema de Mesa de Ayuda");
$mimemail->set_text("Ud. tiene una nueva orden de mesa de ayuda");
$mimemail->set_html("<HTML><HEAD></HEAD><BODY>La sig.<b>orden </b>se ha registrado<BR><BR>Por favor, verifique</BR>- HTML</BODY></HTML>");
if ($mimemail->send())
   echo "The MIME Mail has been sent";
else
   echo "An error has occurred, mail was not sent";
?>