<?php
session_start();
//ver agendacont

if(isset($_REQUEST['COD'])) header("location: agenda_cod.php");
require_once("funciones.php");
if (valida("Actas")=="bad") {header("location: pagina_error.php");}
if(isset($_REQUEST['US_EXTERNOS'])) header("location: us_externos.php");
if (isset($_REQUEST['RETORNAR'])){header("location: lista_gestion.php?Naveg=Gestion");}
if (isset($_REQUEST['NUEVOREG'])) {header("location: agenda.php?verif=0");}
//codigo para el envio de la agenda de reunion por mail 
//$ejecutar=  ;
if (isset($_REQUEST['ejecutar']) && $_REQUEST['ejecutar']=="enviar_agenda"){
	//echo "ENVIAR EGENDA";
	include ("conexion.php");
	$id_agenda=$_REQUEST['id_agenda'];
	$sql = "SELECT *,DATE_FORMAT(en_fecha,'%d / %m / %Y') as en_fecha,DATE_FORMAT(fecha,'%d / %m / %Y') as fecha FROM agenda  WHERE id_agenda='$id_agenda'";
	$result=mysql_db_query($db,$sql,$link);
	$row=mysql_fetch_array($result);
	
		$consul="SELECT * FROM users WHERE login_usr='$row[elab_por]'";
		$resul=mysql_db_query($db,$consul,$link);
		$fila=mysql_fetch_array($resul);
	
	$mensaje="
NUEVA AGENDA DE REUNION
	
	CODIGO: ";
	$mensaje.=$row['codigo'].
"
	NRO.: ";
	$mensaje.=$row['num_codigo'].
"
	ELABORADO POR: ";
	$mensaje.=$fila['nom_usr']." ". $fila['apa_usr']." ".$fila['ama_usr'].
"
	EN FECHA: ";
	$mensaje.=$row['en_fecha'].
"
	TIPO DE REUNION: ";
	$mensaje.=$row['tipo_reu'].
"
	FECHA DE REUNION: ";
	$mensaje.=$row['fecha'].
"
	HORA DE REUNION: ";
	$mensaje.=$row['hora'].
"
	LUGAR DE REUNION: ";
	$mensaje.=$row['lugar'].
"
";	
	//lista de invitados
	$mensaje.="
LISTA DE INVITADOS
";
	$cont=0;
	$sql2 = "SELECT * FROM invitados WHERE id_agenda=$row[id_agenda]";
	$result2=mysql_db_query($db,$sql2,$link);
	while ($row2=mysql_fetch_array($result2)) 
	{
		$cont++;
		$sql3 = "SELECT * FROM users WHERE login_usr='$row2[nombre]'";
		$result3 = mysql_db_query($db,$sql3,$link);
		$row3 = mysql_fetch_array($result3); 
		if($row3)
		{
		$mensaje.="
	$cont. $row3[nom_usr] $row3[apa_usr] $row3[ama_usr]";
		}
		else
		{
		$mensaje.="
	$cont. $row2[nombre]";
		}
	}
	//temas propuestos
	$mensaje.="
	
TEMAS PROPUESTOS
";
	$sql6= "SELECT * FROM temas WHERE id_agenda=$row[id_agenda]";
	$result6=mysql_db_query($db,$sql6,$link);
	while ($row6=mysql_fetch_array($result6)) 
	{
		$sql7 = "SELECT * FROM users WHERE login_usr='$row6[responsable]'";
		$result7 = mysql_db_query($db,$sql7,$link);
		$row7 = mysql_fetch_array($result7); 
		if($row7)
		{
		$mensaje.="
	$row6[id_tema]. TEMA: $row6[tema] RESPONSABLE: $row7[nom_usr] $row7[apa_usr] $row7[ama_usr] DURACION: $row6[duracion]";
		}
		else
		{
		$mensaje.="
	$row6[id_tema]. TEMA: $row6[tema] RESPONSABLE: $row6[responsable] DURACION: $row6[duracion]";
		}
	}
	//comentarios
	$mensaje.="
	
COMENTARIOS
";
	$mensaje.="
	$row[comentario]

";	
	//codigo para el envio del mail
	$sql5="SELECT * FROM invitados WHERE id_agenda=$row[id_agenda]";
	$result5=mysql_db_query($db,$sql5,$link);
	
	//
	$lista="";
	$fallas="";
	while ($row5=mysql_fetch_array($result5)){
		$sql8="SELECT * FROM users WHERE login_usr='$row5[nombre]'";
		
		$result8=mysql_db_query($db,$sql8,$link);
		$row8=mysql_fetch_array($result8);
		$nombre=$row8['nom_usr']." ".$row8['apa_usr']." ".$row8['ama_usr']; 
		$sql9="SELECT * FROM control_parametros";
		$result9=mysql_db_query($db,$sql9,$link);
		$row9=mysql_fetch_array($result9);		
		
		//--------------------------------------------------------------------
		if (!(empty($row8['email'])))
		{	//echo $row8['email'];
			//exit;
			$asunto = "Nro. $row[num_codigo]. Nueva Agenda de Reunion";	
			$mail = $row8['email'];
			if(!mail($mail,$asunto,$mensaje))
			{ $fallas.= $nombre.", ";
				
			}																
			else
			{ $lista.= $nombre.", "; }
		}
		else {$fallas.=$nombre.", ";}
		//---------------------------------		
	}
	if (empty($fallas))
	$msg = "Se envio correctamente el correo de agenda de reunion a todos los invitados.";
	else
	$msg = "Se han enviado los correos correctamente, excepto a: $fallas posiblemente la direccion es erronea";
}
//codigo para el envio de la minuta por mail 
if (isset($_REQUEST['ejecutar']) && $_REQUEST['ejecutar']=="enviar_minuta"){
	if(isset($_GET['id_minuta']))
		$id_minuta=$_GET['id_minuta'];
	else
		$id_minuta=0;
	include ("conexion.php");
	$sql = "SELECT *,DATE_FORMAT(en_fecha,'%d / %m / %Y') as en_fecha,DATE_FORMAT(fecha,'%d / %m / %Y') as fecha FROM minuta  WHERE id_minuta='$id_minuta'";
	$result=mysql_db_query($db,$sql,$link);
	$row=mysql_fetch_array($result);
	
		$consul="SELECT * FROM users WHERE login_usr='$row[elab_por]'";
		$resul=mysql_db_query($db,$consul,$link);
		$fila=mysql_fetch_array($resul);
	
	$mensaje="
NUEVA MINUTA DE REUNION
	
	CODIGO: ";
	$mensaje.=$row['codigo'].
"
	ELABORADO POR: ";
	$mensaje.=$fila['nom_usr']." ". $fila['apa_usr']." ".$fila['ama_usr'].
"
	EN FECHA: ";
	$mensaje.=$row['en_fecha'].
"
	TIPO DE REUNION: ";
	$mensaje.=$row['tipo_min'].
"
	FECHA DE REUNION: ";
	$mensaje.=$row['fecha'].
"
	HORA DE REUNION: ";
	$mensaje.=$row['hora'].
"
	LUGAR DE REUNION: ";
	$mensaje.=$row['lugar'].
"
";	
	//asistentes
	$mensaje.="
ASISTENTES
";
	$cont=0;
	$sql2 = "SELECT * FROM asistentes WHERE id_minuta=$row[id_minuta]";
	$result2=mysql_db_query($db,$sql2,$link);
	while ($row2=mysql_fetch_array($result2)) 
	{
		$cont++;
		$sql3 = "SELECT * FROM users WHERE login_usr='$row2[nombre]'";
		$result3 = mysql_db_query($db,$sql3,$link);
		$row3 = mysql_fetch_array($result3); 
		if($row3)
		{
		$mensaje.="
	$cont. $row3[nom_usr] $row3[apa_usr] $row3[ama_usr]";
		}
		else
		{
		$mensaje.="
	$cont. $row2[nombre]";
		}
	}
	//temas discutidos
	$mensaje.="
	
TEMAS DISCUTIDOS
";
	$sql6= "SELECT * FROM temad WHERE id_minuta=$row[id_minuta]";
	$result6=mysql_db_query($db,$sql6,$link);
	while ($row6=mysql_fetch_array($result6)) 
	{
		$sql10 = "SELECT * FROM temas WHERE id_tema='$row6[tema]'  AND id_agenda='$row[id_minuta]'";
		$result10 = mysql_db_query($db,$sql10,$link);
		$row10 = mysql_fetch_array($result10);
		if (!$row10['id_tema'])
		{
		$mensaje.="
	$row6[id_tema]. TEMA: $row6[tema] ";
		}
		else
		{
		$mensaje.="
	$row6[id_tema]. TEMA: $row10[tema] ";
		}
		$sql7 = "SELECT * FROM users WHERE login_usr='$row6[responsable]'";
		$result7 = mysql_db_query($db,$sql7,$link);
		$row7 = mysql_fetch_array($result7); 
		if($row7)
		{
		$mensaje.="RESPONSABLE: $row7[nom_usr] $row7[apa_usr] $row7[ama_usr] DURACION: $row6[duracion]";
		}
		else
		{
		$mensaje.="RESPONSABLE: $row6[responsable] DURACION: $row6[duracion]";
		}
	}
	//resultados por tema
	$mensaje.="
	
RESULTADOS POR TEMA
";
	$sql11 = "SELECT * FROM rtema WHERE id_minuta=$row[id_minuta]";
	$result11 = mysql_db_query($db,$sql11,$link);
	while ($row11 = mysql_fetch_array($result11)){
	$mensaje.="
	$row11[id_tema]. $row11[resultado]";
	}
	//acciones por tema
	$mensaje.="
	
ACCIONES POR TEMA
";
	$sql14 = "SELECT *, DATE_FORMAT(flimite, '%d/%m/%Y') AS flimite FROM atema WHERE id_minuta=$row[id_minuta]";
	$result14=mysql_db_query($db,$sql14,$link);
	while ($row14=mysql_fetch_array($result14)) 
	{
		$mensaje.="
	$row14[id_tema]. ACCION: $row14[accion] ";
		$sql3 = "SELECT * FROM users WHERE login_usr='$row14[responsable]'";
		$result3 = mysql_db_query($db,$sql3,$link);
		$row3 = mysql_fetch_array($result3); 
		if($row3)
		{
		$mensaje.="RESPONSABLE: $row3[nom_usr] $row3[apa_usr] $row3[ama_usr] ";
		}
		else
		{
		$mensaje.="RESPONSABLE: $row14[responsable] ";
		}
		$mensaje.="FECHA LIMITE: $row14[flimite] ";
	}
	//codigo para el envio del mail
	$lista="";
	$fallas="";
	$sql5="SELECT * FROM asistentes WHERE id_minuta=$row[id_minuta]";
	$result5=mysql_db_query($db,$sql5,$link);
	while ($row5=mysql_fetch_array($result5)){
		$sql8="SELECT * FROM users WHERE login_usr='$row5[nombre]'";
		$result8=mysql_db_query($db,$sql8,$link);
		$row8=mysql_fetch_array($result8);
		$nombre=$row8['nom_usr']." ".$row8['apa_usr']." ".$row8['ama_usr']; 
		$sql9="SELECT * FROM control_parametros";
		$result9=mysql_db_query($db,$sql9,$link);
		$row9=mysql_fetch_array($result9);
		//----------------------------------------------------------
		if (!(empty($row8['email'])))
		{	$asunto = "Nro. $id_minuta. Nueva Minuta de Reunion";	
			$mail = $row8['email'];
			if(!mail($mail,$asunto,$mensaje))
			{ $fallas.= $nombre.", ";}																
			else
			{ $lista.= $nombre.", "; }
		}
		else {$fallas.=$nombre.", ";}
		//---------------------------------
		
	}
	if (empty($fallas))
	$msg = "Se envio correctamente el correo de minuta de reunion a todos los invitados.";
	else
	$msg = "Se han enviado los correos correctamente, excepto a: $fallas posiblemente la direccion es erronea";	
}
include ("top.php");
include_once ("help.class.php");
$help=new Help();
$help->AddHelp("num","Numero");
print $help->ToHtml();
//*********ver id_minuta por migracion
/*if(isset($row['id_agenda']))
	;
else*/
	

//
?>
<script language="JavaScript">
<!--
var win1;
function acerca(num) {
	win1=window.open('minuta_file.php?num='+num,'Limberg','toolbar=no,status=no,menubar=no,location=no,directories=no,resizable=no,scrollbars=no,width=780,height=234,left=150,top=150');
}
-->
</script>
<table width="100%" border="3" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg" >
   <tr> 
         <th colspan="14">LISTA DE AGENDA / MINUTA DE REUNION</th>
    </tr>
        <tr align="center"> 
  		  <th class="menu">FECHA</th>
   		  <th class="menu">CODIGO</th>
   		  <th class="menu"><?php print $help->AddLink("num", "Nro");?></th>
   		  <th class="menu">ELABORADO POR</th>
  		  <th class="menu">TIPO DE REUNION</th>
   		  <th class="menu">LUGAR</th>
          <?php if ($tipo=="A" or $tipo=="B") {?>
   		  <th class="menu" width="6%">MODIFICAR REUNION</th>
   		  <th class="menu" width="5%">ENVIAR ACTA</th>
		  <?php }?>
		  <th class="menu" width="6%">IMPRIMIR REUNION</th>
		  <th class="menu" width="6%">LLENAR MINUTA</th>
          <?php if ($tipo=="A" or $tipo=="B") {?>
		  <th class="menu" width="6%">MODIFICAR MINUTA</th>
   		  <th class="menu" width="5%">ENVIAR MINUTA</th>
		  <?php }?>
		  <th class="menu" width="6%">IMPRIMIR MINUTA</th>
  		  <th class="menu" width="6%">ADJUNTAR ARCHIVOS</th>
		  </tr>
        <?php
    $sql11 = "SELECT num_ord_pag FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM agenda";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
$sql = "SELECT *, DATE_FORMAT(en_fecha, '%d/%m/%Y') AS en_fecha FROM agenda ORDER BY id_agenda DESC LIMIT $_pagi_inicial,$_pagi_cuantos"; 
$result=mysql_db_query($db,$sql,$link);
while ($row=mysql_fetch_array($result)) 
{
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\">&nbsp;$row[en_fecha]</font></td>";
	$sql_cod1="SELECT agenda_desc FROM agenda_cod WHERE agenda_cod='$row[codigo]' ORDER BY agenda_cod";
	$res_cod1=mysql_db_query($db,$sql_cod1,$link);
	$row_cod1=mysql_fetch_array($res_cod1);
	echo "<td><font size=\"1\">&nbsp;$row[codigo] ($row_cod1[agenda_desc])</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[num_codigo]</td>";
		$sql7="SELECT * FROM users WHERE login_usr='$row[elab_por]'";
		$result7=mysql_db_query($db,$sql7,$link);
		$row7=mysql_fetch_array($result7);	
	echo "<td><font size=\"1\">&nbsp;$row7[nom_usr] $row7[apa_usr] $row7[ama_usr]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[tipo_reu]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[lugar]</font></td>";	
		
	$sql3 = "SELECT * FROM agenda WHERE id_agenda='$row[id_agenda]'";
    $result3 = mysql_db_query($db,$sql3,$link);
	$row3 = mysql_fetch_array($result3);
	if ($tipo=="A" or $tipo=="B")
	{echo "<td><font size=\"1\">&nbsp;<a href=\"agenda_last.php?verif=0&id_agenda=$row[id_agenda]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar Reunion\"></a></font></td>";	
	echo "<td valign=\"middle\"><a href=\"lista_agenda.php?ejecutar=enviar_agenda&id_agenda=$row[id_agenda]\"><img src=\"images/enviar.jpg\" border=\"0\" alt=\"Enviar\"></a>&nbsp;</td>";
	}
	echo "<td><font size=\"1\">&nbsp;<a href=\"ver_agenda.php?variable=$row[id_agenda]\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Reunion\"></a></font></td>";	
	$sql4 = "SELECT * FROM minuta WHERE id_minuta='$row[id_agenda]' ";
    $result4 = mysql_db_query($db,$sql4,$link);
	$row4 = mysql_fetch_array($result4);
	if (!$row4['id_minuta'])
		{	echo "<td><font size=\"1\">&nbsp;<a href=\"minuta.php?verif=0&id_minuta=$row[id_agenda]\">MINUTA</a></font></td>";}
		else	
		{	echo "<td><font size=\"1\">LLENADO</font></td>";}	
	// parte valida id_munuta
	if(isset($row['id_minuta']))
	{	$sql3 = "SELECT * FROM minuta WHERE id_minuta='$row[id_minuta]' GROUP BY id_minuta";
	//echo $sql3;
    	$result3 = mysql_db_query($db,$sql3,$link);
		$row3 = mysql_fetch_array($result3);
	}
		
if ($row4['id_minuta'])
		{
		if ($tipo=="A" or $tipo=="B")
		{echo "<td><font size=\"1\">&nbsp;<a href=\"minuta_last.php?verif=0&id_minuta=$row[id_agenda]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar Minuta\"></a></font></td>";
		echo "<td valign=\"middle\"><a href=\"lista_agenda.php?ejecutar=enviar_minuta&id_minuta=$row4[id_minuta]\"><img src=\"images/enviar.jpg\" border=\"0\" alt=\"Enviar\"></a>&nbsp;</td>";
		echo "<td><font size=\"1\">&nbsp;<a href=\"ver_minuta1.php?variable=$row4[id_minuta]\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Minuta\"></a></font></td>";}
		else
		{echo "<td><font size=\"1\">&nbsp;<a href=\"ver_minuta1.php?variable=$row4[id_minuta]\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Minuta\"></a></font></td>";}}
else
		{if ($tipo=="A" or $tipo=="B")
			{echo "<td><font size=\"1\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar Minuta\"></font></td>";
			echo "<td valign=\"middle\"><img src=\"images/enviar.jpg\" border=\"0\" alt=\"Enviar\">&nbsp;</td>";
			echo "<td><font size=\"1\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Minuta\"></font></td>";}
			else
			{echo "<td><font size=\"1\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Minuta\"></font></td>";}
		}	
		
		if ($row['file']==""){
			echo "<td><a href=\"minuta_file.php?num=$row[num_codigo]&id_agenda=$row[id_agenda]\">ADJUNTAR</a></td>";
		}
		else {
			echo "<td><a href=\"minuta_file.php?num=$row[num_codigo]&id_agenda=$row[id_agenda]\">ADJUNTADOS</a></td>";
//			echo "<td><a href=\"archivos adjuntos/".$row[file]."\" target=\"_blank\">$row[file]</a></td>";
		}
		
		echo "</tr>\n";}
?>
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
    <input name="NUEVOREG" type="submit" id="reg_form3" value="NUEVA AGENDA DE REUNION">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input name="US_EXTERNOS" type="submit" id="NUEVOREG" value="USUARIOS EXTERNOS">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="ESTADISTICAS" type="button" onClick="estad()" id="NUEVOREG" value="ESTADISTICAS">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="IMPRIMIR" type="button" onClick="impre()" id="NUEVOREG1" value="IMPRIMIR">
  </div>
</form>
<script language="JavaScript">
<!-- 
function estad(){
	open("agenda_estadisticas_pre.php",'Estadísticas', 'width=580,height=210,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes')
}
function impre(){
	open('agenda_impresion_pre.php','Estadísticas', 'width=580,height=210,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes')
}
<?php
	if (isset($msg)) {
	print "var msg=\"$msg\";\n";
	print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
	} 
?>
//-->
</script>
<?php include("top_.php"); ?> 