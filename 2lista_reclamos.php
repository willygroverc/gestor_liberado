<?php
include ("conexion.php");
session_start();
$login_usr = $_SESSION["login"];
if ($exportar)
{
$dir="c:/";
$path=date("Y-m-d");
$ext=".txt";
//echo date("m");
//echo date("Y");
switch(date("m")-1)
{
case "00":
$sqlfr="update reclamos set DFechaReporte='".$path."' where TFechaReclamo between '".(date("Y")-1)."-12-01"."' and '".(date("Y")-1)."-12-31"."'";
$resultfr=mysql_db_query($db,$sqlfr,$link);
$rowfr=mysql_fetch_array($rowfr);
break;
case "01":
$sqlfr="update reclamos set DFechaReporte='".$path."' where TFechaReclamo between '".date("Y")."-01-01"."' and '".date("Y")."-01-31"."'";
$resultfr=mysql_db_query($db,$sqlfr,$link);
$rowfr=mysql_fetch_array($rowfr);
break;
case "02":
$sqlfr="update reclamos set DFechaReporte='".$path."' where TFechaReclamo between '".date("Y")."-02-01"."' and '".date("Y")."-02-28"."'";
$resultfr=mysql_db_query($db,$sqlfr,$link);
$rowfr=mysql_fetch_array($rowfr);
break;
case "03":
$sqlfr="update reclamos set DFechaReporte='".$path."' where TFechaReclamo between '".date("Y")."-03-01"."' and '".date("Y")."-03-31"."'";
$resultfr=mysql_db_query($db,$sqlfr,$link);
$rowfr=mysql_fetch_array($rowfr);
break;
case "04":
$sqlfr="update reclamos set DFechaReporte='".$path."' where TFechaReclamo between '".date("Y")."-04-01"."' and '".date("Y")."-04-30"."'";
$resultfr=mysql_db_query($db,$sqlfr,$link);
$rowfr=mysql_fetch_array($rowfr);
break;
case "05":
$sqlfr="update reclamos set DFechaReporte='".$path."' where TFechaReclamo between '".date("Y")."-05-01"."' and '".date("Y")."-05-31"."'";
$resultfr=mysql_db_query($db,$sqlfr,$link);
$rowfr=mysql_fetch_array($rowfr);
break;
case "06":
$sqlfr="update reclamos set DFechaReporte='".$path."' where TFechaReclamo between '".date("Y")."-06-01"."' and '".date("Y")."-06-30"."'";
$resultfr=mysql_db_query($db,$sqlfr,$link);
$rowfr=mysql_fetch_array($rowfr);
break;
case "07":
$sqlfr="update reclamos set DFechaReporte='".$path."' where TFechaReclamo between '".date("Y")."-07-01"."' and '".date("Y")."-07-31"."'";
$resultfr=mysql_db_query($db,$sqlfr,$link);
$rowfr=mysql_fetch_array($rowfr);
break;
case "08":
$sqlfr="update reclamos set DFechaReporte='".$path."' where TFechaReclamo between '".date("Y")."-08-01"."' and '".date("Y")."-08-31"."'";
$resultfr=mysql_db_query($db,$sqlfr,$link);
$rowfr=mysql_fetch_array($rowfr);
break;
case "09":
$sqlfr="update reclamos set DFechaReporte='".$path."' where TFechaReclamo between '".date("Y")."-09-01"."' and '".date("Y")."-09-30"."'";
$resultfr=mysql_db_query($db,$sqlfr,$link);
$rowfr=mysql_fetch_array($rowfr);
break;
case "10":
$sqlfr="update reclamos set DFechaReporte='".$path."' where TFechaReclamo between '".date("Y")."-10-01"."' and '".date("Y")."-10-31"."'";
$resultfr=mysql_db_query($db,$sqlfr,$link);
$rowfr=mysql_fetch_array($rowfr);
break;
case "11":
$sqlfr="update reclamos set DFechaReporte='".$path."' where TFechaReclamo between '".date("Y")."-11-01"."' and '".date("Y")."-11-30"."'";
$resultfr=mysql_db_query($db,$sqlfr,$link);
$rowfr=mysql_fetch_array($rowfr);
break;
case "12":
$sqlfr="update reclamos set DFechaReporte='".$path."' where TFechaReclamo between '".date("Y")."-12-01"."' and '".date("Y")."-12-31"."'";
$resultfr=mysql_db_query($db,$sqlfr,$link);
$rowfr=mysql_fetch_array($rowfr);
break;
}

$sqlexp="SELECT CTipoEntidad, CCorrelativoEntidad, CReclamo, TGestion, TFechaReclamo, CTipoIdentificacion, CIDReclamante, TNombre, TApellido, CTipoOficina, CLocalidadOficina,CTipologia,CSubTipologia, TGlosa, NMontoComprometido, CMoneda, CMonedaExtranjera, NPlazoEstimadoSolucion, TPersonaDeContacto, DFechaReporte INTO OUTFILE '".$dir.$path.$ext."' FIELDS TERMINATED BY '|' FROM reclamos";
$resultexp=mysql_db_query($db,$sqlexp,$link);
$rowexp=mysql_fetch_array($resultexp);

}


$sql3 = "SELECT * FROM users WHERE login_usr='$login_usr'";
$res3 = mysql_db_query($db,$sql3,$link);
$row3 = mysql_fetch_array($res3);

$sql_cp = "SELECT * FROM control_parametros";
$res_cp = mysql_db_query($db,$sql_cp,$link);
$row_cp = mysql_fetch_array($res_cp);

if($closeord == 1)
{
	//echo "<br>close orde : ".$closeord;
	//echo "<br>vector : ".$vector;
	$ordenes = explode("|",$vector);
	for($i=1; $i<=count($ordenes) - 2; $i++)
	{
		//echo "<br>ordenes : ".$ordenes[$i];
		$sql = "Select *from asignacion where id_orden='$ordenes[$i]'";
		//echo "<br>sql  : ".$sql;
		$res = mysql_db_query($db,$sql,$link);
		$num = mysql_num_rows($res);		
		//echo "<br>num es : ".$num;
		if($num == 0)
		{
			$sqlins = "insert into asignacion (id_orden, nivel_asig, criticidad_asig, prioridad_asig, asig, fecha_asig, hora_asig, fechaestsol_asig, reg_asig, diagnos, area)
			values('$ordenes[$i]', 3, 1, 1, 'admin','".date("Y-m-d")."','".date("H:i:s")."', '".date("Y-m-d")."', 'admin', 'ORDEN ASIGNADA POR ADMINISTRADOR DEL SISTEMA', 'Mesa')";
			mysql_db_query($db, $sqlins, $link);
			
			$sqlsol = "insert into solucion (id_orden, detalles_sol, fecha_sol_e, fecha_sol, hora_sol, medprev_sol, login_sol, observaciones)
			values ('$ordenes[$i]', 'ORDEN CERRADA POR EL ADMINISTRADOR DEL SISTEMA', '".date("Y-m-d")."', '".date("Y-m-d")."','".date("H:i:s")."', 'EL USUARIO ADMINISTRADOR CERR� LA ORDEN', 'admin', observaciones='LA ORDEN NO HA SIDO SOLUCIONADA POR TANTO EL ADMINISTRADOR CERR� DICHA ORDEN')";
			mysql_db_query($db, $sqlsol, $link);
			//echo "<br>sql sol: ".$sqlsol;
			$sqlconf = "insert into conformidad (id_orden, fecha_conf, hora_conf, tiemposol_conf, calidaten_conf,obscli_conf,reg_conf, tipo_conf) 
			values ('$ordenes[$i]', '".date("Y-m-d")."','".date("H:i:s")."', '2', '2', 'EL ADMINISTRADOR DA CONFORMIDAD AUTOM�TICAMENTE POR CIERRE DE ORDEN', 'admin', '1')";
			//echo "<br>sqlconf : ".$sqlconf;
			mysql_db_query($db, $sqlconf, $link);
			
		}
		else
		{
			$sql_sol = "select *from solucion where id_orden = '$ordenes[$i]'";
			$res_sol = mysql_db_query($db,$sql_sol,$link);
			$num_sol = mysql_num_rows($res_sol);
			//echo "<br>num_sol : ".$num_sol;
			if($num_sol == 0)
			{
				$sql_ins = "insert into solucion (id_orden, detalles_sol, fecha_sol_e, fecha_sol, hora_sol, medprev_sol, login_sol, observaciones)
				values ('$ordenes[$i]', 'ORDEN CERRADA POR EL ADMINISTRADOR DEL SISTEMA', '".date("Y-m-d")."', '".date("Y-m-d")."','".date("H:i:s")."', 'EL USUARIO ADMINISTRADOR CERR� LA ORDEN', 'admin', observaciones='LA ORDEN NO HA SIDO SOLUCIONADA POR TANTO EL ADMINISTRADOR CERR� DICHA ORDEN')";
				mysql_db_query($db, $sql_ins, $link);
				//echo "<br>sql sol: ".$sql_ins;
				$sql_conf = "insert into conformidad (id_orden, fecha_conf, hora_conf, tiemposol_conf, calidaten_conf,obscli_conf,reg_conf, tipo_conf) 
				values ('$ordenes[$i]', '".date("Y-m-d")."','".date("H:i:s")."', '2', '2', 'EL ADMINISTRADOR DA CONFORMIDAD AUTOM�TICAMENTE POR CIERRE DE ORDEN', 'admin', '1')";
				//echo "<br>sqlconf : ".$sql_conf;
				mysql_db_query($db, $sql_conf, $link);
			}
			
			
		}
		//die();
	}
}




if (empty($menu))
{	
	if ($row3[visualizacion] == 1) $opc = 1;
	else  $menu = "general";
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
 <input name="opc" type="hidden" value="<?php echo $opc;?>">
  <table width="80%" border="1" align="center" bgcolor="#006699">
    <tr> 
      <td width="60%"><div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">PUNTO DE RECLAMO - PR</font></strong></div></td>
	    </tr>
  </table>
</form>
<form method="post" name="frmOrdenes" action="">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  >
    <tr> 
    <td height="47" valign="top">
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
        <tr> 
          <th colspan="20">RECLAMOS </th>
        </tr>
		<tr align="center"> 
          <td width="30" height="25" class="menu">Nro</td>
		  <td width="70" class="menu">FECHA </td>
          <td width="70" class="menu">NOMBRE</td>
          <td width="200" class="menu">RECLAMO<?php //print $help->AddLink("incidencia", "INCIDENCIA"); ?></td>
		  <td width="130" class="menu">TIPOLOGIA</td>
          <td width="70" class="menu">SUBTIPOLOGIA </td>
          <td width="20" class="menu">SOLUCION<?php //print $help->AddLink("segui", "SEGUI"); ?></td>         
          <td width="50" class="menu">IMPRIMIR INTERNO</td>
          <td width="60" class="menu">ARCHIVO ADJUNTO</td>
		  <td width="60" class="menu">ORIGEN 2</td>
        </tr>
        <?php

	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11[num_ord_pag])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11[num_ord_pag] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM reclamos";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);

$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

if($tipo=="A" or $tipo=="B") 
{	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM reclamos";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql = "SELECT reclamos.* FROM reclamos ORDER BY TFechaReclamo DESC limit $_pagi_inicial,$_pagi_cuantos";}
else if($tipo=="T") 
{	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM reclamos";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql = "SELECT reclamos.* FROM reclamos ORDER BY TFechaReclamo DESC limit $_pagi_inicial,$_pagi_cuantos";}
else if($tipo=="C") 
{	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM reclamos";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
	$sql = "SELECT reclamos.* FROM reclamos ORDER BY TFechaReclamo DESC limit $_pagi_inicial,$_pagi_cuantos";}


//-----------------------------------------------------------------------------------------------------------------------

if($selecta==general) {$login_usr='%';}
else $login_usr=$selecta;

//------------------------------------------------------------------------------------------------------------------------
?>
<input type="hidden" name="txtLimite" value="<?php=$_pagi_cuantos?>">
<?php

$sql11 = "SELECT * FROM control_parametros";
			$result11=mysql_db_query($db,$sql11,$link);
			$row11=mysql_fetch_array($result11);

	$registros=$row11[num_ord_pag];
	if (!$pag) { 
    $inicio = 0; 
    $pag = 1; 
} 
else { 
    $inicio = ($pag - 1) * $registros; 
} 
		
		
	$resultados = mysql_query("SELECT CReclamo FROM reclamos");
	$total_registros = mysql_num_rows($resultados); 
	$sql = mysql_query("SELECT * FROM reclamos ORDER BY TFechaReclamo DESC LIMIT $inicio, $registros");	
	$total_paginas = ceil($total_registros / $registros); 	
		
	//$sql="SELECT * FROM reclamos ";
	//$result=mysql_db_query($db,$sql,$link);
	//$numRows = mysql_num_rows($result);
	if($total_registros){ 
	while ($row=mysql_fetch_array($sql)) 
	  {
		$k++;
		//ASIGNACION
		$sql1 = "SELECT * FROM asignacion WHERE id_orden='$row[id_orden]' ORDER BY id_asig DESC limit 1";
		$result1=mysql_db_query($db,$sql1,$link);
		$row1=mysql_fetch_array($result1);
				
		//SEGUIMIENTO
		$sql2 = "SELECT count(*) AS num FROM seguimiento WHERE id_orden='$row[id_orden]'";
		$result2=mysql_db_query($db,$sql2,$link);
		$row2=mysql_fetch_array($result2);
		//SOLUCION
		$sql3 = "SELECT * FROM solucion_reclamos where CReclamo='$row[CReclamo]'";
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
		
		$fechahoy=date("Y-m-d");
		
			if (!$row3[CReclamo])//VENCIDOS
				{$color="bgcolor=\"#A5BBF5\"";}
			else
			{$color="bgcolor=\"#00CC66\"";}// CON SOLUCION
		
	
		echo "<tr align=\"center\">";
		if(!$row3[CReclamo])
		{
		echo "<td ".$color.">$row[CReclamo]</td>"; 
		}
		else
		{
		echo "<td ".$color.">$row[CReclamo]</td>"; 
		}
		
		echo "<td >$row[TFechaReclamo]</td>";
		//Canal de Ingreso
		switch ($row[TCanalIngreso]) {
    	case "1":
        echo "<td>Plataforma de Atencion al Cliente</td>";
        break;
    	case "2":
       echo "<td>Internet</td>";
        break;
   		 case "3":
        echo "<td>Telefono</td>";
        break;
		 case "4":
        echo "<td>Fax</td>";
        break;
		 case "5":
        echo "<td>Correspondencia</td>";
        break;
		 case "6":
        echo "<td>E-Mail</td>";
        break;
}
		 	//HERE fECHA
		//Tipo Persona
		switch ($row[CTipoPersona]) {
		case "01":
        echo "<td>Persona Natural</td>";
        break;
    	case "02":
       echo "<td>Sucesion Indivisa</td>";
        break;
   		 case "03":
        echo "<td>Empresa Unipersonal</td>";
        break;
		 case "04":
        echo "<td>Sociedad Colectiva</td>";
        break;
		 case "05":
        echo "<td>Sociedad Anonima</td>";
        break;
		 case "06":
        echo "<td>Sociedad en Comandita Simple</td>";
        break;
		case "07":
        echo "<td>Sociedad en Comandita por Acciones</td>";
        break;
		case "08":
        echo "<td>Sociedad de Responsabilidad Limitada</td>";
        break;
		case "09":
        echo "<td>Asociacion Accidental</td>";
        break;
		case "10":
        echo "<td>Sociedad Entidad Constituida en el Extranjero</td>";
        break;
		case "11":
        echo "<td>Cooperativas y Mutuales</td>";
        break;
		case "12":
        echo "<td>Sociedad Social Cultural y Deportiva</td>";
        break;
		case "13":
        echo "<td>Asoc o Fundaciones Religiosas</td>";
        break;
		case "14":
        echo "<td>Empresas Publicas</td>";
        break;
		case "15":
        echo "<td>Empresas Publicas Descen.</td>";
        break;
		case "16":
        echo "<td>Sociedad de Economia Mixta</td>";
        break;
		case "17":
        echo "<td>Otras No Especificadas</td>";
        break;
}
			    //HERE NOMBRE
		//Nombre y Apellido
		echo "<td>&nbsp;$row[TNombre] $row[TApellido] </td>";  //HERE TIPO
	
		//Glosa Reclamo
		echo "<td>&nbsp;$row[TGlosa]</td>";  //HERE 
	
		//Tipologia
		switch ($row[CTipologia]) {
    	case "1":
        echo "<td>Atencion al Cliente Usuario</td>";
        break;
    	case "4":
       echo "<td>Buro de Informacion Crediticia</td>";
        break;
		case "0":
       echo "<td></td>";
        break;
  }
		//ASIGNACION
		switch ($row[CSubTipologia]) {
		case "0":
        echo "<td></td>";
        break;
    	case "1":
        echo "<td>Espera en Colas</td>";
        break;
    	case "2":
       echo "<td>Mala Atencion</td>";
        break;
		case "3":
       echo "<td>SARC</td>";
        break;
		case "4":
       echo "<td>Actualizacion de Datos</td>";
        break;
		case "5":
       echo "<td>Falta de Liquidez</td>";
        break;
		case "6":
       echo "<td>Correspondencia no Entregada</td>";
        break;
		case "7":
       echo "<td>Facturacion</td>";
        break;
		case "8":
       echo "<td>Certificado de Aportaciones</td>";
        break;
		case "9":
       echo "<td>Transacciones de Ventanilla/Boveda</td>";
        break;
		case "10":
       echo "<td>Secreto Bancario</td>";
        break;
		case "105":
       echo "<td>Modificacion de Datos</td>";
        break;
		case "39":
       echo "<td>Duplicidad de Documento de Identidad</td>";
        break;
		case "75":
       echo "<td>Registro de Procesos Judiciales</td>";
        break;
		case "71":
       echo "<td>Permanencia en Base de Datos</td>";
        break;
		case "53":
       echo "<td>Homonimo</td>";
        break;
		
  }
		
		if(!$row3[CReclamo])
		{
		echo "<td><img src=\"images/no3.gif\" border=\"0\" alt=\"Solucion: No\"></td>";
		}
		else
		{
		echo "<td><a href=\"solucion_ver_rec.php?id_orden=$row[CReclamo]&pg=$pg\"><img src=\"images/ok.gif\" border=\"0\" alt=\"Solucion: Si Ver\"></td>";
		}
		
	
		//FECHA ESTIMADA DE SOLUCION
		?> 
		  
		<?php
	   //COSTO DEL SERVICIO	
		echo "<td><a href=\"ver_orden_sarc.php?id_orden=$row[CReclamo]\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir Interno\"></a></td>"; 
		//ARCHIVOS ADJUNTOS
		/*if($tipo=="A" or $tipo=="B" or $tipo=="T") 
		{*/
			if (!$row[TDocumentosAdjuntos]){echo "<td>NINGUNO</td>";}
			else {echo "<td><a href=\"archivos_adjuntos_sarc.php?id_orden=$row[CReclamo]\">VER ARCHIVOS</a></td>";}
		/*}
		else 
		{
			if (!$row[nomb_archivo]){echo"<td>NINGUNO</td>";}
			else {echo"<td>ADJUNTADO</td>";}
		}*/
		switch ($row[origen]){
			case "0": $graf="<img src=\"images/0.gif\" border=\"0\" alt=\"Mesa de Ayuda\">"; break;
			case "1": $graf="<img src=\"images/1.gif\" border=\"0\" alt=\"Gestion\">"; break;
			case "1.4": $graf="<img src=\"images/1-4.gif\" border=\"0\" alt=\"Gestion - Planificacion Estrategica\">"; break;
			case "2": $graf="<img src=\"images/2.gif\" border=\"0\" alt=\"Soporte Tecnico\">"; break;
			case "2.3": $graf="<img src=\"images/2-3.gif\" border=\"0\" alt=\"Soporte Tecnico - Cronograma\">"; break;
			case "3": $graf="<img src=\"images/3.gif\" border=\"0\" alt=\"Desarrollo y Mantenimiento\">"; break;
			default: $graf="<img src=\"images/0.gif\" border=\"0\" alt=\"Mesa de Ayuda\">"; break;
		}
		echo "<td>$graf&nbsp;</td>";
		echo "</tr>";
	  }
		  
  }
  mysql_free_result($sql);	
    
?>
	<input type="hidden" name="txtCount" value="<?php=$k?>">
      </table></td>
  </tr>
</table>
</form>
<form name="form1" method="post" action="">
  <table width="100%" border="0" align="center">
    <tr> 
      <td height="20"> 
        <div align="center"> 
          <p><font size="2"><strong> Pagina(s): 
            <?php
if($total_registros) {
		
		//echo "<center>";
		
		if(($pag - 1) > 0) {
			echo "<a href='lista_reclamos.php?pag=".($pag-1)."'><< Anterior</a> ";
		}
		
		for ($i=1; $i<=$total_paginas; $i++){ 
			if ($pag == $i) {
				echo "<b>".$pag."</b> "; 
			} else {
				echo "<a href='lista_reclamos.php?pag=$i'>$i</a> "; 
			}	
		}
	  
		if(($pag + 1)<=$total_paginas) {
			echo " <a href='lista_reclamos.php?pag=".($pag+1)."'>Siguiente >></a>";
		}
		
		echo "</center>";
		
	}
?>
            <br>
            <br>
            </strong></font></p>
        </div></td>
    </tr>
  </table>
  <table width="396" border="1" align="center">
    <!--DWLayoutTable-->
    <tr align="center"> 
      <td width="124" height="42" valign="middle" >SOLUCIONADOS</td>
      <td width="53" valign="top" bgcolor="#00CC66" ><!--DWLayoutEmptyCell-->&nbsp;</td>
      <td width="128" valign="middle" >NO SOLUCIONADOS </td>
      <td width="63" valign="top" bgcolor="#A5BBF5"><!--DWLayoutEmptyCell-->&nbsp;</td>
    </tr>
  </table>
 
  <p>&nbsp;</p>
  <label>
    <div align="center">
  <div align="center">
      <!--  <input type="submit" name="exportar" value="Exportar" onclick="return exportarreclamos()"/> -->
    <label>
        <input type="submit" name="exportar2" value="Exportar Reclamos" onClick="openStat_3()" />
    </label>
      <label>
      <input type="submit" name="exportar3" value="Exportar Solucion" onClick="openStat_4()"/>
      </label>
  </div>
      </label>
    <p align="center">&nbsp; </p>
  <div align="center"><br>
    
  </div>
</form>
  </p>
<script language="JavaScript">
<!--
<?php 
if($msg) print "alert(\"$msg\\n\\nMensaje generado por GesTor F1.\");"?>
function openStat_2() {	
	window.open("orden_estadistical.php",'Estad�sticas', 'width=610,height=200,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
function openStat_3() {	
	window.open("exportar_reclamos.php",'Estad�sticas', 'width=610,height=200,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
function openStat_4() {	
window.open("exportar_solucion.php",'pre_tiempos', 'width=610,height=200,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
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
<?php if($vent){?>
ventana_secundaria=window.open('pru2.php','secundaria','location=no,menubar=no,status=no,toolbar=no,scrollbars=0,resizable=no,width=350,height=170,left=150,top=150'); 
ventana_secundaria.close(); 
<?php }?>
-->
</script>
<?php 
include("top_.php");
?>
<script language="javascript1.2">
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
function exportarreclamos()
{
var fecha=new Date();
var mes = fecha.getMonth() -1;
var anio = fecha.getYear() + 1900;
var anioo = fecha.getYear() + 1900 -1;
if(mes=-1)
{
if(confirm("Esta Seguro de Exportar los Reclamos Correspondiente al Mes 12 del a�o "+anioo+""))
{
}
else
{
return false;
}
} else
{
if(confirm("Esta Seguro de Exportar los Reclamos Correspondiente al Mes "+mes+" del a�o "+anio+""))
{
}
else
{
return false;
}
}
}
function cerrarOrdenes()
{
	var pg='<?phpecho $pg ?>';

	contador = 0;
	limite = document.frmOrdenes.txtCount.value;
	for(i=1; i<=limite; i++)
	{
		if(document.frmOrdenes.all("ch_" + i).checked)
		{
			contador = 1;
		}
	}
	if(contador == 1)
	{
		if(confirm("Esta seguro de cerrar las ordenes seleccionadas?\nMensaje generado por GesTor F1."))
		{
			closeord = 1;
			vector = "|";
			for(i=1; i<=limite; i++)
			{
				if(document.frmOrdenes.all("ch_" + i).checked)
				{
					id = document.frmOrdenes.all("id_" + i).value;
					vector = vector + id + "|";
				}
			}
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
