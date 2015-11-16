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
require("conexion.php");
if (isset($retornar)){header("location: accionistas.php");}
if (isset($mas_pruebas))
{	
		session_start();
		$login=$_SESSION["login"];
		$fecha_acc="$Ano-$Mes-$Dia";
		
		$sql6="INSERT INTO accionistas (nom_acc,fecha_acc,nac_acc,dom_acc,tel_acc,fec_acc,estado) VALUES('$nom_acc', '$fecha_acc','$nac_acc','$dom_acc','$tel_acc','".date("Y-m-d")." ".date("H:i:s")."','$estado')";
		mysql_query($sql6);
		
		$sql6=str_replace("'","´",$sql6);

		$sql_log="INSERT INTO accion_log (date_log, acc_log, usr_log, ip_log) VALUES ('".date("Y-m-d")." ".date("H:m:s")."', '$sql6', '$login','".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($sql_log);

		$sql_i = "SELECT MAX(id_acc) AS id_acc FROM accionistas";
		$result_i = mysql_query($sql_i);
		$row_i = mysql_fetch_array($result_i);
		header("location: naccionista_det.php?num=$row_i[id_acc]");
}
include("top.php");
?> 
<script language="JavaScript" src="calendar.js"></script>
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
      <th background="images/main-button-tileR1.jpg">DATOS DEL ACCIONISTA
        <input name="tpo" type="hidden" value="<?php echo @$tpo;?>">
      </th>
    </tr>
  </table>	
  <table width="70%" border="1" align="center" background="images/fondo.jpg">
  <tr> 
      <td width="36%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NOMBRE O RAZON SOCIAL DEL ACCIONISTA </font></div></td>
      <td width="33%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA 
          DE REGISTRO</font></div></td>
      <td width="31%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NACIONALIDAD</font></div></td>
    </tr>
    <tr align="center"> 
      <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">
        <input name="nom_acc" type="text" value="" size="50">
        </font>
        <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
        </font></div></td><td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
        <select name="Dia" >
          <?php
				$fsist=date("Y-m-d");
  				$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);
				if (!(empty($nro)))
				{	$fec = explode("-", $row9['FechaPlanifica']);
					$a1 = substr($row9['FechaPlanifica'],0,4);
					$m1 = substr($row9['FechaPlanifica'],5,2);
					$d1 = substr($row9['FechaPlanifica'],8,2);
				}
				for($i=1;$i<=31;$i++)
				{
	              echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
				}
				?>
        </select>
        <select name="Mes">
          <?php
				for($i=1;$i<=12;$i++)
				{
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
				}
				?>
        </select>
        <select name="Ano">
          <?php
				for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
        </select>
        <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></td>
      <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">
        <input name="nac_acc" type="text" value="Boliviano" size="25">
        </font><font  size="1" face="Arial, Helvetica, sans-serif">&nbsp; </font></td>
    </tr>
  </table>
	<table width="70%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="51%" bgcolor="#006699" > <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">DOMICILIO</font></div></td>
      <td width="49%" bgcolor="#006699" align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica">TELEFONO</font></td>
      <td width="49%" bgcolor="#006699" align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica">ESTADO</font></td>
    </tr>
	<tr> 
	
	  <td width="51%"  > <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="dom_acc" type="text" value="" size="60">
          </font></div></td>
      <td width="49%"  align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica">
	   <input name="tel_acc" type="text" value="" size="20">
	  </font></td>
      <td width="49%"  align="center"><select name="estado">
        <option value="Suscrito">Suscrito</option>
        <option value="Pagado">Pagado</option>
      </select></td>
	</tr>
   <tr> 
      <td colspan="3"><div align="center"> <br>
          <input type="submit" name="mas_pruebas" value = "GUARDAR Y CONTINUAR"   <?php print $valid->onSubmit() ?>Z> 
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
