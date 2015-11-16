<?php
session_start();
$login=$_SESSION["login"];
include ("../../../conexion.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><head>
<link href="SCLIB/style_105.css" type="text/css" rel="stylesheet">
<link href="SCLIB/style.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="SCLIB/style.css" media="screen,projection"/>
<style type="text/css">
.style1 {
	text-align: center;
}
.style2 {
	text-align: left;
	color: #FFFFFF;
	font-size: small;
}
.Estilo1 {color: #9ECA90}
body,td,th {
	color: #9ECA90;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<script language="JavaScript" src="SCLIB/incMenu.js"></script>
<script>
function regVis(aux){
	var tipo=aux;
	location.href="izq.php?variable="+tipo;
}
</script>
<?php
@session_start();
$login_usr = $_SESSION["login"];
include("../../../conexion.php");
if(!empty($_GET['variable'])){
	$tipoN = $_GET['variable'];
	if($tipoN=="tbl_1")
		$n_norma="NORINT";
	if($tipoN=="tbl_2")
		$n_norma="NORPIC";
	if($tipoN=="tbl_3")
		$n_norma="NORTI";
	if($tipoN=="tbl_4")
		$n_norma="PLANOS";
	if($tipoN=="tbl_5")
		$n_norma="REPORTES";
	if($tipoN=="tbl_6")
		$n_norma="DOC1";
	if($tipoN=="tbl_7")
		$n_norma="DOC2";
	if($tipoN=="tbl_8")
		$n_norma="DOC3";	
	$sql="INSERT INTO t_pnp (login_usr,pnp,n_nombre,fecha,hora) VALUES('$login_usr','$tipoN','$n_norma','".date('Y-m-d')."','".date('H:i:s')."')";
	//echo $sql;	
	mysql_query($sql);
}
?>
<base target="_blank" />

			<div id="menu" style="width: 230px">
					<br>
				  <div align="left"><a href="centro.html" target="mainFrame"><img src="imagenes/cabe1.gif" alt="" width="139" height="66" class="ImageBorder" /></a></div>
					<br>
					
					<a href="../AAP - Administracion del Ambiente de Produccion/NORAAP - NORMA DE ADMINISTRACION DEL AMBIENTE DE PRODUCCION.pdf" target="mainFrame" onClick="onClick=regVis('tbl_1');menuShow(tbl_1)" class="linkParentSideMenu">
					<span class="Estilo1"><font face="verdana" size="3">NORINT</font></a></span>
					
					<br />
					<span class="Estilo1">
					<a href="../ACP - Administracion de Cambios en Produccion/NORACP -  NORMA DE ADMINISTRACI_323N DE CAMBIOS EN PRODUCCI_323N.pdf" target="mainFrame" onClick="onClick=regVis('tbl_2');menuShow('tbl_2');" class="linkParentSideMenu"><font face="verdana" size="3">NORPIC</font></a>					</span>
					<ul class="Estilo1" id="tbl_2" style="display:none">
	                	<li><a href="../ACP - Administracion de Cambios en Produccion/NORACP -  NORMA DE ADMINISTRACI_323N DE CAMBIOS EN PRODUCCI_323N.pdf" target="mainFrame" >Administracion de Cambios en Produccion</a></li>
					</ul>
					<br />
					<span class="Estilo1">
					<a href="../ACT - Administracion de Contratos de Tecnologia/NORACT - Norma de Administracion de Contratos de Tecnolog1.pdf" target="mainFrame" onClick="regVis('tbl_3');" class="linkParentSideMenu"><font face="verdana" size="3">NORTI</font></a>					</span>
					<ul class="Estilo1" id="tbl_3" style="display:none">
	                	<li><a href="../ACT - Administracion de Contratos de Tecnologia/NORACT - Norma de Administracion de Contratos de Tecnolog1.pdf" target="mainFrame" >Administracion de Contratos de Tecnologia</a></li>
					</ul>
						<br />	
					<span class="Estilo1"> 
					<a href="../Planos DataCenter/PlanosDataCenter.pdf" target="mainFrame" onClick="onClick=regVis('tbl_4');menuShow('tbl_4');" class="linkParentSideMenu"><font face="verdana" size="3">PLANOS DATA CENTER</font></a>					</span>
					<ul class="Estilo1" id="tbl_4" style="display:none">
	                	<li><a href="../ACP - Administracion de Cambios en Produccion/NORACP -  NORMA DE ADMINISTRACI_323N DE CAMBIOS EN PRODUCCI_323N.pdf" target="mainFrame" >DOCUMENTO PLAONS DATA CENTER</a></li>
					</ul>
					<br />
					<span class="Estilo1">
					<a href="../reportes/reportes.pdf" target="mainFrame" onClick="onClick=regVis('tbl_5');menuShow('tbl_5');" class="linkParentSideMenu"><font face="verdana" size="3">REPORTES</font></a>					</span>
					<ul class="Estilo1" id="tbl_5" style="display:none">
	                	<li><a href="../ACP - Administracion de Cambios en Produccion/NORACP -  NORMA DE ADMINISTRACI_323N DE CAMBIOS EN PRODUCCI_323N.pdf" target="mainFrame" >DOCUMENTO PLAONS DATA CENTER</a></li>
					</ul>
					<br />
					<span class="Estilo1">
					<a href="../documento1/doc1.pdf" target="mainFrame" onClick="onClick=regVis('tbl_6');menuShow('tbl_6');" class="linkParentSideMenu"><font face="verdana" size="3">DOC 1</font></a>					</span>
					<ul class="Estilo1" id="tbl_6" style="display:none">
	                	<li><a href="../documento1/doc1.pdf" target="mainFrame" >DOCUMENTO 1</a></li>
					</ul>
					<br />
					<span class="Estilo1">
					<a href="../documento2/doc2.pdf"" target="mainFrame" onClick="onClick=regVis('tbl_7');menuShow('tbl_7');" class="linkParentSideMenu"><font face="verdana" size="3">DOC 2</font></a>					</span>
					<ul class="Estilo1" id="tbl_7" style="display:none">
	                	<li><a href="../documento2/doc2.pdf" target="mainFrame" >DOCUMENTO 2</a></li>
					</ul>
					<br />
					<span class="Estilo1">
					<a href="../documento3/doc3.pdf"" target="mainFrame" onClick="regVis('tbl_8');" class="linkParentSideMenu"><font face="verdana" size="3">DOC 3</font></a>					</span>
					<ul class="Estilo1" id="tbl_8" style="display:none">
	                	<li><a href="../documento3/doc3.pdf" target="mainFrame" >Documento 3</a></li>
					</ul>
					
					
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					
					
					</ul>	
							
					<span class="Estilo1">
					<!--<a href="capa.html" target="mainFrame" onClick="menuShow('tbl_19');" class="linkParentSideMenu"><font face="verdana" size="3">CAPACITACION</font></a>-->					</span>
					<ul class="Estilo1" id="tbl_19" style="display:none">
						<li><a><strong>Capacitacion a Usuarios</strong></a></li>
						<li><a href="../CAPACITACION/Capacitacion Seguridad Usuarios Finales.pdf" target="mainFrame">Capacitacion Seguridad Usuarios Finales</a></li>
						<li><a href="../CAPACITACION/Capacitacion Norma de Seguridad Fisica.pdf" target="mainFrame">Capacitacion Norma de Seguridad Fisica</a></li>
						<li><a href="../CAPACITACION/Capacitacion Profilactica Antivirus.pdf" target="mainFrame">Capacitacion Profilactica Antivirus</a></li>
						<li><a href="../CAPACITACION/correo_spam_prueba.html" target="mainFrame">CORREO SPAM</a></li>
						<li><a href="../CAPACITACION/spyware_prueba.html" target="mainFrame">SPYWARE</a></li>
					</ul>			
					<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>
					<div id="nav_btm" class="style2"><strong><a href="http://www.yanapti.com">www.yanapti.com</a></strong></div>	
			</div>
			</div>
</body>

