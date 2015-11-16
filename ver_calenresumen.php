<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	Sanitizacion de variables para evitar ataques de SQL injection
// Fecha: 		03/OCT/2013
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include ("top_ver.php");
require_once('funciones.php');
$AdicUSI=SanitizeString($_GET['AdicUSI']);
?>
<html>
<head>
<title> GesTor F1 - SOPORTE TÉCNICO-PROAST - CRONOGRAMA</title>
</head>
<body><p>
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
<?php
require("conexion.php");
include ("funciones.inc.php");

		$AdicUSI=trim($AdicUSI);

		//Nuevo código

			$sqla = "select *from datfichatec where AdicUSI = '$AdicUSI'";
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
            //fin de new code
?>
<font face="Arial, Helvetica, sans-serif" size="1"> &nbsp;&nbsp; &nbsp;&nbsp;ASIGNADO A: </font>
<font face="Arial, Helvetica, sans-serif" size="1"> &nbsp;

<?php  echo $datos; ?> 

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</font>
<table width="97%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
    <th  rowspan="2" nowrap><font size="2" face="Arial, Helvetica, sans-serif">No.</font></th>
    <th  rowspan="2" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cod. 
      Adicional </font></th>
    <th  rowspan="2" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Estado</font></th>
    <th colspan="4" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre1</font></th>
    <th colspan="4" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre2</font></th>
    <th colspan="4" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuatrimestre3</font></th>
    <th rowspan="2" nowrap><font size="2" face="Arial, Helvetica, sans-serif">Gestion</font></th>
    <th  rowspan="2" nowrap><font size="2" face="Arial, Helvetica, sans-serif">Observaciones</font></th>
    <th  rowspan="2" nowrap><font size="2" face="Arial, Helvetica, sans-serif">Firma</font></th>
  </tr>
  <tr bgcolor="#006699"> 
    <th  nowrap bgcolor="#CCCCCC"  id="1"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ene</font></th>
    <th  nowrap bgcolor="#CCCCCC" id="2"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Feb</font></th>
    <th  nowrap bgcolor="#CCCCCC" id="3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Mar</font></th>
    <th  nowrap bgcolor="#CCCCCC" id="4"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Abr</font></th>
    <th  nowrap bgcolor="#CCCCCC" id="5"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">May</font></th>
    <th  nowrap bgcolor="#CCCCCC" id="6"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Jun</font></th>
    <th  nowrap bgcolor="#CCCCCC" id="7"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Jul</font></th>
    <th  nowrap bgcolor="#CCCCCC" id="8"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ago</font></th>
    <th  nowrap bgcolor="#CCCCCC" id="9"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Sept</font></th>
    <th  nowrap bgcolor="#CCCCCC" id="10"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Oct</font></th>
    <th  nowrap bgcolor="#CCCCCC" id="11"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Nov</font></th>
    <th  nowrap bgcolor="#CCCCCC" id="12"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Dic</font></th>
  </tr>
  <?php
		$sql = "SELECT * FROM calenmantplanif WHERE AdicUSI='$AdicUSI' ORDER BY id_cmant ASC";
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
  <tr> 
    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row['id_cmant'];?></font></td>
    <td height="29" align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;
	<?php 
    echo $row['AdicUSI'];
	?></font></td>
    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['estado']?></font></td>
    <td  align="center"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="01"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa"; }}?>
        </font></div></td>
    <td  align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="02"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="03"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td  align="center"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="04"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td  align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="05"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td  align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="06"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td  align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="07"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td  align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="08"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td  align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="09"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td  align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="10"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td  align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="11"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td align="center"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php if($mesd=="12"){if($mesd==$mesa) echo $fechac; else{echo $diad; $mesd="$mesa"; $mesa="13"; $diad="$diaa";}}?>
        </font></div></td>
    <td  align="center"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $anod; ?> 
        </font></div></td>
    <td  align="center">&nbsp;<font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row['Observ']; ?></font></td>
    <td  align="center">&nbsp;</td>
  </tr>
  <?php } ?>
</table>
<br>
<br>
<p>&nbsp;</p>
</body>
</html>