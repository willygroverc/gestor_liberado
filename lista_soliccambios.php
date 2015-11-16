<?php
header('Content-Type: text/html; charset=iso-8859-1');
session_start();
$tipo=$_SESSION["tipo"];
include ("conexion.php");
if (isset($RETORNAR)){echo "<script type=\"text/javascript\">
           history.go(-2);
       </script>";}
if (isset($NueFicha))
{ 	
	$sql2 = "SELECT MAX(Codigo) AS Cod FROM solicproydatos";
	$result2=mysql_db_query($db,$sql2,$link);
	$row2=mysql_fetch_array($result2);
	$Co=$row2[Cod]+1;
	header("location: solicproyecto1.php?Codigo=$Co");
}
else 
{ include ("top.php");
	
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num","Numero de la Orden de Trabajo");
	print $help->ToHtml();
?>
<html>
<head>
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top">
	<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="11" background="images/main-button-tileR11.jpg" height="35">LISTA DE SOLICITUD DE CAMBIOS</th>
        </tr>
        <tr align=\"center\"> 
          <th class="menu" rowspan="2" width="1%" background="images/main-button-tileR2.jpg" height="20"><?php print $help->AddLink("num", "Nro. Orden"); ?></th>
          <th width="11%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg" height="20">SOLICITANTE DEL CAMBIO</th>
          <th class="menu" rowspan="2" width="14%" background="images/main-button-tileR2.jpg" height="20">REQUERIMIENTO</th>
          <th colspan="5" class="menu" background="images/main-button-tileR2.jpg" height="20">FASES DEL CAMBIO</th>
		  <th width="7%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg" height="20">ADJUNTAR ARCHIVOS</th>
          <?php if ($tipo=="A" or $tipo=="B") {?>
          <th width="7%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg" height="20">MODIFICAR</th>
          <?php }?>
          <th width="7%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg" height="20">IMPRIMIR</th>
        </tr>
        <tr align="center"> 
          <th width="10%" class="menu" background="images/main-button-tileR1.jpg">SOLICITUD</th>
          <th width="10%" class="menu" background="images/main-button-tileR1.jpg">PLANIFICACION</th>
          <th width="10%" class="menu" background="images/main-button-tileR1.jpg">EJECUCION</th>
          <th width="10%" class="menu" background="images/main-button-tileR1.jpg">CONTROL</th>
          <th width="10%" class="menu" background="images/main-button-tileR1.jpg">CIERRE</th>
        </tr>
        <?php
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM soliccambiodatos";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

//$sql = "SELECT *, DATE_FORMAT(FechSolic, '%d/%m/%Y') AS FechSolic FROM soliccambiodatos ORDER BY Codigo DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
if ($tipo=="T") 
	{$sql = "SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion WHERE asig='$login' GROUP BY id_orden";}
else
	{$sql = "SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
$rs1=mysql_db_query($db,$sql,$link);
while ($row=mysql_fetch_array($rs1))  
{
  	$sql1="SELECT id_orden, area, asig FROM asignacion WHERE id_asig='$row[id_asig]'";
	$row1=mysql_fetch_array(mysql_db_query($db,$sql1,$link));
	if($row1['area']=="Cambios")
	{	
		echo "<tr align=\"center\">";
		echo "<td><font size=\"1\">&nbsp;$row1[id_orden]</font></td>";
		
		$sql_ord="SELECT desc_inc, cod_usr FROM ordenes WHERE id_orden='$row1[id_orden]'";
		$row_ord=mysql_fetch_array(mysql_db_query($db,$sql_ord,$link));
		
		$sql2 = "SELECT * FROM users WHERE login_usr='$row_ord[cod_usr]'";
		$result2 = mysql_db_query($db,$sql2,$link);
		$row2 = mysql_fetch_array($result2); 
		
		echo "<td align=\"center\"><font size=\"1\">&nbsp;$row2[nom_usr] $row2[apa_usr] $row2[ama_usr]</font></td>";
		echo "<td><font size=\"1\">&nbsp;$row_ord[desc_inc]</font></td>";
		
		$sql3_0 = "SELECT * FROM soliccambiodatos WHERE Codigo='$row1[id_orden]'"; 
		$result3_0 = mysql_query($sql3_0);
		$row3_0 = mysql_fetch_array($result3_0);
		if (!$row3_0['Codigo'])
		{	echo "<td><font size=\"1\">&nbsp;<a href=\"soliccambios1.php?id_orden=".$row1['id_orden']."\">SOLICITUD</a></font></td>";
			echo "<td><font size=\"1\">&nbsp;ANTES SOLICITE</font></td>";
			echo "<td><font size=\"1\">&nbsp;ANTES SOLICITE</font></td>";
			echo "<td><font size=\"1\">&nbsp;ANTES SOLICITE</font></td>";
			echo "<td><font size=\"1\">&nbsp;ANTES SOLICITE</font></td>";}
		else
		{	echo "<td><font size=\"1\">SOLICITADO&nbsp;</font></td>";
			$sql3 = "SELECT * FROM soliccambioplanif WHERE Codigo='$row1[id_orden]' GROUP BY Codigo";
			$result3 = mysql_db_query($db,$sql3,$link);
			$row3 = mysql_fetch_array($result3);
			if (!$row3['Codigo'])
			{	echo "<td><font size=\"1\">&nbsp;<a href=\"soliccambios3.php?id_orden=".$row1['id_orden']."\">PLANIFICACION</a></font></td>";
				echo "<td><font size=\"1\">&nbsp;ANTES PLANIFIQUE</font></td>";
				echo "<td><font size=\"1\">&nbsp;ANTES PLANIFIQUE</font></td>";
				echo "<td><font size=\"1\">&nbsp;ANTES PLANIFIQUE</font></td>";}
			else
			{	echo "<td><font size=\"1\">PLANIFICADO</font></td>";	
				
				$sql_pro="SELECT num_orden FROM maestro WHERE num_orden='$row1[id_orden]'";
				$res_pro = mysql_db_query($db,$sql_pro,$link);
				$row_pro = mysql_fetch_array($res_pro);
				if(!$row_pro['num_orden'])
				{	echo "<td><font size=\"1\">&nbsp;ANTES PROGRAME EL CAMBIO</a></font></td>";
					echo "<td><font size=\"1\">&nbsp;ANTES PROGRAME EL CAMBIO</font></td>";
					echo "<td><font size=\"1\">&nbsp;ANTES PROGRAME EL CAMBIO</font></td>";}
				else
				{
					$sql4 = "SELECT * FROM soliccambioejecucion WHERE Codigo='$row1[id_orden]' GROUP BY Codigo";
					$result4 = mysql_db_query($db,$sql4,$link);
					$row4 = mysql_fetch_array($result4);
					if (!$row4['Codigo'])
					{	echo "<td><font size=\"1\">&nbsp;<a href=\"soliccambios4.php?id_orden=".$row1['id_orden']."\">EJECUCION</a></font></td>";
						echo "<td><font size=\"1\">&nbsp;ANTES EJECUTE</font></td>";
						echo "<td><font size=\"1\">&nbsp;ANTES EJECUTE</font></td>";
					}
					else	
					{	echo "<td><font size=\"1\">EJECUTADO</font></td>";	
						$sql5 = "SELECT * FROM soliccambiocontrol WHERE Codigo='$row1[id_orden]' GROUP BY Codigo";
						$result5 = mysql_db_query($db,$sql5,$link);
						$row5 = mysql_fetch_array($result5);
						if (!$row5['Codigo'])
						{	echo "<td><font size=\"1\">&nbsp;<a href=\"soliccambios5.php?id_orden=".$row1['id_orden']."\">CONTROL</a></font></td>";
							echo "<td><font size=\"1\">&nbsp;ANTES CONTROLE</font></td>";}
						else 
						{	echo "<td><font size=\"1\">CONTROLADO</font></td>";	
							$sql6 = "SELECT * FROM soliccambiocierre WHERE Codigo='$row1[id_orden]' GROUP BY Codigo";
							$result6 = mysql_db_query($db,$sql6,$link);
							$row6 = mysql_fetch_array($result6);	
							if (!$row6['Codigo'])
							{	echo "<td><font size=\"1\">&nbsp;<a href=\"soliccambios6.php?id_orden=".$row1['id_orden']."\">CIERRE</a></font></td>";}
							else
							{	echo "<td><font size=\"1\">CIERRE</font></td>";}
						}	
					}
				}
			}
		}
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"acp_file.php?id_orden=".$row1['id_orden']."\"><img src=\"images/page.gif\" border=\"0\" alt=\"Adjuntar\"></a></font></td>";
		if ($tipo=="A" or $tipo=="B")
		{echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"soliccambios1_last.php?id_orden=".$row1['id_orden']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";		}
		if ($row3_0['Codigo'])
		{
			echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"ver_soliccambiosdatos.php?id_orden=".$row1['id_orden']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
		}
		else
		{
			echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><img src=\"images/imprimir_no.gif\" border=\"0\" alt=\"Imprimir\"></font></td>";
		}
	}
}
echo "</tr>";
?>
      </table></td>
  </tr>
</table>
  
<br>
<table width="85%" border="0" align="center">
  <tr> 
    <td> <div align="center"><strong><font size="2">Pagina(s) :&nbsp; 
<?php
//La idea es pasar tambi�n en los enlaces las variables hayan llegado por url.
$_pagi_enlace = $_SERVER['PHP_SELF'];
$_pagi_query_string = "?";
if(isset($_GET)){
	//Si ya se han pasado variables por url, escribimos el query string concatenando
	//los elementos del array $_GET excepto la variable $_GET['pg'] si es que existe.
	$_pagi_variables = $_GET;
	foreach($_pagi_variables as $_pagi_clave => $_pagi_valor){
		if($_pagi_clave != 'pg'){
			$_pagi_query_string .= $_pagi_clave."=".$_pagi_valor."&";
		}
	}
}

//Anadimos el query string a la url.
$_pagi_enlace .= $_pagi_query_string;

//La variable $_pagi_navegacion contendr� los enlaces a las p�ginas.
$_pagi_navegacion = '';

if ($_pagi_actual != 1){
	//Si no estamos en la p�gina 1. Ponemos el enlace "anterior"
	$_pagi_url = $_pagi_actual - 1;//ser� el numero de p�gina al que enlazamos
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."'>&laquo; Anterior</a>&nbsp;";
}
//Enlaces a numeros de p�gina:
for ($_pagi_i = 1; $_pagi_i<=$_pagi_totalPags; $_pagi_i++){//Desde p�gina 1 hasta ultima p�gina ($_pagi_totalPags)
    if ($_pagi_i == $_pagi_actual) {
		//Si el numero de p�gina es la actual ($_pagi_actual). Se escribe el numero, pero sin enlace y en negrita.
        $_pagi_navegacion .= "<b>&nbsp;$_pagi_i&nbsp;</b>";
    }else{
		//Si es cualquier otro. Se escibe el enlace a dicho numero de p�gina.
        $_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."'>".$_pagi_i."</a>&nbsp;";
    }
}

if ($_pagi_actual < $_pagi_totalPags){
	//Si no estamos en la ultima p�gina. Ponemos el enlace "Siguiente"
    $_pagi_url = $_pagi_actual + 1;//ser� el numero de p�gina al que enlazamos
    $_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."'>Siguiente &raquo;</a>";
}
print $_pagi_navegacion;
//Hasta ac� hemos completado la "barra de navegacion"
?>
</font></strong> <font size="2"><strong>&nbsp;</strong></font></div></td>
  </tr>
</table>
<form name="form1" method="post" action="">
  <div align="center"> 
    <input name="ESTADISTICAS" type="button" id="ESTADISTICAS" value="ESTADISTICAS" onClick="openStat_3()">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
  </div>
</form>
<?php } include("top_.php");?>
<script language="JavaScript">
<!--
function openStat_3() {
	window.open("report_soliccambios.php",'Estad�sticas', 'width=590,height=315,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
-->
</script>
</body>
</html>