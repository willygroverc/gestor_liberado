<?php
echo "Programa en Ejecucion ...";
//$link = mysql_connect("localhost","ds", "nobosticam04");
//mysql_select_db("nobosti_usuario", $link);
//$tunombre = "Webmaster Nobosti";
//$tuemail = "webmaster@nobosti.com";
//$nombre_amigo = "Amigo XXX";
//$email_amigo = "avicente@nobosti.com";

$prioridad = "3";

$valor_submit = "Enviar Correos";

$asunto = "Nuevo Boletin de Seguridad y Tecnologia de la Informacion en Bolivia ";

$gracias= "Gracias, tus Email's ya se han enviado!!!";
$mensaje2 = "
Tenemos el gusto de anunciarle el lanzamiento de un Boletin Informativo de publicacion periodica, especializado en temas puntuales de Tecnologias de la Informacion - TI, denominado NOBOSTI cuyo significado es, Novedades Bolivianas de Seguridad y TI.

Por lo que le invitamos a visitar nuestro sitio y suscribirse gratuitamente, en: ";

 

$mensaje = "Estimad@:
".$mensaje2."

				

http://www.nobosti.com


NOTA.- De acuerdo a las reglas de correo no solicitado, si usted NO DESEA recibir este e-mail en el futuro, envie un mensaje a info@nobosti.com con el Asunto (subjet): Borrar de lista.";

##------------FIN DE LOS PARÁMETROS CONFIGURABLES----------------##
## No modifiques nada a partir de aqui a no ser que sepas lo que ##
## estás haciendo.							     ##
##---------------------------------------------------------------##

function get_ext($key) { 
	$key = strtolower($key);
	$key = explode("/",$key);
	$key1 = $key[1];
	$key = substr(strrchr($key1, "."), 1);
    return($key); 
} 
function get_name($key){ //sin la extension
	$key = strtolower($key);
	$key = explode("/",$key);
	$key1 = $key[1];
	$key = explode(".",$key1);
	$key = $key[0];
	return($key);
}


$tipos_aceptados = array("jpg", "jpeg", "png", "gif");

if ($_POST['enviar']){
	
		foreach($tipos_aceptados as $eso) {$tipos .="*.".$eso.",";}							
		$ext = get_ext($adjunto);
		$nombre = get_name($adjunto);
		$nom_completo = $nombre.".".$ext;
					
		$headers  = "From: $tunombre <$tuemail>\n";
		$headers .= "Reply-To: $tunombre <$tuemail>\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: multipart/mixed; boundary=\"MIME_BOUNDRY\"\n";
		$headers .= "X-Sender: WEBmail <$tuemail>\n";
		$headers .= "X-Mailer: WEBmail1.0\n"; 
		$headers .= "X-Priority: $prioridad\n"; 
		$headers .= "Return-Path: <$email_amigo>\n";
		$headers .= "\n";

		$fp = fopen($adjunto,"r");
		$str = fread($fp, filesize($adjunto));
		$str = chunk_split(base64_encode($str));
		$fp = fclose($fp);
		
		
		$message = "--MIME_BOUNDRY\n";
		$message .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
		$message .= "Content-Transfer-Encoding: quoted-printable\n";
		$message .= "\n";
		$message .= "$mensaje";
		$message .= "\n";
		
		$message .= "--MIME_BOUNDRY\n";
		$message .= "Content-Type: application/octet-stream; name=\"$nom_completo\"\n";
		$message .= "Content-disposition: attachment\n";
		$message .= "Content-Transfer-Encoding: base64\n";
		$message .= "\n";
		$message .= "$str\n";
		$message .= "\n";
		$message .= "--MIME_BOUNDRY--\n";
		
		$res = mysql_query("SELECT * FROM usr", $link);
		while ($fila = mysql_fetch_row ($res)){
			$email_amigo = trim($fila[0]);
			if(!mail($email_amigo,$asunto,$message,$headers)) {			
				$sql = "INSERT INTO errores VALUES ('$email_amigo','')";
				mysql_query ($sql, $link);
				exit("Ha ocurrido un error, por favor intentelo mas tarde<br>");
			}
			else{
			echo "<br>Realizado con Exito!!!".$fila[0];
			}
		}
			
		Echo("<div align=\"center\">$gracias</div>");
		exit();
}
?>
<HTML>
<body bgcolor="#FFFFFF">
<form name="form1" method="post" action="correo2.php" enctype="multipart/form-data">
		  <?php $img = "img/loguitop.jpg";?>
          <input type="hidden" name="adjunto" value="<?php=$img?>">
          <input type="submit" name="enviar" value="<?php=$valor_submit?>">
</form>
</body>
</html>