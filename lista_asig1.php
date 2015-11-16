<?php
include ("top.php");
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num","Numero");
	$help->AddHelp("crit","Criticidad");
	$help->AddHelp("prio","Prioridad");
	$help->AddHelp("estima","Estimacion");
	$help->AddHelp("reg","Registrado por");
	$help->AddHelp("esc","Escala");
	$help->AddHelp("segui","Seguimiento");
	print $help->ToHtml();
 ?>
  
  <table width="100%" border="1" cellpadding="0" cellspacing="2" background="images/fondo.jpg">
    <tr> <th colspan="13" bgcolor="#006699">ASIGNACIONES DE TRABAJO</th></tr>
	<tr align="center"> 
	  <th class="menu" width="5%"><?php print $help->AddLink("num","SOLUC. ORDEN"); ?></th>
	  <th class="menu">INCIDENCIA</th>
	  <th class="menu">ENVIADO POR</th>
	  <th class="menu">NIVEL</th>
	  <th class="menu"><?php print $help->AddLink("crit", "CRITI"); ?></th>
	  <th class="menu"><?php print $help->AddLink("prio", "PRIOR"); ?></th>
	  <th class="menu">ASIGNADO A</th>
	  <th class="menu"><?php print $help->AddLink("segui", "SEGUI"); ?></th>
	  <th class="menu">FECHA_HORA</th>
	  <th class="menu"><?php print $help->AddLink("estima", "ESTIMAC"); ?></th>
	  <th class="menu"><?php print $help->AddLink("reg", "ASIGNADO POR"); ?></th>
	  <th class="menu">DIAGNOSTICO</th>
	  <th class="menu"><?php print $help->AddLink("esc", "ESCAL"); ?></th>
	</tr>
<?php
//$sql6 = "SELECT * FROM asignacion GROUP BY id_orden";
	$sql11 = "SELECT num_ord_pag FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11[num_ord_pag])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11[num_ord_pag] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1; $j=1;}
	else{$_pagi_actual = $_GET['pg']; $j=1;}
	
if ($tipo=="T") 
{$sql = "SELECT DISTINCT(id_orden), MAX(id_asig) FROM asignacion WHERE asig='$login' GROUP BY id_orden";}
else
{$sql = "SELECT DISTINCT(id_orden), MAX(id_asig) FROM asignacion GROUP BY id_orden";}
$rs1=mysql_db_query($db,$sql,$link);
$numAsig=0;

while ($tmp=mysql_fetch_array($rs1))  
{			
if ($tipo=="T"){
		$sql = "SELECT id_orden,id_asig, asig FROM asignacion WHERE id_orden=$tmp[id_orden] ORDER BY id_asig DESC";
			$rsTmp=mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp["asig"]==$login) {
				$total[$numAsig]=$rsTmp[id_orden];
				$numAsig++;}
			}
else
$numAsig++;			
}
    $_pagi_totalPags = ceil($numAsig / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

$i=$_pagi_inicial+$j;
$ii=$_pagi_inicial+$_pagi_cuantos;

$uu=0;
$sql6 = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";
$result6=mysql_db_query($db,$sql6,$link);
while($row6=mysql_fetch_array($result6))
{
if ($tipo=="T") {$sql = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion WHERE asig='$login' AND id_orden='$row6[id_orden]' AND id_asig='$row6[id_asig]' ORDER BY id_asig DESC";}
else {$sql = "SELECT *, DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion WHERE id_orden='$row6[id_orden]' ORDER BY id_asig DESC";}
$result=mysql_db_query($db,$sql,$link);
while ($row=mysql_fetch_array($result)) {
$uu=$uu+1;

if ($i<=$ii and $uu>=$i){

//seguimiento
	$sqlSeg = "SELECT count(*) AS num FROM seguimiento WHERE id_orden='$row[id_orden]'";
	$resultSeg=mysql_db_query($db,$sqlSeg,$link);
	$rowSeg=mysql_fetch_array($resultSeg);
	
//ver si se encuentra solucionado o no	
	$sql3 = "SELECT * FROM solucion where id_orden='$row[id_orden]'";
	$result3=mysql_db_query($db,$sql3,$link);
	$row3=mysql_fetch_array($result3);
	$fechahoy=date("Y-m-d");
	if (!$row3[id_orden])//VENCIDOS
		{$color="bgcolor=\"#A5BBF5\"";
		if (($row[fechaestsol_asig]>$fechahoy) or ($row[fechaestsol_asig]==$fechahoy))//SIN SOLUCION
		$color="bgcolor=\"#FFFF00\"";}
	else
	$color="bgcolor=\"#00CC66\"";// CON SOLUCION
$sql2 = "SELECT * FROM ordenes WHERE id_orden='$row[id_orden]'";
$result2=mysql_db_query($db,$sql2,$link);
$row2=mysql_fetch_array($result2);
  	echo "<tr align=\"center\">";
	echo "<td ".$color.">&nbsp;<a href=\"solucion.php?id_orden=".$row[id_orden]."\">".$row[id_orden]."</a></td>";
	echo "<td>&nbsp;$row2[desc_inc]</td>";
	$sql5="SELECT * FROM users WHERE login_usr='$row2[cod_usr]'";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
	if($row2[cod_usr]=="SISTEMA")
	{echo "<td>&nbsp;$row2[cod_usr]</td>";}
	else
	{echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";}
	echo "<td>&nbsp;$row[nivel_asig]</td>";
	echo "<td>&nbsp;$row[criticidad_asig]</td>";
	echo "<td>&nbsp;$row[prioridad_asig]</td>";
	$sql5="SELECT * FROM users WHERE login_usr='$row[asig]'";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
	echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";
	echo "<td>&nbsp;<a href=\"segui.php?id_orden=$row[id_orden]&lug=1\">$rowSeg[num]</a></td>"; //seguimiento
	
	echo "<td>&nbsp;$row[fecha_asig] $row[hora_asig]</td>";
	echo "<td>&nbsp;$row[fechaestsol_asig2]</td>";
	$sql5="SELECT * FROM users WHERE login_usr='$row[reg_asig]'";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
	echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";
	echo "<td>&nbsp;$row[diagnos]&nbsp;</td>";

	$sql16="SELECT * FROM users WHERE login_usr='$row[escal]'";
	$result16=mysql_db_query($db,$sql16,$link);
	$row16=mysql_fetch_array($result16);
	echo "<td>&nbsp;$row16[nom_usr] $row16[apa_usr] $row16[ama_usr]</td>";
	echo "</tr>";
$i=$i+1;}
}}
?>
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
  <br>
  <table width="70%" border="1" align="center">
    <tr align="center"> 
      
    <td width="17%" height="42">NO SOLUCIONADOS</td>
      <td width="6%" bgcolor="#FFFF00">&nbsp;</td>
      <td width="18%">&nbsp;</td>
      <td width="13%">SOLUCIONADOS</td>
      <td width="6%" bgcolor="#00CC66">&nbsp;</td>
      <td width="18%">&nbsp;</td>
      <td width="13%">VENCIDOS</td>
      <td width="6%" bgcolor="#A5BBF5">&nbsp;</td>
    </tr>
  </table>
  <script language="JavaScript">
  <?php	
  $lstMsg[3]="Esta orden ha sido generado por el SISTEMA y no puede ser notificado por correo electronico.\\n\\nMensaje generado por GesTor F1.";
  $lstMsg[2]="Precaucion, no se ha podido enviar la orden por correo electronico al Cliente. Posiblemente, su direccion de correo electronico sea incorrecto.";
  if($msg) print "alert(\"$lstMsg[$msg]\");"; ?>
  </script>
  <?php include("top_.php");?> 