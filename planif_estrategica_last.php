<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		24/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

//$NumPlanif = $NumPlanif; 
if (isset($_REQUEST['RETORNAR'])){header("location: lista_planifes.php");}
if (isset($_REQUEST['GUARDATOS']))
{   require("conexion.php");	
	$FechaPlanifica="$Ano-$Mes-$Dia";
	if (isset($NumPlanif) && $NumPlanif=="NUEVO") // ya no existe
	{	header("location: lista_acciones_last.php?varia2=$var2&NumPlanif=$NumPlanif");}
	else
		{$sql2= "UPDATE planif_estrategica SET ObjNegocio='$ObjNegocio',ObjTi='$ObjTi',RespPlanifica='$RespPlanifica',".
				"FechaPlanifica='$FechaPlanifica',orden='',costo='$costo' WHERE TipoPlanifica='$var2' AND NumPlanif='$NumPlanif'";
		//ENVIO DE MAIL Y SMS
		if (mysql_query($sql2)){
				$sql0="SELECT * FROM users WHERE login_usr='$RespPlanifica'";
				$result0=mysql_query($sql0);
				$row0=mysql_fetch_array($result0);
			
				$sqlSystem="SELECT nombre, mail, conf_mail, conf_sms, web FROM control_parametros";
				$systemData=mysql_fetch_array(mysql_query( $sqlSystem));
				
				if($systemData["conf_mail"]==2 || $systemData["conf_mail"]==3 || $systemData["conf_sms"]==2 || $systemData["conf_sms"]==3){
					$userData=$row0;
					$userName=$userData['nom_usr'].' '.$userData['apa_usr'].' '.$userData['ama_usr'];
					include ('mail.inc.php');
					$mimemail = new nxs_mimemail(); 
					//envio de SMS
					if($systemData["conf_sms"]==2 || $systemData["conf_sms"]==3){
						$sqlMovil="SELECT id_dat_tel_movil, direccion FROM dat_tel_movil";
						$movilRs=mysql_query( $sqlMovil);
						while($tmp=mysql_fetch_array($movilRs)){
							$movilLst[$tmp['id_dat_tel_movil']]=$tmp['direccion'];
						}
						$userData['movilEmail']="591".$userData['ext_usr']."@".$movilLst[$userData['id_dat_tel_movil']];
						if($mimemail->validate_mail($userData['movilEmail'])){						
							$mimemail->set_to($userData['movilEmail'], $userName);
							$mimemail->set_subject($userName);
							$mimemail->set_text("Nuevo objetivo en Planificacion Estrategica. ".$systemData['nombre']);
							if (!$mimemail->send()){
								$msg.="Precaucion, no se ha podido enviar la orden por SMS al Usuario asignado.\\n";
								}
							}
						else $msg.="Precaucion, no se ha podido enviar la orden por SMS al Usuario asignado.*\\n";
						}
					//envio de mail
					if($systemData["conf_mail"]==2 || $systemData["conf_mail"]==3){																				
					if($mimemail->validate_mail($userData['email'])){
						$mimemail->set_from($systemData['mail'], $systemData['nombre']);
						$mimemail->set_to($userData['email'], "$userName");
						$mimemail->set_subject("Nuevo objetivo en Planificacion Estrategica");
						$mimemail->set_text("Nuevo objetivo en Planificacion Estrategica\n\nObjetivo de Negocio: $ObjNegocio\nObjetivo TI: $ObjTi\nAccion: $Accion\nFecha: $FechaPlanifica\n\nPara mayores detalles, consulte el Sistema de Mesa de Ayuda.\n\n$systemData[nombre]");
						if (!$mimemail->send()){
							$msg.="Precaucion, no se ha podido enviar la orden por correo electronico al Usuario asignado.";
						}
						}	
					  else {
						$msg.="Precaucion, no se ha podido enviar la orden por correo electronico al Usuario asignado. Posiblemente, su direccion de correo electronico sea incorrecto.";
						  }
					}	  
				}			
		}	
		header("location: lista_acciones_last.php?varia2=$var2&NumPlanif=$NumPlanif");}
}
include("top.php");
if (isset($_GET['varia2']))
$tip=($_GET['varia2']);
if (isset($_GET['varia3']))
$num=($_GET['varia3']);
?> 
<!--<script language="JavaScript" src="calendar.js"></script>-->
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTextNormal ( "ObjNegocio",  "Objetivo, $errorMsgJs[expresion]" );
$valid->addLength ( "ObjNegocio",  "Objetivo, $errorMsgJs[length]" );
$valid->addIsTextNormal ( "ObjTi",  "Objetivo TI, $errorMsgJs[expresion]" );
$valid->addLength ( "ObjTi",  "Objetivo TI, $errorMsgJs[length]" );
$valid->addIsTextNormal ( "Accion",  "Accion, $errorMsgJs[expresion]" );
$valid->addLength ( "Accion",  "Accion, $errorMsgJs[length]" );
$valid->addIsNotEmpty ( "RespPlanifica",  "Responsable, $errorMsgJs[empty]" );
$valid->addIsDate   ( "Dia", "Mes", "Ano", "Fecha, $errorMsgJs[date]" );
$valid->addIsNumber ( "costo",  "Costo estimado, $errorMsgJs[number]" );
print $valid->toHtml ();
?>  
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<form name="form1"  acction = "lista_acciones_last.php" method="post" action="" onKeyPress="return Form()">
   <input name="var2" type="hidden" value="<?php echo $_REQUEST['tip'];?>">
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <th colspan="8" ><font size="2" face="Arial, Helvetica, sans-serif">PLANIFICACION 
        ESTRATEGICA - <?php echo $tip; ?></font></th>
    </tr>
    <tr> 
      <td width="5%" bgcolor="#006699" align="center"> <font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nro</font></td>
      <td width="23%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBJETIVO 
          DE NEGOCIO</font></div></td>
      <td width="19%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBJETIVO 
          TI </font></div></td>
      <td width="10%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NRO.OBJETIVOS</font></div></td>
	  <td width="11%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NRO.ACCIONES</font></div></td>
      <td width="10%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA</font></div></td>
      <td width="14%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">COSTO 
          ($us )</font></div></td>
	 <td width="8%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">IMPRIMIR</font></div></td>

    </tr>
    <?php
		$fechahoy=date("Y-m-d");
		$costo_abs=0;
		$sql = "SELECT *, DATE_FORMAT(FechaPlanifica, '%d/%m/%Y') AS FechaPlanifica2 FROM planif_estrategica WHERE TipoPlanifica='$tip' GROUP BY NumPlanif ORDER BY NumPlanif ASC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
			if ($row['FechaPlanifica'] >= $fechahoy ) { //VIGENTE
				$color="bgcolor=\"#00CC00\"";
			}
			else {
				$color="bgcolor=\"#FF6666\""; //VENCIDO
			}

		 ?>
    <tr align="center"> <?php echo "<td $color><a href=\"planif_estrategica_last1.php?varia2=$tip&varia3=".$row['NumPlanif']."\">".$row['NumPlanif']."</a></td>";?> 
      <td>&nbsp;<?php echo $row['ObjNegocio'];?></td>
      <td>&nbsp; 
        <?php
	  echo "<a href=\"actividades_pre_last.php?tip=$tip&numer=$row[NumPlanif]&actividad=1&ObjNegocio=$row[ObjNegocio]&varia2=$tip\">VER OBJETIVOS</a>";
  		$sql5 = "SELECT count(*) AS numero FROM planif_estrategica WHERE NumPlanif='$row[NumPlanif]' AND TipoPlanifica='$row[TipoPlanifica]'";
		$result5 = mysql_query($sql5);
		$row5 = mysql_fetch_array($result5);
		echo "<td>&nbsp;$row5[numero]</td>";
	  ?>
      </td>
      <td>&nbsp; 
        <?php
	  $num_acciones=0;
	  $costo_tot=0;
	  $sql_acc="SELECT Accion,costo FROM planif_estrategica WHERE TipoPlanifica='$tip' AND NumPlanif='$row[NumPlanif]'";
	  $res_acc=mysql_query($sql_acc);
	  while($row_acc=mysql_fetch_array($res_acc)){
		if($row_acc['Accion']){
	  		$acc_aux=explode("|",$row_acc['Accion']);
			foreach($acc_aux as $valor)	if(isset($valor)) $num_acciones++;
			$cos_aux=explode("|",$row_acc['costo']);
			$costo_tot+=array_sum($cos_aux);
		}
	  }
	  echo $num_acciones;
	 ?>
      </td>
      <td>&nbsp; 
        <?php 
	  echo $row['FechaPlanifica2'];
	  ?>
      </td>
      <td>&nbsp;<?php echo $costo_tot; $costo_abs+=$costo_tot;?></td>
	   <?php 
	  	echo '<td><font size="1"><a href="ver_planifxproy.php?variable1='.$tip.'&numer='.$row['NumPlanif'].'" target="_blank"><img src="images/imprimir.gif" border="0" alt="Imprimir"></a></font></td>';
	  ?>
    </tr>
    <?php 
		 }
		 ?>
  </table>
	<?php
	//costo total
	$sql7 = "SELECT SUM(costo) as total FROM planif_estrategica WHERE TipoPlanifica='$_REQUEST[varia2]'";
	$result7=mysql_query($sql7);
	$row7=mysql_fetch_array($result7);
	?>
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
	<tr>
	  <td><div align="left"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong>COSTO TOTAL: <?php echo "$"."us ".$costo_abs;?></strong></font></div></td>
  </table>

  <br>
  <table width="65%" border="1" align="center">
  <tr> 
    <td width="16%" align="center">PLANIFICACION VENCIDA</td>
    <td width="7%" bgcolor="#FF6666">&nbsp;</td>
    <td width="16%">&nbsp;</td>
    <td width="16%" align="center">PLANIFICACION VIGENTE</td>
    <td width="7%" bgcolor="#00CC00">&nbsp;</td>
  </tr>
  </table>
  <br><?php /*?>
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
    <tr align="center"> 
      <td bgcolor="#006699" colspan="2"> <div align="center"></div>
        <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nro,</font></div></td>
      <td width="38%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBJETIVO 
          DE NEGOCIO</font></div></td>
      <td width="39%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBJETIVO 
          TI </font></div></td>
    </tr>
    <tr align="center" background="images/fondo.jpg"> 
      <?php $sql3 = "SELECT * FROM planif_estrategica WHERE TipoPlanifica='$tip' AND NumPlanif='$num'";
		$result3=mysql_query($sql3);
		$row3=mysql_fetch_array($result3); ?>
      <td colspan="2"> <select name="NumPlanif">
          <?php $sql2 = "SELECT * FROM planif_estrategica WHERE TipoPlanifica='$tip'";
			 $result2 = mysql_query($sql2);
			 while ($row2 = mysql_fetch_array($result2)) 
				{   if ($row2[NumPlanif]==$num)
				{echo "<option value=\"$row2[NumPlanif]\"selected>$row2[NumPlanif]</option>";}
			  else
				{echo "<option value=\"$row2[NumPlanif]\">$row2[NumPlanif]</option>";}}
			   ?>
          <!--option value="NUEVO">NUEVO</option-->
        </select></td>
      <td width="38%" > <div align="center"> 
          <textarea name="ObjNegocio" cols="25"><?php echo $row3[ObjNegocio]?></textarea>
        </div></td>
      <td width="39%"> <div align="center"> 
          <textarea name="ObjTi" cols="25"><?php echo $row3[ObjTi]?></textarea>
        </div></td>
    </tr>
    <tr align="center"> 
      <td colspan="2" bgcolor="#006699"> <font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">RESPONSABLE</font></td>
      <td bgcolor="#006699"> <font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA</font></td>
      <td width="39%" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">COSTO 
        ESTIMADO ($us)</font></td>
    </tr>
    <tr align="center" background="images/fondo.jpg"> 
      <td colspan="2"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
          <select name="RespPlanifica" id="select2">
            <option value="0"></option>
            <?php $sql2 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear='0' ORDER BY apa_usr ASC";
			   $result2 = mysql_query($sql2);
			   while ($row2 = mysql_fetch_array($result2)) 
				{   if ($row2[login_usr]==$row3[RespPlanifica])
				{echo "<option value=\"$row2[login_usr]\"selected>$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";}
			  else
				{echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";}}
			   ?>
          </select>
          </font></div></td>
      <td> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
          <select name="Dia" >
            <?php
				if ($num=="")
				{$fsist=date("Y-m-d");
				$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);}
				else
				{$a1=substr($row3[FechaPlanifica],0,4);
				$m1=substr($row3[FechaPlanifica],5,2);
				$d1=substr($row3[FechaPlanifica],8,2);}?>
            <?php for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
				?>
          </select>
          <select name="Mes">
            <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
				?>
          </select>
          <select name="Ano">
            <?php
				for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
          </select>
          <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong> 
          </font></div></td>
      <td><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="costo" type="text" value="<?php echo $row3[costo]?>">
          </font></div></td>
    </tr>
  </table>
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="100%"><div align="center"> <br>
          <input name="GUARDATOS" type="submit" id="GUARDATOS" value="GUARDAR CAMBIOS Y CONTINUAR" <?php print $valid->onSubmit() ?>>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          
        </div></td>
    </tr>
  </table><?php */?>
<tr>
    <td colspan="1"><blockquote> <div align="center">
        <input type="submit" name="RETORNAR" value="RETORNAR">
      </div></form>