<?php // Version: 	1.0 // Objetivo: 	Implementacion de nueva funcionalidad: Recuperar password con correo alternativo.//				Implementación WEB 2.0 (Barra informativa: Numero de Intentos Fallidos Y Restantes) //				 // Autor:		Cesar Cuenca. // Fecha:		01/DIC/12//_____________________________________________________________________________________________@session_start();if (isset($_SESSION['login'])){	header('location:pagina_inicio.php');}require ("conexion.php"); ?><html><head><title>GesTor F1</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><link href="css/validation.css" rel="stylesheet" type="text/css"><script language="javascript" src="js/validate.js"></script><script type="text/javascript" src="js/jquery.js"></script><script type="text/javascript" src="js/login.js"></script><script type="text/javascript" src="js/ajax.js"></script><script language="javascript"></script>	<script language="javascript" src="js/login.js"></script>	<script language="javascript">		var siguienteCampo = "login";  		var nombreForm = "frm_login" ;		document.onkeydown = TelcaPulsada;          //asigna el evento pulsacion tecla a la funcion  		function TelcaPulsada( e ) {  		   if ( window.event != null)               //IE4+  			  tecla = window.event.keyCode;  		   else if ( e != null )                //N4+ o W3C compatibles  			  tecla = e.which;  		   else  			  return;  		   if (tecla == 13) {                   //se pulso enter  			  if ( siguienteCampo == 'fin' ) {          //fin de la secuencia, hace el submit  				 validar_usuario();         				 return false ;                 //sustituir por return true para hacer el submit  			  } else {                      //da el foco al siguiente campo  				 eval('document.' + nombreForm + '.' + siguienteCampo + '.focus()');				 return false ; 			  }  		   }  		}    		if (document.captureEvents)             //netscape es especial: requiere activar la captura del evento  			document.captureEvents(Event.KEYDOWN) ; 	</script></head><body onload="document.getElementById('login').focus();"><?php	$sql='SELECT intentos_cont, intentos_disc FROM control_parametros LIMIT 1';	$recordset=mysql_query($sql);	if (mysql_num_rows($recordset)==1){		$fila=mysql_fetch_array($recordset);		echo '<input type="hidden" id="max" name="max" id="max" value="'.$fila['intentos_cont'].'"></input>';	}?><table width="80%" border="1" align="center">  <tr>     <td width="20%"> <img src="images/imagen_ins.jpg"></td>	<td width="80%">	<img src="images/bannerTI.jpg"></img></td>  </tr></table><hr size="3"><form name="frm_login" id="frm_login" method="post" action="#">    <table width="45%" height="282" align="center" background="images/fondo.jpg">		<tr>		  <td>			<table width="50%" border="0" align="center" cellpadding="4" cellspacing="0" >				<tr>					<td bgcolor="#006699" colspan="2" align="center" background="images/main-button-tileR2.jpg">						<font face="arial,helvetica"  color="#FFFFFF">&nbsp;&nbsp;<b>INGRESE SUS DATOS</b></font>					</td>				</tr>				<tr>					<td bgcolor="#F4F2EA" class="box"> 						<br>						<table width="100%" border="0" cellpadding="4" cellspacing="0">							<tr>								<td width="40%" align ="right"><font size="2" face="arial"><strong>LOGIN</strong></font></td>								<td width="60%"><input type="text" size="20" maxlength="20" name="login" id="login" onFocus="siguienteCampo ='password';"></td>								<td rowspan="4"><img src="images/login_icon.png" style="width:80px;"></img></td>							</tr>							<tr>								<td align ="right"><font size="2" face="arial"><strong>PASSWORD</strong></font></td>								<td><input type="password" size="20" maxlength="44" name="password" id="password" onFocus="siguienteCampo ='fin';"></td>							</tr>							<tr>								<td colspan="2"></td>							</tr>							<tr>								<td colspan="3" align="center">									<input name="submit" id="submit" type="button" value="INGRESAR" onclick="validar_usuario();"></input>								</td>							</tr>													</table>						<br>					</td>				</tr>								<tr>					<td bgcolor="#006699" colspan="2" align="center" background="images/main-button-tileR2.jpg">						<font face="arial,helvetica"  size="-1" color="#FFFFFF">&nbsp;&nbsp;<b><a href="javascript:recuperar_pass();" style="color:white;">Si olvido su password click aqui.</a></b></font>					</td>				</tr>			</table>		</td>		</tr>	<tr>		<td align="right" colspan="2"></td>	</tr>	</table>  <br><br>  <div align="center" id="div_ajax">	<div style="display: none;" class="success_box"></div>	<div style="display: block;" class="error_box" id="error_box">Si Ud. no posee una cuenta, contacte con el Administrador del Sistema.</div>  </div>		</form><hr size="3"><div align="center"><font face="arial, verdana" size="1">GesTor F1 Version 4.0.1<br>COPYRIGHT &copy; 2013 YANAPTI S.R.L.</font></div></body></html>