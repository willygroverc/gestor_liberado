<?php 
// Version: 1.0
// Fecha: 14/NOV/12
// Autor: Cesar Cuenca
// Objetivo: Actualizacion de funciones php obsoletas para version 5.3
//___________________________________________________________________________

$sql2 = "SELECT * FROM users WHERE login_usr='$login'";	
$result2 = mysql_query($sql2);
$row2 = mysql_fetch_array($result2);
$tipo_usr = $row2['tipo_usr'];
?>
<p>
<table width="80%" border="1" align="center" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
      <th colspan="9" background="images/main-button-tileR11.jpg" height="30"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">Boletin Informativo</strong></font></div></td>
    </tr>
    <tr bgcolor="#006699"> 
      <td width="4%" background="images/main-button-tileR11.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro</font></div></td>
      <td width="11%" background="images/main-button-tileR11.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha y Hora</font></div></td>
      <td width="77%" background="images/main-button-tileR11.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Descripcion</font></div></td>
      <td width="8%" background="images/main-button-tileR11.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Adjunto</font></div></td>
    </tr>
    
	<?php  
	$sql11 = "SELECT num_ord_pag FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$fechahoy=date("Y-m-d");
	$d1=substr($fechahoy,8,2);
	if ( (($row2['tipo2_usr']=="A") or ($row2['tipo2_usr']=="B") or ($row2['tipo2_usr']=="T")) and $tipo_usr != "EXTERNO")
	{
		$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM boletin";
		$result9=mysql_query($_pagi_sqlConta);
		$row9 = mysql_fetch_array($result9);

		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
		$sql1 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM boletin ORDER BY fecha DESC, hora DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
		$result1=mysql_query($sql1);
		while($row1=mysql_fetch_array($result1)){
		if ($fechahoy==$row1['fecha']) {$color="bgcolor=\"#FF6600\"";}
		if ($fechahoy>$row1['fecha']) {$color="bgcolor=\"#00CC66\"";}
		$d2=substr($row1['fecha'],8,2);
		if ($d2==($d1-1)) {$color="bgcolor=\"#FFFF33\"";}
		
		//if ($tipo_usr != "EXTERNO" and $tipo != "T" and $row1[clasificacion]!="reservado"){
		?>        
		<tr align="center"> 
		<?php echo "<td ".$color.">&nbsp;$row1[id_boletin]</td>"; ?>
        <td height="23"><?php echo $row1['fecha2'];?>&nbsp; <?php echo $row1['hora'];?><div align="center"></div></td>
		 
        <td><font size="3" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['desc_bol'];?></td>
        <td>
	    <?php if (!$row1['nomb_archivo']){echo "NINGUNO";}
			else {
				echo '<a href="archivos adjuntos"'.$row1['nomb_archivo'].'" target="_blank">'.$row1['nomb_archivo'].'</a>';}
        ?></td></tr>
		<?php //}
		?>
    <?php }
	}
	else
	{
		$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM boletin WHERE clasificacion='interno'";
		$result9=mysql_query($_pagi_sqlConta);
		$row9=mysql_fetch_array($result9);

		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		
		$sql1 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM boletin WHERE clasificacion='interno' ORDER BY fecha DESC, hora DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
		$result1=mysql_query($sql1);
		while($row1=mysql_fetch_array($result1))
	    {
		if ($fechahoy==$row1['fecha']) {$color="bgcolor=\"#FF6600\"";}
		if ($fechahoy>$row1['fecha']) {$color="bgcolor=\"#00CC66\"";}
		$d2=substr($row1['fecha'],8,2);
		if ($d2==($d1-1)) {$color="bgcolor=\"#FFFF33\"";}
		?>
        <tr align="center"> 
		<?php echo "<td ".$color.">&nbsp;".$row1['id_boletin']."</td>"; ?>
		<td height="23"><?php echo $row1['fecha2'];?>&nbsp; <?php echo $row1['hora'];?><div align="center"></div></td>
        <td><font size="3" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['desc_bol'];?></td>
        <td>
	    <?php if (!$row1['nomb_archivo']){echo "NINGUNO";}
			else {echo'<a href="archivos adjuntos'.$row1['nomb_archivo'].'" target="_blank">'.$row1['nomb_archivo'].'</a>';}
        ?></td></tr>
    <?php }
	}?>
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

