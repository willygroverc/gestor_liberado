<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include ("top_ver.php");
include ( "funciones.inc.php" );
if (isset($_GET['IdFicha'])){
	$IdFicha=($_GET['IdFicha']);
	$sql = "SELECT * FROM datfichatec WHERE IdFicha='$IdFicha'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
}

?>
<html>
<head>
<title>GesTor F1 - SOPORTE TÉCNICO-PROAST - CRONOGRAMA</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF">
<p>
<?php
include("datos_gral.php");
?>
<table width="100%" border="0" align="center">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td> <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">CRONOGRAMA 
              DE MANTENIMIENTO</font></u></b></div></td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
<br>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
    <th width="4%"  rowspan="2" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">No.</font></th>
    <th width="5%"  rowspan="2" nowrap><div align="center"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Codigo 
        <br>
        Adicional</font></div></th>
	<th width="10%" rowspan="2" nowrap><div align="center"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Asignado A</font></div></th>	
    <th width="10%" rowspan="2" nowrap><div align="center"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Estado</font></div></th>
    <th height="18" colspan="3" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre1</font></th>
    <th colspan="3" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre2</font></th>
    <th colspan="3" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre3</font></th>
	<th colspan="3" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre4</font></th>
    <th width="8%" rowspan="2" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Gestion</font></th>
    <th width="13%" rowspan="2" nowrap><font size="2" face="Arial, Helvetica, sans-serif">Observacion</font></th>
    <th width="10%" rowspan="2" nowrap><font size="2" face="Arial, Helvetica, sans-serif">Firma</font></th>
  </tr>
  <tr bgcolor="#006699" align="center"> 
    <th width="4%" height="19"  nowrap bgcolor="#CCCCCC"  id="1"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ene</font></th>
    <th width="4%" nowrap bgcolor="#CCCCCC" id="2"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Feb</font></th>
    <th width="4%" nowrap bgcolor="#CCCCCC" id="3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Mar</font></th>
    <th width="4%" nowrap bgcolor="#CCCCCC" id="4"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Abr</font></th>
    <th width="4%" nowrap bgcolor="#CCCCCC" id="5"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">May</font></th>
    <th width="4%" nowrap bgcolor="#CCCCCC" id="6"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Jun</font></th>
    <th width="4%" nowrap bgcolor="#CCCCCC" id="7"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Jul</font></th>
    <th width="4%" nowrap bgcolor="#CCCCCC" id="8"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ago</font></th>
    <th width="4%" nowrap bgcolor="#CCCCCC" id="9"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Sept</font></th>
    <th width="4%" nowrap bgcolor="#CCCCCC" id="10"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Oct</font></th>
    <th width="4%" nowrap bgcolor="#CCCCCC" id="11"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Nov</font></th>
    <th width="4%" nowrap bgcolor="#CCCCCC" id="12"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Dic</font></th>
  </tr>
  <?php
		//SELECT count(AdicUSI) as total, AdicUSI FROM calenmantplanif AdicUSI GROUP BY AdicUSI
		
		$sql = "SELECT * FROM calenmantplanif  AdicUSI where elim<>1 ORDER BY AdicUSI";
		$result=mysql_query($sql);

		while($row=mysql_fetch_array($result)) 
  		{
			
		 ?>
  <?php
				$anod=substr($row['fecha_del'],0,4);
				$mesd=substr($row['fecha_del'],5,2);
				$diad=substr($row['fecha_del'],8,2);
	
				$anoa=substr($row['fecha_al'],0,4);
				$mesa=substr($row['fecha_al'],5,2);
				$diaa=substr($row['fecha_al'],8,2);?>
  <?php if($mesd==$mesa) 
			$fechac="$diad-$diaa";
		 ?>
		 
<?php //condicional para filtrado de fechas en cronograma de mantenimiento
 if($idges == $anod || $idges == 'T')  
 {
?>		 
  <tr> 
    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?phpecho @$i?><?php echo @$row['id_cmant'];?></font></td>
    <td height="30" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo @$row['AdicUSI']?></font></td>
	<td align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;
	<?php 
		
		/*
		$codu2 = XCampo($row[AdicUSI],"datfichatec","AdicUSI","Idficha");
		$temp="SELECT NombAsig FROM asigcustficha WHERE Idficha='$codu2'";
		$temp=mysql_query($temp);
		$temp=mysql_num_rows($temp);
		$temp="SELECT NombAsig FROM asigcustficha WHERE Idficha='$codu2' LIMIT 1,$temp";
		$temp=mysql_query($temp);
		$temp=mysql_fetch_array($temp);
		$codu=$temp[NombAsig];
//		$codu = XCampo($codu2,"asigcustficha","IdFicha","NombAsig");
		$nom = XCampo($codu,"users","login_usr","nom_usr");
		$pat = XCampo($codu,"users","login_usr","apa_usr");
		$mat = XCampo($codu,"users","login_usr","ama_usr");
		if (!empty($nom))
			echo $nom. " ". $pat." ".$mat;
		else
			echo "Noa signado"	
		*/
		//New code

			$sqla = "select *from datfichatec where AdicUSI = '$row[AdicUSI]'";
			$resa = mysql_query($sqla);
			$rowa = mysql_fetch_array($resa);
			
			$sqlb = "select *from asigcustficha where IdFicha = '$rowa[IdFicha]'";
			$resb = mysql_query($sqlb);
			if(mysql_num_rows($resb) >= 1)
			{
				while($rowb = mysql_fetch_array($resb))
				{
					$sel = "select *from users where login_usr='$rowb[NombAsig]' and bloquear = 0";
					$rel = mysql_query($sel);
					$rol = mysql_fetch_array($rel);
				}
				$valor = $rol['login_usr'];	
			}else{
				$valor = '';
			}
			
			$sqlc = "select *from users where login_usr = '$valor'";
			$resc = mysql_query($sqlc);
			$rowc = mysql_fetch_array($resc);
			
			
			$datos = $rowc['nom_usr']." ".$rowc['apa_usr']." ".$rowc['ama_usr'];
			if(mysql_num_rows($resc) == 0)
			{
				$datos = 'No Asignado';
			}
			
			//End new code
		    echo $datos;
		
	?>
	</font></td>
    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['estado'];?></font></td>
	
    <td align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="01"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa"; }}?>
        </font></div></td>
    <td align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="02"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="03"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="04"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="05"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="06"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="07"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="08"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="09"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="10"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="11"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="12"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $anod; ?> 
      </font> <div align="center"></div></td>
    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['Observ'];?></font> <div align="center"></div></td>
    <td align="center">&nbsp;</td>
  </tr>
  <?php } 
    //Fin de condicional para filtrado de gestion
    }
  ?>
</table>
<p>&nbsp;</p>
</body>
</html>