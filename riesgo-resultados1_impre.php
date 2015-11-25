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
include("datos_gral.php");
?>
<title>GesTor PCN - Riesgos</title>
<?php 
	include("conexion.php");
	 if(isset($_REQUEST['codigo']))
	$codigo=$_REQUEST['codigo'];
   
  if(isset($_REQUEST['campo']))
	$campo=$_REQUEST['campo'];	
 
  if(isset($_REQUEST['orden']))
	$orden=$_REQUEST['orden'];	
	if(isset($cons)){ 
		$cons=str_replace("*",", ",$cons);
		$sql = "SELECT *,DATE_FORMAT(fecha,'%d/%m/%Y %H:%i:%s') as fecha1 FROM riesgo_resptabla WHERE id_riesgo0 IN ($cons) LIMIT 1";
	}
	else $sql = "SELECT *,DATE_FORMAT(fecha,'%d/%m/%Y %H:%i:%s') as fecha1 FROM riesgo_resptabla WHERE id_riesgo0='$codigo' LIMIT 1";
	$result=mysql_fetch_array(mysql_query($sql));
  ?>
  
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="2">
  <tr> 
    <th colspan="6"><span class="style1">RESULTADOS DE EVALUACION</span></th>
  </tr>
  <tr align="center"> 
    <td height="27" colspan="6"> <table width="100%" border="0">
        <tr> 
          <td width="17%">&nbsp;&nbsp;&nbsp;&nbsp;<strong>TITULO:</strong> 
            </td>
			<td width="29%">
			<?php if(isset($cons)){ 
				$sql_titu="SELECT *,DATE_FORMAT(fecha,'%d/%m/%Y') as fecha1 FROM riesgo_resptabla WHERE id_riesgo0 IN ($cons) GROUP BY id_riesgo0";
				$res_titu=mysql_query($sql_titu);
				while($row_titu=mysql_fetch_array($res_titu)){
					echo "- ".$row_titu['titulo']."<br>";
				}
			}else{echo $result['titulo'];}?>
          </td>
          <td width="20%" valign="top"> <div align="right"><strong>DESCRIPCION 
              :</strong></div></td>
          <td width="34%" valign="top"> 
            <?php if(isset($cons)){echo "CONSOLIDADO";}else{echo $result['descripcion'];}?>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr align="center"> 
    <td colspan="6">&nbsp;<strong>FECHA:</strong>
      <?php echo $result['fecha1'];?>
    </td>
  </tr>
  <tr align="center" bgcolor="#CCCCCC"> 
    <td width="49" class="menu"><strong>NRO</strong></td>
    <td width="340" class="menu"><strong>DESCRIPCION</strong></td>
    <td width="131" class="menu"><strong>PROBABILIDAD&nbsp; 
      <?php if($campo=="P") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7 >"; ?>
      </strong></td>
    <td width="83" class="menu"><strong>IMPACTO&nbsp;
      <?php if($campo=="I") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7 >"; ?>
      </strong></td>
    <td width="102" class="menu"><strong>RIESGO&nbsp;
      <?php if($campo=="R") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7 >"; ?>
      </strong></td>
    <td width="145" class="menu"><strong>OBSERVACIONES</strong></td>
  </tr>

    <?php
						
		if($campo=="P"){$campo1="val1";}
		elseif($campo=="I"){$campo1="val2";}
		elseif($campo=="R"){$campo1="val3";}
		if($orden=="A"){$orden1="ASC";}
		elseif($orden=="D"){$orden1="DESC";}
		if(isset($cons)) $sql = "SELECT * FROM riesgo_resptabla WHERE id_riesgo0 IN ($cons) ORDER BY $campo1 $orden1";
		else $sql = "SELECT * FROM riesgo_resptabla WHERE id_riesgo0='$codigo' ORDER BY $campo1 $orden1";
		$result=mysql_query($sql);
		$num=1;
		$i=1;
		while($row=mysql_fetch_array($result)) {					
			$i++;
			$sql2 = "SELECT * FROM riesgo_pregunta WHERE id_riesgo='$row[id_riesgo]'";
			$result2=mysql_query($sql2);
			$row2=mysql_fetch_array($result2);
			$desc=$row2['desc_riesgo'];
			if(isset($cons)) 
				$titulox=" - ".$row['titulo'];
			else	
				$titulox='';
			echo "<tr align=\"center\">";
			printf(" <td width=\"38\">".@$num++."</td>",$i);
			printf (" <td width=\"269\">".$desc.$titulox."</td>",$i);
			printf (" <td width=\"138\">$row[val1]</td>",$i);
			printf (" <td width=\"104\">$row[val2]</td>",$i);			
			printf (" <td width=\"94\">$row[val3]</td>",$i);
			printf (" <td width=\"94\">&nbsp;$row[obs]</td>",$i);			
		}
	 ?>
</tr>
</table>
<table width="90%" border="0" align="center">
  <tr> 
    <td width="16%" height="32"><strong><font size="2" face="Arial, Helvetica, sans-serif">Promedio 
      Riesgo : </font></strong></td>
    <td width="84%"><font size="2" face="Arial, Helvetica, sans-serif"> 
      <?php
	  if(isset($cons)) $sql8 = "SELECT COUNT(*) AS num,SUM(val3)AS suma FROM riesgo_resptabla WHERE id_riesgo0 IN ($cons)";
	  else $sql8 = "SELECT COUNT(*) AS num,SUM(val3)AS suma FROM riesgo_resptabla WHERE id_riesgo0='$codigo'";
	  $result8 = mysql_query($sql8);
	  $row8 = mysql_fetch_array($result8);
	  $prom=round($row8['suma']/$row8['num'],2);
	  echo "&nbsp;$prom";
	  ?>
      </font></td>
  </tr>
</table>
