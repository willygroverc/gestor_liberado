<?php
// Version: 	1.0
// Objetivo:	Modificaci�n de funciones php obsoletas para version 5.3 
//
// Autor:		Cesar Cuenca
// Fecha:		20/Nov/12
//__________________________________________________________________________
// Version:		2.0
// Autor:		Alvaro ROdriguez
// Objetivo:	Se ha corrgido el vista de los caracteres especiales y 
// 				se ha cambiado el formato de fecha.
//_________________________________________________________________________________
@session_start();
header('Content-Type: text/html; charset=iso-8859-1');
$login=$_SESSION["login"];
$tipo=$_SESSION["tipo"];
echo 'Usuario logueado: '.$login;
echo '<br>';
echo 'Usuario Tipo: '.$tipo;
if (!isset($login)) {
	header("location: index.php"); 
}
require("conexion.php");
?>
<!-----------------------------------------------Funciones java script--------------------------------------------------------->
<script language="javascript1.2">
function mostrar()
{
	color = document.frmAdd.color.value;
	if(color == 3)
	{
		document.all("background").style.display = "";
		document.all("bgcolor").style.display = "";
	}
	else{
		document.all("background").style.display = "none";
		document.all("bgcolor").style.display = "none";
		if(color == 2){
			document.all("bgcolor").style.display = "";
			document.all("paleta").style.display = "";
			//document.all("boton").style.display = "none";
		}else{
			document.all("bgcolor").style.display = "none";
			document.all("paleta").style.display = "none";
			//document.all("boton").style.display = "";
			if(color == 1){
				document.all("background").style.display = "";
			}else{
				document.all("background").style.display = "none";
			}
		}
	} 
}
//Funci�n para habilitar colores
 lck=0;
	function r(hval)
    {
        if ( lck == 0 )
        {  
           document.frmAdd.bgcolor.value=hval;
		   document.bgColor=hval;
        }
    }
        
    function l(){
         if (lck == 0){lck = 1;}
         else{lck = 0;}
     }
</script>

<!-----------------------------------------------Fin java script--------------------------------------------------------->
<?php 
$sql2 = "SELECT * FROM users WHERE login_usr='$login'";	
$result2 = mysql_query($sql2);
$row2 = mysql_fetch_array($result2);

if ($row2['tipo2_usr']=="T" OR $row2['tipo2_usr']=="A" OR $row2['tipo2_usr']=="B")
{
	//NUMERO DE ORDENES TOTALES
	$sql1 = "SELECT DISTINCT(id_orden), MAX(id_asig) FROM asignacion WHERE asig='$login' GROUP BY id_orden";
	$rs1=mysql_query($sql1);
	$numAsig=0;
	while ($tmp=mysql_fetch_array($rs1))  {			
		$sql1 = "SELECT id_orden, id_asig, asig FROM asignacion WHERE id_orden=".$tmp['id_orden']." ORDER BY id_asig DESC";
		$rsTmp=mysql_fetch_array(mysql_query($sql1));
		if ($rsTmp["asig"]==$login) {
			$total[$numAsig]=$rsTmp['id_orden'];
			$numAsig++;
		}
	}
	$row[0]=$numAsig;
	$row['numtot']=$numAsig;
	
	//NUMERO DE ORDENES CON SOLUCION
		$solu=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql3="SELECT id_orden FROM solucion WHERE id_orden='$total[$i]'";
			$row3 = mysql_fetch_array(mysql_query($sql3));
			if ($row3['id_orden']==$total[$i]) {
			$solu++;}
		}
		$row3['solu']=$solu;	
		
	//NUMERO DE ORDENES SIN SOLUCION
	if ($row['numtot']>$row3['solu'])
		{$nosolu=$row['numtot']-$row3['solu'];}
	else
		{$nosolu=0;}
	//NUMERO DE ORDENES CON CONFORMIDAD DEL CLIENTE
	$numConf=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql = "SELECT id_orden FROM conformidad WHERE id_orden='$total[$i]'";
		$rsTmp3=mysql_fetch_array(mysql_query($sql));
		if ($rsTmp3['id_orden']==$total[$i]){
		$numConf++;}
	}
	$row5['conf']=$numConf;
 		
 	//NUMERO DE ORDENES SIN CONFORMIDAD DEL CLIENTE
	if ($row['numtot']>$row5['conf'])
		{$noconf=$row['numtot']-$row5['conf'];}
	else
		{$noconf=0;}
	//NUMERO DE ORDENES CON CONFORMIDAD DEL TECNICO
		//NUMERO TOTAL DE ORDENES
		$sql6 = "SELECT DISTINCT(id_orden) FROM ordenes,users WHERE ordenes.cod_usr=users.login_usr AND users.login_usr='$login'";
		$rs6=mysql_query($sql6);
		$numAsig=0;
		while ($tmp=mysql_fetch_array($rs6))  {			
				$total[$numAsig]=$tmp['id_orden'];
				$numAsig++;
		}
		$row6[0]=$numAsig;
		$row6['numtot']=$numAsig;
	
	$numConf=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql = "SELECT id_orden FROM conformidad WHERE id_orden='$total[$i]'";
		$rsTmp3=mysql_fetch_array(mysql_query($sql));
		if ($rsTmp3['id_orden']==$total[$i]){
		$numConf++;}
	}
	$row7['conftec']=$numConf;
	
	//NUMERO DE ORDENES SIN CONFORMIDAD DEL TECNICO
	$noconftec=$row6['numtot']-$row7['conftec'];
	
}
else
{
	//NUMERO TOTAL DE ORDENES
	$sql6 = "SELECT DISTINCT(id_orden) FROM ordenes,users WHERE ordenes.cod_usr=users.login_usr AND users.login_usr='$login'";
	$rs6=mysql_query($sql6);
	$numAsig=0;
	while ($tmp=mysql_fetch_array($rs6))  {			
			$total[$numAsig]=$tmp['id_orden'];
			$numAsig++;
	}
	$row6[0]=$numAsig;
	$row6['numtot']=$numAsig;
	
	//NUMERO DE ORDENES CON SOLUCION
	$solu=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql4="SELECT id_orden FROM solucion WHERE id_orden='$total[$i]'";
		$row4 = mysql_fetch_array(mysql_query($sql4));
		if ($row4['id_orden']==$total[$i]) {
		$solu++;}
	}
	$row8['solu']=$solu;	
	
	//NUMERO DE ORDENES SIN SOLUCION
	$nosolu=$row6['numtot']-$row8['solu'];
	
	//NUMERO DE ORDENES CON CONFORMIDAD DEL CLIENTE
	$numConf=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql = "SELECT id_orden FROM conformidad WHERE id_orden='$total[$i]'";
		$rsTmp3=mysql_fetch_array(mysql_query($sql));
		if ($rsTmp3['id_orden']==$total[$i]){
		$numConf++;}
	}
	$row9['conf']=$numConf;
	
	//NUMERO DE ORDENES SIN CONFORMIDAD DEL CLIENTE
	$noconf=$row6['numtot']-$row9['conf'];
}
?>
<html>
<head>
<title>GesTor F1</title>
<link href="css/validation.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta content="Copyright:" name="YANAPTI-2012 Todos los Derechos Reservados">
</head>
<?php
	$consulta = "select *from fondo where fndActive = 1";
	$resultado = mysql_query($consulta,$link);
	$fila = mysql_fetch_array($resultado);
	$valor = $fila['fndValor'];
	$colores = $fila['fndCampo'];
?>
<body>
<script type="text/javascript">var MenuLinkedBy="AllWebMenus [4]",awmMenuName="cabecera",awmBN="706";awmAltUrl="";</script><script charset="UTF-8" src="cabecera.js" type="text/javascript"></script><script type="text/javascript">awmBuildMenu();</script>
<?php
  if ($tipo=="A")
  {
echo "<script type=\"text/javascript\">var MenuLinkedBy=\"AllWebMenus [4]\",awmMenuName=\"menua1\",awmBN=\"706\";awmAltUrl=\"\";</script><script charset=\"UTF-8\" src=\"menuadm.js\" type=\"text/javascript\"></script><script type=\"text/javascript\">awmBuildMenu();</script>";
}else if ($tipo=="D")
{
echo "<script type=\"text/javascript\">var MenuLinkedBy=\"AllWebMenus [4]\",awmMenuName=\"menua1\",awmBN=\"706\";awmAltUrl=\"\";</script><script charset=\"UTF-8\" src=\"menuadd.js\" type=\"text/javascript\"></script><script type=\"text/javascript\">awmBuildMenu();</script>";
}else if ($tipo=="T")
{
echo "<script type=\"text/javascript\">var MenuLinkedBy=\"AllWebMenus [4]\",awmMenuName=\"menuatec\",awmBN=\"706\";awmAltUrl=\"\";</script><script charset=\"UTF-8\" src=\"menutec.js\" type=\"text/javascript\"></script><script type=\"text/javascript\">awmBuildMenu();</script>";
}else if ($tipo=="C")
{
echo "<script type=\"text/javascript\">var MenuLinkedBy=\"AllWebMenus [4]\",awmMenuName=\"menucli\",awmBN=\"706\";awmAltUrl=\"\";</script><script charset=\"UTF-8\" src=\"menucli.js\" type=\"text/javascript\"></script><script type=\"text/javascript\">awmBuildMenu();</script>";
}
?>

<?php 
	include_once ("help.class.php");
	$help=new Help();
	$help->AddJsFunction();
	$help->AddHelp("faq","AYUDA, PREGUNTAS Y RESPUESTAS FRECUENTES ACERCA DEL SISTEMA.");
	$help->AddHelp("gestion","PROCEDIMIENTOS DE DIRECCION Y ADMINISTRACION DE TECNOLOGIA");
	$help->AddHelp("soporte","PROCEDIMIENTOS DE ADMINISTRACION DEL SOPORTE TECNICO.");
	$help->AddHelp("desarrollo","PROCEDIMIENTOS DE ADMINISTRACION DEL DESARROLLO Y MANTENIMIENTO.");
	$help->AddHelp("produccion","PROCEDIMIENTOS DE ADMINISTRACION DEL PROCESAMIENTO DE DATOS");
	$help->AddHelp("problemas","PROCEDIMIENTOS DE ADMINISTRACION DE PROBLEMAS E INCIDENTES");
	$help->AddHelp("contingencia","PROCEDIMIENTOS DE ADMINISTRACION DEL PLAN DE CONTINGENCIAS");
	$help->AddHelp("seguridad","PROCEDIMIENTOS DE ADMINISTRACION DE LA SEGURIDAD DE LA INFORMACION");
	$help->AddHelp("cambios","PROCEDIMIENTOS DE ADMINISTRACION DE CAMBIOS EN PRODUCCION");
	print $help->ToHtml();
 ?>
<center>
  
    <?php 
	echo '<table width="970" height="32" border="1" cellspacing="0" align="center" background="images/main-button-tile.jpg">';
	echo '<tr>';
	if ($row2['tipo2_usr']=="T" OR $row2['tipo2_usr']=="A" OR $row2['tipo2_usr']=="B"){
	
		echo '<td width="18%" align="left"><font color="#FFFFFF" size="1"><b>Usuario: '.$row2['login_usr'].'</b></font></td>';
		echo '<td width="21%" align="left"><font color="#FFFFFF" size="1"><b>Pendientes de soluci�n: '.$nosolu.'</b></font></td>';
		echo '<td width="29%" align="left"><font color="#FFFFFF" size="1"><b>Pendientes de conformidad del cliente: '.$noconf.'</b></font></td>';
		if ($row2['tipo2_usr']=="A" OR $row2['tipo2_usr']=="B")
			echo '<td width="33%" align="left"><font color="#FFFFFF" size="1"><b>Pendientes de conformidad del administrador: '.$noconftec.'</b></font></td>';
		if ($row2['tipo2_usr']=="T")
			echo '<td width="33%"align="left"><font color="#FFFFFF" size="1"><b>Pendientes de conformidad del t�cnico: '.$noconftec.'</b></font></td>';
	}
	else{
		echo '<td width="20%" align="left"><font color="#FFFFFF" size="1"><b>Usuario: '.$row2['login_usr'].'</b></font></td>';
		echo '<td width="40%" align="left"><font color="#FFFFFF" size="1"><b>Ordenes de trabajo pendientes de soluci�n: '.$nosolu.'</b></font></td>';
		echo '<td width="40%"align="left"><font color="#FFFFFF" size="1"><b>Ordenes de trabajo pendientes de conformidad: '.$noconf.'</b></font></td>';
	}
	?>
	
<table width="970" height="81" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width="222" height="82" align="right" valign="middle">
			<img src="images/imagen_ins.jpg" alt="Yanapti" width="222" height="81">
		</td>
		<td width="747" valign="top">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/bannerTI.jpg">
				<tr>
					<td width="33" height="10"></td>
					<td colspan="2" rowspan="2" align="center" valign="middle"><span class="Estilo5 Estilo1"> </span></td>
					<td width="354"></td>
					<td width="148" valign="top" id="awmAnchor-cabecera"></td>
					<td width="66"></td>
				</tr>
				<tr>
					<td height="35"></td>
					<td></td>
					<td>&nbsp;</td>
					<td></td>
				</tr>
				<tr>
					<td height="22"></td>
					<td width="13"></td>
					<td width="134" valign="top"><span class="Estilo3">  </span></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td height="15"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table width="500" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<?php
		if ($tipo =="A"){
			echo "<td width=\"874\" height=\"0\" valign=\"middle\" id=\"awmAnchor-menuadm\" alignn=\"left\"></td>";
		}
		else  if ($tipo =="D"){
			echo "<td width=\"874\" height=\"0\" valign=\"middle\" id=\"awmAnchor-menuadm\" alignn=\"left\"></td>";
		}
		else if ($tipo=="T"){
			echo "<td width=\"874\" height=\"0\" valign=\"middle\" id=\"awmAnchor-menutec\" alignn=\"left\"></td>";
		}
		else if ($tipo =="C"){
			echo "<td width=\"874\" height=\"0\" valign=\"middle\" id=\"awmAnchor-menucli\" alignn=\"left\"></td>";
		}
		?>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
  </tr>
</table>

</tr>
</table>
</center>

<center>
<br><br><br>
</body>
</html>
<script language="JavaScript">
<!--
function acerca(url_pop) {
		window.open('acercade.php','Yanapti-2012','toolbar=no,status=no,menubar=no,location=no,directories=no,resizable=no,scrollbars=no,width=650,height=275,left=150,top=150');
}
-->
</script>