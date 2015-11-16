<?php
if (isset($RETORNAR)){ header("location: lista_cambios.php?Naveg=Cambios");}
include ("top.php");
?>
<form name="form1" method="post" action="" >
<table width="95%" border="1" align="center" background="images/fondo.jpg">
  <tr bgcolor="#006699" align="center"> 
    <td background="images/main-button-tileR1.jpg" height="22" <?php if ($tipo=="A" or $tipo=="B") {echo "colspan=\"9\""; } else{ echo "colspan=\"7\"";}?> ><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>MAESTRO 
        DE CAMBIOS</strong></font></td>
  <tr bgcolor="#006699" align="center"> 
    <td width="6%" background="images/main-button-tileR2.jpg"><font color="#FFFFFF">N&deg; ORDEN</font></td>
    <td width="6%" background="images/main-button-tileR2.jpg"><font color="#FFFFFF">N&deg; DE CAMBIO</font></td>
    <td width="35%" background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF">INCIDENCIA</font></div></td>
    <td width="15%" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF">SOLICITANTE</font></div></td>
    <?php if ($tipo=="A" or $tipo=="B") {?>
	<td width="15%" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF">ASIGNADO A</font></div></td>
	<?php }?>
	<td width="10%" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF">FECHA PROGRAMADA</font></div></td>
    <td width="10%" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF">FECHA REAL</font></div></td>
	<?php if ($tipo=="A" or $tipo=="B") {?>
    <td width="8%" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF">MODIFICAR</font></div></td>
	<?php }?>
	<td width="8%"><div align="center"><font color="#FFFFFF">IMPRIMIR</font></div></td>
	<?php
	   	$sql11 = "SELECT num_ord_pag FROM control_parametros";
		$result11=mysql_db_query($db,$sql11,$link);
		$row11=mysql_fetch_array($result11);

		if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
		else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

		if (empty($_GET['pg'])){$_pagi_actual = 1; $j=1;}
		else{$_pagi_actual = $_GET['pg']; $j=1;}
	    
if ($tipo=="T") 
{$sql = "SELECT DISTINCT(id_orden), MAX(id_asig) FROM asignacion WHERE asig='$login' GROUP BY id_orden";}
else
{$sql = "SELECT DISTINCT(id_orden), MAX(id_asig) FROM asignacion GROUP BY id_orden";}

$rs1=mysql_db_query($db,$sql,$link);
$numAsig=0;

while ($tmp=mysql_fetch_array($rs1))  
{ 	if ($tipo=="T")
	{ 	$sql10 = "SELECT asig,area FROM asignacion WHERE id_orden=$tmp[id_orden] ORDER BY id_asig DESC";
		$rsTmp=mysql_fetch_array(mysql_db_query($db,$sql10,$link));
		if ($rsTmp['area']=="Cambios" AND $rsTmp['asig']==$login)
  		{
			$total[$numAsig]=$rsTmp['id_orden'];
	 		$numAsig++;
 		}
	}
	else 
	{ 
		$sql10 = "SELECT area FROM asignacion WHERE id_orden=$tmp[id_orden] ORDER BY id_asig DESC";
		$rsTmp=mysql_fetch_array(mysql_db_query($db,$sql10,$link));
		if ($rsTmp['area']=="Cambios"){$numAsig++;}
	}
}
		
$_pagi_totalPags = ceil($numAsig / $_pagi_cuantos);
$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

$i=$_pagi_inicial+$j;
$ii=$_pagi_inicial+$_pagi_cuantos;

$uu=0;
$sql = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";
$result=mysql_db_query($db,$sql,$link);
while($row=mysql_fetch_array($result)) 
{
	if ($tipo=="A" or $tipo=="B"){$sql1 = "SELECT area, asig, id_orden FROM asignacion WHERE id_asig='$row[id_asig]'";}
	else {$sql1 = "SELECT area, asig, id_orden FROM asignacion WHERE id_asig='$row[id_asig]' AND asig='$login'";}
	$result1=mysql_db_query($db,$sql1,$link);
	$row1=mysql_fetch_array($result1);
	if ($row1['area']=="Cambios") 
	{
		$sql_pla="SELECT Codigo FROM soliccambioplanif WHERE Codigo='$row1[id_orden]'";
		$res_pla=mysql_db_query($db,$sql_pla,$link);
		$row_pla=mysql_fetch_array($res_pla);
		if($row_pla)
		{
			$uu=$uu+1;
			if ($i<=$ii and $uu>=$i)
			{
			?>
			<tr align="center"> 
			  <td><font size="1">&nbsp;<?php echo $row['id_orden']?></font></td>
			  <td><font size="1">&nbsp; 
				<?php 
				$sql2 = "SELECT num_cambio, DATE_FORMAT(fechaprog, '%d/%m/%Y') AS fechaprog, DATE_FORMAT(fechareal, '%d/%m/%Y') AS fechareal FROM maestro WHERE num_orden='$row[id_orden]'";
				$result2=mysql_db_query($db,$sql2,$link);
				$row2=mysql_fetch_array($result2);
				if (empty($row2['num_cambio'])){echo "SIN REGISTRO";}
				else {echo $row2['num_cambio'];}?>
				</font></td>
			 <td><font size="1">&nbsp; 
				<?php 
				$sql3 = "SELECT desc_inc, cod_usr FROM ordenes WHERE id_orden='$row[id_orden]'";
				$result3=mysql_db_query($db,$sql3,$link);
				$row3=mysql_fetch_array($result3);
				echo $row3['desc_inc']?>
				</font></td>
			 <td><font size="1">&nbsp; 
			 <?php
			   
				$sql4 = "SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$row3[cod_usr]'";
				$result4=mysql_db_query($db,$sql4,$link);
				$row4=mysql_fetch_array($result4);
				echo $row4['nom_usr']." ".$row4['apa_usr']." ".$row4['ama_usr'];
				?></font></td>
			  
				<?php 
				if ($tipo=="A" or $tipo=="B"){ 
				echo "<td><font size=\"1\">&nbsp;";
				$sql4 = "SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$row1[asig]'";
				$result4=mysql_db_query($db,$sql4,$link);
				$row4=mysql_fetch_array($result4);
				echo $row4['nom_usr']." ".$row4['apa_usr']." ".$row4['ama_usr'];
				echo "</font></td>";}?>
				
			  <td><font size="1">&nbsp;
				<?php 
				 if (empty($row2['num_cambio'])){echo "<a href=\"maes_cambios.php?orden=$row[id_orden]\">Programar</a></td>";}
				 else {echo $row2['fechaprog'];}?>
				</font></td>
			  <td><font size="1">&nbsp;
				<?php 
				 if ($row2['fechaprog']=="00/00/0000" || empty($row2['fechaprog'])){echo "Antes Programe";}
				 else {
				 if ($row2['fechareal']=="00/00/0000")
				 {echo "<a href=\"maes_cambios2.php?orden=$row[id_orden]\">Llenar Fecha Realizada</a></td>";}
				 else
				 {echo $row2['fechareal'];}
				 }?>
				</font></td>
				<?php if ($tipo=="A" or $tipo=="B"){
					if (!empty($row2['num_cambio'])){echo "<td>&nbsp;<a href=\"maes_cambios_last.php?orden=$row[id_orden]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></td>";}
					else {echo "<td>&nbsp;<img src=\"images/no2.gif\" border=\"0\" alt=\"Modificar\"></td>";}
				   }
					if (!empty($row2['num_cambio'])){echo "<td>&nbsp;<a href=\"ver_maes_cambios.php?orden=$row[id_orden]\"target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></td>";}
					else {echo "<td>&nbsp;<img src=\"images/no2.gif\" border=\"0\" alt=\"Imprimir\"></td>";}
				   ?>
			</tr>
			<?php 
			  $i=$i+1;}}}}
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
  <div align="center"><br>
    <input type="submit" name="IMPRIMIR" value="IMPRIMIR" onClick="pagina()">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input type="submit" name="RETORNAR" value="RETORNAR">
  </div>
</form>
<?php include ("top_.php");?>
<script language="JavaScript">
<!--
function pagina() {
	window.open("ver_maestro.php");
}
-->
</script>