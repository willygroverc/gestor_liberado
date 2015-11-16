<?php
// Version:		1.0
// Objetivo:	Modificacion funciones php obsoletas para version 5.3
//				Control de acceso directo NO autorizado
// Fecha:		20/NOV/12
// Autor:		Cesar Cuenca
//____________________________________________________________________________
// Version:		2.0
// Autor:		Alvaro ROdriguez
// Objetivo:	Se ha corrgido el vista de los caracteres especiales y 
// 				se ha cambiado el formato de fecha.
//_________________________________________________________________________________
require ("conexion.php");
header('Content-Type: text/html; charset=iso-8859-1');
@session_start();
$tipo=$_SESSION['tipo'];
if ($_SESSION['tipo']=='C')
	header('location:pagina_inicio.php');

//echo "<br>Tipo de Usuario: ".$tipo;
//----------------Tecnico solo visualiza sus ordenes-----------------------------------------------------------------
	$ss = "SELECT tecni_solo FROM control_parametros";
	$rr=mysql_query($ss);
	$res=mysql_fetch_array($rr);
	$tecni_solo = $res['tecni_solo'];
	if($tipo == "A" or $tipo=="D"){
		$tecni_solo = '0';
	}
	
//-------------------------------------------------------------------------------------------------------------------

	//echo "<br>tecnio solo : ".$tecni_solo;
$login_usr = $_SESSION["login"];
$sql3 = "SELECT * FROM users WHERE login_usr='$login_usr'";
$res3 = mysql_query($sql3);
$row3 = mysql_fetch_array($res3);
if (empty($_REQUEST['menu']))
{	if ($row3['visualizacion'] == 1) $opc = 1;
	else  $_REQUEST['menu'] = "general";
}
   
include ("top.php"); ?>
<?php include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("segui","Seguimiento.");
	$help->AddHelp("tipo","Tipo de Cliente. A: Administrador, T: Tecnico, C: Cliente.");
	$help->AddHelp("conf","Conformidad.");
	$help->AddHelp("solu","Solucion.");
	$help->AddHelp("incidencia","Consultas de los clientes sin aclarar la naturaleza de las mismas.");
	print $help->ToHtml();
?>
<p>
<form action="" method="get" name="form2" id="form2" >
    <input name="opc" type="hidden" value="<?php echo isset($_REQUEST['opc']);?>">
    <input name="sel" type="hidden" value="<?php=  isset($_REQUEST['sel'])?>">
 <input name="obco" type="hidden" value="<?php=  isset($_REQUEST['obco'])?>">
 
  <table width="90%" border="1" align="center" bgcolor="#006699" >
    <tr> 
      <td width="60%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Busqueda 
          por :</strong></font> 
		  <?php  $login_usr = $_SESSION["login"];
	          $sqluser="SELECT * from users where login_usr='$login_usr'";
              $resultuser=mysql_query($sqluser);
		      $rowuser=mysql_fetch_array($resultuser);
		  ?>
		  <select name="menu" id="menu" <?php if ($rowuser['tipo2_usr']=="D") { ?> <?php echo "onChange=tipo_d(this.value,'".$rowuser['area_usr']."','".$rowuser['area_usr']."')"; ?>  <?php } else { ?> onChange="tipo(this.value)"<?php }?> >
		  	<option value="general">General</option>
			<option value="tipo"<?php if ($_REQUEST['menu']=="tipo") print 'selected'?>>Tipo</option>
          </select>		  
          &nbsp;&nbsp;&nbsp;
		 <?php if(isset($_REQUEST['menu']) && $_REQUEST['menu']!="nro_de_orden"){
			 //*****************
			  if ($_REQUEST['menu']=="tipo"){
			  $login_usr = $_SESSION["login"];
	          $sqluser="SELECT * from users where login_usr='$login_usr'";
              $resultuser=mysql_query($sqluser);
		      $rowuser=mysql_fetch_array($resultuser);
			  if ($rowuser['tipo2_usr']=="D"){
		 ?>
			  <br><br><br>
			  <font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Nivel 1 :</strong></font> 
			  <select name="area" class="titulo4" onChange="tipos(this.value)">
					<option value="0" selected>General</option>
					<option value="s" <?php if($_REQUEST['area'] == "s"){?> selected <?php }?>>Sin Tipificacion</option>
					<?php 
						$sCon = "select * from area where area_cod='".$rowuser['area_usr']."' ORDER BY area_nombre";						
						$sRes = mysql_query($sCon);
						while($sFil = mysql_fetch_array($sRes)){
							echo '<option value="'.$sFil['area_cod'].'"';
							if ($sFil['area_cod']==$_REQUEST['sel']){echo"selected";}
							else
							{
								if ($sFil['area_cod']==$_REQUEST['area']){echo"selected";}
							}
							echo'>'.$sFil['area_nombre'].'</option>';
						}
					?>
			  </select>&nbsp;&nbsp;&nbsp;
			  <?php  } else { ?>
			  
			  <br><br><br>
			  <font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Nivel 1 :</strong></font> 
			  <select name="area" class="titulo4" onChange="tipos(this.value)">
					<option value="0" selected>General</option>
                                        <option value="s" <?php if(isset($_REQUEST['area']) == "s"){?> selected <?php }?>>Sin Tipificaci�n</option>
					<?php 
						$sCon = "select * from area ORDER BY area_nombre";						
						$sRes = mysql_query($sCon);
						while($sFil = mysql_fetch_array($sRes))
						{
							echo "<option value=\"$sFil[area_cod]\"";
							if ($sFil['area_cod']==isset($_REQUEST['sel'])){echo"selected";}
							else
							{
								if ($sFil['area_cod']==isset($_REQUEST['area'])){echo"selected";}
							}
							echo">$sFil[area_nombre]</option>";
						}
					?>
			  </select>&nbsp;&nbsp;&nbsp;
			  
			  <?php  } ?>
			  <font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Nivel 2 :</strong></font>
			  <select name="dominio" class="titulo4" onChange="tipos1(<?php if (empty($_REQUEST['sel'])){echo "0";} else {echo "$_REQUEST[sel]";}?>,this.value)">
					<option value="0">General</option>
					<?php 
						$sCon = "select * from dominio WHERE id_area='$_REQUEST[sel]' ORDER BY dominio";						
						$sRes = mysql_query($sCon);
						while($sFil = mysql_fetch_array($sRes)){
							 echo "<option value=\"$sFil[id_dominio]\"";
							 if ($sFil['id_dominio']==isset($_REQUEST['obco'])){echo"selected";}
							 else
							 {
							 	if ($sFil['id_dominio']==isset($_REQUEST['dominio'])){echo"selected";}
							 }
							 echo ">$sFil[dominio]</option>";
						}
					?>
			  </select>
		   
			  <font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Nivel 3 :</strong></font> 
			  <select name="objetivo" class="titulo4" onChange="valida()">
					<option value="0">General</option>
					<?php 
						$sCon = "select *from objetivos WHERE id_dominio='$_REQUEST[obco]' ORDER BY objetivo";
						$sRes = mysql_query($sCon);
						while($sFil = mysql_fetch_array($sRes))
						{
							if($_REQUEST['objetivo'] == $sFil['id_objetivo']){
								echo "<option value='".$sFil['id_objetivo']."' selected>".$sFil['objetivo']."</option>";
							}else{
								echo "<option value='".$sFil['id_objetivo']."'>".$sFil['objetivo']."</option>";
							}
						}	
					?>
			  </select>
			  <?php
			  }
			  else{
		  
		  	 //******************
		  ?>
     <?php 
	  if($tecni_solo <> 1 or $tipo <> "T")
	  {
	 ?>
		  
		  <select name="selecta">
            <option value="general">General</option>
			<?php
			switch ($_REQUEST['menu']) {
			case "conConformidad":
						$auxb='nochar';
						$sqlb= "SELECT distinct(cod_usr) AS maxi FROM ordenes";
						$resultb=mysql_query($sqlb);
						while ($rowb = mysql_fetch_array($resultb)) {
									$auxb=$auxb.", '".$rowb['maxi']."'";
								};
						$auxb=str_replace('nochar,',' ', $auxb);
						$sqltec="SELECT * from users WHERE tipo2_usr='T' AND login_usr NOT IN ($auxb) ORDER BY apa_usr";
				break;
			case "sinConformidad":
						$auxbox='nochar';
						$sqlbox= "SELECT max(id_asig) as maxi FROM asignacion group by id_orden";
						$resultbox=mysql_query($sqlbox);
						while ($rowbox = mysql_fetch_array($resultbox)) {
						$auxbox=$auxbox.", ".$rowbox['maxi'];
						}
						$auxbox=str_replace('nochar,',' ', $auxbox);
						$auxbo='nochar';
						$sqlbo= "SELECT distinct(asig) AS maxi FROM asignacion WHERE id_asig IN ($auxbox)";
						$resultbo=mysql_query($$sqlbo);
						while ($rowbo = mysql_fetch_array($resultbo)) {
						$auxbo=$auxbo.", '".$rowbo['maxi']."'";
						}
						$auxbo=str_replace('nochar,',' ', $auxbo);
						$sqltec="SELECT * from users WHERE tipo2_usr='T' AND login_usr IN ($auxbo) ORDER BY apa_usr";
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
						$sqltec="SELECT * from users WHERE tipo2_usr='T' AND login_usr IN ($auxbo) ORDER BY apa_usr";

			break;
			case "enviadoPor":
				$sqltec="SELECT * from users WHERE tipo2_usr<>'A' AND tipo2_usr<>'B' ORDER BY apa_usr";
			break;				
			case "noAsignado":
				 if($tipo == "A" or $tipo == "T" ){$sqltec="SELECT * from users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr";}
			break;
			default:
				$sqltec="SELECT * from users WHERE tipo2_usr='T' ORDER BY apa_usr";
			break;
			}
			$resultec= mysql_query($sqltec);
			while($rowtec= mysql_fetch_array($resultec)){
			?>
            <option value="<?php echo $rowtec['login_usr']?>"<?php if (isset($_REQUEST['selecta'])==$rowtec['login_usr']) print 'selected' ?>><?php echo $rowtec['apa_usr']." ".$rowtec['ama_usr']." ".$rowtec['nom_usr'];?></option>
			<?php
			}
			?>
          </select>
		  <?php //----------------------------------------------------------------------------------------------
			}
			 //----------------------------------------------------------------------------------------------
		  ?>  
		  
		   <?php } }else{?>
		  <input name="selecta" type="text" size="5" maxlength="5" value="<?php if (isset($_REQUEST['selecta'])) echo $_REQUEST['selecta'];?>">
		  <?php }?>&nbsp;&nbsp;&nbsp;
		
	
		  
          <?php if(((isset ($_REQUEST['menu']) && $_REQUEST['menu'] <> "tipo") && $tecni_solo <> "1") || (isset($_REQUEST['menu']) && $_REQUEST['menu'] == "nro_de_orden") || $tipo <> "T"){
		  		
				if($_REQUEST['menu'] <> "tipo"){
		  ?>
		  <input name="BUSCAR" type="submit" id="BUSCAR" value=" BUSCAR ">
		  
		  <?php 
		  		} 
		    }
		  ?>
        </div></td>
    </tr>
  </table>
</form>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#990000"  >
    <tr> 
    <td height="47" valign="top">
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
        <tr> 
          <th colspan="22">TIPIFICACION DE ORDENES DE TRABAJO</th>
        </tr>
        <tr align="center"> 
          <td height="25" class="menu">Nro</td>
		  <td height="25" class="menu" ><font size="1">ORIGEN</font></td>
          <td class="menu"><font size="1">FECHA Y HORA</font></td>
          <td class="menu"><font size="1">ENVIADO POR</font></td>
		  <!---->
		  <td class="menu">NIVEL 1</td>
          <td class="menu">NIVEL 2</td>
          <td class="menu">NIVEL 3</td>
		  <!---->
          <td class="menu">TIPO</td>
          <?php if($tipo == "A" ) {?>
		  <td class="menu"><font size="1">TIP</font></td>
		  <?php }?>
          <td class="menu"><font size="1">INCIDENCIA</font></td>
          <td class="menu">ASIGNACION</td>
          <td class="menu">FECHA SOLUCION</td>
          <td class="menu">SEG</td>
          <td class="menu">SOL</td>
          <td class="menu">CONF</td>
          <?php  
		    //if($tipo=="A"  or $tipo=="B" or $tipo=="T") {
             //echo "<th width=\"40\" class=\"menu\">COSTO</th>";
	         //}
	      ?>
          <td class="menu">IMPRIMIR INTERNO</td>
          <!--td width="50" class="menu">IMPRIMIR EXTERNO</td-->
          <td class="menu">ARCHIVO ADJUNTO</td>
        </tr>
        <?php

	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_query($sql11);
	$row11=mysql_fetch_array($result11);
	
	$login_usr = $_SESSION["login"];
	$sqluser="SELECT * from users where login_usr='$login_usr'";
	$resultuser=mysql_query($sqluser);
	$rowuser=mysql_fetch_array($resultuser);
	

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
{	
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ordenes";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql = "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";
}
else if ($tipo=="D")
{
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ordenes where area='".$rowuser['area_usr']."'";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql = "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes area='$rowuser[area_usr]' ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";
}
else if($tipo=="T") {	
	if($tecni_solo == 1){
		$sql = "select id_orden from asignacion where asig='$login_usr' UNION select  id_orden from ordenes where cod_usr<>'SISTEMA' and cod_usr='$login_usr' order by id_orden desc";
		$res = mysql_query($sql);
		$acum = "mike";
		while($row = mysql_fetch_array($res)){
			$acum = $acum.','.$row['id_orden'];
		}
		$acum = str_replace('mike,',' ', $acum);
		if($acum == 'mike'){
			$acum = '0';
		}
		
		$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ordenes WHERE cod_usr<>'SISTEMA' and id_orden IN ($acum)";
		$result9=mysql_query($_pagi_sqlConta);
		$row9=mysql_fetch_array($result9);
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		$sql = "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE cod_usr<>'SISTEMA' and id_orden IN ($acum) ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";
	}
	else{
		$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ordenes WHERE cod_usr<>'SISTEMA'";
		$result9=mysql_query($_pagi_sqlConta);
		$row9=mysql_fetch_array($result9);
	
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		$sql = "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE cod_usr<>'SISTEMA' ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";
	}
}
else if($tipo=="C") 
{	
	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ordenes WHERE cod_usr='$login'";
	$result9=mysql_query($_pagi_sqlConta);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql = "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE cod_usr<>'SISTEMA' and cod_usr='$login' ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";
}

if($tipo=="A" or $tipo=="B") {$sqlAdd = "";}
else if($tipo=="T") {$sqlAdd = "cod_usr<>'SISTEMA'"." AND ";}
else if($tipo=="C") {$sqlAdd = "cod_usr='$login'"." AND ";}

if (isset($_REQUEST['selecta'])){
	if($_REQUEST['selecta']=='general') {$login_usr='%';}
	else $login_usr=$_REQUEST['selecta'];
}

if (isset($_REQUEST['menu'])) {
	if ($_REQUEST['menu']=="general"){
	    $login_usr = $_SESSION["login"];
	    $sql = "select id_orden from asignacion where asig='$login_usr' UNION select id_orden from ordenes where cod_usr='$login_usr' order by id_orden desc";
		$res = mysql_query($sql);
		$acum = "mike";
		$sqluser="SELECT * from users where login_usr='$login_usr'";
		$resultuser=mysql_query($sqluser);
		$rowuser=mysql_fetch_array($resultuser);
		while($row = mysql_fetch_array($res)){
			$acum = $acum.','.$row['id_orden'];
		}
		$acum = str_replace('mike,',' ', $acum);
		
		if($acum == 'mike'){
			$acum = '0';
		}
	
	   if($tipo == 'A'){
	   		$sql="SELECT * FROM ordenes ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
	   } else if ($tipo=="D"){
	   		$sql="SELECT * FROM ordenes where area='$rowuser[area_usr]' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos"; //Listar Ordenes de un Area
	   }
	   
	   else{
	   		$sql="SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes where id_orden IN ($acum) and cod_usr <> 'SISTEMA' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
	   }
	}
	if ($_REQUEST['menu']=="asignado"){
		if($tecni_solo == 1){
			$log = $_SESSION["login"];
			$cadvalor = " asignacion.asig='".$log. "' and ";
		}
		else{
			$cadvalor = "";
		}
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion group by id_orden";
		$resultbo=mysql_query($sqlbo);
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
		
		if ($tipo=="A" or $tipo=="B") $_pagi_sqlConta9 = "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg FROM ordenes, asignacion WHERE $cadvalor ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$login_usr' AND id_asig IN ($auxbo)";
		else $_pagi_sqlConta9 = "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg FROM  ordenes, asignacion WHERE $cadvalor $sqlAdd ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$login_usr' AND id_asig IN ($auxbo)";
		$result9=mysql_query($_pagi_sqlConta9);
		$row9=mysql_fetch_array($result9);
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	
		if ($tipo=="A" or $tipo=="B") $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, asignacion WHERE $cadvalor ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$login_usr' AND id_asig IN ( $auxbo ) GROUP BY id_orden ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
		else $sql= "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, asignacion WHERE $cadvalor $sqlAdd ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$login_usr' AND id_asig IN ( $auxbo ) GROUP BY id_orden ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
	}
	if ($_REQUEST['menu']=="noSolucionado"){
		if($tecni_solo == 1)
		{
			$log = $_SESSION["login"];
			$cadvalor = " cod_usr='".$log. "' and ";
		}
		else{
			$cadvalor = "";
		}
		$sqlbo1 = "SELECT id_orden AS maxi FROM solucion WHERE login_sol='$_REQUEST[selecta]'";		
		$resultbo1=mysql_query($sqlbo1);
		while ($rowbo1 = mysql_fetch_array($resultbo1)) {
			$auxbo1 = $auxbo1.", ".$rowbo1['maxi'];
		}			
		$auxbo1 = str_replace('nochar,',' ', $auxbo1);
		
		$auxbo='nochar';
		$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion group by id_orden";
		$resultbo=mysql_query($sqlbo);
		while ($rowbo = mysql_fetch_array($resultbo)) {
		$auxbo=$auxbo.",".$rowbo['maxi'];
		}
		$auxbo3 = str_replace('nochar,',' ', $auxbo);					
		$auxbo8='nochar';
		$sqlbo8= "SELECT max(id_asig) as maxi FROM asignacion group by id_orden";
		$resultbo8=mysql_query($sqlbo8);
		while ($rowbo8 = mysql_fetch_array($resultbo8)) {
		$auxbo8=$auxbo8.",".$rowbo8['maxi'];
		}
		$auxbo8 = str_replace('nochar,',' ', $auxbo8);
		
		$datos = explode (",",$auxbo);
		$auxbo='nochar';
		$c3 = 0;
		for ($i=0; $i<count($datos); $i++)		
		{	
			$sql_abc = "SELECT * FROM asignacion WHERE id_asig='$datos[$i]'";
			$res_abc = mysql_query($sql_abc);
			$row_abc = mysql_fetch_array($res_abc);
			if ( $row_abc['asig']=="$_REQUEST[selecta]" )
			{	 $sql_or = "select * from solucion WHERE id_orden='".$row_abc['id_orden']."'"; 
				 $res_or = mysql_query($sql_or);
				 $num2  = mysql_num_rows($res_or);				
				 if ( $num2 > 0 )
				 {  
				 }
				else
				 {  $auxbo=$auxbo.",".$datos[$i];}				
			}
		}			
		$auxbo = str_replace('nochar,',' ', $auxbo);	

		$auxbo1 = 'nochar';	
		$sqlbo1 = "SELECT id_orden AS maxi FROM solucion WHERE login_sol='$_REQUEST[selecta]'";		
		$resultbo1=mysql_query($sqlbo1);
		while ($rowbo1 = mysql_fetch_array($resultbo1)) {
			$auxbo1 = $auxbo1.", ".$rowbo1[maxi];
		}			
		$auxbo1 = str_replace('nochar,',' ', $auxbo1);
				
		$sql11 = "SELECT * FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		if(empty($row11['num_ord_pag'])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11[num_ord_pag] ;}
		if (empty($_GET['pg'])) {$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}
		if ($auxbo=='nochar'){
			if ($tipo=="A" or $tipo=="B") 
			{
				if ($_REQUEST['selecta'] == "general")
			    {
					$auxbo12 = 'nochar';	
					$sqlbo12 = "SELECT id_orden AS maxi FROM solucion";		
					$resultbo12=mysql_query($sqlbo12);
					while ($rowbo12 = mysql_fetch_array($resultbo12)) {
						$auxbo12 = $auxbo12.", ".$rowbo12['maxi'];
					}			
					 $auxbo12 = str_replace('nochar,',' ', $auxbo12); 
					 $_pagi_sqlConta9 = "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg 
					 FROM  ordenes, asignacion WHERE ordenes.id_orden=asignacion.id_orden AND ordenes.id_orden NOT IN($auxbo12)";
					
				}
				else
			    { $_pagi_sqlConta9 = "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg 
				  FROM  ordenes, asignacion WHERE $sqlAdd ordenes.id_orden=asignacion.id_orden AND asignacion.asig 
				  LIKE  '$login_usr'";
				}
			}
			else  
			{
			 $_pagi_sqlConta9= "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg  FROM ordenes, asignacion WHERE ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$login_usr' AND id_asig IN ($auxbo8)";
				if ($_REQUEST['selecta']=="general")
				{ 
					$auxbo12 = 'nochar';	
					$sqlbo12 = "SELECT id_orden AS maxi FROM solucion";		
					$resultbo12=mysql_query($sqlbo12);
					while ($rowbo12 = mysql_fetch_array($resultbo12)) {
						$auxbo12 = $auxbo12.", ".$rowbo12['maxi'];
					}			
					 $auxbo12 = str_replace('nochar,',' ', $auxbo12);
					 $_pagi_sqlConta9 = "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg 
					 FROM  ordenes, asignacion WHERE ordenes.id_orden=asignacion.id_orden AND ordenes.id_orden NOT IN($auxbo12)";

				 }
				 else 
				{ $_pagi_sqlConta9 = "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg 
				  FROM  ordenes, asignacion WHERE ordenes.id_orden=asignacion.id_orden AND asignacion.asig 
				  LIKE  '$login_usr'";			
				 }				 
			}
		}
		else{
			if ($tipo=="A" or $tipo=="B") $_pagi_sqlConta9 = "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg FROM ordenes, asignacion WHERE ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$login_usr' AND id_asig IN ($auxbo)";
			else $_pagi_sqlConta9 = "SELECT count(distinct asignacion.id_orden) AS pagi_totalReg FROM  ordenes, asignacion WHERE $sqlAdd ordenes.id_orden=asignacion.id_orden AND asignacion.asig LIKE '$login_usr' AND id_asig IN ($auxbo)";
			}			
			$result9=mysql_query($_pagi_sqlConta9);
			$row9=mysql_fetch_array($result9);

			$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
			$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		
		if ($auxbo=='nochar'){
			if ($tipo=="A" or $tipo=="B") 
			{  	if ($_REQUEST['selecta']=="general"){
					$auxbo12 = 'nochar';	
					$sqlbo12 = "SELECT id_orden AS maxi FROM solucion";		
					$resultbo12=mysql_query($sqlbo12);
					while ($rowbo12 = mysql_fetch_array($resultbo12)) {
						$auxbo12 = $auxbo12.", ".$rowbo12['maxi'];
					}			
					 $auxbo12 = str_replace('nochar,',' ', $auxbo12);
					
					$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, asignacion 
					WHERE ordenes.id_orden=asignacion.id_orden AND ordenes.id_orden NOT IN ( $auxbo12 ) 
					GROUP BY id_orden ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
				}
				else
				{$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, asignacion WHERE $sqlAdd ordenes.id_orden=asignacion.id_orden AND asignacion.asig like '$login_usr' AND id_asig IN (0) GROUP BY id_orden ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
				}
			}
			else 
			{	if ($_REQUEST['selecta']=="general")
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
			
	}
	if ($_REQUEST['menu']=="solucionado"){
		
		//------------------
		if($tecni_solo == 1)
		{
			$login_usr = $_SESSION["login"];
			$sql = "select id_orden from asignacion where asig='$login_usr' UNION select  id_orden from ordenes where cod_usr='$login_usr' order by id_orden desc";
			$res = mysql_query($sql);
			$acum = "mike";
			while($row = mysql_fetch_array($res))
			{
				$acum = $acum.','.$row['id_orden'];
			}
			$acum = str_replace('mike,',' ', $acum);
			$sol = explode(",",$acum);
			echo "<br>count : ".count($sol);
			$j = 0;
			for($i=0;$i <=count($sol)-1;$i++)
			{
				$sql1 = "select *from solucion where id_orden = '$sol[$i]'";
				$res1 = mysql_query($sql1);
				$row1 = mysql_fetch_array($res1);
				if($row1[id_orden] <> '')
				{
					$sol1[$j] = $row1['id_orden'];
					$j++;
				}
			}			
			$sol2 = 'dm';
			for($i=0;$i <=count($sol1)-1;$i++)
			{
				$sol2 = $sol2.",".$sol1[$i];
			}
			$sol2 = str_replace('dm,',' ',$sol2);
			//$sol2 = explode(",",$sol2);
			echo "<br>sol3 es : ".$sol2;
		}
		
		//-------------------

		$sql11 = "SELECT * FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		if(empty($row11['num_ord_pag'])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11['num_ord_pag'] ;}
		if (empty($_GET['pg'])) {$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}

		if ($tipo=="A" or $tipo=="B") $_pagi_sqlConta9 = "SELECT count(solucion.id_orden) AS pagi_totalReg FROM ordenes, solucion WHERE ordenes.id_orden IN ($sol2) and ordenes.id_orden=solucion.id_orden AND solucion.login_sol like '$login_usr'";
		else $_pagi_sqlConta9 = "SELECT count(solucion.id_orden) AS pagi_totalReg FROM  ordenes, solucion WHERE ordenes.id_orden IN ($sol2) and $sqlAdd ordenes.id_orden=solucion.id_orden AND solucion.login_sol like '$login_usr'";
		$result9=mysql_query($_pagi_sqlConta9);
		$row9=mysql_fetch_array($result9);
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		
		if ($tipo=="A" or $tipo=="B") $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, solucion WHERE ordenes.id_orden IN ($sol2) and ordenes.id_orden=solucion.id_orden AND solucion.login_sol like '$login_usr' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
		else $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, solucion WHERE ordenes.id_orden IN ($sol2)  and $sqlAdd  ordenes.id_orden=solucion.id_orden AND solucion.login_sol like '$login_usr' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
		echo "<br>solucionados: ".$sql;
		}
		
	//
	if($_REQUEST['menu']=="tipo"){
		//------------------
		//echo "<br>tecni solo: ".$tecni_solo;
		/*if($tecni_solo == 1 )
		{
			$login_usr = $_SESSION["login"];
			$sql = "select id_orden from asignacion where asig='$login_usr' UNION select  id_orden from ordenes where cod_usr='$login_usr' order by id_orden desc";
			$res = mysql_query($sql);
			$acum = "mike";
			while($row = mysql_fetch_array($res)){
				$acum = $acum.','.$row['id_orden'];
			}
			$acum = str_replace('mike,',' ', $acum);
		}
		if($acum == 'mike'){
			$acum = 0;
		}*/
		
		//-------------------
		
		$sql11 = "SELECT * FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		if(empty($row11['num_ord_pag'])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11['num_ord_pag'] ;}
		if (empty($_GET['pg'])) {$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}
		//
		//if(isset <> 0 || $dominio <> 0 || $objetivo <> 0)
		if(isset($_REQUEST['area']) || isset($_REQUEST['dominio']) || isset($_REQUEST['objetivo']))
		{
			if($_REQUEST['area'] == 0 ){$_REQUEST['area'] = '%';}
			if($_REQUEST['dominio'] == 0 ){$_REQUEST['dominio'] = '%';}
			if($_REQUEST['objetivo'] == 0 ){$_REQUEST['objetivo'] = '%';}
			if($tecni_solo == 1){
				$_pagi_sqlConta9 ="SELECT count(distinct id_orden) AS pagi_totalReg FROM ordenes where id_orden IN ($acum) and area like '$_REQUEST[area]' and dominio like '$_REQUEST[dominio]' and objetivo like '$_REQUEST[objetivo]' and cod_usr <> 'SISTEMA'"; 
			}
			else{ $_pagi_sqlConta9 ="SELECT count(distinct id_orden) AS pagi_totalReg FROM ordenes where area like '$_REQUEST[area]' and dominio like '$_REQUEST[dominio]' and objetivo like '$_REQUEST[objetivo]'"; 
			}		
		}
		else{
			if($tecni_solo == 1 ){$_pagi_sqlConta9 ="SELECT count(distinct id_orden) AS pagi_totalReg FROM ordenes where id_orden IN ($acum) and cod_usr <> 'SISTEMA'";}
			else{ $_pagi_sqlConta9 ="SELECT count(distinct id_orden) AS pagi_totalReg FROM ordenes"; }
		}
		/*if($acum == 'mike'){
			$acum = 0;
		}*/

		$result9=mysql_query($_pagi_sqlConta9);
		$row9=mysql_fetch_array($result9);
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		
		//if($area <> 0 || $dominio <> 0 || $objetivo <> 0){
		if(isset($_REQUEST['area']) || isset($_REQUEST['dominio']) || isset($_REQUEST['objetivo'])){
			if($_REQUEST['area'] == 0 ){$_REQUEST['area'] = '%';}
			if($_REQUEST['dominio'] == 0 ){$_REQUEST['dominio'] = '%';}
			if($_REQUEST['objetivo'] == 0 ){$_REQUEST['objetivo'] = '%';}
			if($tecni_solo == 1)
			{ 
				$sql="SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes where id_orden IN($acum) and area like '$_REQUEST[area]' and dominio like '$_REQUEST[dominio]' and objetivo like '$_REQUEST[objetivo]' and cod_usr <> 'SISTEMA' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos"; 
			}
			else
			{ 
				$sql="SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes where area like '$_REQUEST[area]' and dominio like '$_REQUEST[dominio]' and objetivo like '$_REQUEST[objetivo]' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";	
			}	
		}
		else
		{
			if($tecni_solo == 1)
			{ 
				$sql="SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes where id_orden IN ($acum) and cod_usr <> 'SISTEMA' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
			}		
			else
			{ 
				$sql="SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
			}
		}
		// Sin tipificacion
		if (isset($_REQUEST['area'])){
			if($_REQUEST['area'] == "s"){
				if($tecni_solo == 1){ $_pagi_sqlConta9 ="SELECT count(id_orden) AS pagi_totalReg FROM ordenes where id_orden IN ($acum) and area='0' and dominio='0' and objetivo='0'";}	
				else{ $_pagi_sqlConta9 ="SELECT count(id_orden) AS pagi_totalReg FROM ordenes where area='0' and dominio='0' and objetivo='0'";}
				$result9=mysql_query($_pagi_sqlConta9);
				$row9=mysql_fetch_array($result9);
				$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
				$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
				
				
				//consulta
				if($tecni_solo == 1){ $sql="SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes where id_orden IN ($acum) and area='0' and dominio='0' and objetivo='0' and cod_usr <> 'SISTEMA' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos ";}
				else{ $sql="SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes where area='0' and dominio='0' and objetivo='0' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos ";}
				//consulta fin
			}
		}
		//Fin
	  	

	}
	//
	if($_REQUEST['menu']=="enviadoPor"){
		$sql11 = "SELECT * FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		if(empty($row11['num_ord_pag'])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11['num_ord_pag'] ;}
		if (empty($_GET['pg'])) {$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}

		if ($tipo=="A" or $tipo=="B") $_pagi_sqlConta9 = "SELECT count(id_orden) AS pagi_totalReg FROM ordenes WHERE cod_usr LIKE '$login_usr'";
		else $_pagi_sqlConta9 = "SELECT count(id_orden) AS pagi_totalReg FROM ordenes WHERE $sqlAdd cod_usr LIKE '$login_usr'";
		$result9=mysql_query($_pagi_sqlConta9);
		$row9=mysql_fetch_array($result9);
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		
		if ($tipo=="A" or $tipo=="B") $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE cod_usr LIKE '$login_usr' ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";
		else $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE $sqlAdd cod_usr LIKE'$login_usr' ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";
	}
	
	if ($_REQUEST['menu']=="nro_de_orden"){
		$log_usr = $_SESSION["login"];
		$sql11 = "SELECT * FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		if(empty($row11['num_ord_pag'])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11['num_ord_pag'] ;}
		if (empty($_GET['pg'])) {$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}

		if ($tipo=="A" or $tipo=="B") $_pagi_sqlConta9 = "SELECT count(id_orden) AS pagi_totalReg FROM ordenes WHERE id_orden='$_REQUEST[selecta]'";
		else $_pagi_sqlConta9 = "SELECT count(id_orden) AS pagi_totalReg FROM ordenes WHERE id_orden='$_REQUEST[selecta]'";
		$result9=mysql_query($_pagi_sqlConta9);
		$row9=mysql_fetch_array($result9);
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		
		if ($tipo=="A" or $tipo=="B" or $tipo=="T") $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE id_orden='$_REQUEST[selecta]' limit $_pagi_inicial,$_pagi_cuantos";
		else $sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE id_orden='$_REQUEST[selecta]' and 
		cod_usr = '$log_usr'  limit $_pagi_inicial,$_pagi_cuantos";
	}
		
	if ($_REQUEST['menu']=="conConformidad"){
		if($tecni_solo == 1){
			$login_usr = $_SESSION["login"];
			$sql = "select id_orden from asignacion where asig='$login_usr' UNION select  id_orden from ordenes where cod_usr='$login_usr' order by id_orden desc";
			$res = mysql_query($sql);
			$acum = "mike";
			while($row = mysql_fetch_array($res)){
				$acum = $acum.','.$row['id_orden'];
			}
			$acum = str_replace('mike,',' ', $acum);
		}
		//-------------------
				
		$sql11 = "SELECT * FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		if(empty($row11['num_ord_pag'])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11['num_ord_pag'] ;}
		if (empty($_GET['pg'])) {$_pagi_actual = 1;}
		else{$_pagi_actual = $_GET['pg'];}

		if ($tipo=="A" or $tipo=="B") 
			$_pagi_sqlConta9 = "SELECT count(conformidad.id_orden) AS pagi_totalReg FROM ordenes, conformidad WHERE ordenes.id_orden IN ($acum) and ordenes.id_orden=conformidad.id_orden AND conformidad.reg_conf like '$login_usr'";
		else 
			$_pagi_sqlConta9 = "SELECT count(conformidad.id_orden) AS pagi_totalReg FROM  ordenes, conformidad WHERE ordenes.id_orden IN ($acum) and $sqlAdd ordenes.id_orden=conformidad.id_orden AND conformidad.reg_conf like '$login_usr'";
			
		$result9=mysql_query($_pagi_sqlConta9);
		$row9=mysql_fetch_array($result9);
		$_pagi_totalPags = ceil($row9['pagi_totalReg'] / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
		
		if ($tipo=="A" or $tipo=="B")	
			$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, conformidad WHERE ordenes.id_orden IN ($acum) and ordenes.id_orden=conformidad.id_orden AND conformidad.reg_conf like '$login_usr' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
		
		else 
			$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes, conformidad WHERE ordenes.id_orden IN ($acum) and $sqlAdd  ordenes.id_orden=conformidad.id_orden AND conformidad.reg_conf like '$login_usr' ORDER BY id_orden DESC limit $_pagi_inicial,$_pagi_cuantos";
		
	}
}


if (isset($_REQUEST['menu']) && ($_REQUEST['menu']=="noAsignado" || $_REQUEST['menu']=="sinConformidad")) {

switch ($_REQUEST['menu']) {
	case "noAsignado":
		if ($tipo=="A" or $tipo=="B") {
			$sql="SELECT id_orden FROM ordenes ORDER BY id_orden DESC";
			$sqlOut="SELECT distinct id_orden FROM asignacion ORDER BY id_orden ASC";			
			}
		else {
			if($tipo=="T") {$sqlAdd = "cod_usr<>'SISTEMA'"; }
			if($tipo=="C") {$sqlAdd = "cod_usr='$login'"; }
			$sql="SELECT id_orden FROM ordenes WHERE $sqlAdd ORDER BY id_orden DESC";
			$sqlOut="SELECT asignacion.id_orden FROM ordenes, asignacion WHERE $sqlAdd AND ordenes.id_orden=asignacion.id_orden GROUP BY id_orden ORDER BY asignacion.id_orden ASC";
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
			$sql = "SELECT id_orden FROM ordenes WHERE $sqlAdd AND ORDER BY id_orden DESC";
			$sqlOut = "SELECT solucion.id_orden FROM ordenes, solucion WHERE $sqlAdd ordenes.id_orden=solucion.id_orden ORDER BY id_orden ASC";
			}
		break;
	case "sinConformidad":
	 	
		if($tipo == "A" or $tipo == "T"){
			if($_REQUEST['selecta'] == "general"){$_REQUEST['selecta'] = '%';}
			$sql = "SELECT distinct ordenes.id_orden, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2  FROM ordenes, solucion, conformidad 		
			WHERE ordenes.id_orden=solucion.id_orden AND ordenes.cod_usr like '$_REQUEST[selecta]' and conformidad.id_orden <> ordenes.id_orden 	
			ORDER BY id_orden DESC";
		}else{
			$log_usr = $_SESSION["login"];
			$sql = "SELECT distinct ordenes.id_orden, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2  FROM ordenes, solucion, conformidad 		
			WHERE ordenes.id_orden=solucion.id_orden AND ordenes.cod_usr like '$log_usr' and conformidad.id_orden <> ordenes.id_orden 	
			ORDER BY id_orden DESC";
		}
			
		$sqlOut = "SELECT id_orden FROM conformidad ORDER BY id_orden ASC";
			
		break;
		}
		$sql11 = "SELECT num_ord_pag FROM control_parametros";
		$result11=mysql_query($sql11);
		$row11=mysql_fetch_array($result11);
		if(empty($row11['num_ord_pag'])) {$_pagi_cuantos =20 ; }
		else{  $_pagi_cuantos = $row11['num_ord_pag'] ;}
		$rsOrden=mysql_query($sql);
		$rsOut=mysql_query($sqlOut);
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
	while ($tmpOut=mysql_fetch_array($rsOut)) {
		$lstOut[$tmpOut["id_orden"]]=$tmpOut["id_orden"];
		}
	$lstOrden=array();
	while ($tmpOrden=mysql_fetch_array($rsOrden)) {
		if (!array_key_exists($tmpOrden["id_orden"], $lstOut)) $lstOrden[]=$tmpOrden["id_orden"];
		}
	for($i=($_pagi_inicial+$j); $i<=($_pagi_inicial+$_pagi_cuantos);$i++)
	  {
		$sql="SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE id_orden=".$lstOrden[$i];
		if($lstOrden[$i]) 
		$row = mysql_fetch_array(mysql_query($sql));
		else break;
		//ASIGNACION
		$sql1 = "SELECT id_orden, asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion WHERE id_orden='".$row['id_orden']."' ORDER BY id_asig DESC limit 1";
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
		echo "<td ".$color.">&nbsp;$row[id_orden]</td>"; 
		if ($row['id_anidacion']==0){echo "<td>&nbsp;<img src='images/eliminar.gif' width='16' height='16'></td>";}
		else{echo '<td><a href="#" onClick="enviar('.$row['id_anidacion'].')">&nbsp;'.$row['id_anidacion'].'</a></td>';}
		//FECHA Y HORA
		echo '<td>&nbsp;'.$row['fecha'].' '.$row['time'].'</td>';
		//ENVIADO POR
			$sql5 = "SELECT * FROM users WHERE login_usr='".$row['cod_usr']."'";
			$result5 = mysql_query($sql5);
			$row5 = mysql_fetch_array($result5);
			if (!$row5['login_usr']){echo '<td>&nbsp;'.$row['cod_usr'].'</td>';}
			else{echo '<td>&nbsp;'.$row5['nom_usr'].' '.$row5['apa_usr'].' '.$row5['ama_usr'].'</td>';}
		//TIPO
		echo '<td>&nbsp;'.$row5['tipo2_usr'].'</td>';
	
		//CI RUC
		echo '<td>&nbsp;<a href="titular.php?ci_ruc='.$row['ci_ruc'].'">'.$row['ci_ruc'].'</a></td>';
	
		//INCIDENCIA
		echo '<td>&nbsp;'.$row['desc_inc'].'</td>';
		
		
		
		//ASIGNACION
		if (!$row1['id_orden'])
		{
			if ($tipo=="C"){echo"<td>&nbsp;<img src=\"images/no3.gif\" border=\"0\" alt=\"Asignacion: No\"></td>";}
			else{			
				//echo "<td>&nbsp;<a href=\"asignacion.php?pg=$_pagi_actual&menu=$menu&sel=$n1&dominio=$n2&objetivo=$n3&id_orden=$row[id_orden]\"><img src=\"images/no3.gif\" border=\"0\" alt=\"Asignacion: No\"></a></td>";
				echo '<td>&nbsp;<a href="asignacion.php?pg='.$_pagi_actual.'&menu=$menu&sel='.$_GET['sel'].'&dominio='.$_GET['dominio'].'&objetivo='.$_GET['objetivo'].'&id_orden='.$row['id_orden'].'"><img src="images/no3.gif" border="0" alt="Asignacion: No"></a></td>';
			}
		}
		else
		{
			if ($tipo=="C")
				{$sql5 = "SELECT * FROM users WHERE login_usr='$row1[asig]'";
				$result5 = mysql_query($sql5);
				$row5 = mysql_fetch_array($result5);
				echo '<td>&nbsp;'.$row5['nom_usr'].' '.$row5['apa_usr'].' '.$row5['ama_usr'].'</td>';}
			else
				{$sql5 = "SELECT * FROM users WHERE login_usr='$row1[asig]'";
				$result5 = mysql_query($sql5);
				$row5 = mysql_fetch_array($result5);
				$nomb=$row5['nom_usr']." ".$row5['apa_usr']." ".$row5['ama_usr'];
				if (mysql_num_rows($result3)!=1) 
					echo '<td>&nbsp;<a href="asignacion_last.php?pg=$_pagi_actual&menu=$menu&sel='.$_GET['sel'].'&dominio='.$_GET['dominio'].'&objetivo='.$_GET['objetivo'].'&id_orden='.$row['id_orden'].'">'.$nomb.'</a></td>';
				else echo"<td>".$nomb."</td>";
				}
		}
	
		//FECHA ESTIMADA DE SOLUCION
		?> 
		<td>&nbsp;<?php echo $row1['fechaestsol_asig2']; ?></td>
		<?php
		
		//SEGUIMIENTO
		echo '<td>&nbsp;<a href="segui.php?id_orden='.$row['id_orden'].'&lug=0&var2=0">'.$row2['num'].'</a></td>';
	
		//SOLUCION
		if ($row3){
			echo '<td><a href="solucion_ver.php?id_orden='.$row['id_orden'].'"><img src="images/ok.gif" border="0" alt="Solucion: Si Ver"></a></td>';
		}
		else
		{
			echo "<td><img src=\"images/no2.gif\" border=\"0\" alt=\"Solucion\"></td>";
			
		}
		//CONFORMIDAD
		if ($row4)
		{	if ($row4['tipo_conf'] == "2")
				echo '<td><a href="conformidad_ver.php?id_orden='.$row['id_orden'].'"><img src="images/disconf.gif" border="0" alt="Conformidad: Si Ve"></a></td>';							
			else 
				echo '<td><a href="conformidad_ver.php?id_orden='.$row['id_orden'].'"><img src="images/ok.gif" border="0" alt="Conformidad: Si Ver"></a></td>';
		}
		else
		{
			if (($login == $row['cod_usr'] || ($row['cod_usr'] == "SISTEMA" || $tipo=="A" || $tipo=="B")) && $row3['id_orden']) // 03082004 IPM
				echo '<td><a href="conformidad.php?id_orden='.$row['id_orden'].'"><img src="images/no3.gif" border="0" alt="Conformidad: No"></a></td>';
			else
				echo"<td><img src=\"images/no2.gif\" border=\"0\" alt=\"Conformidad\"></td>";
		}
		
		//COSTO DEL SERVICIO	
		if($tipo=="A" or $tipo=="B" or $tipo=="T") {echo "<td><a href=\"costo.php?id_orden=$row[id_orden]\"><img src=\"images/ver.gif\" border=\"0\" alt=\"Costo: Ver\"></a></td>";}
	
		echo '<td><a href="ver_orden.php?id_orden='.$row['id_orden'].'" target="_blank"><img src="images/imprimir.gif" border="0" alt="Imprimir Interno"></a></td>'; 
		echo '<td><a href="ver_orden2.php?id_orden='.$row['id_orden'].'" target="_blank"><img src="images/imprimir.gif" border="0" alt="Imprimir Externo"></a></td>'; 
		//ARCHIVOS ADJUNTOS
		/*if($tipo=="A" or $tipo=="B" or $tipo=="T") 
		{*/
			if (!$row['nomb_archivo']){echo "<td>NINGUNO</td>";}
			else {echo '<td><a href="archivos_adjuntos.php?id_orden='.$row['id_orden'].'">VER ARCHIVOS</a></td>';}

		/*}
		else 
		{
			if (!$row[nomb_archivo]){echo"<td>NINGUNO</td>";}
			else {echo"<td>ADJUNTADO</td>";}
		}*/
		echo "</tr>";
	  }
  }
  else{// cuando es General, asignado, solucionado, con conformidad  
   
	//echo "<br>sql es : ".$sql;
	$result=mysql_query($sql);
	while ($row=mysql_fetch_array($result)) 
	  {
		//ASIGNACION
		$sql1 = "SELECT id_orden, asig, fechaestsol_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion WHERE id_orden='".$row['id_orden']."' ORDER BY id_asig DESC limit 1";
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
		else{
			echo '<td><a href="#" onClick="enviar('.$row['id_anidacion'].')">&nbsp;'.$row['id_anidacion'].'</a></td>';}
		//FECHA Y HORA
		
		echo '<td>'.$row['fecha'].' '.$row['time'].'</td>'; 	//HERE fECHA
		//ENVIADO POR
			$sql5 = "SELECT * FROM users WHERE login_usr='$row[cod_usr]'";
			$result5 = mysql_query($sql5);
			$row5 = mysql_fetch_array($result5);
			if (!$row5['login_usr']){
				echo '<td>&nbsp;'.$row['cod_usr'].'</td>';}
			else{
				echo '<td>&nbsp;'.$row5['nom_usr'].' '.$row5['apa_usr'].' '.$row5['ama_usr'].'</td>';}    //HERE NOMBRE
			
		//**********Nuevo
		
		//Area 
		$_REQUEST['area'] = area($row['area']);
		echo "<td>&nbsp;$_REQUEST[area]</td>";
		//Dominio
		$_REQUEST['dominio'] = dominio($row['dominio']);
		echo "<td>&nbsp;$_REQUEST[dominio]</td>";
		//Objetivo de control
		$_REQUEST['objetivo'] = objetivo($row['objetivo']);
		echo "<td>&nbsp;$_REQUEST[objetivo]</td>";
		
		//**********
		
		//TIPO
		echo '<td>&nbsp;'.$row5['tipo2_usr'].'</td>';  //HERE TIPO
	
		//TIPIFICAR
		if($tipo == "A" or $tipo=="D")
		{
			$sNivel = "select *from ordenes where id_orden = '".$row['id_orden']."'";
			$rNivel = mysql_query($sNivel);
			$rowNivel = mysql_fetch_array($rNivel);
			$n1 = $rowNivel['area'];
			$n2 = $rowNivel['dominio'];
			$n3 = $rowNivel['objetivo'];
			//$n4 = $rowNivel['punto'];
			//echo '<td>&nbsp;<a href="tipos.php?id_orden='.$row['id_orden'].'&Naveg=Asignar Tipificacion&n1='.$n1.'&n2='.$n2.'&n3='.$n3.'&n4='.$n4.'&regional='.$regional.'"><img src="images/tipo.gif" border="0" alt="Tipificacion"></a></td>';  //HERE 
			if (isset($regional))
				echo '<td>&nbsp;<a href="tipos.php?id_orden='.$row['id_orden'].'&Naveg=Asignar Tipificacion&n1='.$n1.'&n2='.$n2.'&n3='.$n3.'&regional='.$regional.'"><img src="images/tipo.gif" border="0" alt="Tipificacion"></a></td>';  //HERE 
			else
				echo '<td>&nbsp;<a href="tipos.php?id_orden='.$row['id_orden'].'&Naveg=Asignar Tipificacion&n1='.$n1.'&n2='.$n2.'&n3='.$n3.'"><img src="images/tipo.gif" border="0" alt="Tipificacion"></a></td>';  //HERE 
		}
	
		//INCIDENCIA
		echo '<td>&nbsp;'.$row['desc_inc'].'</td>';
		
		//ASIGNACION
		if (!$row1['id_orden'])
		{
			if ($tipo=="C"){echo"<td><img src=\"images/no3.gif\" border=\"0\" alt=\"Asignacion: No\"></td>";}
			else{
				echo '<td><a href="asignacion.php?pg=$_pagi_actual&menu=$menu&sel='.@$_GET['sel'].'&dominio='.@$_GET['dominio'].'&objetivo='.@$_GET['objetivo'].'&id_orden='.$row['id_orden'].'&tipificacion=1"><img src="images/no3.gif" border="0" alt="Asignacion: No"></a></td>';}
		}
		else{
			if ($tipo=="C")
				{$sql5 = "SELECT * FROM users WHERE login_usr='".$row1['asig']."'";
				$result5 = mysql_query($sql5);
				$row5 = mysql_fetch_array($result5);
				echo '<td>&nbsp;'.$row5['nom_usr'].' '.$row5['apa_usr'].' '.$row5['ama_usr'].'</td>';}
			else
				{$sql5 = "SELECT * FROM users WHERE login_usr='".$row1['asig']."'";
				$result5 = mysql_query($sql5);
				$row5 = mysql_fetch_array($result5);
				$nomb=$row5['nom_usr']." ".$row5['apa_usr']." ".$row5['ama_usr'];
				if (mysql_num_rows($result3)!=1) 
					echo '<td><a href="asignacion_last.php?pg=$_pagi_actual&menu=$menu&sel='.@$_GET['sel'].'&dominio='.@$_GET['dominio'].'&objetivo='.@$_GET['objetivo'].'&id_orden='.$row['id_orden'].'&tipificacion=1">'.$nomb.'</a></td>';
				else echo"<td>".$nomb."</td>";
				}
		}
	
		//FECHA ESTIMADA DE SOLUCION
		?> 
		  <td>&nbsp;<?php echo $row1['fechaestsol_asig2']; ?></td>
		<?php
		
		//SEGUIMIENTO
		echo '<td>&nbsp;<a href="segui.php?id_orden='.$row['id_orden'].'&lug=0&tipificacion=1&var2=0">'.$row2['num'].'</a></td>';
	
		//SOLUCION
		if ($row3){
			if (isset($pg))
				echo '<td><a href="solucion_ver.php?id_orden='.$row['id_orden'].'&tipificacion=1&pg='.$pg.'"><img src="images/ok.gif" border="0" alt="Solucion: Si Ver"></a></td>';
			else
				echo '<td><a href="solucion_ver.php?id_orden='.$row['id_orden'].'&tipificacion=1"><img src="images/ok.gif" border="0" alt="Solucion: Si Ver"></a></td>';
		}
		else
		{
			echo "<td><img src=\"images/no2.gif\" border=\"0\" alt=\"Solucion\"></td>";
			
		}
		//CONFORMIDAD
		if ($row4)
		{	if ($row4['tipo_conf'] == "2")
				echo '<td><a href="conformidad_ver.php?id_orden='.$row['id_orden'].'&tipificacion=1&pg='.$pg.'"><img src="images/disconf.gif" border="0" alt="Conformidad: Si Ver"></a></td>';	
			else{
				if (isset($pg))
					echo '<td><a href="conformidad_ver.php?id_orden='.$row['id_orden'].'&tipificacion=1&pg='.$pg.'"><img src="images/ok.gif" border="0" alt="Conformidad: Si Ver"></a></td>';
				else
					echo '<td><a href="conformidad_ver.php?id_orden='.$row['id_orden'].'&tipificacion=1"><img src="images/ok.gif" border="0" alt="Conformidad: Si Ver"></a></td>';
			}
		}	
		else
		{
			if (($login == $row['cod_usr'] || ($row['cod_usr'] == "SISTEMA" || $tipo=="A" || $tipo=="B")) && $row3['id_orden']){
				if (isset($pg))
					echo '<td><a href="conformidad.php?id_orden='.$row['id_orden'].'&tipificacion=1&pg='.$pg.'"><img src="images/no3.gif" border="0" alt="Conformidad: No"></a></td>';
				else
					echo '<td><a href="conformidad.php?id_orden='.$row['id_orden'].'&tipificacion=1"><img src="images/no3.gif" border="0" alt="Conformidad: No"></a></td>';
			}
			else{
				echo '<td><img src="images/no2.gif" border="0" alt="Conformidad"></td>';
			}
		}
	
		//COSTO DEL SERVICIO	
		echo '<td><a href="ver_orden.php?id_orden='.$row['id_orden'].'" target="_blank"><img src="images/imprimir.gif" border="0" alt="Imprimir Interno"></a></td>';
		//ARCHIVOS ADJUNTOS
			if (!$row['nomb_archivo']){echo "<td>NINGUNO</td>";}
			else {
				if (isset($pg))
					echo '<td><a href="archivos_adjuntos.php?id_orden='.$row['id_orden'].'&tipificacion=1&pg='.$pg.'">VER ARCHIVOS</a></td>';
				else
					echo '<td><a href="archivos_adjuntos.php?id_orden='.$row['id_orden'].'&tipificacion=1">VER ARCHIVOS</a></td>';
			}
			echo "</tr>";
	  }
  }  
?>
      </table></td>
  </tr>
</table>
<form name="form1" method="post" action="">
<input name="pg" type="hidden" value="<?php=$pg?>">
  <table width="100%" border="0" align="center">
    <tr> 
      <td height="20"> 
        <div align="center"> 
          <p><font size="2"><strong> Pagina(s) :&nbsp; 
            <?php
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
  <?php if($tecni_solo <> '1' or $tipo <> 'T') {?>
	  <div align="center"><br>
		<?php if ($tipo=="A" or $tipo=="B" or $tipo=="T") {?>
		<input name="ESTADISTICAS" type="button" id="ESTADISTICAS" value="ESTADISTICAS" onClick="openStat_2()">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="IMPRIMIR" type="button" id="IMPRIMIR" value="  IMPRIMIR  " onClick="openStat_3()">
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="NIVELES" type="button" value=" VER NIVELES " onClick="openStat_4()">    
		<?php }?>
	  </div>
  <?php }?>  
</form>
  </p>
<script language="JavaScript">
<!--
<?php 
if(isset($msg)) echo "alert(\"$msg\\n\\nMensaje generado por GesTor F1.\");"?>
function openStat_2() {	
	window.open("orden_estadistica.php",'Estadasticas', 'width=610,height=200,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
function openStat_3() {	
	window.open("orden_estadistica2.php",'Estadasticas', 'width=610,height=350,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
function openStat_4() {	
	window.open("imprimir_pre_niveles.php",'Niveles', 'width=610,height=300,status=no,top=200,left=200,scrollbars=yes,resizable=yes');
}
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function tipo(men)
{
 	if(men=="nro_de_orden"){irapagina("lista_tipos.php?menu="+men+"&selecta=");}
	else{irapagina("lista_tipos.php?menu="+men+"&selecta=general");}
}
function tipo_d(men,sel,area)
{
 	if(men=="nro_de_orden"){irapagina("lista_tipos.php?menu="+men+"&selecta=0&sel=5");}
	else{irapagina("lista_tipos.php?menu="+men+"&selecta=general&sel="+sel+"&area="+area+"");}
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
<script>
<!--

// Funciones adicionales 
function irapaginas(pagina){         
	 if (pagina!="") {
		self.location = pagina;
	 }
}
function tipos(men){
	var area = document.form2.area.value;
	var dominio = 0;
	var objetivo = 0;
	irapaginas("lista_tipos.php?menu=tipo&sel="+men+"&Naveg=Registrar Proceso&area="+ area +"&dominio="+ dominio +"&objetivo="+objetivo);
}
function tipos1(men,va1){
	var area = document.form2.area.value;
	var dominio = document.form2.dominio.value;
	var objetivo = document.form2.objetivo.value;
	irapaginas("lista_tipos.php?menu=tipo&sel="+men+"&obco="+va1+"&Naveg=Registrar Proceso&area="+ area +"&dominio="+ dominio +"&objetivo="+objetivo);
}
function valida()
{
	var area = document.form2.area.value;
	var dominio = document.form2.dominio.value;
	var objetivo = document.form2.objetivo.value;
	irapaginas("lista_tipos.php?menu=tipo&sel="+area+"&obco="+dominio+"&Naveg=Registrar Proceso&area="+ area +"&dominio="+ dominio +"&objetivo="+objetivo);
}

</script>
<?php 

function area($id)
{
	require("conexion.php");
	$nom_area='';
	if($id <> 0)
	{
		$sql = "select *from area where area_cod = '$id'";
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res);
		$nom_area = $row['area_nombre'];
	}
	return ($nom_area);
}

function dominio($id)
{
	require("conexion.php");
	$nom_dom='';
	if($id <> 0)
	{
		$sql = "select *from dominio where id_dominio = '$id'";
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res);
		$nom_dom = $row['dominio'];
	}
	return ($nom_dom);
}

function objetivo($id)
{
	require("conexion.php");
	$nom_obj='';
	if($id <> 0)
	{
		$sql = "select *from objetivos where id_objetivo = '$id'";
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res);
		$nom_obj = $row['objetivo'];
	}
	return ($nom_obj);
}

?>
 
