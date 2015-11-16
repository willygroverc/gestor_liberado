<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		03/JUL/2013
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
$_SESSION['modulo']='ficha_nuevo';
?>
<html>
<head>
	<link rel="stylesheet" href="css/jquery-ui_f.css" />
	<link href="css/validation.css" rel="stylesheet" type="text/css">
	<link href="css/style_fic.css" rel="stylesheet" type="text/css">
	<script language="javascript" src="js/ajax.js"></script>
	<script language="javascript" src="js/proveedores.js"></script>
	<script language="javascript" src="js/validate.js"></script>
	<script language="javascript" src="js/jquery.js"></script>
	<script language="javascript" src="js/jquery-ui.js"></script>
	
	<script language="javascript">
		var siguienteCampo = "Nombre";  
		var nombreForm = "frm_prov" ;
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
						guardar_nuevo_prov();
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
<?php
/*$sqlV="SELECT nivel2 FROM proveedor WHERE idProv='$IdProv'";
$resultV=mysql_query($sqlV);
$filaV=mysql_fetch_array($resultV);*/
?>
<body>

<?php 
include("conexion.php");
include("top.php");
if(!empty($IdProv))
{
	$sql = "SELECT * FROM proveedor WHERE IdProv='$IdProv'";
    $result=mysql_query($sql);
    $row=mysql_fetch_array($result);
}
echo '<form name="frm_prov" id="frm_prov" method="POST" action="#">
<table width="67%" border="0" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr> 
    <th background="images/main-button-tileR1.jpg" heigh="30px" colspan="2">DATOS 
      DEL PROVEEDOR</th>
  </tr>
  <tr>
	<td colspan="2">&nbsp;</td>
  </tr>
  <tr>
	<th colspan="2"><strong>Registro</strong></th>
  </tr>
  <tr>
	<td colspan="2">
		&nbsp;
	</td>
  </tr>
  <tr>
	<td colspan="2" align="center">
		Fecha:'; echo date("d/m/Y");
	echo '</td>
  </tr>
  <tr> 
    <td aling="center"> 
	
      <input name="IdProv" id="IdProv" type="hidden" value="'; echo $IdProv; echo '"> <strong><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre 
        &nbsp;&nbsp;: </strong> &nbsp; 
        <input name="NombProv" id="NombProv" type="text" size="50" maxlength="55" value="';echo @$row['NombProv'];echo '">  
</td>
    <td> <strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Direccion &nbsp;:</strong>&nbsp; 
        <input name="DirecProv" id="DirecProv" type="text" size="50" maxlength="55"  value="'; echo @$row['DirecProv']; echo '">
      </td>
  </tr>
  <tr> 
    <td> <p><strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telefono 1 :</strong> 
        <input name="Fono1Prov" id="Fono1Prov" type="text" size="20" maxlength="20"  value="'; echo @$row['Fono1Prov']; echo '">
        <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> 
      </p></td>
    <td><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Telefono 2:</b> 
      <input name="Fono2Prov" id="Fono2Prov" type="text" size="20" maxlength="20"  value="'; echo @$row['Fono2Prov']; echo '"> 
    </td>
  </tr>
  <tr> 
    <td> <p><strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Encargado :</strong> 
        <input name="EncProv" id="EncProv" type="text" size="50" maxlength="50"  value="'; echo @$row['EncProv']; echo '">
      </p></td>
    <td><strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E-mail &nbsp;&nbsp;:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input name="EmailProv" id="EmailProv" type="text" size="40" maxlength="40"  value="'; echo @$row['EmailProv']; echo '">
    </td>
  </tr>
  <tr> 
    <td> <p><strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Servicio :</strong> 
        &nbsp;&nbsp;&nbsp;
		<select name="servicio1" id="servicio1" onchange="filtrar_servicio();" style="font-size:9">
			<option value="0" selected>Seleccione</option>';
			
			$sqlS = "SELECT * FROM t_servicio ORDER BY servicio_nombre ASC";
			$recordsetS = mysql_query($sqlS);
			while($filaS=mysql_fetch_array($recordsetS)){
				if($filaS['servicio_cod']==$row['nivel1']) {
					echo '<option value="'.$filaS['servicio_cod'].'" selected>'.$filaS['servicio_nombre'].'</option>';
				} else {
					echo '<option value="'.$filaS['servicio_cod'].'">'.$filaS['servicio_nombre'].'</option>';
				}
			}
			
			
	echo '</select>
	<div id="div_proveedor" style="left:290px;position: absolute;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <select id="servicio2" name="servicio2" style="font-size:9">
							<option value="0">Seleccione</option>';
		echo '</select>';
	if(isset($servicio2)==0)
		echo '<script>onload=cargacombo('; echo $IdProv; echo ');</script>';
	echo '</div>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		
	
	</p></td>
    
  </tr>
  <tr> 
    <td> <p><strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nivel de Riesgo :</strong> 
		<select name="nivelRiesgo" id="nivelRiesgo" >
			<option value="1"'; if($row['nivelRiesgo']=="1")  echo 'selected';  echo '>1</option>
			<option value="2"'; if($row['nivelRiesgo']=="2")  echo 'selected';  echo '>2</option>
			<option value="3"'; if($row['nivelRiesgo']=="3")  echo 'selected';  echo '>3</option>
			<option value="4"'; if($row['nivelRiesgo']=="4")  echo 'selected';  echo '>4</option>';
			if(!empty($row['nivelRiesgo'])) {
				echo '<option value="5"'; if($row['nivelRiesgo']=="5")  echo 'selected';  echo '>5</option>';
			} else {
				echo '<option value="5" selected>5</option>';
			}
		echo '</select>
      </p>
	  
	  <b>Descripcion del Riesgo:</b> 
	  &nbsp;
		<textarea name="descRiesgo" id="descRiesgo" cols="40">'; echo @$row['descRiesgo']; echo '</textarea>
	</td>
    <td> <p><strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nivel de Calidad :</strong> 
		<select name="nivelCalidad" id="nivelCalidad" >';
			if(!empty($row['nivelRiesgo'])) {
				echo '<option value="1"'; if($row['nivelCalidad']=="1")  echo 'selected';  echo '>1</option>';
			} else {
				echo '<option value="1" selected>1</option>';
			}
			echo '
			<option value="2"'; if($row['nivelCalidad']=="2")  echo 'selected';  echo '>2</option>
			<option value="3"'; if($row['nivelCalidad']=="3")  echo 'selected';  echo '>3</option>
			<option value="4"'; if($row['nivelCalidad']=="4")  echo 'selected';  echo '>4</option>
			<option value="5"'; if($row['nivelCalidad']=="5")  echo 'selected';  echo '>5</option>
		</select>
      </p>
	  
	  <b>Descripcion de Calidad:</b> 
	  &nbsp;
		<textarea name="descCalidad" id="descCalidad" cols="40">'; echo @$row['descCalidad']; echo '</textarea>
	</td>
  
  </tr>
  <tr> 
    <td> <p><strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Observaciones :</strong> 
        <textarea name="ObsProv" id="ObsProv" cols="40">'; echo @$row['ObsProv']; echo '</textarea>
      </p>
      <p>&nbsp; </p></td>
    <td>&nbsp; </td>
  </tr>
	<tr>'; 
	if(!empty($IdProv))
	{
    echo '<td align="center"> <input type="button" name="submit" id="submit" value="GUARDAR" onclick="editar_prov();" >&nbsp;&nbsp;&nbsp;';
	} else	{
		echo '<td align="center"> <input type="button" name="submit" id="submit" value="GUARDAR" onclick="guardar_nuevo_prov();" >&nbsp;&nbsp;&nbsp;';
	}
	echo '</td>
    <td align="center"><input type="button" name="submit" id="submit" value="RETORNAR" onclick="retornar(1);" >
    </td>
  </tr>
<tr>
	<td colspan="2" align="center">
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