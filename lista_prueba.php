<?php
if (isset($RETORNAR)){ header("location: lista_prueba_tipo.php?Naveg=Cambios");}
include ("top.php");
?>
<form name="form1" method="post">
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
    <tr bgcolor="#006699" align="center"> 
      <td height="23" colspan="15" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>EJECUCION 
        DE PRUEBAS DE ACEPTACION</strong></font></td>
    <tr bgcolor="#006699" align="center"> 
      <td width="7%" rowspan="2" background="images/main-button-tileR1.jpg" height="22"><font color="#FFFFFF">N&deg; ORDEN</font></td>
      <td width="20%" rowspan="2" background="images/main-button-tileR1.jpg" height="22"> <div align="center"><font color="#FFFFFF">INCIDENCIA</font></div></td>
      <td width="13%" rowspan="2" background="images/main-button-tileR1.jpg" height="22"><div align="center"><font color="#FFFFFF">SOLICITANTE</font></div></td>
      <?php if ($tipo=="A" or $tipo=="B") {?>
      <td width="13%" rowspan="2" background="images/main-button-tileR1.jpg" height="22"><div align="center"><font color="#FFFFFF">ASIGNADO 
          A</font></div></td>
      <?php }?>
      <td <?php if($tipo=="T"){echo "colspan=\"2\" width=\"18%\"";}else{echo "colspan=\"3\" width=\"18%\"";}?> background="images/main-button-tileR1.jpg" height="22"><font color="#FFFFFF">PRUEBA USUARIA</font></div></td>
      <td <?php if($tipo=="T"){echo "colspan=\"2\" width=\"18%\"";}else{echo "colspan=\"3\" width=\"18%\"";}?> background="images/main-button-tileR1.jpg" height="22"><font color="#FFFFFF">PRUEBA DE SISTEMAS</font></td>
      <td <?php if($tipo=="T"){echo "colspan=\"2\" width=\"18%\"";}else{echo "colspan=\"3\" width=\"18%\"";}?> background="images/main-button-tileR1.jpg" height="22"><font color="#FFFFFF">PRUEBA DE SEGURIDAD</font></td>
	  </tr>
	    <tr bgcolor="#006699" align="center"> 
      	<td width="3%" background="images/main-button-tileR1.jpg" height="22"><div align="center"><font color="#FFFFFF">LLENAR</font></div></td>
		<?php if($tipo=="A" OR $tipo=="B"){?>
      	<td width="3%" background="images/main-button-tileR1.jpg" height="22"><div align="center"><font color="#FFFFFF">MODIFICAR</font></div></td>
		<?php }?>
      	<td width="3%" background="images/main-button-tileR1.jpg" height="22"><div align="center"><font color="#FFFFFF">IMPRIMIR</font></div></td>
		<td width="3%" background="images/main-button-tileR1.jpg" height="22"><div align="center"><font color="#FFFFFF">LLENAR</font></div></td>
		<?php if($tipo=="A" OR $tipo=="B"){?>
      	<td width="3%" background="images/main-button-tileR1.jpg" height="22"><div align="center"><font color="#FFFFFF">MODIFICAR</font></div></td>
		<?php }?>
      	<td width="3%" background="images/main-button-tileR1.jpg" height="22"><div align="center"><font color="#FFFFFF">IMPRIMIR</font></div></td>
		<td width="3%" background="images/main-button-tileR1.jpg" height="22"><div align="center"><font color="#FFFFFF">LLENAR</font></div></td>
		<?php if($tipo=="A" OR $tipo=="B"){?>
      	<td width="3%" background="images/main-button-tileR1.jpg" height="22"><div align="center"><font color="#FFFFFF">MODIFICAR</font></div></td>
		<?php }?>
      	<td width="3%" background="images/main-button-tileR1.jpg" height="22"><div align="center"><font color="#FFFFFF">IMPRIMIR</font></div></td>
	</tr>
      <?php
	    $sql11 = "SELECT num_ord_pag FROM control_parametros";
		$result11=mysql_db_query($db,$sql11,$link);
		$row11=mysql_fetch_array($result11);

		if(empty($row11['num_ord_pag'])){	$_pagi_cuantos =20 ; }
		else{$_pagi_cuantos = $row11['num_ord_pag'] ;}

		if (empty($_GET['pg'])){$_pagi_actual = 1; $j=1;}
		else{$_pagi_actual = $_GET['pg']; $j=1;}
	    
		$sql = "SELECT DISTINCT(id_orden) FROM cambios_prueba_planif GROUP BY id_orden";
		$rs1=mysql_db_query($db,$sql,$link);
		$numAsig=0;
		while ($tmp=mysql_fetch_array($rs1))  
		{ 	if ($tipo=="T")
			{ 	$sql20="SELECT MAX(id_asig) AS id_asig FROM asignacion WHERE id_orden=$tmp[id_orden]";
				$result20=mysql_db_query($db,$sql20,$link);	
				$row20=mysql_fetch_array($result20);
			
				$sql10 = "SELECT asig,area FROM asignacion WHERE id_asig=$row20[id_asig]";
		  	  	$rsTmp=mysql_fetch_array(mysql_db_query($db,$sql10,$link));
		  		if ($rsTmp['area']=="Cambios" AND $rsTmp['asig']==$login)
	 	  		{$total[$numAsig]=$rsTmp['id_orden'];
			 	 $numAsig++;
		  		}
			}
			else 
			{ 
				$numAsig++;
			}
		}
		
		$_pagi_totalPags = ceil($numAsig / $_pagi_cuantos);
		$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

		$sql = "SELECT id_orden FROM cambios_prueba_planif GROUP BY id_orden ORDER BY id_orden DESC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
			if ($tipo=="T")
			{ 
				$sql20="SELECT MAX(id_asig) AS id_asig FROM asignacion WHERE id_orden=$row[id_orden]";
				$result20=mysql_db_query($db,$sql20,$link);	
				$row20=mysql_fetch_array($result20);
				
				$sql10 = "SELECT * FROM asignacion WHERE id_asig=$row20[id_asig]";
				$rsTmp=mysql_fetch_array(mysql_db_query($db,$sql10,$link));
				if ($rsTmp['asig']==$login)
				{ $imprime="SI";}
				else
				{ $imprime="NO";}
			}
			else 
			{	
				$sql20="SELECT MAX(id_asig) AS id_asig FROM asignacion WHERE id_orden=$row[id_orden]";
				$result20=mysql_db_query($db,$sql20,$link);	
				$row20=mysql_fetch_array($result20);
				if(!empty($row20['id_asig'])) {
					$sql10 = "SELECT * FROM asignacion WHERE id_asig=$row20[id_asig]";
					$rsTmp=mysql_fetch_array(mysql_query($sql10));
				}
				$imprime="SI";
			}
		 
		 				
			if ($imprime=="SI")
		 	{
			?>
				 
				  <tr align="center">
				  <td><font size="1"><?php echo "<a href=\"ver_orden.php?id_orden=$row[id_orden]\" target=\"_blank\">$row[id_orden]</a>";?>&nbsp; </font></td>
				  <td><font size="1">&nbsp; 
					<?php 
					$sql3 = "SELECT desc_inc, cod_usr FROM ordenes WHERE id_orden='$row[id_orden]'";
					$result3=mysql_db_query($db,$sql3,$link);
					$row3=mysql_fetch_array($result3);
					echo $row3['desc_inc']?>
					</font></td>
				  <td><font size="1">&nbsp; 
					<?php
				   
					$sql4 = "SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$row3[cod_usr]'";
					$result4=mysql_db_query($db,$sql4,$link);
					$row4=mysql_fetch_array($result4);
					echo $row4['nom_usr']." ".$row4['apa_usr']." ".$row4['ama_usr'];
					?>
					</font></td>
				  <?php 
					if ($tipo=="A" or $tipo=="B")
					{ 
						echo "<td><font size=\"1\">&nbsp;";
						if(!empty($rsTmp['asig'])) {
							$sql4 = "SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$rsTmp[asig]'";
							$result4=mysql_query($sql4);
							$row4=mysql_fetch_array($result4);
						}
						echo $row4['nom_usr']." ".$row4['apa_usr']." ".$row4['ama_usr'];
						echo "</font></td>";
					}
					
					$tp1=md5($row['id_orden']);
					
					$sql2 = "SELECT * FROM cambios_prueba_planif WHERE id_orden='$row[id_orden]' AND tipo_pru='1'";
					$result2=mysql_db_query($db,$sql2,$link);
					$row2=mysql_fetch_array($result2);
					$sql3 = "SELECT * FROM cambios_prueba WHERE id_orden='$row[id_orden]' AND tipo_pru='1'";
					$result3=mysql_db_query($db,$sql3,$link);
					$row3=mysql_fetch_array($result3);
				  
				  ?>		  
				  <td width="6%">&nbsp;
				  <?php 
				  if(!$row2['id_orden']){echo "<img src=\"images/no2.gif\" border=\"0\" alt=\"Llenar\">";}else{if(!$row3['id_orden'] OR $row3['tipo_pru']!="1"){echo "<a href=\"cambio_pru.php?orden=$row[id_orden]&tp=258db52a0b75ba2448af531309ad5eac_$tp1&cod=$row2[id_pru]\"><img src=\"images/no3.gif\" border=\"0\" alt=\"LLenar\"></a>";}else{echo "<img src=\"images/ok.gif\" border=\"0\" alt=\"LLenado\"></a>";}		 }?></td>
				  <?php if($tipo=="A" OR $tipo=="B"){?>
				  <td width="6%">&nbsp;<?php if(!$row3['id_orden']){echo "<img src=\"images/no2.gif\" border=\"0\" alt=\"Editar\">";}else{echo "<a href=\"cambio_pru_last.php?orden=$row[id_orden]&tp=258db52a0b75ba2448af531309ad5eac_$tp1&cod=$row2[id_pru]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Editar\"></a>";}?></td>
				  <?php }?>
				  <td width="6%">&nbsp;<?php if(!$row3['id_orden']){echo "<img src=\"images/no2.gif\" border=\"0\" alt=\"Imprimir\">";}else{echo "<a href=\"cambio_pru_ver.php?orden=$row[id_orden]&tp=258db52a0b75ba2448af531309ad5eac_$tp1\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a>";}?></td>
				  
				  <?php $sql2 = "SELECT * FROM cambios_prueba_planif WHERE id_orden='$row[id_orden]' AND tipo_pru='2'";
				  	$result2=mysql_db_query($db,$sql2,$link);
					$row2=mysql_fetch_array($result2);
					$sql3 = "SELECT * FROM cambios_prueba WHERE id_orden='$row[id_orden]' AND tipo_pru='2'";
					$result3=mysql_db_query($db,$sql3,$link);
					$row3=mysql_fetch_array($result3);
					?>
				  <td width="6%">&nbsp;<?php if(!$row2['id_orden']){echo "<img src=\"images/no2.gif\" border=\"0\" alt=\"Llenar\">";}else{if(!$row3['id_orden'] OR $row3['tipo_pru']!="2"){echo "<a href=\"cambio_pru.php?orden=$row[id_orden]&tp=7d428547b8723786029735cde7b75d7d_$tp1&cod=$row2[id_pru]\"><img src=\"images/no3.gif\" border=\"0\" alt=\"LLenar\"></a>";}
					else{echo "<img src=\"images/ok.gif\" border=\"0\" alt=\"LLenado\"></a>";}}?></td>
				  <?php if($tipo=="A" OR $tipo=="B"){?>
				  <td width="6%">&nbsp;<?php if(!$row3['id_orden']){echo "<img src=\"images/no2.gif\" border=\"0\" alt=\"Editar\">";}else{echo "<a href=\"cambio_pru_last.php?orden=$row[id_orden]&tp=7d428547b8723786029735cde7b75d7d_$tp1&cod=$row2[id_pru]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Editar\"></a>";}?></td>
				  <?php }?>
				  <td width="6%">&nbsp;<?php if(!$row3['id_orden']){echo "<img src=\"images/no2.gif\" border=\"0\" alt=\"Imprimir\">";}else{echo "<a href=\"cambio_pru_ver.php?orden=$row[id_orden]&tp=7d428547b8723786029735cde7b75d7d_$tp1\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a>";}?></td>
				 
				 <?php $sql2 = "SELECT * FROM cambios_prueba_planif WHERE id_orden='$row[id_orden]' AND tipo_pru='3'";
					$result2=mysql_db_query($db,$sql2,$link);
					$row2=mysql_fetch_array($result2);
					$sql3 = "SELECT * FROM cambios_prueba WHERE id_orden='$row[id_orden]' AND tipo_pru='3'";
					$result3=mysql_db_query($db,$sql3,$link);
					$row3=mysql_fetch_array($result3);
					?>
				  <td width="6%">&nbsp;<?php if(!$row2['id_orden']){echo "<img src=\"images/no2.gif\" border=\"0\" alt=\"Llenar\">";}else{if(!$row3[id_orden] OR $row3[tipo_pru]!="3"){echo "<a href=\"cambio_pru.php?orden=$row[id_orden]&tp=f4b29b15eee509a8fa39344471561d29_$tp1&cod=$row2[id_pru]\"><img src=\"images/no3.gif\" border=\"0\" alt=\"LLenar\"></a>";}
					else{echo "<img src=\"images/ok.gif\" border=\"0\" alt=\"LLenado\"></a>";}}?></td>
				  <?php if($tipo=="A" OR $tipo=="B"){?>
				  <td width="6%">&nbsp;<?php if(!$row3['id_orden']){echo "<img src=\"images/no2.gif\" border=\"0\" alt=\"Editar\">";}else{echo "<a href=\"cambio_pru_last.php?orden=$row[id_orden]&tp=f4b29b15eee509a8fa39344471561d29_$tp1&cod=$row2[id_pru]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Editar\"></a>";}?></td>
				  <?php }?>
				  <td width="6%">&nbsp;<?php if(!$row3['id_orden']){echo "<img src=\"images/no2.gif\" border=\"0\" alt=\"Imprimir\">";}else{echo "<a href=\"cambio_pru_ver.php?orden=$row[id_orden]&tp=f4b29b15eee509a8fa39344471561d29_$tp1\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a>";}?></td>
				  <?php /*if ($tipo=="A" or $tipo=="B"){
						if (!empty($row2[num_cambio])){echo "<td>&nbsp;<a href=\"maes_cambios_last.php?orden=$row[id_orden]\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></td>";}
						else {echo "<td>&nbsp;<img src=\"images/no2.gif\" border=\"0\" alt=\"Modificar\"></td>";}
					   }
						if (!empty($row2[num_cambio])){echo "<td>&nbsp;<a href=\"ver_maes_cambios.php?orden=$row[id_orden]\"target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></td>";}
						else {echo "<td>&nbsp;<img src=\"images/no2.gif\" border=\"0\" alt=\"Imprimir\"></td>";}*/
					   ?>
			</tr>
			<?php 
			}
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
  <div align="center"><br>
    <input type="submit" name="RETORNAR" value="RETORNAR">
  </div>
</form>
<?php include ("top_.php");?>
<script language="JavaScript">
<!--
<?php if ($msg=="2"){
			print "var msg=\"Los Datos no fueron registrados, por error de codificacion, no modifique valores de variables\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";	
	}
?>
-->
</script>