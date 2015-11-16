<?php
// version: 	1.0
// Autor:		Cesar Cuenca
// Objetivo1:	Implementacion control de acceso a ficheros desde url.
// 				Implmentacion validaci�n del lado cliente para reducir el numero de request al servidor;
//				Actualizar funciones ambiguas php no recomendadas para versiones 5.3 o posterior.
// fecha1:		16/NOV/12

// Objetivo2:	Implementacion medidor de fortaleza de password.
// fecha2:		26/DIC/12
//_____________________________________________________________________________________________________
include("top.php");
require ("conexion.php");
@session_start();
if (!isset($login)) {	header("location: index.php"); 	}
//$sql="SELECT pass_longitud, pass_secuencial, pass_repetidos FROM control_parametros";
$sql='SELECT pass_longitud FROM control_parametros LIMIT 1';
$recordset=mysql_query($sql);
$fila=mysql_fetch_array($recordset);
?>

	<style>
		
#passwordStrength{
	height:10px;
	display:block;
	float:left;
	margin-left:160px;
}

.strength0{
	margin-left:160px;
	width:250px;
	background:#cccccc;
}

.strength1{
	margin-left:160px;
	width:50px;
	background:#ff0000;
}

.strength2{
	margin-left:160px;
	width:100px;	
	background:#ff5f5f;
}

.strength3{
	margin-left:160px;
	width:150px;
	background:#56e500;
}

.strength4{
	background:#4dcd00;
	width:200px;
}

.strength5{
	margin-left:160px;
	background:#399800;
	width:250px;
}

	</style>
	<link href="css/validation.css" rel="stylesheet" type="text/css"></link>
	<script language="javascript" src="js/ajax.js"></script>
	<script language="javascript" src="js/password.js"></script>
	<script language="javascript" src="js/validate.js"></script>
	<script language="javascript" src="js/jquery.js"></script>
	<script language="javascript">
		var siguienteCampo = "pass_actual";  
		var nombreForm = "frm_pass" ;
		document.onkeydown = TelcaPulsada;          //asigna el evento pulsacion tecla a la funcion  
		function TelcaPulsada( e ) {  
		   if ( window.event != null)               //IE4+  
			  tecla = window.event.keyCode;  
		   else if ( e != null )                //N4+ o W3C compatibles  
			  tecla = e.which;  
		   else  
			  return;  
		   if (tecla == 13) {                   //se pulso enter  
			  if ( siguienteCampo == 'fin' ) {          //fin de la secuencia, hace el submit  
				 validar_cambio_pass();
				 return false ;                 //sustituir por return true para hacer el submit  
			  } else {                      //da el foco al siguiente campo  
				 eval('document.' + nombreForm + '.' + siguienteCampo + '.focus()');
				 return false ; 
			  }  
		   }  
		}  
  
		if (document.captureEvents)             //netscape es especial: requiere activar la captura del evento  
			document.captureEvents(Event.KEYDOWN) ; 
	</script>
	
<?php echo '<input type="hidden" id="pass_long" name="pass_long" value="'.$fila['pass_longitud'].'">'?>
<form name="frm_pass" id="frm_pass" method="post" action="#">
  <table width="75%" height="282" align="center" background="images/fondo.jpg">
    <tr>
      <td>
	   <table width="64%" border="0" align="center" cellpadding="0" cellspacing="10">
			<tr>
               <td align="CENTER" bgcolor="#006699" colspan="2" height="30px" background="windowsvista-assets1/main-button-tile.jpg">
					<font face="arial,helvetica" size="-1" color="#FFFFFF"><b>C A M B I A R  &nbsp; P A S S W O R D </b></font>
				</td>
			</tr>
			<tr>
               <td COLSPAN="2" bgcolor="#F4F2EA"> 
                            <font face="arial,helvetica" size="-1">El <b>PASSWORD</b> tiene 
							que contener <b>mas de <?php echo $fila['pass_longitud']; ?> caracteres</b> y diferencia entre mayusculas 
							y minusculas. </font> 
					<table border="3" width="100%" cellspacing="0" cellpadding="2">
						<tr>
							<td width="35%"><font size="2" face="arial"><strong>Password Actual:&nbsp;&nbsp;</strong></font></td>
							<td width="65%">
								<input type="password" size="30" maxlength="44" name="pass_actual" id="pass_actual" onFocus="siguienteCampo ='password1';">
							</td>
						</tr>
						<tr>
							<td><font size="2" face="arial"><strong>Password Nuevo:&nbsp;&nbsp;</strong></font></td>
							<td>
								<input type='password' size="30" maxlength="44" name="password1" id="password1" onkeyup="pass_seguro(this.value)" onFocus="siguienteCampo ='password2';">
							</td>
						</tr>
						<tr>
							<td><font size="2" face="arial"><strong>Password (CONFIRMACION):&nbsp;&nbsp;</strong></font></td>
							<td> <input type='password' size="30" maxlength="44" name="password2" id="password2" onFocus="siguienteCampo ='fin';"></td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<p>
								<label for="passwordStrength">Password Seguro</label>
								<div id="passwordDescription">Password no introducido</div>
								<div id="passwordStrength" class="strength0"></div>
								</p>
							</td>
						</tr>
					</table> 
				</td>
			</tr>
        </table>
	    <div align="center">
          <input name="ingreso" type="button" value="CAMBIAR" onclick="validar_cambio_pass()"></input>
        </div><br>
		<div align="center" id="div_ajax">
			<div style="display: none;" class="success_box">El password se modifico con exito</div>
                        
			<div style="display: block;" class="error_box" id="error_box">El nuevo password debe contener al menos <?php echo $fila['pass_longitud'];?> caracteres.</div>
		</div>
		</td>
    </tr>
  </table>
</form>
<script>
document.getElementById('pass_actual').focus();
</script>