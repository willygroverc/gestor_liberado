<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		13/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (!$_SESSION["login"]) { header("location: index_2.php"); }
$login=$_SESSION["login"];

require("conexion.php");
if (isset($_REQUEST['RETORNAR2'])) header("location: riesgo-opciones.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");

if ( isset($_REQUEST['NUEVO']) ) header("location: riesgo_alarmas.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");

if (isset($_REQUEST['ejecutar']) && $_REQUEST['ejecutar']=="eliminar")
{	$sql_delete = "DELETE FROM alarmas_riesgos WHERE id_alarma='$id_alar'";
	$res_delete = mysql_query($sql_delete);
}

if (isset($_REQUEST['ejecutar']) && $_REQUEST['ejecutar']=="enviar_alarma")
{	//echo "ALARMA ENVIADA MAIL";
	if(isset($_REQUEST['id_alar']))
	$id_alar=$_REQUEST['id_alar'];
	ini_set("error_reporting", "E_ALL & ~E_NOTICE & ~E_WARNING");
	$sql_tmp   = "SELECT *, DATE_FORMAT(fec_creacion, '%d/%m/%Y') AS fec_creacion FROM alarmas_riesgos WHERE id_alarma='$id_alar'";
	$row_tmp   = mysql_fetch_array(mysql_query( $sql_tmp));
	$sql4  = "SELECT id_riesgo, descripcion FROM riesgo_tipos WHERE id_riesgo='$row_tmp[tipo_alarma]'";
	$row4  = mysql_fetch_array(mysql_query( $sql4));
	$sql6  = "SELECT id_riesgo, desc_riesgo  FROM riesgo_pregunta WHERE id_riesgo='$row_tmp[alarma]'";
	$row6  = mysql_fetch_array(mysql_query( $sql6));
	$sql5 = "SELECT * FROM control_parametros";
	$row5 = mysql_fetch_array(mysql_query($sql5));			
	
		$sql2 = "SELECT * FROM alarma_usuarios WHERE id_alarma='$id_alar'";
		$res2 = mysql_query($sql2);		
		while ($row2 = mysql_fetch_array($res2))			
		{	
			$sql_ord="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc, tipo,id_riesgo) ".
			"VALUES('".date("Y-m-d")."','".date("H:i:s")."','$login','$row_tmp[mensaje_u]','L','$id_alar')"; 
			
			mysql_query($sql_ord); 
					
			$sql_max="SELECT MAX(id_orden) AS max_orden FROM ordenes";
			$result_max=mysql_query($sql_max);
			$row_max=mysql_fetch_array($result_max);
				
			$sql_asig="INSERT INTO asignacion (id_orden,nivel_asig,criticidad_asig,prioridad_asig,asig,fecha_asig,hora_asig,".
			"fechaestsol_asig,reg_asig,diagnos) ".
			"VALUES('$row_max[max_orden]','3','1','1','$row2[usuario]','".date("Y-m-d")."','".date("H:i:s")."',".
			"'".date("Y-m-d")."','$login','$row6[desc_riesgo]')";
			
			mysql_query($sql_asig);
		}		
	$msg="Se crearon correctamente las Ordenes de Trabajo";
	
	if ($row_tmp['msn_mail']==1)
	{	
		$sql2 = "SELECT * FROM alarma_usuarios WHERE id_alarma='$id_alar'";
		$res2 = mysql_query($sql2);		
		while ($row2 = mysql_fetch_array($res2))			
		{	$sql = "SELECT nom_usr,apa_usr,ama_usr FROM users WHERE login_usr='$login'";
			$row = mysql_fetch_array(mysql_query( $sql));				
			$usuario1 = $row['nom_usr']." ".$row[apa_usr]." ".$row['ama_usr'];
			$sql_u = "SELECT nom_usr,apa_usr,ama_usr, area_usr, email FROM users WHERE login_usr='$row2[usuario]'";
			$row_u = mysql_fetch_array(mysql_query( $sql_u));
			$mail = trim($row_u['email']);
			$asunto = "ALARMA DE RIESGOS";
			$usuario = $row_u['nom_usr']." ".$row_u['apa_usr']." ".$row_u['ama_usr'];
$mensaje = "
ALARMA: Nro. $id_alar
Institucion: $row5[nombre]
Tipo de Riesgo:$row4[descripcion]
Riesgo: $row6[desc_riesgo]
Enviado por: $usuario1
Mensaje: $row_tmp[mensaje_u]

Para mayores detalles, consulte el Sistema GesTor F1.";

			$tunombre = $row5['nombre'];	
			$tuemail = $row5['mail_institucion'];
			$headers  = "From: $tunombre <$tuemail>\n";
			$headers .= "\n";	
													
			if(!mail($mail,$asunto,$mensaje,$headers)) 
				{$fallas.= $usuario.", ";}										
			else 
				{$lista0.= $usuario.", ";}
		}		
		if (!empty($lista0)) {$msg=$msg."\\nSe enviaron correctamente los correos electronicos a los usuarios.";}
				
		$sql2 = "SELECT * FROM alarma_proveedores WHERE id_alarma='$id_alar'";
		$res2 = mysql_query($sql2);		
		while ($row2 = mysql_fetch_array($res2))			
		{	$sql = "SELECT nom_usr,apa_usr,ama_usr, area_usr FROM users WHERE login_usr='$login'";
			$row = mysql_fetch_array(mysql_query( $sql));
			$usuario1 = $row[nom_usr]." ".$row[apa_usr]." ".$row[ama_usr];				
			$sql_u = "SELECT NombProv, email_prov FROM proveedor WHERE IdProv='$row2[id_proveedor]'";
			$row_u = mysql_fetch_array(mysql_query( $sql_u));
			$mail = trim($row_u['email_prov']);
			$asunto = "ALARMA DE RIESGOS";
			$usuario = $row_u['NombProv'];
$mensaje = "
ALARMA: Nro. $id_alar
Institucion: $row5[nombre]
Tipo de Riesgo:$row4[descripcion]
Riesgo: $row6[desc_riesgo]
Enviado por: $usuario1
Mensaje: $row_tmp[mensaje_p]

Para mayores detalles, consulte el Sistema GesTor F1.";

			$tunombre = $row5['nombre'];	
			$tuemail = $row5['mail_institucion'];						
			$headers  = "From: $tunombre <$tuemail>\n";
			$headers .= "\n";	
													
			if(!mail($mail,$asunto,$mensaje,$headers)) 
				{$fallas.= $usuario.", ";}										
			else 
				{$lista1.= $usuario.", ";}
		}			
	if (!empty($lista1)) {$msg=$msg."\\nSe enviaron correctamente los correos electronicos a los proveedores.";}

	$sql2 = "SELECT * FROM alarma_entidad WHERE id_alarma='$id_alar'";
	$res2 = mysql_query($sql2);		
	while ($row2 = mysql_fetch_array($res2))			
		{	$sql = "SELECT nom_usr,apa_usr,ama_usr FROM users WHERE login_usr='$login'";
			$row = mysql_fetch_array(mysql_query( $sql));
			$usuario1 = $row['nom_usr']." ".$row['apa_usr']." ".$row['ama_usr'];				
			$sql_u = "SELECT desc_dep,mail_dep FROM procesos_parametros WHERE tipo_dep='2' AND id_dep='$row2[id_entidad]'";
			$row_u = mysql_fetch_array(mysql_query( $sql_u));
			$mail = trim($row_u['mail_dep']);
			$asunto = "ALARMA DE RIESGOS";
			$usuario = $row_u['desc_dep'];
$mensaje = "
ALARMA: Nro. $id_alar
Institucion: $row5[nombre]
Tipo de Riesgo:$row4[descripcion]
Riesgo: $row6[desc_riesgo]
Enviado por: $usuario1
Mensaje: $row_tmp[mensaje_e]

Para mayores detalles, consulte el Sistema GesTor F1.";

			$tunombre = $row5['nombre'];	
			$tuemail = $row5['mail_institucion'];						
			$headers  = "From: $tunombre <$tuemail>\n";
			$headers .= "\n";	
													
			if(!mail($mail,$asunto,$mensaje,$headers)) 
				{$fallas.= $usuario.", ";}										
			else 
				{$lista2.= $usuario.", ";}
		}
	 if (!empty($lista2)) {$msg=$msg."\\nSe enviaron correctamente los correos electronicos a las entidades.";} 
	 if (!empty($fallas)) {$msg1 = "Han ocurrido algunas fallas durante el envio de alarmas, no se envio correo electronico a : $fallas";	}
	 }	
	 if ($row_tmp['msn_celu']==1)
	 {					 
		$sqlMovil = "SELECT id_dat_tel_movil, direccion FROM dat_tel_movil";
		$movilRs  = mysql_query( $sqlMovil);
		while($tmp = mysql_fetch_array($movilRs))
		{
			$movilLst[$tmp['id_dat_tel_movil']]= $tmp['direccion'];
		}	 
	 	$sql2 = "SELECT * FROM alarma_usuarios WHERE id_alarma='$id_alar'";
		$res2 = mysql_query($sql2);		
		while ($row2 = mysql_fetch_array($res2))			
		{	
			$sql = "SELECT nom_usr,apa_usr,ama_usr, area_usr, ext_usr, id_dat_tel_movil FROM users WHERE login_usr='$row2[usuario]'";
			$userData = mysql_fetch_array(mysql_query( $sql));			
			$userData['movilEmail']="591".$userData['ext_usr']."@".$movilLst[$userData['id_dat_tel_movil']];
			$mensaje = substr($row_tmp['mensaje_u'],0, 50);
			$mensaje1 = substr($row6['desc_riesgo'],0, 20);	
			$clienteNombre = $userData['apa_usr']." ".$userData['ama_usr']." ".$userData['nom_usr'];					
			if (!(mail($userData['movilEmail'],$mensaje1,$mensaje))){$fallas2.= $clienteNombre.", ";}
			else  $lista3.= $clienteNombre.", "; 
			unset($userData['movilEmail']);													
		}	 
		if (!empty($lista3)) {$msg=$msg."\\nSe enviaron correctamente los SMS a los usuarios.";} 
		if (!empty($fallas2)) {$msg2 = "Han ocurrido algunas fallas durante el envio de alarmas, no se envio SMS a : $fallas";	}
	 }
}
include ("top.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
</head>
<body>
	
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
  <tr class="titulo">
    <th colspan="10" background="images/main-button-tileR2.jpg">LISTA DE ALARMAS</th>
  </tr>
  <tr align="center"> 
    <th width="4%" class="menu style2 style3" background="images/main-button-tileR2.jpg">Nro.</th>
    <th width="15%" class="menu style2 style3" background="images/main-button-tileR2.jpg">TIPO DE RIESGO</th>
    <th width="22%" class="menu style2 style3" background="images/main-button-tileR2.jpg">RIESGO</th>
    <th width="22%" class="menu style2 style3" background="images/main-button-tileR2.jpg">MENSAJE USUARIOS</th>
    <th width="6%" class="menu style2 style3" background="images/main-button-tileR2.jpg">FECHA CREACION</th>
    <th width="10%" class="menu style2 style3" background="images/main-button-tileR2.jpg">TIPO DE ENVIO</th>
    <th width="5%" class="menu style2 style3" background="images/main-button-tileR2.jpg">ORDENES SIN SOLUCION</th>
	<th width="5%" class="menu style2 style3" background="images/main-button-tileR2.jpg">ENVIAR ALARMA</th>
	<?php if ($tipo=="A"){?>
	<th width="5%" class="menu" background="images/main-button-tileR2.jpg">MODIFICAR</th>
	<?php }?>
    <th width="5%" class="menu" background="images/main-button-tileR2.jpg">IMPRIMIR</th>
  </tr>
  <?php	
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);

	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM alarmas_riesgos";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
//=====end Pag.	

		$c = 1;
		$sql3 = "SELECT *, DATE_FORMAT(fec_creacion, '%d/%m/%Y') AS fec_creacion FROM alarmas_riesgos ORDER BY id_alarma DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
		$res3 = mysql_query($sql3);
		while(@$row3 = mysql_fetch_array($res3)) 
		{	$sql4  = "SELECT id_riesgo, descripcion FROM riesgo_tipos WHERE id_riesgo='$row3[tipo_alarma]'";
			$row4  = mysql_fetch_array(mysql_query( $sql4));
			$sql5  = "SELECT id_riesgo, desc_riesgo  FROM riesgo_pregunta WHERE id_riesgo='$row3[alarma]'";
			$row5  = mysql_fetch_array(mysql_query( $sql5));
			echo "<tr align ='center'>";
			echo "<td>".$row3['id_alarma']."</td>";
			echo "<td>".$row4['descripcion']."</td>";
			echo "<td>".$row5['desc_riesgo']."</td>";
			echo "<td>".$row3['mensaje_u']."&nbsp;</td>";
			echo "<td>".$row3['fec_creacion']."</td>";
			echo "<td>";
			echo "Orden de Trabajo";
			if ($row3['msn_mail']==1){echo "<br>Correo Electronico";}
			if ($row3['msn_celu']==1){echo "<br>Mesaje a Celular";}
			echo "&nbsp;</td>";
			echo "<td>";
			$numsol=0;
			$sql_o="SELECT id_orden FROM ordenes WHERE id_orden='$row3[id_alarma]'";
			$result_o1=mysql_query($sql_o);
			$result_o=mysql_query($sql_o);
			if(mysql_fetch_array($result_o1))
			{
				while($row_o=mysql_fetch_array($result_o))
				{
					$sql_s="SELECT id_orden FROM solucion WHERE id_orden='$row_o[id_orden]'";
					$result_s=mysql_query($sql_s);
					$row_s=mysql_fetch_array($result_s);
					if (!$row_s['id_orden']){$numsol=$numsol+1;}
				}
				if ($numsol=="0"){echo "<img src=\"images/ok.gif\" border=\"0\" alt=\"Solucionados\">";}
				else {echo $numsol;}
			}
			else
			{echo "<img src=\"images/ok.gif\" border=\"0\" alt=\"Solucionados\">";}
			
			echo "</td>";
			echo "<td><a href=\"?ejecutar=enviar_alarma&id_alar=$row3[id_alarma]\"><img src=\"images/enviar.jpg\" border=\"0\" alt=\"Contactar\"></a></td>";
			if ($tipo=="A") 
			{
				echo "<td><a href=\"riesgo_alarmas_last.php?id_alar=$row3[id_alarma]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></td>";
			}
			echo "<td><div style=cursor:hand><a onClick=impresion_a('$row3[id_alarma]') target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Alarmas\"></a></div></td>";
			echo "</tr>";
			$c++;
		}
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
<form name="form1" action="lista_alarmas.php" method="post">
  <input name="pg" type="hidden" id="pg" value="<?php echo $pg?>">
  <input name="idproc" type="hidden" id="idproc" value="<?php echo $idproc?>">
  <input name="BUSCAR" type="hidden" value="<?php echo $BUSCAR;?>">
  <input name="menu" type="hidden" value="<?php echo $menu;?>">
  <input name="busc" type="hidden" value="<?php echo $busc;?>">
<table width="311" align="center">
    <tr>
      <td height="40" align="center"> 
		<input type="submit" name="NUEVO" value="    NUEVO    ">
	  </td>	
	  <td><input type="submit" name="RETORNAR2" value=" RETORNAR "></td>
	  <td align="center"><input name="IMPRIMIR" type="button" onClick="imprimir()" id="IMPRIMIR" value="IMPRIMIR">
	 </td>
    </tr>							
</table>

</form>
</body>
</html>
<script language="JavaScript">

function impresion_a(campo)
{
	open('ver_alarmas.php?alarma='+campo,'Alarmas','location=no,menubar=yes,status=no,toolbar=no,scrollbars=1,resizable=yes');	
}
function imprimir(){
	open("impresion_riesgo.php")
}
function confirmLink(theLink, archi)
{
    var is_confirmed = confirm("Desea realmente eliminar la Alarma"+ ' :\n' +" Nro.:" + archi + "\n\nMensaje generado por GesTor F1");
    if (is_confirmed) {
        theLink.href += '&confirmado=1';
    }
    return is_confirmed;
} 
	
<?php
	if (isset($msg)) {
	print "var msg=\"$msg\";\n";
	print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
	} 
	if (isset($msg1)) {
	print "var msg1=\"$msg1\";\n";
	print "alert ( msg1 + \"\\n \\nMensaje generado por GesTor F1.\");\n";
	} 
	if (isset($msg2)) {
	print "var msg2=\"$msg2\";\n";
	print "alert ( msg2 + \"\\n \\nMensaje generado por GesTor F1.\");\n";
	} 
?>
		
</script>