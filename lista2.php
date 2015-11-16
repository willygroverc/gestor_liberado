<?php 
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("segui","Seguimiento.");
	$help->AddHelp("tipo","Tipo de Cliente. A: Administrador, T: Tecnico, C: Cliente.");
	$help->AddHelp("conf","Conformidad.");
	$help->AddHelp("solu","Solucion.");
	$help->AddHelp("incidencia","Consultas de los clientes sin aclarar la naturaleza de las mismas.");
	print $help->ToHtml();
 ?>
<p>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#F4F2EA" >
    <tr> 
    <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
        <tr> 
          <th colspan="14">ORDENES DE TRABAJO</th>
        </tr>
        <tr align=\"center\"> 
          <th width="26" class="menu">Nro</th>
          <th width="110" class="menu">FECHA Y HORA</th>
          <th width="130" class="menu">ENVIADO POR</th>
          <th width="17" class="menu"><?php print $help->AddLink("tipo", "TIPO"); ?></th>
          <th width="73" class="menu">CLIENTE / TITULAR</th>
          <th width="210" class="menu"><?php print $help->AddLink("incidencia", "INCIDENCIA"); ?></th>
          <th width="141" class="menu">ASIGNACION</th>
          <th width="17" class="menu"><?php print $help->AddLink("segui", "SEGUI"); ?></th>
          <th width="17" class="menu"><?php print $help->AddLink("solu", "SOLU."); ?></th>
          <th width="17" class="menu"><?php print $help->AddLink("conf", "CONF."); ?></th>
          <?php  if($tipo=="A" or $tipo=="B" or $tipo=="T") {
             echo "<th width=\"40\" class=\"menu\">COSTO</th>";
	  }?>
          <th width="26" class="menu">IMPRIMIR INTERNO</th>
          <th width="27" class="menu">IMPRIMIR EXTERNO</th>
          <th width="55" class="menu">ARCHIVO ADJUNTO</th>
        </tr>
        <?php
$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

if(empty($row11[num_ord_pag]))
{	$_pagi_cuantos =20 ; }
else
{  $_pagi_cuantos = $row11[num_ord_pag] ;
}

if (empty($_GET['pg'])){
	$_pagi_actual = 1;
}else{
    $_pagi_actual = $_GET['pg'];
}

//Contamos el total de registros en la BD (para saber cuántas páginas serán)
//$_pagi_sqlConta = eregi_replace("select (.*) from ordenes", "SELECT COUNT(*) FROM ordenes", $_pagi_sql);
//$_pagi_result2 = mysql_query($_pagi_sqlConta) or die ("Error en la consulta de conteo de registros. Mysql dijo: <b>".mysql_error()."</b>");
//$_pagi_totalReg = mysql_result($_pagi_result2,0,0);//total de registros
    
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ordenes";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);
//Calculamos el numero de páginas (saldrá un decimal)
//con ceil() redondeamos y $_pagi_totyalPags será el numero total (entero) de páginas que tendremos
$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);
$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

if($tipo=="A" or $tipo=="B") {$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";}
else if($tipo=="T") {$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes WHERE cod_usr<>'SISTEMA' ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";}
else if($tipo=="C") {$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes WHERE cod_usr='$login' ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";}
$result=mysql_db_query($db,$sql,$link);
while ($row=mysql_fetch_array($result)) 
  {
	//ASIGNACION
	$sql1 = "SELECT id_orden, asig FROM asignacion WHERE id_orden='$row[id_orden]' ORDER BY id_asig DESC limit 1";
	$result1=mysql_db_query($db,$sql1,$link);
	$row1=mysql_fetch_array($result1);
	//SEGUIMIENTO
	$sql2 = "SELECT count(*) AS num FROM seguimiento WHERE id_orden='$row[id_orden]'";
	$result2=mysql_db_query($db,$sql2,$link);
	$row2=mysql_fetch_array($result2);
	//SOLUCION
	$sql3 = "SELECT * FROM solucion where id_orden='$row[id_orden]'";
	$result3=mysql_db_query($db,$sql3,$link);
	$row3=mysql_fetch_array($result3);
	//CONFORMIDAD
	$sql4 = "SELECT * FROM conformidad where id_orden='$row[id_orden]'";
	$result4=mysql_db_query($db,$sql4,$link);
	$row4=mysql_fetch_array($result4);
	//TIPO
	$sql5 = "SELECT tipo2_usr FROM users where login_usr='$row[cod_usr]'";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
	
	if (!$row1[id_orden])   //ASIGNACION
		$color="bgcolor=\"#FF6666\"";
	else if (!$row3[id_orden]) //SOLUCION
		$color="bgcolor=\"#FFFF00\"";
	else 
		$color="bgcolor=\"#00CC66\"";

  	echo "<tr align=\"center\">";
	echo "<td ".$color.">$row[id_orden]</td>"; 
	//FECHA Y HORA
	echo "<td>$row[fecha] $row[time]</td>";
	//ENVIADO POR
		$sql5 = "SELECT * FROM users WHERE login_usr='$row[cod_usr]'";
    	$result5 = mysql_db_query($db,$sql5,$link);
    	$row5 = mysql_fetch_array($result5);
		if (!$row5[login_usr]){echo"<td>&nbsp;$row[cod_usr]</td>";}
		else{echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";}
	//echo "<td><a href=\"usuario_modi.php?login_usr=$row[cod_usr]\">$row[cod_usr]</a></td>";
	//TIPO
	echo "<td>&nbsp;$row5[tipo2_usr]</td>";
	//CI RUC
	echo "<td>&nbsp;<a href=\"titular.php?ci_ruc=$row[ci_ruc]\">$row[ci_ruc]</a></td>";
	//INCIDENCIA
	echo "<td>$row[desc_inc]</td>";
	//ASIGNACION
	
	if (!$row1[id_orden])
	{
		if ($tipo=="C"){echo"<td><img src=\"images/no3.gif\" border=\"0\" alt=\"Asignacion: No\"></td>";}
		else{
			echo"<td><a href=\"asignacion.php?id_orden=$row[id_orden]\"><img src=\"images/no3.gif\" border=\"0\" alt=\"Asignacion: No\"></a></td>";
			}
	}
	else
	{
		if ($tipo=="C")
			{$sql5 = "SELECT * FROM users WHERE login_usr='$row1[asig]'";
	    	$result5 = mysql_db_query($db,$sql5,$link);
    		$row5 = mysql_fetch_array($result5);
			echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";}
		else
			{$sql5 = "SELECT * FROM users WHERE login_usr='$row1[asig]'";
	    	$result5 = mysql_db_query($db,$sql5,$link);
    		$row5 = mysql_fetch_array($result5);
			$nomb=$row5[nom_usr]." ".$row5[apa_usr]." ".$row5[ama_usr];
			if (mysql_num_rows($result3)!=1) echo"<td><a href=\"asignacion_last.php?id_orden=$row[id_orden]\">".$nomb."</a></td>";
			else echo"<td>".$nomb."</td>";
			}
	}
	//SEGUIMIENTO
	echo "<td>&nbsp;<a href=\"segui.php?id_orden=$row[id_orden]\">$row2[num]</a></td>";

	//SOLUCION
	if ($row3)
	{
		echo "<td><a href=\"solucion_ver.php?id_orden=$row[id_orden]\"><img src=\"images/ok.gif\" border=\"0\" alt=\"Solucion: Si Ver\"></a></td>";
	}
	else
	{
		echo "<td><img src=\"images/no2.gif\" border=\"0\" alt=\"Solucion: No\"></td>";
		
	}
	//CONFORMIDAD
	if ($row4)
	{
			echo"<td><a href=\"conformidad.php?id_orden=$row[id_orden]\"><img src=\"images/ok.gif\" border=\"0\" alt=\"Conformidad: Si Ver\"></a></td>";
	}
	else
	{
		if ($login == $row[cod_usr])
			echo"<td><a href=\"conformidad.php?id_orden=$row[id_orden]\"><img src=\"images/no3.gif\" border=\"0\" alt=\"Conformidad: No\"></a></td>";
		else
			echo"<td><img src=\"images/no2.gif\" border=\"0\" alt=\"Conformidad: No\"></td>";
	}

	//COSTO DEL SERVICIO	
	if($tipo=="A" or $tipo=="B" or $tipo=="T") {echo"<td><a href=\"costo.php?id_orden=$row[id_orden]\"><img src=\"images/ver.gif\" border=\"0\" alt=\"Costo: Si Ver\"></a></td>";}

	echo "<td><a href=\"ver_orden.php?id_orden=$row[id_orden]\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir: Interno\"></a></td>"; 
	echo "<td><a href=\"ver_orden2.php?id_orden=$row[id_orden]\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir: Externo\"></a></td>"; 
	//ARCHIVOS ADJUNTOS
	if($tipo=="A" or $tipo=="B" or $tipo=="T") 
	{
		if (!$row[nomb_archivo]){echo "<td>NINGUNO</td>";}
		else {echo"<td><a href=\"archivos adjuntos/".$row[nomb_archivo]."\" target=\"_blank\">$row[nomb_archivo]</a></td>";}
	}
	else 
	{
		if (!$row[nomb_archivo]){echo"<td>NINGUNO</td>";}
		else {echo"<td>ADJUNTADO</td>";}
	}
	echo "</tr>";
  }
?>
      </table></td>
  </tr>
</table>

<br>
<table width="75%" border="0" align="center">
  <tr> 
    <td><div align="center"><strong><font size="2"> 
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
        </font></strong></div></td>
  </tr>
</table>
<BR>
  <table width="70%" border="1">
    <tr align="center"> 
      <td width="12%" >NO ASIGNADOS</td>
      <td width="6%" bgcolor="#FF6666">&nbsp;</td>
      <td width="15%">&nbsp;</td>
      <td width="17%">NO SOLUCIONADOS</font></div></td>
      <td width="6%" bgcolor="#FFFF00">&nbsp;</td>
      <td width="18%">&nbsp;</td>
      <td width="13%">SOLUCIONADOS</td>
      <td width="6%" bgcolor="#00CC66">&nbsp;</td>
    </tr>
  </table>
  </p>

