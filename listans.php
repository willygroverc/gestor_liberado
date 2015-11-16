<?php
include ("top.php");
include("funciones.inc.php");	
session_start();
if (!$menu)
$menu = "noSolucionado";
?>
<p>
<form action="" method="get" name="form2" id="form2" onKeyPress="return Form()">
  <table width="80%" border="1" align="center" bgcolor="#006699">
    <tr> 
      <td width="60%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Busqueda 
          por :</strong></font> 
          <select name="menu" id="menu" onChange="tipo(this.value)">
			 <option value="noSolucionado"<?php if ($menu=="noSolucionado") print selected ?>>No Solucionado</option>
             <option value="asignado"<?php if ($menu=="asignado") print selected ?>>Asignado</option>
             <option value="noAsignado"<?php if ($menu=="noAsignado") print selected ?>>No Asignado</option>
             <option value="enviadoPor"<?php if ($menu=="enviadoPor") print selected ?>>Enviado Por</option>
			 <option value="nro_de_orden"<?php if ($menu=="nro_de_orden") print selected?>>Nro. de Orden</option>
          </select>
          &nbsp;
		   <?php if($menu!="nro_de_orden"){?>
		  	<select name="selecta">
            <option value="general">General</option>
          <?php
		  	switch($menu){
			case 'noAsignado':
			break;
			case 'noSolucionado':
			break;
			default:
			$sqltec="SELECT * from users WHERE tipo2_usr='T' ORDER BY apa_usr";
			$resultec= mysql_db_query($db,$sqltec,$link);
			while($rowtec= mysql_fetch_array($resultec)){
		  ?>
			<option value="<?php echo $rowtec[login_usr]?>"<?php if ($selecta==$rowtec[login_usr]) print selected ?>><?php echo "$rowtec[apa_usr]"." $rowtec[ama_usr]"." $rowtec[nom_usr]"?></option>
          <?php
			};
			break;
			}
		  ?>
          </select>
		  <?php }else{?>
		  <input name="selecta" type="text" size="5" maxlength="5" value="<?php echo $selecta;?>">
		  <?php }?>
          &nbsp;&nbsp; 
          <input name="BUSCAR" type="submit" id="BUSCAR" value="BUSCAR">
        </div></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#F4F2EA" >
    <tr> 
    <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
        <tr> 
          <th colspan="20">ORDENES DE TRABAJO</th>
        </tr>
        <tr align="center"> 
          <td width="25" class="menu">Nro</td>
		  <td width="20" height="25" class="menu">ORIGEN</td>
          <td width="67" class="menu">FECHA Y HORA</td>
          <td width="90" class="menu">ENVIADO POR</td>
          <td width="17" class="menu">TIPO</td>
          <td width="88" class="menu">CLIENTE / TITULAR</td>
          <td width="150" class="menu">INCIDENCIA</td>
          <td width="90" class="menu">ASIGNACION</td>
          <td width="60" class="menu">FECHA SOLUCION</td>
          <td width="17" class="menu">SEGUI. </td>
          <td width="17" class="menu">SOLU.</td>
          <td width="17" class="menu">CONF.</td>
		  <?php if ($tipo != "C"){?>
		  <td width="17" class="menu">COSTO</td>      
		  <?php }?>
          <td width="55" class="menu">IMPRIMIR INTERNO</td>
          <td width="55" class="menu">IMPRIMIR EXTERNO</td>
          <td width="55" class="menu">ARCHIVO ADJUNTO</td>
		  <td width="55" class="menu">ORIGEN 2</td>
        </tr>
    <?php
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11[num_ord_pag])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11[num_ord_pag] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}
	
if($selecta==general) {$login_usr='%';}
else $login_usr=$selecta;
	
	$gen = array();
	$gen_reg = array();
	$gen = CuentaRegistrosNS_G($tipo, $login);
	switch ($menu) {
	case "asignado":
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion group by id_orden";
		$resultbo=mysql_db_query($db, $sqlbo, $link);
		while ($rowbo = mysql_fetch_array($resultbo)) {
		$auxbo=$auxbo.", ".$rowbo[maxi];
		}
		$auxbo=str_replace('nochar,',' ', $auxbo);
		$gen_reg = CuentaRegistrosASIG_GS($gen, $login_usr, $auxbo);
		$totalReg = count($gen_reg);
		break;
	case "noAsignado":	
		$gen_reg = CuentaRegistrosNOASIG_GS($gen);
		$totalReg = count($gen_reg);
		break;
	case "enviadoPor":	
		$gen_reg = CuentaRegistrosEnviado_por($gen, $login_usr);
		$totalReg = count($gen_reg);
		break;
	case "nro_de_orden":	
		$gen_reg = Nro_orden($gen,$selecta);
		$totalReg = count($gen_reg);
		break;
	case "noSolucionado":
		$totalReg = count($gen);
		break;
	}
	
	$_pagi_totalPags = ceil($totalReg / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	if ($menu == "noSolucionado") $vec = $gen;	
	else $vec = $gen_reg;
	
	for ($i=($_pagi_inicial); $i<($_pagi_inicial+$_pagi_cuantos);$i++)
	{	if ($i<$totalReg){	
		$datos = DatosEnvio($vec[$i]); 
		$asign = Asignacion($vec[$i]);
		$valores = explode("*",$datos);
		$vasign  = explode ("*", $asign);
		$sql3 = "SELECT * FROM solucion where id_orden='$vec[$i]'";
		$result3 = mysql_db_query($db,$sql3,$link);
		$row3 = mysql_fetch_array($result3);
		$row[cod_usr] = UsuarioOrden($vec[$i]);
		
		$sql1 = "SELECT * FROM asignacion WHERE id_orden='$vec[$i]' ORDER BY id_asig DESC limit 1";		
		$result1 = mysql_db_query($db,$sql1,$link);
		$row1 = mysql_fetch_array($result1);
		$sql8 = "SELECT * FROM solucion where id_orden='$vec[$i]'";
		$result8 = mysql_db_query($db,$sql8,$link);
		$row8 = mysql_fetch_array($result8);
		$fechahoy = date("Y-m-d");		
		if (!$row1[id_orden])   //NO ASIGNADOS
			$color="bgcolor=\"#FF6666\"";
		else{ 
			if (!$row8[id_orden])//VENCIDOS
			{	$color="bgcolor=\"#A5BBF5\"";
				if (($row1[fechaestsol_asig]>=$fechahoy) or ($row1[fechaestsol_asig]==$fechahoy))//SIN SOLUCION
				$color="bgcolor=\"#FFFF00\"";
			}
			else
			$color="bgcolor=\"#00CC66\"";// CON SOLUCION
		}
		//EN COLORES		
		echo "<tr align='center'>";	
		echo "<td ".$color.">$vec[$i]&nbsp;</td>";
		$sqlid="SELECT id_anidacion,origen FROM ordenes WHERE id_orden=$vec[$i]";
		$resultid=mysql_db_query($db, $sqlid, $link);
		$rowid=mysql_fetch_array($resultid);
		if ($rowid[id_anidacion]==0){echo "<td>&nbsp;<img src='images/eliminar.gif' width='16' height='16'></td>";}
		else{echo "<td><a href=\"#\" onClick=\"enviar($rowid[id_anidacion])\">&nbsp;$rowid[id_anidacion]</a></td>";}
		echo "<td>$valores[0]&nbsp;</td>";
		echo "<td>$valores[1]&nbsp;</td>";		
		echo "<td>$valores[2]&nbsp;</td>";	
		echo "<td><a href='titular.php?ci_ruc=$valores[3]'>$valores[3]</a>&nbsp;</td>";
		echo "<td>$valores[4]&nbsp;</td>";
		if ($vasign[2] == 0) 
		{	if ($tipo == "C")	
			{	echo "<td align='center'>&nbsp;<img src=\"images/no3.gif\" border=\"0\" alt=\"Asignacion: No\"></td>";
				echo "<td>&nbsp;</td>";
			}
			else
			{	echo "<td align='center'>&nbsp;<a href=\"asignacion.php?id_orden=$vec[$i]&op=3\"><img src=\"images/no3.gif\" border=\"0\" alt=\"Asignacion: No\"></a></td>";
				echo "<td>&nbsp;</td>";
			}			
		}
		else
		{	if ( $tipo == "C" ) 
			{	echo "<td>&nbsp;".$vasign[0]."</td>";
				echo "<td>$vasign[1]</td>";	
			}	
			else
			{	if ($row3) echo "<td>&nbsp;".$vasign[0]."</td>";	
				else echo "<td>&nbsp;<a href=\"asignacion_last.php?id_orden=$vec[$i]&op=3\">".$vasign[0]."</a></td>";
				echo "<td>$vasign[1]</td>";	
			}				
		}
		$num = NroSeguimientos($vec[$i]);
		echo "<td>&nbsp;<a href=\"segui.php?id_orden=$vec[$i]&var2=3\">$num</a></td>";
		if ($row3){ echo "<td><a href=\"solucion_ver.php?id_orden=$vec[$i]&op=3\"><img src=\"images/ok.gif\" border=\"0\" alt=\"Solucion: Si Ver\"></a></td>";}		
		else {echo "<td><img src=\"images/no2.gif\" border=\"0\" alt=\"Solucion\"></td>";}
		$row4 = Conformidad($vec[$i]);
		if ($row4)
		{   if ($row4[tipo_conf] == "2")
			echo "<td><a href=\"conformidad_ver.php?id_orden=$vec[$i]&op=3\"><img src=\"images/disconf.gif\" border=\"0\" alt=\"Conformidad: Si Ver\"></a></td>";
			else
			echo "<td><a href=\"conformidad_ver.php?id_orden=$vec[$i]&op=3\"><img src=\"images/ok.gif\" border=\"0\" alt=\"Conformidad: Si Ver\"></a></td>";			
		}
		else
		{	if (($login_usr == $row[cod_usr] || ($login_usr == "SISTEMA" || $tipo=="A" || $tipo=="B")) && $row3[id_orden] ) // 03082004 IPM
				echo "<td><a href=\"conformidad.php?id_orden=$vec[$i]&op=3\"><img src=\"images/no3.gif\" border=\"0\" alt=\"Conformidad: No\"></a></td>";
			else
				echo "<td><img src=\"images/no2.gif\" border=\"0\" alt=\"Conformidad\"></td>";
		}
		
		if ($tipo != "C")
		{		
		echo "<td><a href=\"costo.php?id_orden=$vec[$i]&op=3\"><img src=\"images/ver.gif\" border=\"0\" alt=\"Costo: Ver\"></a></td>";
		}
		echo "<td><a href=\"ver_orden.php?id_orden=$vec[$i]\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Interno\"></a></td>"; 
		echo "<td><a href=\"ver_orden2.php?id_orden=$vec[$i]\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Externo\"></a></td>"; 
		$sql = "SELECT * FROM ordenes WHERE id_orden='$vec[$i]'";
		$res = mysql_db_query($db,$sql,$link);
		$row = mysql_fetch_array($res);		
		if (!$row[nomb_archivo]){echo "<td>NINGUNO</td>";}
		else {echo "<td><a href=\"archivos_adjuntos.php?id_orden=$row[id_orden]\">VER ARCHIVOS</a></td>";}
/*		else {
			$adjuntos_bo=explode("|",$row[nomb_archivo]);
//			echo "<td width=\"95%\"><div align=\"center\"><font face=\"arial,helvetica\" size=\"2\"><strong>Archivos Adjuntos :</strong></font></div></td></tr>";
			echo "<td>";
			foreach($adjuntos_bo as $valor)	echo "<a href=\"archivos adjuntos/".$valor."\" target=\"_blank\">$valor</a><br>";
//			echo"<td><a href=\"archivos adjuntos/".$row[nomb_archivo]."\" target=\"_blank\">$row[nomb_archivo]</a></td>";
			echo "</td>";
		}*/
		switch ($rowid[origen]){
		case "0": $graf="<img src=\"images/0.gif\" border=\"0\" alt=\"Mesa de Ayuda\">"; break;
		case "1": $graf="<img src=\"images/1.gif\" border=\"0\" alt=\"Gestion\">"; break;
		case "1.4": $graf="<img src=\"images/1-4.gif\" border=\"0\" alt=\"Contratos\">"; break;
		case "2": $graf="<img src=\"images/2.gif\" border=\"0\" alt=\"Soporte Tecnico\">"; break;
		case "3": $graf="<img src=\"images/3.gif\" border=\"0\" alt=\"Desarrollo y Mantenimiento\">"; break;
		default: $graf="<img src=\"images/0.gif\" border=\"0\" alt=\"Mesa de Ayuda\">"; break;
		}
		echo "<td>$graf&nbsp;</td>";
		echo "</tr>";
		}	
	}
?>
</TABLE>
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
        </font></strong> <font size="2"><strong>&nbsp;<br>
        <br>
        </strong></font></div></td>
  </tr>
</table>
  
  <table width="70%" border="1" align="center">
    <tr align="center"> 
      <td width="12%" >NO ASIGNADOS</td>
      <td width="5%" bgcolor="#FF6666">&nbsp;</td>
      <td width="10%">&nbsp;</td>
      <td width="12%">NO SOLUCIONADOS</td>
      <td width="5%" bgcolor="#FFFF00">&nbsp;</td>
      <td width="10%">&nbsp;</td>
      <td width="12%">SOLUCIONADOS</td>
      <td width="5%" bgcolor="#00CC66">&nbsp;</td>
      <td width="10%">&nbsp;</td>
      <td width="12%">VENCIDOS</td>
      <td width="5%" bgcolor="#A5BBF5">&nbsp;</td>
    </tr>
  </table>
  <?php
   $sql2 = "SELECT tipo_usr FROM users WHERE login_usr='$login'"; 
   $res2 = mysql_db_query($db,$sql2,$link);
   $row2 = mysql_fetch_array($res2);
   if ($row2[tipo_usr]="INTERNO"){
  ?>
	<br><center>
    <?php if ($tipo=="A" or $tipo=="B" or $tipo=="T") {?>
    <input name="ESTADISTICAS" type="button" id="ESTADISTICAS" value="ESTADISTICAS" onClick="openStat_2()">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input name="IMPRIMIR" type="button" id="IMPRIMIR" value="IMPRIMIR" onClick="openStat_3()">
	<?php }
	}
?>
		</center>
<script language="JavaScript">
<!--
<?php 
if($msg) print "alert(\"$msg\\n\\nMensaje generado por GesTor F1.\");"?>
function openStat_2() {	
	window.open("orden_estadistica.php",'Estadìsticas', 'width=610,height=190,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
function openStat_3() {	
	window.open("orden_estadistica2.php",'Estadìsticas', 'width=610,height=200,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}

function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function tipo(men)
{
	if(men=="nro_de_orden"){irapagina("listans.php?menu="+men+"&selecta=1");}
	else{irapagina("listans.php?menu="+men+"&selecta=general");}
}
function enviar(id){
		open("ver_orden.php?id_orden="+id);
}
<?php if($vent){?>
ventana_secundaria=window.open('pru2.php','secundaria','location=no,menubar=no,status=no,toolbar=no,scrollbars=0,resizable=no,width=350,height=170,left=150,top=150'); 
ventana_secundaria.close(); 
<?php }?>
-->
</script>
<?php 
include("top_.php");
?>