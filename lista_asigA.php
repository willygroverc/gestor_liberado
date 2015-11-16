<?php
include ("conexion.php");
session_start();
$login_usr = $_SESSION["login"];
$sql3 = "SELECT * FROM users WHERE login_usr='$login_usr'";
$res3 = mysql_db_query($db,$sql3,$link);
$row3 = mysql_fetch_array($res3);
?>

<script language="JavaScript" src="calendar.js"></script>

<?php
include ("top.php");
	include_once ("help.class.php");
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
 
<!------------------------------------------------Formulario de Búsqueda----------------------------------------------------------->
<?php if ($tipo=="A"){?>
<form action="" method="get" name="form2" id="form2" >
  <table width="90%" border="1" align="center"  bgcolor="#006699">
    <tr> 
      <td width="60%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Busqueda 
          por :</strong></font> 
		  <select name="menu" id="menu" onChange="tipo(this.value);">
		  	<option value="general">General</option>
            <option value="porNivel"<?php if ($menu=="porNivel") print selected?>>Complejidad</option>
            <option value="porPrioridad"<?php if ($menu=="porPrioridad") print selected?>>Prioridad</option>
			<option value="porCriticidad"<?php if ($menu=="porCriticidad") print selected?>>Criticidad</option>			
            <option value="asignadoA"<?php if ($menu=="asignadoA") print selected?>>Asignado A</option>
            <option value="asignadoPor"<?php if ($menu=="asignadoPor") print selected?>>Asignado Por</option>
			<option value="porFecha"<?php if ($menu=="porFecha") print selected?>>Por Fecha de Registro</option>
          </select>
          <?php if($menu!="porFecha"){?>
          <select name="selecta" >
		  		<option value="general" selected > General </option>
       	  	
			<?php
			switch ($menu) {
			
			case "porNivel":
						for($i = 1; $i<=3; $i++){
							if($i == 1){$j = "Baja";}
							else if ($i == 2){$j = "Media";}
							else if ($i == 3){$j = "Alta";}
			?>				<option value="<?php=$i?>" <?php if($selecta == $i)  print selected ;?>><?php=$j?></option>
						<?php }?>			
						</select>
			<?php break;
			case "porPrioridad":
						for($i = 1; $i<=3; $i++){
							if($i == 1){$j = "Alta";}
							else if ($i == 2){$j = "Media";}
							else if ($i == 3){$j = "Baja";}
			?>				<option value="<?php=$i?>" <?php if($selecta == $i)  print selected ;?>><?php=$j?></option>
						<?php }?>			
			<?php break;
			
			case "porCriticidad":
						for($i = 1; $i<=3; $i++){
							if($i == 1){$j = "Alta";}
							else if ($i == 2){$j = "Media";}
							else if ($i == 3){$j = "Baja";}
			?>				<option value="<?php=$i?>" <?php if($selecta == $i)  print selected ;?>><?php=$j?></option>
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
			}?>
			
		  &nbsp;&nbsp;&nbsp;
		  <?php }else{?>
		  <!----------------------------------->
		  &nbsp;&nbsp;&nbsp;
		  <font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Desde :</strong></font> 
		  <select name="DE" id="select8">
                <?php
				//$ano=substr($row7[fechasol_esc],0,4);
				//$mes=substr($row7[fechasol_esc],5,2);
				//$dia=substr($row7[fechasol_esc],8,2);

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
				/*$ano=substr($row7[fechasol_esc],0,4);
				$mes=substr($row7[fechasol_esc],5,2);
				$dia=substr($row7[fechasol_esc],8,2);*/

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
<!------------------------------------------------Fin Formulario------------------------------------------------------------------->

  
  <table width="100%" border="1" cellpadding="0" cellspacing="2" background="images/fondo.jpg">
    <tr> <th colspan="13" bgcolor="#006699">ASIGNACIONES DE TRABAJO</th></tr>
	<tr align="center"> 
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
//$sql6 = "SELECT * FROM asignacion GROUP BY id_orden";
	$sql11 = "SELECT num_ord_pag FROM control_parametros";
	$result11=mysql_db_query($db,$sql11,$link);
	$row11=mysql_fetch_array($result11);

	if(empty($row11[num_ord_pag])){	$_pagi_cuantos =20 ; }
	else{$_pagi_cuantos = $row11[num_ord_pag] ;}

	if (empty($_GET['pg'])){$_pagi_actual = 1; $j=1;}
	else{$_pagi_actual = $_GET['pg']; $j=1;}
	
if ($tipo=="T") 
{$sql = "SELECT DISTINCT(id_orden), MAX(id_asig) FROM asignacion WHERE asig='$login' GROUP BY id_orden";}
else
{ $sql = "SELECT DISTINCT(id_orden), MAX(id_asig) FROM asignacion GROUP BY id_orden";}

$rs1=mysql_db_query($db,$sql,$link);
$numAsig=0;

while ($tmp=mysql_fetch_array($rs1))  
{			
if ($tipo=="T"){
		$sql = "SELECT id_orden,id_asig, asig FROM asignacion WHERE id_orden=$tmp[id_orden] ORDER BY id_asig DESC";
			$rsTmp=mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp["asig"]==$login) {
				$total[$numAsig]=$rsTmp[id_orden];
				$numAsig++;}
			}
else
$numAsig++;			
}
    $_pagi_totalPags = ceil($numAsig / $_pagi_cuantos);
	$_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;

$i=$_pagi_inicial+$j;
$ii=$_pagi_inicial+$_pagi_cuantos;


//----------------------------------------------------------------------------------------------------------------------------

	//Consulta a Asignacion -- General
	
	if(isset($BUSCAR)){
		switch($menu){
					
		 case "general":
				$sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";
		 break;
		  
		 case "porNivel":
				if($selecta != "general"){$sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig, nivel_asig FROM asignacion  where nivel_asig = $selecta GROUP BY id_orden ORDER BY id_orden DESC";}
				else{$sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";}
		 break;

		 case "porPrioridad":
				if($selecta != "general") $sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig, prioridad_asig FROM asignacion  where prioridad_asig = $selecta GROUP BY id_orden ORDER BY id_orden DESC";
				else{$sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";}
		 break;
		 
		 case "porCriticidad":
				if($selecta != "general") $sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig, criticidad_asig FROM asignacion  where criticidad_asig = $selecta  GROUP BY id_orden ORDER BY id_orden DESC";
				else{$sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";}
		 break;

 		 case "asignadoA":
				if($selecta != "general") $sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig, asig FROM asignacion  where asig = '$selecta' GROUP BY id_orden ORDER BY id_orden DESC";
				else{$sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";}
		 break;

		 case "asignadoPor":
				if($selecta != "general") $sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig, reg_asig FROM asignacion where reg_asig = '$selecta' GROUP BY id_orden ORDER BY id_orden DESC";
				else{$sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";}
		 break;

		 case "enviadoPor":
				if($selecta != "general") $sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig, asig FROM asignacion where asig = '$selecta' GROUP BY id_orden ORDER BY id_orden DESC";
				else{$sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";}
		 break;
		 
		 case "porFecha":
		 		
				$date1 = $AE."/".$ME."/".$DE;
				$date2 = $AA."/".$MM."/".$DD;
				if($date1 <= $date2){
					$sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig FROM `asignacion`  where fecha_asig >= '$date1' and fecha_asig <= '$date2' GROUP BY id_orden ORDER BY id_orden DESC";
				}			
				else{ ?><script language="javascript"> alert("\nLa fecha inicial debe ser menor a la fecha final.\n\nMensaje generado por GesTor F1.\n\n");</script><?php 
					$sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";
				}
		 break;
		 }
	}
	else{ 
		//$sqlA = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion ORDER BY id_orden DESC";
		$sqlA = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";
	}

//-------------------------------------------------------------------------------------
$uu=0;

$result6=mysql_db_query($db,$sqlA,$link);
$numRows = mysql_num_rows($result6);
while($row6=mysql_fetch_array($result6))
{
if ($tipo=="T") {$sql = "SELECT *,DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion WHERE asig='$login' AND id_orden='$row6[id_orden]' AND id_asig='$row6[id_asig]' ORDER BY id_asig DESC";}
else { 
$sql = "SELECT *, DATE_FORMAT(fecha_asig, '%d/%m/%Y') AS fecha_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion WHERE id_asig='$row6[id_asig]' ORDER BY id_asig DESC";}

$result=mysql_db_query($db,$sql,$link);
while ($row=mysql_fetch_array($result)) {
$uu=$uu+1;

if ($i<=$ii and $uu>=$i){

//seguimiento
	$sqlSeg = "SELECT count(*) AS num FROM seguimiento WHERE id_orden='$row[id_orden]'";
	$resultSeg=mysql_db_query($db,$sqlSeg,$link);
	$rowSeg=mysql_fetch_array($resultSeg);
	
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
$sql2 = "SELECT * FROM ordenes WHERE id_orden='$row[id_orden]'";
$result2=mysql_db_query($db,$sql2,$link);
$row2=mysql_fetch_array($result2);
  	echo "<tr align=\"center\">";
	echo "<td ".$color.">&nbsp;<a href=\"solucion.php?Naveg=Asignacion >> Solucion&id_orden=".$row[id_orden]."\">".$row[id_orden]."</a></td>";
	echo "<td>&nbsp;$row2[desc_inc]</td>";
	$sql5="SELECT * FROM users WHERE login_usr='$row2[cod_usr]'";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
	if($row2[cod_usr]=="SISTEMA")
	{echo "<td>&nbsp;$row2[cod_usr]</td>";}
	else
	{echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";}
	echo "<td>&nbsp;$row[nivel_asig]</td>";
	echo "<td>&nbsp;$row[criticidad_asig]</td>";
	echo "<td>&nbsp;$row[prioridad_asig]</td>";
	$sql5="SELECT * FROM users WHERE login_usr='$row[asig]'";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
	echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";
	echo "<td>&nbsp;<a href=\"segui.php?Naveg=Asignacion >> Seguimiento&id_orden=$row[id_orden]&lug=1\">$rowSeg[num]</a></td>"; //seguimiento
	
	echo "<td>&nbsp;$row[fecha_asig] $row[hora_asig]</td>";
	echo "<td>&nbsp;$row[fechaestsol_asig2]</td>";
	$sql5="SELECT * FROM users WHERE login_usr='$row[reg_asig]'";
	$result5=mysql_db_query($db,$sql5,$link);
	$row5=mysql_fetch_array($result5);
	echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";
	echo "<td>&nbsp;$row[diagnos]&nbsp;</td>";

	$sql16="SELECT * FROM users WHERE login_usr='$row[escal]'";
	$result16=mysql_db_query($db,$sql16,$link);
	$row16=mysql_fetch_array($result16);
	echo "<td>&nbsp;$row16[nom_usr] $row16[apa_usr] $row16[ama_usr]</td>";
	echo "</tr>";
$i=$i+1;}
}}
?>
</table>
  <br>
  
<table width="95%" border="0" align="center">
  <tr> 
      <td> <div align="center"><strong><font size="2">Pagina(s) :&nbsp; 
        <strong>
        <?php
  if($numRows!=0)
  {
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
		
		//La variable $_pagi_navegacion contendra los enlaces a las paginas.
		$_pagi_navegacion = '';
		
		if ($_pagi_actual != 1){
			//Si no estamos en la pagina 1. Ponemos el enlace "anterior"
			$_pagi_url = $_pagi_actual - 1;//sera el numero de pagina al que enlazamos
			$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_url."'>&laquo; Anterior</a>&nbsp;";
		}
		//Enlaces a numeros de pagina:
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
		for ($_pagi_i = $pagi; $_pagi_i<=$totpag; $_pagi_i++){//Desde pagina 1 hasta ultima pagina ($_pagi_totalPags)
			if ($_pagi_i == $_pagi_actual) {
				//Si el numero de pagina es la actual ($_pagi_actual). Se escribe el numero, pero sin enlace y en negrita.
				$_pagi_navegacion .= "<b>&nbsp;$_pagi_i&nbsp;</b>";
			}else{
				//Si es cualquier otro. Se escibe el enlace a dicho numero de pagina.
				$_pagi_navegacion .= "<a href='".$_pagi_enlace."pg=".$_pagi_i."'>".$_pagi_i."</a>&nbsp;";
			}
		}
		
		if ($_pagi_actual < $_pagi_totalPags){
			//Si no estamos en la ultima pagina. Ponemos el enlace "Siguiente"
			$_pagi_url = $_pagi_actual+1;//sera el numero de pagina al que enlazamos
			$_pagi_navegacion .="<a href='".$_pagi_enlace."pg=".$_pagi_url."'>Siguiente &raquo;</a>";
		}
		print $_pagi_navegacion;
		//Hasta aca hemos completado la "barra de navegacion"
	}else{ print 0;}
	
?>
        </strong> </font></strong></div></td>
    </tr>
  </table>
  <br>
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
  <script language="JavaScript">
  /*$lstMsg[3]="Esta orden ha sido generado por el SISTEMA y no puede ser notificado por correo electronico.\\n\\nMensaje generado por GesTor F1.";
  $lstMsg[2]="Precaucion, no se ha podido enviar la orden por correo electronico al Cliente. Posiblemente, su direccion de correo electronico sea incorrecto.";
  if($msg) print "alert(\"$lstMsg[$msg]\");"; ?>*/
  </script>
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
 	if(men=="porNivel"){irapagina("lista_asig.php?menu=porNivel");}
	else if(men=="general"){irapagina("lista_asig.php?menu=general");}
	else if(men=="asignadoA"){irapagina("lista_asig.php?menu=asignadoA");}
	else if(men=="asignadoPor"){irapagina("lista_asig.php?menu=asignadoPor");}
	else if(men=="enviadoPor"){irapagina("lista_asig.php?menu=enviadoPor");}
	else if(men=="porPrioridad"){irapagina("lista_asig.php?menu=porPrioridad");}
	else if(men=="porCriticidad"){irapagina("lista_asig.php?menu=porCriticidad");}
	else if(men=="porFecha"){irapagina("lista_asig.php?menu=porFecha");}
}


function enviar(id){
		open("ver_orden.php?id_orden="+id);
}
-->
</script>
  


<?php include("top_.php");?> 