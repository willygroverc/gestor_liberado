<?php 
// Version: 	1.0
// Objetivo:	Implementaci�n de expresiones regulares en validacion de formulario.
//				Clasificacion de codigo segun tipo.
//				Modificacion de metodo de insercion (_POST)
//Autor:		Cesar Cuenca
//Fecha:		15/NOV/12
//__________________________________________________________________________________

// pendiente: implementar pass_repetidos (de historial de passwords), pass_secuencial, y pass longitud

include('top.php');
require ("conexion.php");
$sql="SELECT pass_longitud, pass_secuencial, pass_repetidos FROM control_parametros";
$recordset=mysql_query($sql);
$fila=mysql_fetch_array($recordset);
@session_start();
$_SESSION['modulo']='usuario_nuevo';
?>
<html>
<head>
	<link href="css/validation.css" rel="stylesheet" type="text/css">
	<link href="css/tiny_box.css" rel="stylesheet" type="text/css">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<script language="javascript" src="js/ajax.js"></script>
	<script language="javascript" src="js/usuarios.js"></script>
	<script language="javascript" src="js/validate.js"></script>
	<script language="javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/tinybox.js"></script>
	<script language="javascript">
		var siguienteCampo = "login_usr";  
		var nombreForm = "frm_usr" ;
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
						guardar_nuevo_usuario();
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
</head>
<body onload="document.getElementById('login_usr').focus();">

<?php 
echo '<style>

</style>';
echo '<form name="frm_usr" id="frm_usr" method="POST" action="#">
  <table width="90%" border="1" background="images/fondo.jpg">
    <tr> 
	  <th align="center" background="windowsvista-assets1/main-button-tile.jpg" height="30px">USUARIO</td>
   </tr>
   <tr> 
      <td align="center"> 
		<br>
	  	<table border="1" class="tbl1" >
        <tr>
			<th colspan="6"><strong>Datos de Cuenta</strong></th>
		</tr>
		<tr>
			<td>LOGIN(*):</td>
			<td>
				<input name="login_usr" id="login_usr" type="text" size="25" maxlength="15" onFocus="siguienteCampo =\'email\'">
			</td>
			<td>PASSWORD(*):</td>
			<td>
				<input name="password_usr" type="password" id="password_usr" maxlength="15" size="25" onFocus="siguienteCampo =\'password_usr2\'">
				<input type="hidden" id="pass_long" name="pass_long" value="'.$fila['pass_longitud'].'"></input>
			</td>
			<td>TIPO :</td>
			<td>
				<select name="tipo2_usr" id="tipo2_usr">
					<option value="A"';
				if (isset($tipo2_usr)=="A") 
					echo "selected"; 
				echo '>Administrador</option>';
				echo '<option value="B"';
				if (isset($tipo2_usr)=="B") 
					echo "selected";
				echo'>Backup</option>';
				echo '<option value="T"'; 
				if (isset($tipo2_usr)=="T") 
					echo "selected"; 
				echo '>Tecnico</option>';
				echo '<option value="C"';
				if (isset($tipo2_usr)=="C") 
					echo "selected"; 
				echo '>Cliente</option>';
				echo '</select>';
		echo' </td>
		</tr>
        <tr>
			<td>EMAIL:</td>
			<td>
				<input name="email" id="email" value="" size="25" maxlength="50" onFocus="siguienteCampo =\'email_alter\'">
			</td>
			<td>PASSWORD<br>(Repetir):</td>
			<td>
				<input name="password_usr2" type="password" id="password_usr2" size="25" maxlength="15" onFocus="siguienteCampo =\'nom_usr\'">
			</td>
          <td>CLIENTE:</td>
          <td>
				Interno <input type="radio" id="tipo_usr" name="tipo_usr" value="INTERNO" checked>
				Externo <input type="radio" name="tipo_usr" id="tipo_usr" value="EXTERNO">
          </td>
		</tr>
		<tr>
			<td>EMAIL<br>ALTERNATIVO:</td>
			<td><input type="text" name="email_alter" id="email_alter" size="25" onFocus="siguienteCampo =\'password_usr\'"></td>
        </tr>
		<tr>
			<th colspan="6"></th>
		<tr>
        </table>
		
        <table border="1" class="tbl1">
        <tr>
          <th colspan="7"><strong>Datos del Cliente</strong></th>
        </tr>
        <tr>
          <td>NOMBRES(*):</td>
          <td>
            <input name="nom_usr" type="text" id="nom_usr" value="" size="20" maxlength="20" onFocus="siguienteCampo =\'apa_usr\'">
          </td>
          <td>AP.PATERNO(*):</td>
          <td colspan="2">
            <input name="apa_usr" type="text" id="apa_usr" value="" size="20" maxlength="20" onFocus="siguienteCampo =\'ama_usr\'">
          </td>
          <td>AP.MATERNO:</td>
          <td>
            <input name="ama_usr" type="text" id="ama_usr" value="" size="20" maxlength="20" onFocus="siguienteCampo =\'enti_usr\'">
          </td>
        </tr>
        <tr>
          <td>ENTIDAD:</td>
          <td>
            <input name="enti_usr" type="text" id="enti_usr" value="" size="20" maxlength="40" onFocus="siguienteCampo =\'esp_usr\'">
          </td>
          <td>AREA:</td>
          <td>
			<div id="ajax_area">';
			include('lib/cmb_area.php');
echo '		</div>
			<td><a class="modal" href="javascript:TINY.box.show({url:\'lib/frm_area.php\',width:200,height:40})"><img src="images/btn_agregar.png" style="width:25px;"></img></a></td>
          </td>
          <td>&nbsp;ESPECIALIDAD:</td>
          <td>
              <input name="esp_usr" type="text" id="esp_usr"  value="" size="20" maxlength="100" onFocus="siguienteCampo =\'cargo_usr\'">
          </td>
        </tr>
        <tr>
          <td>CARGO:</div></td>
          <td>
            <input name="cargo_usr" type="text" id="cargo_usr" value="" size="20" maxlength="40" onFocus="siguienteCampo =\'telf_usr\'">
          </td>
          <td>TELEFONO:</div></td>
          <td colspan="2">
            <input name="telf_usr" type="text" id="telf_usr" value="" size="20" maxlength="15" onFocus="siguienteCampo =\'ext_usr\'">
          </td>
          <td>CELULAR:</div></td>
          <td valign="middle">
            <input name="ext_usr" type="text" id="ext_usr" value="" size="10" maxlength="8" onFocus="siguienteCampo =\'costo_usr\'">
            <select name="id_dat_tel_movil" id="id_dat_tel_movil">';
            echo '<option value="0">Seleccione Operador</option>';
			$sql2 = "SELECT id_dat_tel_movil, nombre FROM dat_tel_movil ORDER BY nombre ASC";
 			$result2=mysql_query($sql2);
			while ($row2=mysql_fetch_array($result2)) {
				if($row2['id_dat_tel_movil']==$id_dat_tel_movil) 
					echo '<option value="'.$row2['id_dat_tel_movil'].'" selected>'.$row2['nombre'].'</option>';
			    else 
					echo '<option value="'.$row2['id_dat_tel_movil'].'">'.$row2['nombre'].'</option>';
			}
			echo '</select>
          </td>
        </tr>
        <tr>
          <td>COSTO SERVICIO<br>/HORA:</td>
          <td><input name="costo_usr" id="costo_usr" type="text" size="10" maxlength="25" onFocus="siguienteCampo =\'ciu_usr\'"></td>';
           
		  /*$sql1="SELECT agencia FROM control_parametros";
		  $rs1=mysql_query($sql1);
		  $row1=mysql_fetch_array($rs1);
		  if ($row1['agencia']=="si") {*/
			echo '<td>AGENCIA:</td>
				<td valign="middle" >
					<div id="ajax_agencia">';
					include('lib/cmb_agencia.php');
			echo	'</div>
				</td>
		  <td><a class="modal" href="javascript:TINY.box.show({url:\'lib/frm_agencia.php\',width:200,height:40})"><img src="images/btn_agregar.png" style="width:25px;"></img></a></td>
        </tr>';
         //}
		echo '<br>
        <tr>
          <th colspan="7"><strong>Ubicacion Fisica</strong></th>
        </tr>
        <tr>
          <td>CIUDAD:</td>
          <td>
            <input name="ciu_usr" type="text" id="ciu_usr" size="20" value="" onFocus="siguienteCampo =\'direc_usr\'">
          </td>
          <td>DIRECCION:</td>
          <td colspan="3">
            <input name="direc_usr" type="text" id="direc_usr" size="40" value="" onFocus="siguienteCampo =\'fin\'">
          </td>
		  <td>
			&nbsp;&nbsp;&nbsp;<input type="button" name="submit" id="submit" value="GUARDAR" onclick="guardar_nuevo_usuario();" >&nbsp;&nbsp;&nbsp;
			<input type="button" name="RETORNAR" value="RETORNAR" onclick="retornar(1);">
		  </td>
        </tr>
        <tr>
          <th colspan="7"></th>
        </tr>
      </table>
	  <br>
		<div id="lbl_ajax">
			<div style="display: none;" class="success_box"></div>
			<div style="display: block;" class="error_box" id="error_box">Los campos con marcados con (*) son obligatorios</div>
		</div>
	 </td> 
</tr> 
</table>
</form>';
?>
</body>
</html>