<?php
// Version: 	1.0
// Objetivo: 	Optimizacion de consultas SQL. (Reducir consumo de recursos)
// Fecha: 		30/OCT/2012

// Objetivo1: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
// Fecha1: 		20/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

require ("conexion.php");
@session_start();
$login_usr = $_SESSION["login"];
$sql3 = "SELECT * FROM users WHERE login_usr='$login_usr'";
$res3 = mysql_query($sql3); // 
$row3 = mysql_fetch_array($res3);

$sql_cp = "SELECT * FROM control_parametros";
$res_cp = mysql_query($sql_cp);
$row_cp = mysql_fetch_array($res_cp);

if (isset($closeord)){
	if($closeord == 1){
		//echo "<br>close orde : ".$closeord;
		//echo "<br>vector : ".$vector;
		$ordenes = explode("|",$vector);
		for($i=1; $i<=count($ordenes) - 2; $i++)
		{
			//echo "<br>ordenes : ".$ordenes[$i];
			$sql = "Select * from asignacion where id_orden='".$ordenes[$i]."'";
			//echo "<br>sql  : ".$sql;
			$res = mysql_query($sql);
			$num = mysql_num_rows($res);		
			//echo "<br>num es : ".$num;
			
			if($num == 0)
			{
				$sqlins = "insert into asignacion (id_orden, nivel_asig, criticidad_asig, prioridad_asig, asig, fecha_asig, hora_asig, fechaestsol_asig, reg_asig, diagnos, area)
				values('$ordenes[$i]', 3, 1, 1, 'admin','".date("Y-m-d")."','".date("H:i:s")."', '".date("Y-m-d")."', 'admin', 'ORDEN ASIGNADA POR ADMINISTRADOR DEL SISTEMA', 'Mesa')";
				mysql_query($sqlins);
				
				$sqlsol = "insert into solucion (id_orden, detalles_sol, fecha_sol_e, fecha_sol, hora_sol, medprev_sol, login_sol, observaciones)
				values ('$ordenes[$i]', 'ORDEN CERRADA POR EL ADMINISTRADOR DEL SISTEMA', '".date("Y-m-d")."', '".date("Y-m-d")."','".date("H:i:s")."', 'EL USUARIO ADMINISTRADOR CERRO LA ORDEN', 'admin', observaciones='LA ORDEN NO HA SIDO SOLUCIONADA POR TANTO EL ADMINISTRADOR CERRO DICHA ORDEN')";
				mysql_query($sqlsol);
				//echo "<br>sql sol: ".$sqlsol;
				$sqlconf = "insert into conformidad (id_orden, fecha_conf, hora_conf, tiemposol_conf, calidaten_conf,obscli_conf,reg_conf, tipo_conf) 
				values ('$ordenes[$i]', '".date("Y-m-d")."','".date("H:i:s")."', '2', '2', 'EL ADMINISTRADOR DA CONFORMIDAD AUTOMATICAMENTE POR CIERRE DE ORDEN', 'admin', '1')";
				//echo "<br>sqlconf : ".$sqlconf;
				mysql_query($sqlconf);
			}
			else
			{
				$sql_sol = "select *from solucion where id_orden = '$ordenes[$i]'";
				$res_sol = mysql_query($sql_sol);
				$num_sol = mysql_num_rows($res_sol);
				//echo "<br>num_sol : ".$num_sol;
				if($num_sol == 0)
				{
					$sql_ins = "insert into solucion (id_orden, detalles_sol, fecha_sol_e, fecha_sol, hora_sol, medprev_sol, login_sol, observaciones)
					values ('$ordenes[$i]', 'ORDEN CERRADA POR EL ADMINISTRADOR DEL SISTEMA', '".date("Y-m-d")."', '".date("Y-m-d")."','".date("H:i:s")."', 'EL USUARIO ADMINISTRADOR CERR� LA ORDEN', 'admin', observaciones='LA ORDEN NO HA SIDO SOLUCIONADA POR TANTO EL ADMINISTRADOR CERR� DICHA ORDEN')";
					mysql_query($sql_ins);
					//echo "<br>sql sol: ".$sql_ins;
					$sql_conf = "insert into conformidad (id_orden, fecha_conf, hora_conf, tiemposol_conf, calidaten_conf,obscli_conf,reg_conf, tipo_conf) 
					values ('$ordenes[$i]', '".date("Y-m-d")."','".date("H:i:s")."', '2', '2', 'EL ADMINISTRADOR DA CONFORMIDAD AUTOM�TICAMENTE POR CIERRE DE ORDEN', 'admin', '1')";
					//echo "<br>sqlconf : ".$sql_conf;
					mysql_query($sql_conf);
				}
			}
			//die();
		}
	}
}

if (empty($menu))
{	
	if ($row3['visualizacion'] == 1) $opc = 1;
	else  $menu = "general";
}
if(isset($vent)){
	if (!$vent)
	{
		$sqlaux="select lectura from roles where login_usr='$login_usr'";
		$resaux=mysql_query($sqlaux);
		$read=mysql_fetch_array($resaux);
		$lectura="T";
		if ($read['lectura']=="r"){ $lectura="A";} 
		if ($row3['tipo2_usr'] == $lectura AND $row_cp['tecni_solo']=="1"){ header("location: listae.php?Naveg=Ordenes de Trabajo"); exit;}
		if ($row3['tipo_usr'] == "EXTERNO"){ header("location: listae.php?Naveg=Ordenes de Trabajo"); exit;}
		if ( $opc == 1){ header("location: listans.php?Naveg=Ordenes de Trabajo"); }
	}
	else
	{
		if ($row3['tipo2_usr'] == "T" AND $row_cp['tecni_solo']=="1"){ header("location: listae.php?Naveg=Ordenes de Trabajo&vent=1"); exit;}
		if ($row3['tipo_usr'] == "EXTERNO"){ header("location: listae.php?Naveg=Ordenes de Trabajo&vent=1"); exit;}
		if ( $opc == 1){ header("location: listans.php?Naveg=Ordenes de Trabajo&vent=1"); }
	}
}
include ("top.php"); ?>
<?php include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("segui","Seguimiento.");
	$help->AddHelp("tipo","Tipo de Cliente. A: Administrador, T: Tecnico, C: Cliente.");
	$help->AddHelp("conf","Conformidad.");
	$help->AddHelp("solu","Solucion.");
	$help->AddHelp("3","Desarrollo");
	$help->AddHelp("incidencia","Consultas de los clientes sin aclarar la naturaleza de las mismas.");
	print $help->ToHtml();
?>
<p>
  
<form action="" method="get" name="form2" id="form2" >
 <input name="opc" type="hidden" value="<?php echo @$opc;?>">
  <table width="80%" border="1" align="center" bgcolor="#006699">
    <tr> 
      <td width="60%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Busqueda por :</strong></font> 
          <select name="menu" id="menu" onChange="tipo(this.value)">
		  	<option value="general">General</option>
            <option value="asignado"<?php if ($menu=="asignado") echo 'selected ';?>>Asignado</option>
            <option value="noAsignado"<?php if ($menu=="noAsignado") echo 'selected ';?>>No Asignado</option>
            <option value="solucionado"<?php if ($menu=="solucionado") echo 'selected ';?>>Solucionado</option>
            <option value="noSolucionado"<?php if ($menu=="noSolucionado") echo 'selected ';?>>No Solucionado</option>
            <option value="conConformidad"<?php if ($menu=="conConformidad") echo 'selected ';?>>Con Conformidad</option>
            <option value="sinConformidad"<?php if ($menu=="sinConformidad") echo 'selected ';?>>Sin Conformidad</option>
			<?php if ($tipo != "C"){?>
            <option value="enviadoPor"<?php if ($menu=="enviadoPor") echo 'selected ';?>>Enviado Por</option>
			<?php }?>
			<option value="nro_de_orden"<?php if ($menu=="nro_de_orden") echo 'selected ';?>>Nro. de Orden</option>
			<option value="consulta"<?php if ($menu=="consulta") echo 'selected ';?>>Consulta</option>
		   </select>
          &nbsp;&nbsp;&nbsp;
          <?php if($menu!="nro_de_orden" and $menu!="consulta") {?>
		  <select name="selecta">
            <option value="general">General</option>
			<?php
			switch ($menu) {
			case "general";
			break;
			case "conConformidad":
						/*$auxb='nochar';
						$sqlb= "SELECT distinct(cod_usr) AS maxi FROM ordenes";
						$resultb=mysql_query( $sqlb);
						while ($rowb = mysql_fetch_array($resultb)) {
									$auxb=$auxb.", '".$rowb['maxi']."'";
								};
						$auxb=str_replace('nochar,',' ', $auxb);
						$sqltec="SELECT * from users WHERE tipo2_usr='T' AND login_usr NOT IN ($auxb) AND bloquear=0 ORDER BY apa_usr";*/
						if($tipo == "C"){
						$auxb='nochar';
						$sqlb= "SELECT distinct(cod_usr) AS maxi FROM ordenes";
						$resultb=mysql_query($sqlb);
						while ($rowb = mysql_fetch_array($resultb)) {
									$auxb=$auxb.", '".$rowb['maxi']."'";
								};
						$auxb=str_replace('nochar,',' ', $auxb);
						$sqltec="SELECT * from users WHERE tipo2_usr='T' AND login_usr NOT IN ($auxb) AND bloquear=0 ORDER BY apa_usr";
					
					}else{
						$auxbox='nochar';
						$sqlbox= "SELECT max(id_asig) as maxi FROM asignacion group by id_orden";
						$resultbox=mysql_query( $sqlbox);
						while ($rowbox = mysql_fetch_array($resultbox)) {
						$auxbox=$auxbox.", ".$rowbox['maxi'];
						}
						$auxbox=str_replace('nochar,',' ', $auxbox);
			
						$auxbo='nochar';
						$sqlbo= "SELECT distinct(asig) AS maxi FROM asignacion WHERE id_asig IN ($auxbox)";
						$resultbo=mysql_query( $sqlbo);
						while ($rowbo = mysql_fetch_array($resultbo)) {
						$auxbo=$auxbo.", '".$rowbo['maxi']."'";
						}
						$auxbo=str_replace('nochar,',' ', $auxbo);
						//$sqltec="SELECT * from users WHERE tipo2_usr='T' AND login_usr IN ($auxbo) AND bloquear=0 ORDER BY apa_usr";
						$sqltec="SELECT * from users WHERE bloquear=0 ORDER BY apa_usr";
					}
				break;
			case "sinConformidad":
					if($tipo == "C"){
						$auxb='nochar';
						$sqlb= "SELECT distinct(cod_usr) AS maxi FROM ordenes";
						$resultb=mysql_query($sqlb);
						while ($rowb = mysql_fetch_array($resultb)) {
									$auxb=$auxb.", '".$rowb['maxi']."'";
								};
						$auxb=str_replace('nochar,',' ', $auxb);
						$sqltec="SELECT * from users WHERE tipo2_usr='T' AND login_usr NOT IN ($auxb) AND bloquear=0 ORDER BY apa_usr";
						
					
					}else{
						$auxbox='nochar';
						$sqlbox= "SELECT max(id_asig) as maxi FROM asignacion group by id_orden";
						$resultbox=mysql_query($sqlbox);
						while ($rowbox = mysql_fetch_array($resultbox)) {
						$auxbox=$auxbox." ".$rowbox['maxi'];
						
						}
						$auxbox=str_replace('nochar,',' ', $auxbox);
						$auxbo='nochar';
						$sqlbo= "SELECT distinct(asig) AS maxi FROM asignacion WHERE id_asig IN ($auxbox)";
						$resultbo=mysql_query($sqlbo);
						while ($rowbo = mysql_fetch_array($resultbo)) {
						$auxbo=$auxbo.", '".$rowbo['maxi']."'";
						}
						$auxbo=str_replace('nochar,',' ', $auxbo);
						//$sqltec="SELECT * from users WHERE tipo2_usr='T' AND login_usr IN ($auxbo) AND bloquear=0 ORDER BY apa_usr";
						$sqltec="SELECT * from users WHERE bloquear=0 ORDER BY apa_usr";
						
					}
			break;
			case "noSolucionado":
						$auxbox='nochar';
						$sqlbox= "SELECT max(id_asig) as maxi FROM asignacion group by id_orden";
						$resultbox=mysql_query($sqlbox);
						while ($rowbox = mysql_fetch_array($resultbox)) {
						$auxbox=$auxbox.", ".$rowbox['maxi'];
						}
						$auxbox=str_replace('nochar,',' ', $auxbox);
			
						$auxbo='nochar';
						$sqlbo= "SELECT distinct(asig) AS maxi FROM asignacion WHERE id_asig IN ($auxbox)";
						$resultbo=mysql_query($sqlbo);
						while ($rowbo = mysql_fetch_array($resultbo)) {
							$auxbo=$auxbo.", '".$rowbo['maxi']."'";
						}
						$auxbo=str_replace('nochar,',' ', $auxbo);
						$sqltec="SELECT * from users WHERE tipo2_usr='T' AND login_usr IN ($auxbo) AND bloquear=0 ORDER BY apa_usr";
			break;
			case "enviadoPor":
				$sqltec="SELECT * from users WHERE tipo2_usr<>'A' AND tipo2_usr<>'B' AND bloquear=0 ORDER BY apa_usr";
			break;
			case "noAsignado":
				 //if($tipo == "A" or $tipo == "T" ){$sqltec="SELECT * from users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr";}
			break;
			default:
				$sqltec="SELECT * from users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr";
			break;
			}
			
			if (@$nro_requerimiento != ""){
				$sqltec = "SELECT * FROM ordenes where id_orden = $nro_requerimiento ORDER BY fecha DESC, time DESC";
				$resultec = mysql_query($sqltec);
			} 
			else {
				$resultec = @mysql_query($sqltec);
			}
			

			
			while($rowtec= @mysql_fetch_array($resultec)){
			?>
			 <option value="<?php echo $rowtec['login_usr'];?>"<?php if ($selecta==$rowtec['login_usr']) echo 'selected '; ?>><?php echo $rowtec['apa_usr']." ".$rowtec['ama_usr']." ".$rowtec['nom_usr'];?></option>
			<?php
			}
			
			?>
          </select>
		  <?php }else{?>
		  <input name="selecta" type="text" size="25" maxlength="25" value="">
		  <?php }?>&nbsp;&nbsp;
          <input name="BUSCAR" type="submit" id="BUSCAR" value="BUSCAR">
        </div></td>
	    </tr>
  </table>
</form>

<form method="get" name="frmOrdenes" action="" onsubmit="return false;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="bordercolor:#006699">
    <tr> 
    <td height="47" valign="top">
<table width="100%" id="tblOrdenes" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
        <tr> 
          <th colspan="20">ORDENES DE TRABAJO</th>
        </tr>
		<?php 
		if($tipo == "A"){?>
		<tr> 
          <th colspan="20">
		  	<!--<input type="button" name="btnAll" value="Seleccionar Todo" onclick="selectAll()">-->

                        <input type="checkbox" name="all" id="all" onclick="checkAll();" />
			<input type="button" name="btnNone" value=" Sin seleccion " onclick="selNone()" style="display:none">
			<input type="button" name="btnCerrar" value=" Cerrar Ordenes " onclick="javascript:cerrarOrdenes()"></th>
        </tr>
		<?php }?>
        <tr align="center"> 
          <td width="25" height="25" class="menu">Nro</td>
		  <td width="20" height="25" class="menu">ORIGEN</td>
          <td width="72" class="menu">FECHA Y HORA</td>
          <td width="84" class="menu">ENVIADO POR</td>
          <td width="17" class="menu">TIPO</td>
          <td width="60" class="menu">CLIENTE / TITULAR</td>
          <td width="200" class="menu">INCIDENCIA<?php //print $help->AddLink("incidencia", "INCIDENCIA"); ?></td>
		  <?php if($tipo == 'A'){?>
		  <td class="menu">OPCI&oacute;N</td>
		  <?php } ?>
          <td width="100" class="menu">ASIGNACION</td>
          <td width="100" class="menu">TIPO ASIGNACION</td>
          <td width="61" class="menu">FECHA SOLUCION</td>
          <td width="17" class="menu">SEGUI<?php //print $help->AddLink("segui", "SEGUI"); ?></td>
          <td width="17" class="menu">SOLU.<?php //print $help->AddLink("solu", "SOLU."); ?></td>
          <td width="17" class="menu">CONF.<?php //print $help->AddLink("conf", "CONF."); ?></td>
          <?php  if($tipo=="A"  or $tipo=="B" or $tipo=="T") {
             echo "<th width=\"40\" class=\"menu\">COSTO</th>";
	  }?>
          <td width="50" class="menu">IMPRIMIR INTERNO</td>
          <td width="50" class="menu">IMPRIMIR EXTERNO</td>
          <td width="60" class="menu">ARCHIVO ADJUNTO</td>
		  <td width="60" class="menu">ORIGEN 2</td>
        </tr>
        <?php
	
	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);
	if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ordenes";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);

$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

if($tipo=="A" or $tipo=="B") 
{	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ordenes";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql = "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes ORDER BY id_orden DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";}
else if ($tipo=="D")
{

	$sqluser="SELECT * from users where login_usr='$login_usr'";
	$resultuser=mysql_query($sqluser);
	$rowuser=mysql_fetch_array($resultuser);
    $_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ordenes where area='".$rowuser['area_usr']."'";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
	$sql = "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes where area='".$rowuser['area_usr']."' ORDER BY id_orden DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";
}
else if($tipo=="T") 
{	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ordenes WHERE cod_usr<>'SISTEMA'";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql = "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE cod_usr<>'SISTEMA' ORDER BY id_orden DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";}
else if($tipo=="C") 
{	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ordenes WHERE cod_usr='$login'";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql = "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE cod_usr='$login' ORDER BY id_orden DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";}

if($tipo=="A" or $tipo=="B") {$sqlAdd = "";}
else if($tipo=="T") {$sqlAdd = "cod_usr<>'SISTEMA'"." AND ";}
else if($tipo=="C") {$sqlAdd = "cod_usr='$login'"." AND ";}
//-----------------------------------------------------------------------------------------------------------------------

if(@$selecta=='general') {$login_usr='%';}
else @$login_usr=$selecta;

//------------------------------------------------------------------------------------------------------------------------
?>
<input type="hidden" name="txtLimite" value="<?php=$_pagi_cuantos?>">
<?php
switch ($menu) {
	/*case "general":
		//
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion group by id_orden";
		$resultbo=mysql_query( $sqlbo);
		while ($rowbo = mysql_fetch_array($resultbo)) {
		$auxbo=$auxbo.", ".$rowbo['maxi'];
		}
		$auxbo=str_replace('nochar,',' ', $auxbo);
				
		$sql11 = "SELECT * FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		if(empty($row11[num_ord_pag])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11[num_ord_pag] ;}
		if (empty($_GET['pg'])) {$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}
		
		if ($tipo=="A" or $tipo=="B") $_pagi_sqlConta9 = "SELECT count(id_orden) AS pagi_totalReg FROM ordenes ORDER BY id_orden DESC";
		else $_pagi_sqlConta9 = "SELECT count(id_orden) AS pagi_totalReg FROM  ordenes ORDER BY id_orden DESC";
		$result9=mysql_query($_pagi_sqlConta9);
		$row9=mysql_fetch_array($result9);
		$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		//
		$sql="SELECT * FROM ordenes ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
		//$sqlOut="SELECT distinct id_orden FROM asignacion ORDER BY id_orden ASC limit $_pagi_inicial,$_pagi_cuantos";	
	break;*/
	case "asignado":
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion group by id_orden";
		$resultbo=mysql_query( $sqlbo);
		$login_usr = $_SESSION["login"];
		$sqluser="SELECT * from users where login_usr='$login_usr'";
		$resultuser=mysql_query($sqluser);
		$rowuser=mysql_fetch_array($resultuser);
		while ($rowbo = mysql_fetch_array($resultbo)) {
		$auxbo=$auxbo.", ".$rowbo['maxi'];
		}
		$auxbo=str_replace('nochar,',' ', $auxbo);
				
		$sql11 = "SELECT * FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		if(empty($row11['num_ord_pag'])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11['num_ord_pag'] ;}
		if (empty($_GET['pg'])) {$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}
		
		if ($tipo=="A" or $tipo=="B") 
		{$_pagi_sqlConta9 = "SELECT count(distinct a.id_orden) AS pagi_totalReg 
			FROM asignacion a LEFT JOIN ordenes o ON a.id_orden=o.id_orden 
			WHERE a.asig like '$login_usr' AND id_asig IN ($auxbo)";}
		else if ($tipo=="D") 
		{$_pagi_sqlConta9 = "SELECT count(distinct a.id_orden) AS pagi_totalReg 
			FROM asignacion a LEFT JOIN ordenes o ON a.id_orden=o.id_orden
			WHERE a.asig like '$selecta' AND a.id_asig IN ($auxbo) AND o.area=".$rowuser['area_usr'];}
		else {$_pagi_sqlConta9 = "SELECT count(distinct a.id_orden) AS pagi_totalReg 
			FROM  asignacion a LEFT JOIN ordenes o ON a.id_orden=o.id_orden 
			WHERE $sqlAdd AND a.asig like '$login_usr' AND id_asig IN ($auxbo)";}
		$result9=mysql_query($_pagi_sqlConta9);
		
		$row9=mysql_fetch_array($result9);
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
		if ($tipo=="A" or $tipo=="B") {$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, asignacion WHERE ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$selecta' AND id_asig IN ( $auxbo ) GROUP BY id_orden ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";}
		else if ($tipo=="D") {$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, asignacion WHERE ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$selecta' AND id_asig IN ( $auxbo ) AND ordenes.area='$rowuser[area_usr]' GROUP BY id_orden ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";}
		else {$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, asignacion WHERE $sqlAdd ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$selecta' AND id_asig IN ( $auxbo ) GROUP BY id_orden ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";}
		echo $sql;
		break;
	case "noSolucionado":
		
		$sqlbo1 = "SELECT id_orden AS maxi FROM solucion WHERE login_sol='$selecta'";		
		$resultbo1=mysql_query( $sqlbo1);
		while ($rowbo1 = mysql_fetch_array($resultbo1)) {
			$auxbo1 = $auxbo1.", ".$rowbo1['maxi'];
		}			
		@$auxbo1 = str_replace('nochar,',' ', $auxbo1);
		
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion group by id_orden";
		$resultbo=mysql_query( $sqlbo);
		while ($rowbo = mysql_fetch_array($resultbo)) {
		$auxbo=$auxbo.",".$rowbo['maxi'];
		}
		$auxbo3 = str_replace('nochar,',' ', $auxbo);					
		$auxbo8='nochar';
		$sqlbo8= "SELECT max(id_asig) as maxi FROM asignacion group by id_orden";
		$resultbo8=mysql_query( $sqlbo8);
		while ($rowbo8 = mysql_fetch_array($resultbo8)) {
		$auxbo8=$auxbo8.",".$rowbo8['maxi'];
		}
		$auxbo8 = str_replace('nochar,',' ', $auxbo8);
		
		$datos = explode (",",$auxbo);
		$auxbo='nochar';
		$c3 = 0;
		for ($i=0; $i<count($datos); $i++)		
		{	
			$sql_abc = "SELECT * FROM asignacion WHERE id_asig='".$datos[$i]."'";
			$res_abc = mysql_query( $sql_abc);
			$row_abc = mysql_fetch_array($res_abc);
			if ( $row_abc['asig']=="$selecta" )
			{	 $sql_or = "select * from solucion WHERE id_orden='".$row_abc['id_orden']."'"; 
				 $res_or = mysql_query( $sql_or);
				 $num2  = mysql_num_rows($res_or);				
				 if ( $num2 > 0 )
				 {  
				 }
				else
				 {  $auxbo=$auxbo.",".$datos[$i];}				
			}
		}			
		$auxbo = str_replace('nochar,',' ',$auxbo);	
		$auxbo1 = 'nochar';	
		$sqlbo1 = "SELECT id_orden AS maxi FROM solucion WHERE login_sol='$selecta'";		
		$resultbo1=mysql_query($sqlbo1);
		while ($rowbo1 = mysql_fetch_array($resultbo1)) {
			$auxbo1 = $auxbo1.", ".$rowbo1['maxi'];
		}			
		$auxbo1 = str_replace('nochar,',' ', $auxbo1);
		
		$sql11 = "SELECT * FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		if(empty($row11['num_ord_pag'])) {$_pagi_cuantos = 20 ; }
		else{  $_pagi_cuantos = $row11['num_ord_pag'] ;}
		if (empty($_GET['pg'])) {$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}
		if ($auxbo=='nochar')
		{
			if ($tipo=="A" or $tipo=="B") 
			{
				if ($selecta == "general")
			    {
					
					$auxbo12 = 'nochar';	
					$sqlbo12 = "SELECT id_orden AS maxi FROM solucion";		
					$resultbo12=mysql_query( $sqlbo12);
					while ($rowbo12 = mysql_fetch_array($resultbo12)) {
						$auxbo12 = $auxbo12.", ".$rowbo12['maxi'];
					}	
					if(mysql_num_rows($resultbo12) == 0)
				    { 
						$auxbo12 = 0;
					}			
					else
					{
						$auxbo12 = str_replace('nochar,',' ', $auxbo12);
					}
					 $_pagi_sqlConta9 = "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg 
					 FROM  ordenes, asignacion WHERE ordenes.id_orden=asignacion.id_orden AND ordenes.id_orden NOT IN($auxbo12)";
				}
				else
			    { 
		     
				  $_pagi_sqlConta9 = "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg 
				  FROM  ordenes, asignacion WHERE $sqlAdd ordenes.id_orden=asignacion.id_orden AND asignacion.asig 
				  LIKE  '$login_usr'";
				}
			}
			else  
			{ 
				if($auxbo == 'nochar')
				{
					$auxbo = 0;
				}

				$_pagi_sqlConta9= "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg  FROM ordenes, asignacion WHERE ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$login_usr' AND id_asig IN ($auxbo8)";
				if ($selecta=="general")
				{ 
					$auxbo12 = 'nochar';	
					$sqlbo12 = "SELECT id_orden AS maxi FROM solucion";		
					$resultbo12=mysql_query( $sqlbo12);
					while ($rowbo12 = mysql_fetch_array($resultbo12)) {
						$auxbo12 = $auxbo12.", ".$rowbo12['maxi'];
					}
					if(mysql_num_rows($resultbo12) == 0)
					{ 
						$auxbo12 = 0;
					}			
					else
					{
						$auxbo12 = str_replace('nochar,',' ', $auxbo12);
					}
					$_pagi_sqlConta9 = "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg 
					FROM  ordenes, asignacion WHERE ordenes.id_orden=asignacion.id_orden AND ordenes.id_orden NOT IN($auxbo12)";
				 }
				 else 
				 { 
				  $_pagi_sqlConta9 = "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg 
				  FROM  ordenes, asignacion WHERE ordenes.id_orden=asignacion.id_orden AND asignacion.asig 
				  LIKE  '$login_usr'";			
				 }				 
			}
		}
		else
		{
			if ($tipo=="A" or $tipo=="B")
			{ 
				$_pagi_sqlConta9 = "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg FROM ordenes, asignacion WHERE ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$login_usr' AND id_asig IN ($auxbo)";
			}
			else
			{ 
				$_pagi_sqlConta9 = "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg FROM  ordenes, asignacion WHERE $sqlAdd ordenes.id_orden=asignacion.id_orden AND asignacion.asig LIKE '$login_usr' AND id_asig IN ($auxbo)";
			}
		}
			$result9=mysql_query($_pagi_sqlConta9);
			$row9=mysql_fetch_array($result9);

			$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
			$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
			
		if ($auxbo=='nochar'){
			if ($tipo=="A" or $tipo=="B") 
			{  	if ($selecta=="general")
				{
					$auxbo12 = 'nochar';	
					$sqlbo12 = "SELECT id_orden AS maxi FROM solucion";		
					$resultbo12=mysql_query( $sqlbo12);
					while ($rowbo12 = mysql_fetch_array($resultbo12)) {
						$auxbo12 = $auxbo12.", ".$rowbo12['maxi'];
					}			
					 
					 if(mysql_num_rows($resultbo12) == 0)
				    { 
						$auxbo12 = 0;
					}			
					else
					{
						$auxbo12 = str_replace('nochar,',' ', $auxbo12);
					}

					$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, asignacion 
					WHERE ordenes.id_orden=asignacion.id_orden AND ordenes.id_orden NOT IN ( $auxbo12 ) 
					GROUP BY id_orden ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";				
					
				}
				else
				{$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, asignacion WHERE $sqlAdd ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$login_usr' AND id_asig IN (0) GROUP BY id_orden ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";				
				}
			}
			else 
			{	if ($selecta=="general")
				{
					$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, asignacion 
					WHERE $sqlAdd ordenes.id_orden=asignacion.id_orden AND ordenes.id_orden NOT IN ( $auxbo12 ) 
					GROUP BY id_orden ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";								
				}	
				else
				$sql= "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, asignacion WHERE ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$login_usr' AND id_asig IN (0) GROUP BY id_orden ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";				
			}
		}
		else{
			if ($tipo=="A" or $tipo=="B") 
			{ $sql = "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, asignacion 
			  WHERE ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$login_usr' 
			  AND id_asig IN ($auxbo) GROUP BY id_orden ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
			}
			else  
			$sql= "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, asignacion WHERE $sqlAdd  ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$login_usr' AND id_asig IN ( $auxbo ) GROUP BY id_orden ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
			}
			//echo "<br>sql : ".$sql;
		break;
	case "solucionado":
		$sql11 = "SELECT * FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		$login_usr = $_SESSION["login"];
		$sqluser="SELECT * from users where login_usr='$login_usr'";
		$resultuser=mysql_query($sqluser);
		$rowuser=mysql_fetch_array($resultuser);
		if(empty($row11['num_ord_pag'])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11['num_ord_pag'] ;}
		if (empty($_GET['pg'])) {$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}

		if ($tipo=="A" or $tipo=="B") $_pagi_sqlConta9 = "SELECT count(solucion.id_orden) AS pagi_totalReg FROM ordenes, solucion WHERE ordenes.id_orden=solucion.id_orden AND solucion.login_sol like '$selecta'";
		else if ($tipo=="D") {
		$_pagi_sqlConta9 = "SELECT count(solucion.id_orden) AS pagi_totalReg FROM ordenes, solucion WHERE ordenes.id_orden=solucion.id_orden AND solucion.login_sol='$selecta' AND ordenes.area='$rowarea[area_usr]'";
		} else $_pagi_sqlConta9 = "SELECT count(solucion.id_orden) AS pagi_totalReg FROM  ordenes, solucion WHERE $sqlAdd ordenes.id_orden=solucion.id_orden AND solucion.login_sol like '$selecta'";
		$result9=mysql_query($_pagi_sqlConta9);
		$row9=mysql_fetch_array($result9);
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		
		if ($tipo=="A" or $tipo=="B") $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, solucion WHERE ordenes.id_orden=solucion.id_orden AND solucion.login_sol like '$selecta' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
		else if ($tipo=="D") $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, solucion WHERE ordenes.id_orden=solucion.id_orden AND solucion.login_sol='$selecta' AND ordenes.area=".$rowuser['area_usr']." ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
		else $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, solucion WHERE $sqlAdd  ordenes.id_orden=solucion.id_orden AND solucion.login_sol like '$selecta' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
		
		break;
	case "enviadoPor":
		$sql11 = "SELECT * FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		$login_usr = $_SESSION["login"];
		$sqluser="SELECT * from users where login_usr='$login_usr'";
		$resultuser=mysql_query($sqluser);
		$rowuser=mysql_fetch_array($resultuser);
		if(empty($row11['num_ord_pag'])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11['num_ord_pag'] ;}
		if (empty($_GET['pg'])) {$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}

		if ($tipo=="A" or $tipo=="B") $_pagi_sqlConta9 = "SELECT count(id_orden) AS pagi_totalReg FROM ordenes WHERE cod_usr LIKE '$selecta'";
		else if ($tipo=="D") $_pagi_sqlConta9 = "SELECT count(id_orden) AS pagi_totalReg FROM ordenes WHERE cod_usr LIKE '$selecta' AND area='".$rowuser['area_usr']."'" ;
		else $_pagi_sqlConta9 = "SELECT count(id_orden) AS pagi_totalReg FROM ordenes WHERE $sqlAdd cod_usr LIKE '$selecta'";
		$result9=mysql_query($_pagi_sqlConta9);
		$row9=mysql_fetch_array($result9);
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		
		if ($tipo=="A" or $tipo=="B") $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE cod_usr LIKE '$selecta' ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";
		else if ($tipo=="D") $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE cod_usr LIKE '$selecta' AND area='".$rowuser['area_usr']."' ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";
		else $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE $sqlAdd cod_usr LIKE'$selecta' ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";
		break;
		
	case "nro_de_orden":

		$log_usr = $_SESSION["login"];
		$sql11 = "SELECT * FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		$login_usr = $_SESSION["login"];
		$sqluser="SELECT * from users where login_usr='$login_usr'";
		$resultuser=mysql_query($sqluser);
		$rowuser=mysql_fetch_array($resultuser);
		if(empty($row11['num_ord_pag'])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11['num_ord_pag'] ;}
		if (empty($_GET['pg'])) {$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}

		if ($tipo=="A" or $tipo=="B") $_pagi_sqlConta9 = "SELECT count(id_orden) AS pagi_totalReg FROM ordenes WHERE id_orden='$selecta'";
		else if($tipo=="D") $_pagi_sqlConta9 = "SELECT count(id_orden) AS pagi_totalReg FROM ordenes WHERE id_orden='$selecta' AND area='".$rowuser['area_usr']."'";
		else $_pagi_sqlConta9 = "SELECT count(id_orden) AS pagi_totalReg FROM ordenes WHERE id_orden='$selecta'";
		$result9=mysql_query($_pagi_sqlConta9);
		$row9=mysql_fetch_array($result9);
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		
		if ($tipo=="A" or $tipo=="B" or $tipo=="T") $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE id_orden='$selecta' limit $_pagi_inicial,$_pagi_cuantos";
		else if ($tipo=="D") $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE id_orden='$selecta' AND area='".$rowuser['area_usr']."' limit $_pagi_inicial,$_pagi_cuantos";
		else $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE id_orden='$selecta' and 
		cod_usr = '$log_usr'  limit $_pagi_inicial,$_pagi_cuantos";
		break;
		
	case "consulta":
	
	$log_usr = $_SESSION["login"];
		$sql11 = "SELECT * FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		$login_usr = $_SESSION["login"];
		$sqluser="SELECT * from users where login_usr='$login_usr'";
		$resultuser=mysql_query($sqluser);
		$rowuser=mysql_fetch_array($resultuser);
		if(empty($row11['num_ord_pag'])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11['num_ord_pag'] ;}
		if (empty($_GET['pg'])) {$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}

		if ($tipo=="A" or $tipo=="B") $_pagi_sqlConta9 = "SELECT count(id_orden) AS pagi_totalReg FROM ordenes WHERE desc_inc like '%$selecta%'";
		else if ($tipo=="D") $_pagi_sqlConta9 = "SELECT count(id_orden) AS pagi_totalReg FROM ordenes WHERE desc_inc like '%$selecta%' AND area='".$rowuser['area_usr']."'";
		else $_pagi_sqlConta9 = "SELECT count(id_orden) AS pagi_totalReg FROM ordenes WHERE desc_inc like '%$selecta%'";
		$result9=mysql_query($_pagi_sqlConta9);
		$row9=mysql_fetch_array($result9);
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		
		if ($tipo=="A" or $tipo=="B" or $tipo=="T") $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE desc_inc like '%$selecta%' limit $_pagi_inicial,$_pagi_cuantos";
		else if ($tipo=="D") $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE desc_inc like '%$selecta%' AND area='".$rowuser['area_usr']."' limit $_pagi_inicial,$_pagi_cuantos";		
		else $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE desc_inc like '%$selecta%' limit $_pagi_inicial,$_pagi_cuantos";
	
	break;
	case "conConformidad":
		$sql11 = "SELECT * FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		$login_usr = $_SESSION["login"];
		$sqluser="SELECT * from users where login_usr='$login_usr'";
		$resultuser=mysql_query($sqluser);
		$rowuser=mysql_fetch_array($resultuser);
		
		if(empty($row11['num_ord_pag'])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11['num_ord_pag'] ;}
		if (empty($_GET['pg'])) {$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}
		
		if ($selecta=='general')
			$selecta='%';
		if ($tipo=="A" || $tipo=="B")
			$_pagi_sqlConta9 = "SELECT count(c.id_orden) AS pagi_totalReg 
							FROM conformidad c LEFT JOIN ordenes o ON c.id_orden=o.id_orden WHERE c.reg_conf like '$selecta'";
		else if ($tipo=="D") 
			$_pagi_sqlConta9 = "SELECT count(c.id_orden) AS pagi_totalReg 
							FROM conformidad c LEFT JOIN ordenes o ON c.id_orden=o.id_orden WHERE c.reg_conf like '$selecta' AND o.area='".$rowuser['area_usr']."'";
		else 
			$_pagi_sqlConta9 = "SELECT count(c.id_orden) AS pagi_totalReg 
						FROM  conformidad c LEFT JOIN ordenes o ON c.id_orden=o.id_orden WHERE $sqlAdd conformidad.reg_conf like '$selecta'";
		
		$result9=mysql_query($_pagi_sqlConta9);
		$row9=mysql_fetch_array($result9);
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		if ($tipo=="A" or $tipo=="B")$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, conformidad WHERE ordenes.id_orden=conformidad.id_orden AND conformidad.reg_conf like '$selecta' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
		else if ($tipo=="D") $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, conformidad WHERE ordenes.id_orden=conformidad.id_orden AND conformidad.reg_conf like '$selecta' AND ordenes.area='".$rowuser['area_usr']."' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";		
		else $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, conformidad WHERE $sqlAdd  ordenes.id_orden=conformidad.id_orden AND conformidad.reg_conf like '$selecta' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
		break;
}
if ($menu=="noAsignado" || $menu=="sinConformidad") {

switch ($menu) {
	case "noAsignado":
		if ($tipo=="A" or $tipo=="B") {
			$sql="SELECT id_orden FROM ordenes ORDER BY id_orden DESC";
			$sqlOut="SELECT distinct id_orden FROM asignacion ORDER BY id_orden ASC";			
			}
		else {
			if($tipo=="T") {$sqlAdd = "cod_usr<>'SISTEMA'"; }
			if($tipo=="C") {$sqlAdd = "cod_usr='$login'"; }
			$sql="SELECT id_orden FROM ordenes WHERE $sqlAdd ORDER BY id_orden DESC";
			$sqlOut="SELECT a.id_orden FROM ordenes o 
			LEFT JOIN asignacion a ON o.id_orden=a.id_orden WHERE $sqlAdd GROUP BY a.id_orden ORDER BY a.id_orden ASC";
			}
		break;
	case "noSolucionado":
		if ($tipo=="A" or $tipo=="B"){
				$sql = "SELECT id_orden FROM ordenes ORDER BY id_orden DESC";
				$sqlOut = "SELECT id_orden FROM solucion ORDER BY id_orden ASC";			
			}
		else {
			if($tipo=="T") {$sqlAdd = "cod_usr<>'SISTEMA'"; }
			if($tipo=="C") {$sqlAdd = "cod_usr='$login'"; }
			$sql = "SELECT id_orden FROM ordenes WHERE $sqlAdd ORDER BY id_orden DESC";
			$sqlOut = "SELECT s.id_orden FROM solucion s LEFT JOIN ordenes o ON s.id_orden=o.id_orden WHERE $sqlAdd ORDER BY id_orden ASC";
			}
		break;
	case "sinConformidad":
		//Codigo adicionado
			$sql11 = "SELECT * FROM control_parametros";
			$result11=mysql_query($sql11);
			$row11=mysql_fetch_array($result11);
			if(empty($row11['num_ord_pag'])) {$_pagi_cuantos =20 ; }
			else{  $_pagi_cuantos = $row11['num_ord_pag'] ;}
			if (empty($_GET['pg'])) {$_pagi_actual = 1;}
			else{$_pagi_actual = $_GET['pg'];}
			if ($tipo=="A" or $tipo=="T") 
			{	if($selecta == "general"){$selecta = '%';}
				$_pagi_sqlConta9 = "SELECT count( DISTINCT o.id_orden ) AS pagi_totalReg FROM ordenes o LEFT JOIN solucion s 
				ON o.id_orden = s.id_orden WHERE o.cod_usr LIKE '$selecta' AND o.id_orden NOT IN ( SELECT id_orden FROM conformidad)
				ORDER BY s.id_orden DESC ";
			}
			else {
			    $log_usr = $_SESSION["login"];
				$_pagi_sqlConta9 = "SELECT count( DISTINCT o.id_orden ) AS pagi_totalReg FROM ordenes o LEFT JOIN solucion s 
				ON o.id_orden = s.id_orden WHERE o.cod_usr LIKE '$log_usr' AND o.id_orden NOT IN ( SELECT id_orden FROM conformidad)
				ORDER BY s.id_orden DESC ";
			}
			$result9=mysql_query($_pagi_sqlConta9);
			$row9=mysql_fetch_array($result9);
			$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
			$_pagi_inicial = ($_pagi_actual - 1) * $_pagi_cuantos;
			
		if($tipo == "A" or $tipo == "T"){
			if($selecta == "general"){$selecta = '%';}
			$sql = "SELECT distinct ordenes.id_orden, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, solucion, conformidad 		
			WHERE ordenes.id_orden=solucion.id_orden AND ordenes.cod_usr like '$selecta' and conformidad.id_orden <> ordenes.id_orden 	
			ORDER BY ordenes.id_orden DESC ";
			
		
			
		}else{
			$log_usr = $_SESSION["login"];
			$sql = "SELECT distinct (ordenes.id_orden), DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2  FROM ordenes, solucion, conformidad 		
			WHERE ordenes.id_orden=solucion.id_orden AND ordenes.cod_usr like '$log_usr' and conformidad.id_orden <> ordenes.id_orden 	
			ORDER BY ordenes.id_orden DESC ";
		}
		$uno = mysql_query($sql);
		$dos = mysql_num_rows($uno);
		$sqlOut = "SELECT id_orden FROM conformidad ORDER BY id_orden ASC";

	break;
	}
		
		$sql11 = "SELECT num_ord_pag FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		if(empty($row11['num_ord_pag'])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11['num_ord_pag'] ;}
		$rsOrden=mysql_query( $sql);
		$rsOut=mysql_query( $sqlOut);
		$ordenTotal=mysql_num_rows($rsOrden);
		$totrow=mysql_num_rows($rsOut);
		$_pagi_totalPags = ceil(($ordenTotal-$totrow)/ $_pagi_cuantos);
		if (empty($_GET['pg']) || $_GET['pg']==1) {$_pagi_actual = 1;
			$j=0;
		}
		else{$_pagi_actual = $_GET['pg'];
			$j=1;
		}
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		
	$lstOut=array();
	while ($tmpOut=mysql_fetch_array($rsOut)) 
	{
		$lstOut[$tmpOut["id_orden"]]=$tmpOut["id_orden"];
	}
	$lstOrden=array();
	
	while ($tmpOrden=mysql_fetch_array($rsOrden)) {  
		if (!array_key_exists($tmpOrden["id_orden"], $lstOut)) 
			$lstOrden[]=$tmpOrden["id_orden"]; //// REVISAR
	}
	$k = 0;
	for($i=($_pagi_inicial+$j); $i<=($_pagi_inicial+$_pagi_cuantos);$i++){
		@$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE id_orden=".$lstOrden[$i];
		if(isset ($lstOrden[$i])) 
		$row = mysql_fetch_array(mysql_query( $sql));
		else break;
		//ASIGNACION
		$sql1 = "SELECT id_orden, asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion WHERE id_orden='$row[id_orden]' ORDER BY id_asig DESC limit 1";
		$result1=mysql_query($sql1);
		$row1=mysql_fetch_array($result1);
		//SEGUIMIENTO
		$sql2 = "SELECT count(*) AS num FROM seguimiento WHERE id_orden='$row[id_orden]'";
		$result2=mysql_query($sql2);
		$row2=mysql_fetch_array($result2);
		//SOLUCION
		$sql3 = "SELECT * FROM solucion where id_orden='$row[id_orden]'";
		$result3=mysql_query($sql3);
		$row3=mysql_fetch_array($result3);
		//CONFORMIDAD
		
		$sql4 = "SELECT * FROM conformidad where id_orden='$row[id_orden]'";
		$result4=mysql_query($sql4);
		$row4=mysql_fetch_array($result4);
		
		//TIPO
		$sql5 = "SELECT tipo2_usr FROM users where login_usr='$row[cod_usr]'";
		$result5=mysql_query($sql5);
		$row5=mysql_fetch_array($result5);
		
		$fechahoy=date("Y/m/d");
		if (!$row1['id_orden'])   //NO ASIGNADOS
			$color="bgcolor=\"#FF6666\"";
		else{ 
			if (!$row3['id_orden'])//VENCIDOS
				{$color="bgcolor=\"#A5BBF5\"";
				if (($row1['fechaestsol_asig']>$fechahoy) or ($row1['fechaestsol_asig']==$fechahoy))//SIN SOLUCION
				$color="bgcolor=\"#FFFF00\"";}
			else
			$color="bgcolor=\"#00CC66\"";// CON SOLUCION
		}
	
		echo "<tr align=\"center\">";
		echo "<td ".$color.">&nbsp;".$row['id_orden']."</td>"; 
		if ($row['id_anidacion']==0){echo "<td>&nbsp;<img src='images/eliminar.gif' width='16' height='16'></td>";}
		else{echo "<td><a href=\"#\" onClick=\"enviar(".$row['id_anidacion'].")\">&nbsp;".$row['id_anidacion']."</a></td>";}
		//FECHA Y HORA
		echo "<td>&nbsp;".$row['fecha2']." ".$row['time']."</td>";
		//ENVIADO POR
			$sql5 = "SELECT * FROM users WHERE login_usr='".$row['cod_usr']."'";
			$result5 = mysql_query($sql5);
			$row5 = mysql_fetch_array($result5);
			if (!$row5['login_usr']){echo"<td>&nbsp;".$row['cod_usr']."</td>";}
			else{echo "<td>&nbsp;".$row5['nom_usr']." ".$row5['apa_usr']." ".$row5['ama_usr']."</td>";}
		//TIPO
		echo "<td>&nbsp;".$row5['tipo2_usr']."</td>";
	
		//CI RUC
		echo "<td>&nbsp;<a href=\"titular.php?ci_ruc=".$row['ci_ruc']."\">".$row['ci_ruc']."</a></td>";
	    
		//INCIDENCIA
		echo "<td>&nbsp;".$row['desc_inc']."</td>";
		
		//CHECK BOX
		
		if($tipo == 'A')
		{  ?>
			<td>&nbsp;
                <input type="checkbox" id="ch_<?php=$k?>" <?php if($row3['id_orden']>0){echo " disabled" ;} ?>>
			    <input type="hidden" value="<?php=$row['id_orden']?>" name="id_<?php=$k?>" id="id_<?php=$k?>" size="6">
			</td>
		<?php
		}
		
		
		//ASIGNACION
		if (!$row1['id_orden'])
		{
			if ($tipo=="C"){echo"<td>&nbsp;<img src=\"images/no3.gif\" border=\"0\" alt=\"Asignacion: No\"></td>";}
			else{
				echo "<td>&nbsp;<a href=\"asignacion.php?menu=$menu&id_orden=".$row['id_orden']."\"><img src=\"images/no3.gif\" border=\"0\" alt=\"Asignacion: No\"></a></td>";
				}
		}
		else
		{
			if ($tipo=="C")
				{$sql5 = "SELECT * FROM users WHERE login_usr='".$row1['asig']."'";
				$result5 = mysql_query($sql5);
				$row5 = mysql_fetch_array($result5);
				echo "<td>&nbsp;".$row5['nom_usr']." ".$row5['apa_usr']." ".$row5['ama_usr']."</td>";}
			else
				{$sql5 = "SELECT * FROM users WHERE login_usr='".$row1['asig']."'";
				$result5 = mysql_query($sql5);
				$row5 = mysql_fetch_array($result5);
				$nomb=$row5['nom_usr']." ".$row5['apa_usr']." ".$row5['ama_usr'];
				if (mysql_num_rows($result3)!=1) echo "<td>&nbsp;<a href=\"asignacion_last.php?menu=$menu&id_orden=$row[id_orden]\">".$nomb."</a></td>";
				else echo"<td>".$nomb."</td>";
				}
		}
                //TIPO ASIGNACION
                echo "<td>".@$row1['tipo_asignacion']."&nbsp;</td>";

		//FECHA ESTIMADA DE SOLUCION
		?> 
		<td>&nbsp;<?php echo $row1['fechaestsol_asig2']; ?></td>
		<?php
		
		//SEGUIMIENTO
		echo '<td>&nbsp;<a href="segui.php?id_orden='.$row['id_orden'].'&var2=0&pg='.@$pg.'">'.$row2['num'].'</a></td>';
	
		//SOLUCION
		if ($row3)
		{
			echo "<td><a href=\"solucion_ver.php?id_orden=".$row['id_orden']."\"><img src=\"images/ok.gif\" border=\"0\" alt=\"Solucion: Si Ver\"></a></td>";
		}
		else
		{
			echo "<td><img src=\"images/no2.gif\" border=\"0\" alt=\"Solucion\"></td>";
			
		}
		//CONFORMIDAD
		if ($row4)
		{	if ($row4['tipo_conf'] == "2")
				echo"<td><a href=\"conformidad_ver.php?id_orden=".$row['id_orden']."\"><img src=\"images/disconf.gif\" border=\"0\" alt=\"Conformidad: Si Ver\"></a></td>";							
			else 
				echo"<td><a href=\"conformidad_ver.php?id_orden=".$row['id_orden']."\"><img src=\"images/ok.gif\" border=\"0\" alt=\"Conformidad: Si Ver\"></a></td>";
		}
		else
		{
			if (($login == $row['cod_usr'] || ($row['cod_usr'] == "SISTEMA" || $tipo=="A" || $tipo=="B")) && $row3['id_orden']) // 03082004 IPM
				echo"<td><a href=\"conformidad.php?id_orden=".$row['id_orden']."\"><img src=\"images/no3.gif\" border=\"0\" alt=\"Conformidad: No\"></a></td>";
			else
				echo"<td><img src=\"images/no2.gif\" border=\"0\" alt=\"Conformidad\"></td>";
		}
	
		//COSTO DEL SERVICIO	
		if($tipo=="A" or $tipo=="B" or $tipo=="T") {echo "<td><a href=\"costo.php?id_orden=".$row['id_orden']."\"><img src=\"images/ver.gif\" border=\"0\" alt=\"Costo: Ver\"></a></td>";}
	
		echo "<td><a href=\"ver_orden.php?id_orden=".$row['id_orden']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Reporte Basico\"></a></td>"; 
		echo "<td><a href=\"ver_orden2.php?id_orden=".$row['id_orden']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Reporte con Datos SARC 	
Relacionados al Cliente\"></a></td>"; 
		//ARCHIVOS ADJUNTOS
		//if($tipo=="A" or $tipo=="B" or $tipo=="T" or $tipo == "C") 
		//{
			if (!$row['nomb_archivo']){echo "<td>NINGUNO</td>";}
			else {echo '<td><a href="archivos_adjuntos.php?id_orden='.$row['id_orden'].'">VER ARCHIVOS</a></td>';}
/*			else {
			$adj=explode("|",$row[nomb_archivo]);
			echo "<td>";
			foreach($adj as $valor){
				echo"<a href=\"archivos adjuntos/".$valor."\" target=\"_blank\">$valor</a><br>";
				}
			echo "</td>";
			}*/
		//}
		/*else 
		{
			if (!$row[nomb_archivo]){echo"<td>NINGUNO</td>";}
			else {echo"<td>ADJUNTADO</td>";}
		}*/
		//---------------------
		switch ($row['origen']){
			case "0": $graf="<img src=\"images/0.gif\" border=\"0\" alt=\"Mesa de Ayuda\">"; break;
			case "1": $graf="<img src=\"images/1.gif\" border=\"0\" alt=\"Gestion\">"; break;
			case "1.4": $graf="<img src=\"images/1-4.gif\" border=\"0\" alt=\"Gestion - Planificacion Estrategica\">"; break;
			case "2": $graf="<img src=\"images/2.gif\" border=\"0\" alt=\"Soporte Tecnico\">"; break;
			case "2.3": $graf="<img src=\"images/2-3.gif\" border=\"0\" alt=\"Soporte Tecnico - Cronograma\">"; break;
			case "3": $graf="<img src=\"images/3.gif\" border=\"0\" alt=\"Desarrollo y Mantenimiento\">"; break;
			case "4": $graf="<img src=\"images/4.gif\" border=\"0\" alt=\"SARC\">"; break;
			default: $graf="<img src=\"images/0.gif\" border=\"0\" alt=\"Mesa de Ayuda\">"; break;
		}
		echo "<td>$graf&nbsp;</td>";
		
		echo "</tr>";
		//--------------------

	  }
  }
  else{// cuando es General, asignado, solucionado, con conformidad  
  		
  //	echo "<br>sql : ".$sql;
	$result=mysql_query($sql);
	$numRows = mysql_num_rows($result);
	while ($row=mysql_fetch_array($result)) 
	  {
		@$k++;
		//ASIGNACION
		$sql1 = "SELECT id_orden, asig, fechaestsol_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2, tipo_asignacion FROM asignacion WHERE id_orden='".$row['id_orden']."' ORDER BY id_asig DESC limit 1";
		$result1=mysql_query($sql1);
		$row1=mysql_fetch_array($result1);
				
		//SEGUIMIENTO
		$sql2 = "SELECT count(*) AS num FROM seguimiento WHERE id_orden='".$row['id_orden']."'";
		$result2=mysql_query($sql2);
		$row2=mysql_fetch_array($result2);
		//SOLUCION
		$sql3 = "SELECT * FROM solucion where id_orden='".$row['id_orden']."'";
		$result3=mysql_query($sql3);
		$row3=mysql_fetch_array($result3);
		//CONFORMIDAD
		$sql4 = "SELECT * FROM conformidad where id_orden='".$row['id_orden']."'";
		$result4=mysql_query($sql4);
		$row4=mysql_fetch_array($result4);
		//TIPO
		$sql5 = "SELECT tipo2_usr FROM users where login_usr='".$row['cod_usr']."'";
		$result5=mysql_query($sql5);
		$row5=mysql_fetch_array($result5);
		
		$fechahoy=date("Y-m-d");
		if (!$row1['id_orden'])   //NO ASIGNADOS
			$color="bgcolor=\"#FF6666\"";
		else{ 
			if (!$row3['id_orden'])//VENCIDOS
				{$color="bgcolor=\"#A5BBF5\"";
				if (($row1['fechaestsol_asig']>$fechahoy) or ($row1['fechaestsol_asig']==$fechahoy))//SIN SOLUCION
				$color="bgcolor=\"#FFFF00\"";}
			else
			$color="bgcolor=\"#00CC66\"";// CON SOLUCION
		}
	
		echo "<tr align=\"center\">";
		echo "<td ".$color.">$row[id_orden]</td>"; 
		if ($row['id_anidacion']==0){echo "<td >&nbsp;<img src='images/eliminar.gif' width='16' height='16'></td>";}
		else{echo "<td><a href=\"#\" onClick=\"enviar(".$row['id_anidacion'].")\">&nbsp;".$row['id_anidacion']."</a></td>";}
		//FECHA Y HORA
		
		echo "<td>".$row['fecha2']." ".$row['time']."</td>"; 	//HERE fECHA
		//ENVIADO POR
			$sql5 = "SELECT * FROM users WHERE login_usr='$row[cod_usr]'";
			$result5 = mysql_query($sql5);
			$row5 = mysql_fetch_array($result5);
			if (!$row5['login_usr']){echo"<td>&nbsp;".$row['cod_usr']."</td>";}
			else{echo "<td>&nbsp;".$row5['nom_usr']." ".$row5['apa_usr']." ".$row5['ama_usr']."</td>";}    //HERE NOMBRE
		//TIPO
		echo "<td>&nbsp;".$row5['tipo2_usr']."</td>";  //HERE TIPO
	
		//CI RUC
		echo "<td>&nbsp;<a href=\"titular.php?ci_ruc=".$row['ci_ruc']."\">".$row['ci_ruc']."</a></td>";  //HERE 
	
		//CHECK BOX
		echo "<td>&nbsp;".$row['desc_inc']."</td>";
		if($tipo == 'A')
		{  ?>
			<td>&nbsp;
				<input type="checkbox" id="ch_<?php=$k?>" <?php if($row3['id_orden']>0){echo " disabled" ;} ?> >
				<input type="hidden" value="<?php=$row['id_orden']?>" name="id_<?php=$k?>" id="id_<?php=$k?>" size="6">
			</td>
		<?php
		}
		//ASIGNACION
		if (!$row1['id_orden'])
		{
			if ($tipo=="C"){	
				echo"<td><img src=\"images/no3.gif\" border=\"0\" alt=\"Asignacion: No\"></td>";
			}
			else{
				if (isset($pg))
					echo '<td><a href="asignacion.php?menu='.$menu.'&id_orden='.$row['id_orden'].'&pg='.$pg.'"><img src="images/no3.gif" border="0" alt="Asignacion:No"></a></td>';
				else
					echo '<td><a href="asignacion.php?menu='.$menu.'&id_orden='.$row['id_orden'].'"><img src="images/no3.gif" border="0" alt="Asignacion:No"></a></td>';
			}
		}
		else
		{
			if ($tipo=="C")
				{$sql5 = "SELECT * FROM users WHERE login_usr='".$row1['asig']."'";
				$result5 = mysql_query($sql5);
				$row5 = mysql_fetch_array($result5);
				echo "<td>&nbsp;".$row5['nom_usr']." ".$row5["apa_usr"]." ".$row5['ama_usr']."</td>";}
			else
			   {
			    $sql5 = "SELECT * FROM users WHERE login_usr='".$row1['asig']."'";
			    $result5 = mysql_query($sql5);
				$row5 = mysql_fetch_array($result5);
				$nomb=$row5['nom_usr']." ".$row5['apa_usr']." ".$row5['ama_usr'];
				if (mysql_num_rows($result3)!=1) 
					if (isset($pg))
						echo '<td><a href="asignacion_last.php?menu='.$menu.'&id_orden='.$row['id_orden'].'&pg='.$pg.'">'.$nomb.'</a></td>';
					else
						echo '<td><a href="asignacion_last.php?menu='.$menu.'&id_orden='.$row['id_orden'].'">'.$nomb.'</a></td>';
				else echo"<td>".$nomb."</td>";
				}
		}
                //TIPO ASIGNACION
                echo "<td>".$row1['tipo_asignacion']." &nbsp;</td>";
		//FECHA ESTIMADA DE SOLUCION
		?> 
		  <td>&nbsp;<?php echo $row1['fechaestsol_asig2']; ?></td>
		<?php
		
		//SEGUIMIENTO
		echo '<td>&nbsp;<a href="segui.php?id_orden='.$row['id_orden'].'&var2=0&pg='.@$pg.'">"'.$row2['num'].'</a></td>';
	
		//SOLUCION
		if ($row3){
			if (isset($pg))
				echo '<td><a href="solucion_ver.php?id_orden='.$row['id_orden'].'&pg='.$pg.'"><img src="images/ok.gif" border="0" alt="Solucion: Si Ver"></a></td>';
			else
				echo '<td><a href="solucion_ver.php?id_orden='.$row['id_orden'].'"><img src="images/ok.gif" border="0" alt="Solucion: Si Ver"></a></td>';
		}
		else
		{
			echo "<td><img src=\"images/no2.gif\" border=\"0\" alt=\"Solucion\"></td>";
			
		}
		//CONFORMIDAD
		if ($row4){	
			echo '<td><a href="conformidad_ver.php?id_orden='.$row['id_orden'];
			if (isset($pg))
				echo '$pg='.$pg;
			echo '">';
			if ($row4['tipo_conf'] == "2")
				echo '<img src="images/disconf.gif" border="0" alt="Conformidad: Si Ver"></a></td>';
			else
				echo '<img src="images/ok.gif" border="0" alt="Conformidad: Si Ver"></a></td>';
		}
		
		else
		{
			if (($login == $row['cod_usr'] || ($row['cod_usr'] == "SISTEMA" || $tipo=="A" || $tipo=="B")) && $row3['id_orden']) // 03082004 IPM
				echo"<td><a href=\"conformidad.php?id_orden=".$row['id_orden']."\"><img src=\"images/no3.gif\" border=\"0\" alt=\"Conformidad: No\"></a></td>";
			else
				echo"<td><img src=\"images/no2.gif\" border=\"0\" alt=\"Conformidad\"></td>";
		}
	
		//COSTO DEL SERVICIO	
		if($tipo=="A" or $tipo=="B" or $tipo=="T") {
			if (isset($pg))
				echo '<td><a href="costo.php?id_orden='.$row['id_orden'].'&pg='.$pg.'"><img src="images/ver.gif" border="0" alt="Costo: Ver"></a></td>';
			else
				echo '<td><a href="costo.php?id_orden='.$row['id_orden'].'"><img src="images/ver.gif" border="0" alt="Costo: Ver"></a></td>';
		}
		echo "<td><a href=\"ver_orden.php?id_orden=".$row['id_orden']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Reporte Basico\"></a></td>"; 
		echo "<td><a href=\"ver_orden2.php?id_orden=".$row['id_orden']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Reporte con Datos SARC 
Relacionados al Cliente\"></a></td>"; 
		//ARCHIVOS ADJUNTOS
		/*if($tipo=="A" or $tipo=="B" or $tipo=="T") 
		{*/
			if (!$row['nomb_archivo']){echo "<td>NINGUNO</td>";}
			else {echo "<td><a href=\"archivos_adjuntos.php?id_orden=".$row['id_orden']."\">VER ARCHIVOS</a></td>";}
		/*}
		else 
		{
			if (!$row[nomb_archivo]){echo"<td>NINGUNO</td>";}
			else {echo"<td>ADJUNTADO</td>";}
		}*/
		switch ($row['origen']){
			case "0": $graf="<img src=\"images/0.gif\" border=\"0\" alt=\"Mesa de Ayuda\">"; break;
			case "1": $graf="<img src=\"images/1.gif\" border=\"0\" alt=\"Gestion\">"; break;
			case "1.4": $graf="<img src=\"images/1-4.gif\" border=\"0\" alt=\"Gestion - Planificacion Estrategica\">"; break;
			case "2": $graf="<img src=\"images/2.gif\" border=\"0\" alt=\"Soporte Tecnico\">"; break;
			case "2.3": $graf="<img src=\"images/2-3.gif\" border=\"0\" alt=\"Soporte Tecnico - Cronograma\">"; break;
			case "3": $graf="<img src=\"images/3.gif\" border=\"0\" alt=\"Desarrollo y Mantenimiento\">"; break;
			case "4": $graf="<img src=\"images/4.gif\" border=\"0\" alt=\"SARC\">"; break;
			default: $graf="<img src=\"images/0.gif\" border=\"0\" alt=\"Mesa de Ayuda\">"; break;
		}
		echo "<td>$graf&nbsp;</td>";
                // tipo de asignacion
		echo "</tr>";
	  }
	  //echo "<br>k : ".$k;
  }  
?>
	<input type="hidden" name="txtCount" value="<?php=@$k?>">
      </table></td>
  </tr>
</table>
</form>
<form name="form1" method="post" action="">
  <table width="100%" border="0" align="center">
    <tr> 
      <td height="20"> 
        <div align="center"> 
          <p><font size="2"><strong> Pagina(s) :&nbsp; 
            <?php
//if($numRows!=0){

$_pagi_enlace = $_SERVER['PHP_SELF'];
$_pagi_query_string = "?";
if(isset($_GET)){
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
	if($pg){$msg=0;	$vent=0;}
	//Si no estamos en la p�gina 1. Ponemos el enlace "anterior"
	$_pagi_url = $_pagi_actual - 1;//ser� el numero de p�gina al que enlazamos
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."'>&laquo; Anterior</a>&nbsp;";
}
//Enlaces a numeros de p�gina:
if ($_pagi_actual>5)
{$pagi=$_pagi_actual-5;
 $totpag=$_pagi_actual+5;}
 else
 {$pagi=1;
 $totpag=10;}
if ($totpag>=$_pagi_totalPags)
{$totpag=$_pagi_totalPags;
$pagi=$totpag-10;
	if ($pagi<=1)
	{$pagi=1;}
}
for ($_pagi_i = $pagi; $_pagi_i<=$totpag; $_pagi_i++){//Desde p�gina 1 hasta ultima p�gina ($_pagi_totalPags)
    if ($_pagi_i == $_pagi_actual) {
		//Si el numero de p�gina es la actual ($_pagi_actual). Se escribe el numero, pero sin enlace y en negrita.
        $_pagi_navegacion .= "<b>&nbsp;$_pagi_i&nbsp;</b>";
    }else{
		if(isset($pg)){$msg=0;	$vent=0;}
		//Si es cualquier otro. Se escibe el enlace a dicho numero de p�gina.
        $_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."'>".$_pagi_i."</a>&nbsp;";
    }
}

if ($_pagi_actual < $_pagi_totalPags){
	//Si no estamos en la ultima p�gina. Ponemos el enlace "Siguiente"
    $_pagi_url = $_pagi_actual+1;//ser� el numero de p�gina al que enlazamos
    $_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."'>Siguiente &raquo;</a>";
}
print $_pagi_navegacion;
//}else{ print 0;}
//Hasta ac� hemos completado la "barra de navegacion"
?>
            <br>
            <br>
            </strong></font></p>
        </div></td>
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
 
  <div align="center"><br>
    <?php if ($tipo=="A" or $tipo=="B" or $tipo=="T") {?>
    <input name="estadisticas" type="button" id="estadisticas" value="ESTADISTICAS" onClick="openStat_2()">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input name="report" type="button" id="report" value="REPORTE" onClick="openStat_4()">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input name="imprimir" type="button" id="imprimir" value="IMPRIMIR" onClick="openStat_3()">
	<?php }?>
  </div>
</form>
  </p>
<script language="javascript1.2">
<!--

function openStat_2() {	
	window.open("orden_estadistical.php?op=G",'Estadasticas', 'width=610,height=200,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
function openStat_3() {	
	window.open("orden_estadistica2.php?op=G",'Estadasticas', 'width=610,height=350,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
function openStat_4() {	
window.open("report_pre_temp.php?op=G",'pre_tiempos', 'width=610,height=200,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function tipo(men)
{
 	if(men=="nro_de_orden"){irapagina("lista.php?menu="+men+"&selecta=0");}
	else{irapagina("lista.php?menu="+men+"&selecta=general");}
}
function enviar(id){
		open("ver_orden.php?id_orden="+id);
}
<?php if(isset($vent)){?>
ventana_secundaria=window.open('pru2.php','secundaria','location=no,menubar=no,status=no,toolbar=no,scrollbars=0,resizable=no,width=350,height=170,left=150,top=150'); 
ventana_secundaria.close(); 
<?php }?>
-->
</script>
<script language="javascript1.2">
   
      function checkAll() {
          var nodoCheck = document.getElementsByTagName("input");
          var varCheck = document.getElementById("all").checked;
          for (i=0; i<nodoCheck.length; i++){
              if (nodoCheck[i].type == "checkbox" && nodoCheck[i].name != "all" && nodoCheck[i].disabled == false) {
                  nodoCheck[i].checked = varCheck;
              }
          }
      }

function selectAll()
{
	limite = document.frmOrdenes.txtCount.value;
	for(i=1; i<=limite; i++)
	{
		document.frmOrdenes.all("ch_" + i).checked = true;
	}
	document.frmOrdenes.btnAll.style.display = "none";
	document.frmOrdenes.btnNone.style.display = "";
	
}

function selNone()
{
	limite = document.frmOrdenes.txtCount.value;
	for(i=1; i<=limite; i++)
	{
		document.frmOrdenes.all("ch_" + i).checked = false;
	}
	document.frmOrdenes.btnAll.style.display = "";
	document.frmOrdenes.btnNone.style.display = "none";
	
}

function cerrarOrdenes()
{
	var pg='<?phpecho @$pg; ?>';
	contador = 0;
	limite = document.frmOrdenes.txtCount.value;
        var vector="";
      var tr = document.getElementById('tblOrdenes').rows;
      var td = null;
      //a partir de la fila 3
      var j=1;
        for (var i = 3; i < tr.length; ++i) {
        td = tr[i].cells;
        if(document.getElementById("ch_"+j).checked)
            {
                contador=1;
            }
        j=j+1;
      }


//	for(i=1; i<=limite; i++)
//	{
//		if(document.frmOrdenes.all("ch_" + i).checked)
//		{
//			contador = 1;
//		}
//	}

	if(contador == 1)
	{
		if(confirm("Esta seguro de cerrar las ordenes seleccionadas?\nMensaje generado por GesTor F1."))
		{
			closeord = 1;
			vector = "|";
                        j=1;
                        for (var i = 3; i < tr.length; ++i) {
                            td = tr[i].cells;

                            if(document.getElementById("ch_"+j).checked)
                            {
                                id = document.getElementById("id_" + j).value;
				vector = vector + id + "|";
                            }
                            j=j+1;
                        }

//			for(i=1; i<=limite; i++)
//			{
//				if(document.frmOrdenes.all("ch_" + i).checked)
//				{
//					id = document.frmOrdenes.all("id_" + i).value;
//					vector = vector + id + "|";
//				}
//			}
			irapagina("lista.php?closeord=" + closeord + "&vector=" + vector + "&pg=" + pg );
		}
		else
		{
			return false;
		}
	}
	else
	{
		alert("No se ha seleccionado ninguna orden. \nMensaje generado por GesTor F1.");
	}
}
</script>
