<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		12/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require ("conexion.php");
if (isset($retornar)){header("location: naccionista_det.php?num=$idcc");}
if (isset($mas_pruebas))
{	
		session_start();
		$login=$_SESSION["login"];
		$fecha_acc="$anio-$mes-$dia";
		
		$sql6="UPDATE accionistas SET nom_acc = '$nom_acc', fecha_acc='$fecha_acc',nac_acc='$nac_acc',dom_acc='$dom_acc',tel_acc='$tel_acc',fec_acc='".date("Y-m-d").date("H:i:s")."' ,estado='$estado' where id_acc='$idcc'";
		mysql_query($sql6);
		
		$sql6=str_replace("'","´",$sql6);

		$sql_log="INSERT INTO accion_log (date_log, acc_log, usr_log, ip_log) VALUES ('".date("Y-m-d")." ".date("H:m:s")."', '$sql6', '$login','".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($sql_log);

		$sql_i = "SELECT MAX(id_acc) AS id_acc FROM accionistas";
		$result_i = mysql_query($sql_i);
		$row_i = mysql_fetch_array($result_i);
		header("location: naccionista_det.php?num=$idcc");
}
include("top.php");
?> 

<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty ( "nom_acc",  "Nombre del Accionista,  $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "dom_acc",  "Domicilio del Accionista,  $errorMsgJs[empty]" );
print $valid->toHtml ();
?>  
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<html>
<head>
<style>
.cl2 { FONT-SIZE:8PT;}
</style>	
</head>
<body>
<form name="form1" method="post" onKeyPress="return Form()">
  <table width="70%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <th background="images/main-button-tileR1.jpg" height="20">MODIFICAR DATOS DEL ACCIONISTA
        <input name="tpo" type="hidden" value="<?php echo @$tpo;?>">
      </th>
    </tr>
  </table>	
  <table width="70%" border="1" align="center" background="images/fondo.jpg">
  <tr> 
      <td width="36%" background="images/main-button-tileR1.jpg" height="20"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NOMBRE O RAZON SOCIAL DEL ACCIONISTA </font></div></td>
      <td width="33%" background="images/main-button-tileR1.jpg" height="20"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA 
          DE REGISTRO</font></div></td>
      <td width="31%" background="images/main-button-tileR1.jpg" height="20"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NACIONALIDAD</font></div></td>
    </tr>
    <tr align="center"> 
      <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">
        <input name="nom_acc" type="text" value="<?php echo $nom ?>" size="50">
        </font>
        <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
        </font></div></td><td><p><?php echo $anio."-".$mes."-".$dia;?></p>
          </td>
      <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">
        <input name="nac_acc" type="text" value="<?php echo $nac ?>" size="25">
        </font><font  size="1" face="Arial, Helvetica, sans-serif">&nbsp; </font></td>
    </tr>
  </table>
	<table width="70%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="51%" background="images/main-button-tileR1.jpg" height="20" > <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">DOMICILIO</font></div></td>
      <td width="49%" background="images/main-button-tileR1.jpg" height="20" align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica">TELEFONO</font></td>
      <td width="49%" background="images/main-button-tileR1.jpg" height="20" align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica">ESTADO</font></td>
    </tr>
	<tr> 
	
	  <td width="51%"  > <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="dom_acc" type="text" value="<?php echo $direc?>" size="60">
          </font></div></td>
      <td width="49%"  align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica">
        <input name="tel_acc" type="text" value="<?php echo $tel ?>" size="20">
      </font></td>
      <td width="49%"  align="center"><label>
        <select name="estado">
			<?php
							$sqlaux = "select * from accionistas where id_acc='$idcc'";
							$resaux = mysql_query($sqlaux);
							$rowaux = mysql_fetch_array($resaux);
							
								if($rowaux['estado'] == "Pagado")
								{
						echo"<option value='$rowaux[estado]' selected>".$rowaux['estado']."</option>";	
								} else {
						echo"<option value='Pagado'>Pagado</option>";
								}	
								if($rowaux['estado'] == "Suscrito")
								{
						echo"<option value='$rowaux[estado]' selected>".$rowaux['estado']."</option>";	
								} else {
						echo"<option value='Suscrito'>Suscrito</option>";
								}	
		?>
		
			
          </select>
      </label></td>
	</tr>
   <tr> 
      <td colspan="3"><div align="center"> <br>
          <input type="submit" name="mas_pruebas" value = "GUARDAR Y CONTINUAR"   <?php print $valid->onSubmit() ?>> 
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="retornar" value="RETORNAR">
        </div></td>
    </tr>
  </table>
<tr>
    <td colspan="1"><blockquote>
</form>
</body>
</html>
 <script language="JavaScript">
		<!-- 
		<?php if (isset($msg)) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
		var form="form1";
		var cal = new calendar1(document.forms[form].elements['Dia'], document.forms[form].elements['Mes'], document.forms[form].elements['Ano']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>