<?php
include ("conexion.php");
session_start();
$login_usr = $_SESSION["login"];
$sql3 = "SELECT * FROM users WHERE login_usr='$login_usr'";
$res3 = mysql_db_query($db,$sql3,$link);
$row3 = mysql_fetch_array($res3);
include ("top.php");
?>
<script language="JavaScript" src="calendar.js"></script>
<?php include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num","Numero");
	$help->AddHelp("crit","Criticidad");
	$help->AddHelp("prio","Prioridad");
	$help->AddHelp("estima","Estimacion");
	$help->AddHelp("reg","Registrado por");
	$help->AddHelp("esc","Escala");
	$help->AddHelp("segui","Seguimiento");
	print $help->ToHtml();
?>
<p>
<?php if ($tipo=="A"){?>
<form action="" method="get" name="form2" id="form2" >
  <table width="80%" border="1" align="center"  bgcolor="#006699">
    <tr> 
      <td width="60%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Busqueda 
          por :</strong></font> 
		  <select name="menu" id="menu" onChange="tipo(this.value);">
		  	<option value="general">General</option>
            <option value="porNivel"<?php if ($menu=="porNivel") print selected?>>Por Nivel</option>
            <option value="porPrioridad"<?php if ($menu=="porPrioridad") print selected?>>Por Prioridad</option>
			<option value="porCriticidad"<?php if ($menu=="porCriticidad") print selected?>>Por Criticidad</option>			
            <option value="asignadoA"<?php if ($menu=="asignadoA") print selected?>>Asignado A</option>
            <option value="asignadoPor"<?php if ($menu=="asignadoPor") print selected?>>Asignado Por</option>
			<option value="porFecha"<?php if ($menu=="porFecha") print selected?>>Por Fecha</option>
          </select>
          <?php if($menu!="porFecha"){?>
          <select name="selecta" onChange="tipo(this.value)">
		  		<option value="general" selected > General </option>
       	  	
			<?php
			switch ($menu) {
			
			case "porNivel":
						for($i = 1; $i<=3; $i++){
			?>				<option value="<?php=$i?>" <?php if($selecta == $i)  print selected ;?>><?php=$i?></option>
						<?php }?>			
						</select>
			<?php break;
			case "porPrioridad":
						for($i = 1; $i<=3; $i++){
			?>				<option value="<?php=$i?>" <?php if($selecta == $i)  print selected ;?>><?php=$i?></option>
						<?php }?>			
			<?php break;
			
			case "porCriticidad":
						for($i = 1; $i<=3; $i++){
			?>				<option value="<?php=$i?>" <?php if($selecta == $i)  print selected ;?>><?php=$i?></option>
						<?php }?>			
			<?php break;
			
			case "asignadoA":
						$sqltec = "select distinct(asig) from asignacion";
						$resultec= mysql_db_query($db,$sqltec,$link);
						while($rowtec= mysql_fetch_array($resultec)){
							$sqlU = "SELECT * FROM users WHERE login_usr='$rowtec[asig]'";
							$resU = mysql_db_query($db,$sqlU,$link);
							while($rowU=mysql_fetch_array($resU)){
							?>
								<option value="<?php=$rowU[login_usr];?>"<?php if ($selecta==$rowU[login_usr]) print selected ?>>
									<?php=$rowU[ama_usr]." ".$rowU[apa_usr]." ".$rowU[nom_usr];?>
								</option>
								
						<?php }}?>
						</select>
			<?php	break;
			
			case "asignadoPor":
						
						$sqltec = "select distinct reg_asig from asignacion";
						$resultec= mysql_db_query($db,$sqltec,$link);
						while($rowtec= mysql_fetch_array($resultec)){
							$sqlU = "SELECT * FROM users WHERE login_usr='$rowtec[reg_asig]'";
							$resU = mysql_db_query($db,$sqlU,$link);
							while($rowU=mysql_fetch_array($resU)){
							?>
								<option value="<?php=$rowU[login_usr];?>"<?php if ($selecta==$rowU[login_usr]) print selected ?>>
									<?php=$rowU[ama_usr]." ".$rowU[apa_usr]." ".$rowU[nom_usr];?>
								</option>
						<?php }}?>
						</select>
						
			<?php	break;
			
			case "enviadoPor":
			?>			
						
						
			<?php	break;
			}
			
		  ?>&nbsp;&nbsp;&nbsp;
		  <?php }else{?>
		  <!----------------------------------->
		  &nbsp;&nbsp;&nbsp;
		  <font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Desde :</strong></font> 
		  <select name="DE" id="select8">
                <?php
				$ano=substr($row7[fechasol_esc],0,4);
				$mes=substr($row7[fechasol_esc],5,2);
				$dia=substr($row7[fechasol_esc],8,2);

				for($i=1;$i<=31;$i++)
				{
	                echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";
				}
				?>
              </select> <select name="ME" id="select9">
                <?php
				for($i=1;$i<=12;$i++)
				{
    	            echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
				}
				?>
              </select> <select name="AE" id="select10">
                <?php
				for($i=2003;$i<=2020;$i++)
				{
        	        echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";
				}
				?>
              </select> 
			  <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a>
            <!------------------------------------------------------------------------------------------------------>
			&nbsp;&nbsp;&nbsp;
		  <font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Hasta :</strong></font> 
		  <select name="DD" id="select8">
                <?php
				$ano=substr($row7[fechasol_esc],0,4);
				$mes=substr($row7[fechasol_esc],5,2);
				$dia=substr($row7[fechasol_esc],8,2);

				for($i=1;$i<=31;$i++)
				{
	                echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";
				}
				?>
              </select> <select name="MM" id="select9">
                <?php
				for($i=1;$i<=12;$i++)
				{
    	            echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";
				}
				?>
              </select> <select name="AA" id="select10">
                <?php
				for($i=2003;$i<=2020;$i++)
				{
        	        echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";
				}
				?>
              </select> 
			  <a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a>
           
            <!----------------------------------->
			 <script language="JavaScript">
				<!-- 
				 var form="form2";
				 var cal = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);			
					cal.year_scroll = true;
					cal.time_comp = false;
				var cal1 = new calendar1(document.forms[form].elements['DD'], document.forms[form].elements['MM'], document.forms[form].elements['AA']);			
					cal1.year_scroll = true;
					cal1.time_comp = false;
				//-->
			</script>  
		  <?php }?>&nbsp;&nbsp;&nbsp;
          <input name="BUSCAR" type="submit" id="BUSCAR" value="BUSCAR">
        </div></td>
	    </tr>
  </table>
</form>
<?php }?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr> 
   <td height="47" valign="top">
	<table width="100%" border="1" cellpadding="0" cellspacing="2" background="images/fondo.jpg">
		<tr> <th colspan="13" >ASIGNACIONES DE TRABAJO</th></tr>
		<tr align="center" background="images/fondo.jpg"> 
		  <th class="menu" width="5%"><?php print $help->AddLink("num","SOLUC. ORDEN"); ?></th>
		  <th class="menu">INCIDENCIA</th>
		  <th class="menu">ENVIADO POR</th>
		  <th class="menu">NIVEL</th>
		  <th class="menu"><?php print $help->AddLink("crit", "CRITI"); ?></th>
		  <th class="menu"><?php print $help->AddLink("prio", "PRIOR"); ?></th>
		  <th class="menu">ASIGNADO A</th>
		  <th class="menu"><?php print $help->AddLink("segui", "SEGUI"); ?></th>
		  <th class="menu">FECHA_HORA</th>
		  <th class="menu"><?php print $help->AddLink("estima", "ESTIMAC"); ?></th>
		  <th class="menu"><?php print $help->AddLink("reg", "ASIGNADO POR"); ?></th>
		  <th class="menu">DIAGNOSTICO</th>
		  <th class="menu"><?php print $help->AddLink("esc", "ESCAL"); ?></th>
		</tr>
<?php
	//Consulta a Asignacion -- General
	
	//$sqlA = "SELECT * FROM asignacion ORDER BY id_orden DESC";
	if(isset($BUSCAR)){
		switch($menu){
					
		 case "general":
				$sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion ORDER BY id_orden DESC";
		 break;
		  
		 case "porNivel":
				if($selecta != "general"){$sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion  where nivel_asig = $selecta ORDER BY id_orden DESC";}
				else{$sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion ORDER BY id_orden DESC";}
		 break;

		 case "porPrioridad":
				if($selecta != "general") $sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion  where prioridad_asig = $selecta ORDER BY id_orden DESC";
				else{$sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion ORDER BY id_orden DESC";}
		 break;
		 
		 case "porCriticidad":
				if($selecta != "general") $sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion  where criticidad_asig = $selecta ORDER BY id_orden DESC";
				else{$sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion ORDER BY id_orden DESC";}
		 break;

 		 case "asignadoA":
				if($selecta != "general") $sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion  where asig = '$selecta' ORDER BY id_orden DESC";
				else{$sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion ORDER BY id_orden DESC";}
		 break;

		 case "asignadoPor":
				if($selecta != "general") $sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion where reg_asig = '$selecta' ORDER BY id_orden DESC";
				else{$sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion ORDER BY id_orden DESC";}
		 break;

		 case "enviadoPor":
				if($selecta != "general") $sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion where asig = '$selecta' ORDER BY id_orden DESC";
				else{$sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion ORDER BY id_orden DESC";}
		 break;
		 
		 case "porFecha":
		 		
				$date1 = $AE."/".$ME."/".$DE;
				$date2 = $AA."/".$MM."/".$DD;
				if($date1 <= $date2){
					$sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM `asignacion`  where fecha_asig >= '$date1' and fecha_asig <= '$date2'";
				}			
				else{ ?><script language="javascript"> alert("\nLa fecha inicial debe ser menor a la fecha final.\n\nMensaje generado por GesTor F1.\n\n"); </script><?php 
					$sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion ORDER BY id_orden DESC";
				}
		 break;
		 }
	}
	else{ 
		$sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion ORDER BY id_orden DESC";
	}

	$resultA = mysql_db_query($db,$sqlA,$link);
	$num = mysql_num_rows($resultA);

	while($row = mysql_fetch_array($resultA))
    {
	//Consulta a ordenes para obtener campo Incidencia
	$sql2 = "SELECT * FROM ordenes WHERE id_orden='$row[id_orden]'";
	$result2 = mysql_db_query($db,$sql2,$link);
	$row2 = mysql_fetch_array($result2);
	$numero = mysql_num_rows($result2);
	
	// Consulta a  users para obtener campo Enviado por
	$sql5="SELECT * FROM users WHERE login_usr='$row2[cod_usr]'";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
	
	//Consulta a users para obtener Asignado a
	$sql6="SELECT * FROM users WHERE login_usr='$row[asig]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	
	//Campo seguimiento
	$sqlSeg = "SELECT count(*) AS num FROM seguimiento WHERE id_orden='$row[id_orden]'";
	$resultSeg=mysql_db_query($db,$sqlSeg,$link);
	$rowSeg=mysql_fetch_array($resultSeg);
	
	//Consulta a users para obtener campo Asignado por
	$sql7="SELECT * FROM users WHERE login_usr='$row[reg_asig]'";
	$result7=mysql_db_query($db,$sql7,$link);
	$row7=mysql_fetch_array($result7);
	
	//Escala
	$sql8="SELECT * FROM users WHERE login_usr='$row[escal]'";
	$result8=mysql_db_query($db,$sql8,$link);
	$row8=mysql_fetch_array($result8);
	
	//Asignación de colores
	//ver si se encuentra solucionado o no	
	$sql3 = "SELECT * FROM solucion where id_orden='$row[id_orden]'";
	$result3=mysql_db_query($db,$sql3,$link);
	$row3=mysql_fetch_array($result3);
	$fechahoy=date("Y-m-d");
	if (!$row3[id_orden])//VENCIDOS
		{$color="bgcolor=\"#A5BBF5\"";
		if (($row[fechaestsol_asig]>$fechahoy) or ($row[fechaestsol_asig]==$fechahoy))//SIN SOLUCION
		$color="bgcolor=\"#FFFF00\"";}
	else
	$color="bgcolor=\"#00CC66\"";// CON SOLUCION
	
?>  
  
  <tr align="center" > 
		  <?php echo "<td ".$color.">&nbsp;<a href=\"solucion.php?Naveg=Asignacion >> Solucion&id_orden=".$row[id_orden]."\">".$row[id_orden]."</a></td>";?>
		  <td><?php=$row2[desc_inc]?></td>
		  <?php if($row2[cod_usr]=="SISTEMA"){?>
  		  <td><?php=$row2[cod_usr]?></td>
		  <?php }else{?>
  		  <td><?php=$row5[nom_usr]." ".$row5[apa_usr]." ".$row5[ama_usr];?></td>
		  <?php }?>
		  <td><?php=$row[nivel_asig]?></td>
		  <td><?php=$row[criticidad_asig]?></td>
		  <td><?php=$row[prioridad_asig]?></td>
		  <td><?php=$row6[nom_usr]." ".$row6[apa_usr]." ".$row6[ama_usr];?></td>
		  <?php echo "<td >&nbsp;<a href=\"solucion.php?Naveg=Asignacion >> Solucion&id_orden=".$rowSeg[id_orden]."\">".$rowSeg[num]."</a></td>";?>
		  <td><?php=$row[fecha_asig]." ".$row[hora_asig]?></td>
		  <td><?php=$row[fechaestsol_asig2]?></td>
		  <td><?php=$row7[nom_usr]." ".$row7[apa_usr]." ".$row7[ama_usr];?></td>
		  <td><?php=$row[diagnos]?></td>
		  <td>&nbsp;<?php=$row8[nom_usr]." ".$row8[apa_usr]." ".$row8[ama_usr];?></td>
		</tr>

<?php } ?>  
      </table></td>
  </tr>
  
</table>

</p>

<?php //---------------------------------------Inicio de paginación -------------------------------------------------------------------

	$sql11 = "SELECT * FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11[num_ord_pag])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11[num_ord_pag] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1;}
	else{$_pagi_actual = $_GET['pg'];}

	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ordenes";
	$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
	$row9=mysql_fetch_array($result9);

	$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);

	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

		if($tipo=="A" or $tipo=="B") 
		{	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ordenes";
			$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
			$row9=mysql_fetch_array($result9);
		
			$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);
			$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
			$sql = "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";}
		else if($tipo=="T") 
		{	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ordenes WHERE cod_usr<>'SISTEMA'";
			$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
			$row9=mysql_fetch_array($result9);
		
			$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);
			$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
			$sql = "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE cod_usr<>'SISTEMA' ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";}
		else if($tipo=="C") 
		{	$_pagi_sqlConta = "SELECT count(*) AS pagi_totalReg FROM ordenes WHERE cod_usr='$login'";
			$result9=mysql_db_query($db,$_pagi_sqlConta,$link);
			$row9=mysql_fetch_array($result9);
		
			$_pagi_totalPags = ceil($row9[pagi_totalReg] / $_pagi_cuantos);
			$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
			$sql = "SELECT ordenes.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha2 FROM ordenes WHERE cod_usr='$login' ORDER BY fecha DESC, time DESC limit $_pagi_inicial,$_pagi_cuantos";}

?>
<!--------------------------------------------------Fin de Paginación---------------------------------------------------------->
<!--------------------------------------------------Barra de Navegación-------------------------------------------------------->
 <br>
<form name="form1" method="post" action="">
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

//La variable $_pagi_navegacion contendrá los enlaces a las páginas.
$_pagi_navegacion = '';

if ($_pagi_actual != 1){
	//Si no estamos en la página 1. Ponemos el enlace "anterior"
	$_pagi_url = $_pagi_actual - 1;//será el numero de página al que enlazamos
	$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."'>&laquo; Anterior</a>&nbsp;";
}
//Enlaces a numeros de página:
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
for ($_pagi_i = $pagi; $_pagi_i<=$totpag; $_pagi_i++){//Desde página 1 hasta ultima página ($_pagi_totalPags)
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
    $_pagi_url = $_pagi_actual+1;//será el numero de página al que enlazamos
    $_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."'>Siguiente &raquo;</a>";
}
print $_pagi_navegacion;
//Hasta acá hemos completado la "barra de navegacion"
?>
            <br>
            <br>
            </strong></font></p>
        </div></td>
    </tr>
  </table>
 <table width="70%" border="1" align="center">
    <tr align="center"> 
      
    <td width="17%" height="42">NO SOLUCIONADOS</td>
      <td width="6%" bgcolor="#FFFF00">&nbsp;</td>
      <td width="18%">&nbsp;</td>
      <td width="13%">SOLUCIONADOS</td>
      <td width="6%" bgcolor="#00CC66">&nbsp;</td>
      <td width="18%">&nbsp;</td>
      <td width="13%">VENCIDOS</td>
      <td width="6%" bgcolor="#A5BBF5">&nbsp;</td>
    </tr>
  </table>
 
  <div align="center"><br>
  </div>
</form>
<!----------------------------------------------Fin de Barra--------------------------------------------------------------->



<script language="JavaScript">
<!--
<?php 
if($msg) print "alert(\"$msg\\n\\nMensaje generado por GesTor F1.\");"?>
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}

function tipo(men)
{
 	if(men=="porNivel"){irapagina("lista_Asignados.php?menu=porNivel");}
	else if(men=="general"){irapagina("lista_Asignados.php?menu=general");}
	else if(men=="asignadoA"){irapagina("lista_Asignados.php?menu=asignadoA");}
	else if(men=="asignadoPor"){irapagina("lista_Asignados.php?menu=asignadoPor");}
	else if(men=="enviadoPor"){irapagina("lista_Asignados.php?menu=enviadoPor");}
	else if(men=="porPrioridad"){irapagina("lista_Asignados.php?menu=porPrioridad");}
	else if(men=="porCriticidad"){irapagina("lista_Asignados.php?menu=porCriticidad");}
	else if(men=="porFecha"){irapagina("lista_Asignados.php?menu=porFecha");}
}


function enviar(id){
		open("ver_orden.php?id_orden="+id);
}
-->
</script>


<?php 
include("top_.php");
?>
 
