<?php
@session_start();
$login=$_SESSION["login"];
$tipo=$_SESSION["tipo"];
//echo 'Usuario loguead2: '.$login;
//echo '<br>';
//echo 'Usuario Tipo: '.$tipo;
if (!isset($login)) {
	header("location: index.php"); 
}
include ("conexion.php");
include ("recordatorio_calen.php");
$sql2 = "SELECT * FROM users WHERE login_usr='$login'";	
$result2 = mysql_query($sql2);
$row2 = mysql_fetch_array($result2);

$sqlcon = "SELECT Contratos FROM roles WHERE login_usr='$login'";	
$resultcon = mysql_query($sqlcon);
$rowcon = mysql_fetch_array($resultcon);

if ($row2['tipo2_usr']=="T" OR $row2['tipo2_usr']=="A" OR $row2['tipo2_usr']=="B")
{
	//NUMERO DE ORDENES TOTALES
	$sql1 = "SELECT DISTINCT(id_orden), MAX(id_asig) FROM asignacion WHERE asig='$login' GROUP BY id_orden";
	$rs1=mysql_query($sql1);
	$numAsig=0;
	while ($tmp=mysql_fetch_array($rs1))  {			
		$sql1 = "SELECT id_orden, id_asig, asig FROM asignacion WHERE id_orden=".$tmp['id_orden']." ORDER BY id_asig DESC";
		$rsTmp=mysql_fetch_array(mysql_query($sql1));
		if ($rsTmp['asig']==$login) {
			$total[$numAsig]=$rsTmp['id_orden'];
			$numAsig++;
		}
	}
	$row[0]=$numAsig;
	$row['numtot']=$numAsig;
	
	//NUMERO DE ORDENES ASIGNADAS
	$cont = 0;
	$sql1 = "SELECT DISTINCT id_orden AS asig FROM asignacion";
	$res1 = mysql_query($sql1);
	if($row2['tipo2_usr']=="T"){
	while ($row1 = mysql_fetch_array($res1))
	{	$sqltmp = "SELECT id_orden,  cod_usr FROM ordenes WHERE id_orden='".$row1['asig']."'";
		$restmp = mysql_query($sqltmp);
		$rowtmp = mysql_fetch_array($restmp);
		if ($rowtmp['cod_usr'] <> 'SISTEMA') $cont++;
	}
	}elseif($row2['tipo2_usr']=="A"){
	while ($row1 = mysql_fetch_array($res1))
	{	$sqltmp = "SELECT id_orden,  cod_usr FROM ordenes WHERE id_orden='$row1[asig]'";
		$restmp = mysql_query($sqltmp);
		$rowtmp = mysql_fetch_array($restmp);
		$cont++;
	}
	}
	$row1['asig'] = $cont;
	
	//NUMERO DE ORDENES SIN ASIGNACION
	if($row2['tipo2_usr']=="T"){$sql = "SELECT COUNT(id_orden) AS numtot FROM ordenes WHERE cod_usr<>'SISTEMA'";}
	elseif($row2['tipo2_usr']=="A"){$sql = "SELECT COUNT(id_orden) AS numtot FROM ordenes";}
	$row=mysql_fetch_array(mysql_query($sql));

	$noasig=$row['numtot']-$row1['asig'];
	
	//NUMERO DE ORDENES CON SOLUCION
		$solu=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql3="SELECT id_orden FROM solucion WHERE id_orden='$total[$i]'";
			$row3 = mysql_fetch_array(mysql_query($sql3));
			if ($row3['id_orden']==$total[$i]) {
			$solu++;}
		}
		$row3['solu']=$solu;	
		
	//NUMERO DE ORDENES SIN SOLUCION
	if ($row['numtot']>$row3['solu'])
		{$nosolu=$row['numtot']-$row3['solu'];}
	else
		{$nosolu=0;}
	//NUMERO DE ORDENES CON CONFORMIDAD DEL CLIENTE
	$numConf=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql = "SELECT id_orden FROM conformidad WHERE id_orden='".$total[$i]."'";
		$rsTmp3=mysql_fetch_array(mysql_query($sql));
		if ($rsTmp3['id_orden']==$total[$i]){
		$numConf++;}
	}
	$row5['conf']=$numConf;
 		
 	//NUMERO DE ORDENES SIN CONFORMIDAD DEL CLIENTE
	if ($row['numtot']>$row5['conf'])
		{$noconf=$row['numtot']-$row5['conf'];}
	else
		{$noconf=0;}
	//NUMERO DE ORDENES CON CONFORMIDAD DEL TECNICO
		//NUMERO TOTAL DE ORDENES
		$sql6 = "SELECT DISTINCT(id_orden) FROM ordenes,users WHERE ordenes.cod_usr=users.login_usr AND users.login_usr='$login'";
		$rs6=mysql_query($sql6);
		$numAsig=0;
		while ($tmp=mysql_fetch_array($rs6))  {			
				$total[$numAsig]=$tmp['id_orden'];
				$numAsig++;
		}
		$row6[0]=$numAsig;
		$row6['numtot']=$numAsig;
	
	$numConf=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql = "SELECT id_orden FROM conformidad WHERE id_orden='$total[$i]'";
		$rsTmp3=mysql_fetch_array(mysql_query($sql));
		if ($rsTmp3['id_orden']==$total[$i]){
		$numConf++;}
	}
	$row7['conftec']=$numConf;
	
	//NUMERO DE ORDENES SIN CONFORMIDAD DEL TECNICO
	$noconftec=$row6['numtot']-$row7['conftec'];
}
else
{
	//NUMERO TOTAL DE ORDENES
	$sql6 = "SELECT DISTINCT(id_orden) FROM ordenes,users WHERE ordenes.cod_usr=users.login_usr AND users.login_usr='$login'";
	$rs6=mysql_query($sql6);
	$numAsig=0;
	while ($tmp=mysql_fetch_array($rs6))  {			
			$total[$numAsig]=$tmp['id_orden'];
			$numAsig++;
	}
	$row6[0]=$numAsig;
	$row6['numtot']=$numAsig;
	
	//NUMERO DE ORDENES CON SOLUCION
	$solu=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql4="SELECT id_orden FROM solucion WHERE id_orden='$total[$i]'";
		$row4 = mysql_fetch_array(mysql_query($sql4));
		if ($row4['id_orden']==$total[$i]) {
		$solu++;}
	}
	$row8['solu']=$solu;	
	
	//NUMERO DE ORDENES SIN SOLUCION
	$nosolu=$row6['numtot']-$row8['solu'];
	
	//NUMERO DE ORDENES CON CONFORMIDAD DEL CLIENTE
	$numConf=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql = "SELECT id_orden FROM conformidad WHERE id_orden='$total[$i]'";
		$rsTmp3=mysql_fetch_array(mysql_query($sql));
		if ($rsTmp3['id_orden']==$total[$i]){
		$numConf++;}
	}
	$row9['conf']=$numConf;
	
	//NUMERO DE ORDENES SIN CONFORMIDAD DEL CLIENTE
	$noconf=$row6['numtot']-$row9['conf'];
}
	//NUMERO DE D�AS DE ALERTA PARA CONTRATOS
	$sqlcont="SELECT tmp_alert FROM control_parametros";
	$resultcont=mysql_query($sqlcont);
	$rowcont=mysql_fetch_array($resultcont);

include("top.php");

if ($row2['tipo2_usr']=="T" OR $row2['tipo2_usr']=="A" OR $row2['tipo2_usr']=="B")
{
	if ($row2['tipo2_usr']=="A" OR $row2['tipo2_usr']=="B")
	{$msg="DATOS GENERALES";
	//$msg = $msg."\\n_____________________________\\n";
	$msg = $msg."\\nUsuario: ".$row2['login_usr']." \\nPendientes de solucion: $nosolu \\nPendientes de conformidad del cliente: $noconf \\nPendientes de conformidad del administrador: $noconftec \\nNumero de Ordenes no Asignadas: $noasig";}
	if ($row2['tipo2_usr']=="T")
	{$msg="DATOS GENERALES:";
	 //$msg = $msg."\\n_____________________________\\n";
	 $msg = $msg."\\nUsuario: $row2[login_usr] \\nPendientes de solucion: $nosolu \\nPendientes de conformidad del cliente: $noconf \\nPendientes de conformidad del tecnico: $noconftec \\nNumero de Ordenes no Asignadas: $noasig";
	 $sql_t="SELECT FechaDe,Actividad FROM progtareasdiaria WHERE d_asig='$row2[login_usr]' AND idProgTarea NOT IN (SELECT IdProgTarea1 FROM progtareassemanal1 WHERE Realizacion='SI')";
	 $result_t=mysql_query($sql_t);
	 while($row_t=mysql_fetch_array($result_t)){
		$fechaAc=date('Y-m-d');
		if($row_t['FechaDe']<=$fechaAc) {
			$msg=$msg.'\n';
			$msg=$msg."TAREAS: ".$row_t['Actividad'];
			
		}
	 }
	}
	if ($rowcon['Contratos']=="r"){
	$msg.="\\n_________________________\\n";
	$msg = $msg."CONTRATOS POR VENCER:";
  	$sql_c="SELECT IdContra, DATE_FORMAT(FechAl,'%d / %m / %Y') as FechAl FROM contratodatos WHERE FechAl BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ".$rowcont['tmp_alert']." DAY) ORDER BY FechAl";
  	$result_c=mysql_query($sql_c);
  	if (!$row_c=mysql_fetch_array($result_c))
	{$msg.="\\n    Ninguno";
		//en caso de que el mensaje sea ninguno entonces update al login del que tiene contrato!!!
		if($msg.="\\n    Ninguno"){
			//$sql= "UPDATE roles SET Contratos='_' WHERE login_usr='$login'";
			//mysql_query($sql);
		}
	 }	
	else{
		$sql_c="SELECT IdContra, DATE_FORMAT(FechAl,'%d / %m / %Y') as FechAl FROM contratodatos WHERE FechAl BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ".$rowcont['tmp_alert']." DAY) ORDER BY FechAl";
		$result_c=mysql_query($sql_c);
		while($row_c=mysql_fetch_array($result_c)){
			$msg.="\\n    Nro. $row_c[IdContra] : $row_c[FechAl]";}
		}
	}
}
else 
{ $msg="DATOS GENERALES:";
  $msg = $msg."\\n___________________________________________\\n";
  $msg = $msg."\\nUsuario: $row2[login_usr] \\n Ordenes de Trabajo pendientes de solucion: $nosolu \\nOrdenes de Trabajo pendientes de conformidad: $noconf";
}

$sql2 = "SELECT * FROM users WHERE login_usr='$login'";	
$result2 = mysql_query($sql2);
$row2 = mysql_fetch_array($result2);
?>
<TABLE WIDTH="85%" BORDER="2" align="center" CELLPADDING="0" CELLSPACING="2" background="images/fondo.jpg">
  <TR align="center"> 
    <th width="85%" height="74" bgcolor="#006699" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">SISTEMA 
      DE GESTION Y ADMINISTRACION DE TI <br>
      </font><font color="#FFFFFF"><font size="5">&#8220;GesTor F1"</font></font></th>
    <?php if ($tipo<>"C") {?>
	<th width="14%" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2">MIS FAVORITOS</font></th>
	<?php } ?>
  </TR>
  <TR align="center"> 
    <td> <font size="4" face="Arial, Helvetica, sans-serif"> <font color="#FF0000">Este 
      Sistema debe ser usado unicamente para fines relacionados con el Negocio.<br>
      La actividad de su cuenta es monitoreada para fines de control. </font><br>
      <br>
      </font> <table width="100%">
        <tr> 
          <td width="27%">&nbsp;</td>
          <td width="73%"><font size="3" face="Arial, Helvetica, sans-serif"><strong>Usuario 
            :</strong>&nbsp;<?php echo "$row2[nom_usr] $row2[apa_usr] $row2[ama_usr]";?><br>
            <br>
            <strong>Fecha de Ingreso :</strong>&nbsp;<?php echo date("d/m/Y");?></font></td>
        </tr>
        <tr> 
          <td colspan="2">&nbsp; </td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td><font size="3" face="Arial, Helvetica, sans-serif"><strong>Fecha 
            y Hora del Ultimo Acceso : </strong> 
            <?php
		  $sql3 = "SELECT * FROM registro WHERE login_usr='$login' AND tipo_c='INGRESO' AND tipo_d='INGRESO' ORDER BY fecha DESC LIMIT 1,1";
		  $result3 = mysql_query($sql3);
		  if ($row3 = mysql_fetch_array($result3))
			{$a1=substr($row3['fecha'],0,4);
				$m1=substr($row3['fecha'],5,2);
				$d1=substr($row3['fecha'],8,2);
				$h1=substr($row3['fecha'],11,2);
				$min1=substr($row3['fecha'],14,2);
				$seg1=substr($row3['fecha'],17,2);
		  		echo $d1."/".$m1."/".$a1."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$h1.":".$min1.":".$seg1;}
		  else
		  	print ("Primer Ingreso");
		  ?>
            </font></td>
        </tr>
        <tr> 
          <td height="21">&nbsp;</td>
          <td><font size="3" face="Arial, Helvetica, sans-serif"><strong><br>
            Intentos fallidos continuos :</strong> 
            <?php
				$sql1_0="SELECT MAX(id_log) as max_id_log FROM registro WHERE login_usr='$login'";
				$result1_0=mysql_query($sql1_0);
				$row1_0=mysql_fetch_array($result1_0);
					
				$sql1_1="SELECT MAX(id_log) as max_id_log2 FROM registro WHERE login_usr='$login' AND id_log<'".$row1_0['max_id_log']."' AND (tipo_c='CORREGIDO' OR tipo_c='INGRESO')";
				$result1_1=mysql_query($sql1_1);
				$row1_1=mysql_fetch_array($result1_1);
			
				$sql1="SELECT COUNT(*) as cont_c FROM registro WHERE login_usr='$login' AND id_log>'".$row1_1['max_id_log2']."' AND tipo_c='FALLO'";
				$result1=mysql_query($sql1);
				$row1=mysql_fetch_array($result1);
				 echo "&nbsp;&nbsp;".$row1['cont_c'];
			?>
            </font></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td><font size="3" face="Arial, Helvetica, sans-serif"><strong><br>
            Intentos fallidos discontinuos :</strong> 
            <?php 
			$sql10="SELECT COUNT(id_log) AS discont FROM registro WHERE login_usr='$login' AND tipo_d='FALLO'";
			$result10=mysql_query($sql10);
			$row10=mysql_fetch_array($result10);
			echo "&nbsp;&nbsp;".$row10['discont'];
			?>
            </font></td>
        </tr>
      </table>
      <br> 
    <?php if ($tipo<>"C") { ?>
	<td> 
      <table width="95%" border="1">
        <tr>
          <td height="245">
<div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <?php 
			 $sql1 = "SELECT * FROM roles WHERE login_usr='$login'";
			 $result1=mysql_query($sql1);
			 $row1=mysql_fetch_array($result1);
			 
			 $sql = "SELECT * FROM favoritos";
			 $result=mysql_query($sql);
			 $row=mysql_num_fields($result);
			 $rownew=$row-1;
			 for($i=4;$i<$rownew;$i++)
			{
			 	$sql2 = "SELECT * FROM favoritos";
			 	$result2=mysql_query($sql2);
			 	$row2=mysql_field_name($result2,$i);
			 	
				$sql3 = "SELECT * FROM favoritos WHERE login_usr='$login'";
			 	$result3=mysql_query($sql3);
			 	$row3=mysql_fetch_array($result3);
			 	if (!empty($row3['login_usr']))
				{
				if ($row3[$i]<>"_" AND $row1[$i]=="r"){echo "<a href=$row3[$i]>$row2</a> <br> <br>";}
				}
			}
			 for($i=$rownew;$i<$row;$i++){
			 	$sql2 = "SELECT * FROM favoritos";
			 	$result2=mysql_query($sql2);
			 	$row2=mysql_field_name($result2,$i);
			 
				$sql3 = "SELECT * FROM favoritos WHERE login_usr='$login'";
			 	$result3=mysql_query($sql3);
			 	$row3=mysql_fetch_array($result3);
			 	if (!empty($row3['login_usr']))
			 	{
				if ($row3[$i]<>"_"){echo "<a href=$row3[$i]>$row2</a> <br> <br>";}
				}
			}
			 
			 ?>
              </font> </div></td>
        </tr>
        <tr>
          <td height="26">
<div align="center"><a href="favoritos.php?Naveg=Mis Favoritos"><font size="1">Modificar Favoritos</font></a> </div></td>
        </tr>
      </table>
     <?php } ?> <tr> 
</TABLE>
<br>
<?php 
	$sql_hp="SELECT pass_cad_a,pass_cad_b,pass_cad_t,pass_cad_c, pass_cad_date, pass_cad_ing, pass_reset FROM control_parametros";
	$result_hp=mysql_query($sql_hp);
	$row_hp=mysql_fetch_array($result_hp);
		
	$sql_res="SELECT * FROM password_historico WHERE login_usr='$login' ORDER BY id_pass_h DESC limit 1";
	$result_res=mysql_query($sql_res);
	$row_res=mysql_fetch_array($result_res);
	if($row_res['login_usr']<>$row_res['realizado_por'])
	{
		$sql_res1="SELECT COUNT(*) AS ing_reset FROM registro WHERE login_usr='$login' AND tipo_c='INGRESO' AND tipo_d='INGRESO' AND fecha>'$row_res[fecha_n]'";
		$result_res1=mysql_query($sql_res1);		
		$row_res1=@mysql_fetch_array($result_res1);
		$dif3=$row_hp['pass_reset']-$row_res1['ing_reset'];
		if($dif3 > "0")
		{$msg2="Su password fue recien asignado por el Administrador del Sistema. Se le aconseja cambiarlo INMEDIATAMENTE.\\nSolo le queda $dif3 ingreso(s) antes de que su cuenta quede bloqueada";}
		elseif($dif3 == "0")
		{$msg2="Su password fue recien asignado por el Administrador del Sistema. Se le aconseja cambiarlo INMEDIATAMENTE.\\nEste fue su ULTIMO ingreso libre antes de que su cuenta quede bloqueada";}
	}
	else
	{	
		if($tipo=="A"){$sql_pash="SELECT fecha_n + INTERVAL $row_hp[pass_cad_a] DAY AS cuantos_dias FROM password_historico WHERE login_usr='$login' AND realizado_por='$login' ORDER BY id_pass_h DESC limit 1";}
		elseif($tipo=="B"){$sql_pash="SELECT fecha_n + INTERVAL $row_hp[pass_cad_b] DAY AS cuantos_dias FROM password_historico WHERE login_usr='$login' AND realizado_por='$login' ORDER BY id_pass_h DESC limit 1";}
		elseif($tipo=="T"){$sql_pash="SELECT fecha_n + INTERVAL $row_hp[pass_cad_t] DAY AS cuantos_dias FROM password_historico WHERE login_usr='$login' AND realizado_por='$login' ORDER BY id_pass_h DESC limit 1";}
		elseif($tipo=="C"){$sql_pash="SELECT fecha_n + INTERVAL $row_hp[pass_cad_c] DAY AS cuantos_dias FROM password_historico WHERE login_usr='$login' AND realizado_por='$login' ORDER BY id_pass_h DESC limit 1";}
		$result_pash=mysql_query($sql_pash);
		$row_pash=mysql_fetch_array($result_pash);
			
			$d4=substr($row_pash['cuantos_dias'],8,2);
			$m4=substr($row_pash['cuantos_dias'],5,2);
			$a4=substr($row_pash['cuantos_dias'],0,4);
			
		$sql_pash2="SELECT '$row_pash[cuantos_dias]' - INTERVAL $row_hp[pass_cad_date] DAY AS cuantos_dias2";
		$result_pash2=mysql_query($sql_pash2);
		$row_pash2=mysql_fetch_array($result_pash2);
		
		$fechahoy=date("Y-m-d");
		$sql_pash3="SELECT TO_DAYS('$fechahoy') AS hoy";
		$result_pash3=mysql_query($sql_pash3);
		$row_pash3=mysql_fetch_array($result_pash3);
		
		$sql_pash4="SELECT TO_DAYS('$row_pash[cuantos_dias]') AS dias";
		$result_pash4=mysql_query($sql_pash4);
		$row_pash4=mysql_fetch_array($result_pash4);
		
		$dif=$row_pash4['dias']-$row_pash3['hoy'];
		if($dif<=$row_hp['pass_cad_date'] AND $dif>0){ 
			$msg2="Su password caducara en $dif dia(s). Se le aconseja cambiarlo antes del $d4/$m4/$a4";}
		if($dif==0){
			$msg2="Su password caducara HOY. Se le aconseja cambiarlo INMEDIATAMENTE.";}
		if($dif<0){
			$sql_reg="SELECT COUNT(*) AS ing_gra FROM registro WHERE login_usr='$login' AND tipo_c='INGRESO' AND tipo_d='INGRESO' AND fecha>'".$row_pash['cuantos_dias']."'";
			$result_reg=mysql_query($sql_reg);		
			$row_reg=@mysql_fetch_array($result_reg);
			
			$dif2=$row_hp['pass_cad_ing']-$row_reg['ing_gra'];
			if($dif2 > "0")	{$msg2="Su password ya Caduco. Se le aconseja cambiarlo INMEDIATAMENTE.\\nSolo le queda $dif2 ingreso(s) antes de que su cuenta quede bloqueada";}
			elseif($dif2 == "0"){$msg2="Su password ya Caduco. Se le aconseja cambiarlo INMEDIATAMENTE.\\nEste fue su ULTIMO ingreso libre antes de que su cuenta quede bloqueada";}
		}
	}
	include("tbl_boletin_informativo.php");
	//echo '<strong><font color="#FF0000">'.$resul.'</font></strong>';
	?>


<script language="JavaScript">
	<?php
	if (isset($msg)){
		print "var msg=\"$msg\";\n";
		print "alert ( msg + \"\\n \\n \\n MENSAJE GENERADO POR GESTOR F1.\");\n";
	} 
	if (isset($msg2)){
		print "var msg2=\"$msg2\";\n";
		print "window.alert ( msg2 + \"\\n \\nMENSAJE GENERADO POR GESTOR F1.\");\n";
	}
	?>
</script>
