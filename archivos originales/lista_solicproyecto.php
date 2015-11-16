<?php
// version: 	1.0
// Tipo: 		Perfectivo, Correctivo
// Objetivo:	Control acceso directo No autorizado.
//				Modificacion funciones php obsoletas para version 5.3
// Fecha:		22/NOV/2012 
// Autor:		Cesar Cuenca
//____________________________________________________________________________
@session_start();

if (isset($_SESSION['login'])){
	if (isset($_SESSION['tipo']) && $_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
else{
	header('location:login.php');
}
$tipo=$_SESSION["tipo"];
if (isset($RETORNAR)){echo "<script type=\"text/javascript\">
           history.go(-2);
       </script>";}
if (isset($NueFicha))
{ 	include ("conexion.php");
	$sql2 = "SELECT MAX(Codigo) AS Cod FROM solicproydatos";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$Co=$row2['Cod']+1;
	header("location: solicproyecto1.php?Codigo=$Co");
}
else 
{ include ("top.php");
 
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num","Codigo de solicitud de proyecto");
	print $help->ToHtml();
?>

<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top">
	<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th background="images/main-button-tileR1.jpg" colspan="11">LISTA DE SOLICITUD DE PROYECTOS</th>
        </tr>
        <tr align=\"center\"> 
		  <th class="menu" background="images/main-button-tileR2.jpg" rowspan="2" width="3%"><?php print $help->AddLink("num", "COD."); ?></th>
  		  <th class="menu" background="images/main-button-tileR2.jpg" rowspan="2">REQUERIMIENTO</th>
		  <th class="menu" background="images/main-button-tileR2.jpg" rowspan="2" width="20%">LIDER DEL PROYECTO</th>
 		  <th class="menu" background="images/main-button-tileR2.jpg" rowspan="2">DESCRIPCION DEL PROYECTO</th>
  		  <th class="menu" background="images/main-button-tileR2.jpg" rowspan="2">FECHA SOLICITADA</th>
  		  <th class="menu" background="images/main-button-tileR2.jpg" colspan="4">FASES DEL PROYECTO</th>
           <?php if ($tipo=="A" or $tipo=="B") {?>
  		  <th class="menu" background="images/main-button-tileR2.jpg" rowspan="2">MODIFICAR</th>
			<?php }?>
  		  <th class="menu" background="images/main-button-tileR2.jpg" rowspan="2">IMPRIMIR</th>
		  </tr>
		  <tr align="center">
		  <th class="menu" background="images/main-button-tileR2.jpg">PLANIFICACION</th>
  		  <th class="menu" background="images/main-button-tileR2.jpg">EJECUCION</th>
  		  <th class="menu" background="images/main-button-tileR2.jpg" >CONTROL</th>
  		  <th class="menu" background="images/main-button-tileR2.jpg">CIERRE</th>
		  </tr>
        <?php
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM solicproydatos";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

$sql = "SELECT *, DATE_FORMAT(FechSolic, '%d/%m/%Y') AS FechSolic FROM solicproydatos ORDER BY Codigo DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)) 
{
  	echo "<tr align=\"center\">";
	echo '<td><font size="1">&nbsp;'.$row['Codigo'].'</font></td>';
	echo "<td><font size=\"1\">&nbsp;$row[Requerimiento]</font></td>";
	$sql2 = "SELECT * FROM users WHERE login_usr='$row[LiderProyecto]'";
	$result2 = mysql_query($sql2);
	$row2 = mysql_fetch_array($result2); 
	echo "<td align=\"center\"><font size=\"1\">&nbsp;$row2[nom_usr] $row2[apa_usr] $row2[ama_usr]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[DescProyecto]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[FechSolic]</font></td>";
		
	$sql3 = "SELECT * FROM solicproyplanif WHERE Codigo='".$row['Codigo']."' GROUP BY Codigo";
    $result3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($result3);
	if (!$row3['Codigo'])
	{	echo "<td><font size=\"1\">&nbsp;<a href=\"solicproyecto3.php?Codigo=".$row['Codigo']."\">PLANIFICACION</a></font></td>";
		echo "<td><font size=\"1\">&nbsp;ANTES PLANIFIQUE</font></td>";
		echo "<td><font size=\"1\">&nbsp;ANTES PLANIFIQUE</font></td>";
		echo "<td><font size=\"1\">&nbsp;ANTES PLANIFIQUE</font></td>";}
	else
	{	echo "<td><font size=\"1\">PLANIFICADO</font></td>";	
		$sql4 = "SELECT * FROM solicproyejecucion WHERE Codigo='".$row['Codigo']."' GROUP BY Codigo";
	    $result4 = mysql_query($sql4);
		$row4 = mysql_fetch_array($result4);
		if (!$row4['Codigo'])
		{	echo "<td><font size=\"1\">&nbsp;<a href=\"solicproyecto4.php?Codigo=".$row['Codigo']."\">EJECUCION</a></font></td>";
			echo "<td><font size=\"1\">&nbsp;ANTES EJECUTE</font></td>";
			echo "<td><font size=\"1\">&nbsp;ANTES EJECUTE</font></td>";}
		else	
		{	echo "<td><font size=\"1\">EJECUTADO</font></td>";	
			$sql5 = "SELECT * FROM solicproycontrol WHERE Codigo='".$row['Codigo']."' GROUP BY Codigo";
		    $result5 = mysql_query($sql5);
			$row5 = mysql_fetch_array($result5);
			if (!$row5['Codigo'])
			{	echo "<td><font size=\"1\">&nbsp;<a href=\"solicproyecto5.php?Codigo=".$row['Codigo']."\">CONTROL</a></font></td>";
				echo "<td><font size=\"1\">&nbsp;ANTES CONTROLE</font></td>";}
			else 
			{	echo "<td><font size=\"1\">CONTROLADO</font></td>";	
				$sql6 = "SELECT * FROM solicproycierre WHERE Codigo='".$row['Codigo']."' GROUP BY Codigo";
			    $result6 = mysql_query($sql6);
				$row6 = mysql_fetch_array($result6);	
				if (!$row6['Codigo'])
				{	echo "<td><font size=\"1\">&nbsp;<a href=\"solicproyecto6.php?Codigo=".$row['Codigo']."\">CIERRE</a></font></td>";}
				else
				{	echo "<td><font size=\"1\">CIERRE</font></td>";}
			}	
		}	
	}		
if ($tipo=="A" or $tipo=="B")
{echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"solicproyecto1_last.php?Codigo=".$row['Codigo']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";}
echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"ver_solicproydatos.php?variable=".$row['Codigo']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
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
//La idea es pasar también en los enlaces las variables hayan llegado por url.
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

//La variable $_pagi_navegacion contendrá los enlaces a las páginas.
$_pagi_navegacion = '';

if ($_pagi_actual != 1){
	//Si no estamos en la página 1. Ponemos el enlace "anterior"
	$_pagi_url = $_pagi_actual - 1;//será el numero de página al que enlazamos
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."'>&laquo; Anterior</a>&nbsp;";
}
//Enlaces a numeros de página:
for ($_pagi_i = 1; $_pagi_i<=$_pagi_totalPags; $_pagi_i++){//Desde página 1 hasta ultima página ($_pagi_totalPags)
    if ($_pagi_i == $_pagi_actual) {
		//Si el numero de página es la actual ($_pagi_actual). Se escribe el numero, pero sin enlace y en negrita.
        $_pagi_navegacion .= "<b>&nbsp;$_pagi_i&nbsp;</b>";
    }else{
		//Si es cualquier otro. Se escibe el enlace a dicho numero de página.
        $_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."'>".$_pagi_i."</a>&nbsp;";
    }
}

if ($_pagi_actual < $_pagi_totalPags){
	//Si no estamos en la ultima página. Ponemos el enlace "Siguiente"
    $_pagi_url = $_pagi_actual + 1;//será el numero de página al que enlazamos
    $_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."'>Siguiente &raquo;</a>";
}
print $_pagi_navegacion;
//Hasta acá hemos completado la "barra de navegacion"
?>
</font></strong> <font size="2"><strong>&nbsp;</strong></font></div></td>
  </tr>
</table>
<form name="form1" method="post" action="">
  <div align="center">
    <input name="NueFicha" type="submit" id="reg_form3" value="NUEVA FICHA">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input name="ESTADISTICAS" type="submit" id="ESTADISTICAS" value="ESTADISTICAS" onClick="openStat_3()">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
  </div>
</form>
<?php } ?>
<script language="JavaScript">
<!--
function openStat_3() {
	window.open("report_solicproyectos.php",'Estadìsticas', 'width=590,height=300,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
-->
</script>