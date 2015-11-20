<?php   
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		23/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($_REQUEST['Terminar']))
header("location: lista_anayplanifcostos.php");

if (isset($_REQUEST['Cambios']))
{   include("conexion.php");
        $var=$_REQUEST['var'];
        //$idf=$_REQUEST['idf'];
        $numero=$_REQUEST['numero'];
        $recu=$_REQUEST['recu'];
        $tip=$_REQUEST['tip'];
        $descrip=$_REQUEST['descrip'];
        $relproy=$_REQUEST['relproy'];
        $costo_basico=$_REQUEST['costo_basico'];
        $costo_adicional=$_REQUEST['costo_adicional'];
        $porcentaje=$_REQUEST['porcentaje'];
        $dura_vin=$_REQUEST['dura_vin'];
        $costo_basico=$_REQUEST['costo_basico'];
        $dura_vin=$_REQUEST['dura_vin'];
        $costo_adicional=$_REQUEST['costo_adicional'];
        $dura_vin=$_REQUEST['dura_vin'];
        $idficha=$_REQUEST['idficha'];
        $nombreproy=$_REQUEST['nombreproy'];
        $responsable=$_REQUEST['responsable'];
        $total=0;
	// Actualiza la base de datos 
	if(isset($_REQUEST['numero']))
	{
	require_once('funciones.php');
	$nombreproy=_clean($nombreproy);
	$responsable=_clean($responsable);
	$tip=_clean($tip);
	$recu=_clean($recu);
	$relproy=_clean($relproy);
	$costo_adicional=_clean($costo_adicional);
	$porcentaje=_clean($porcentaje);
	$dura_vin=_clean($dura_vin);
	$costo_basico=_clean($costo_basico);
	$descrip=_clean($descrip);
	
	$nombreproy=SanitizeString($nombreproy);
	$responsable=SanitizeString($responsable);
	$tip=SanitizeString($tip);
	$recu=SanitizeString($recu);
	$relproy=SanitizeString($relproy);
	$costo_adicional=SanitizeString($costo_adicional);
	$porcentaje=SanitizeString($porcentaje);
	$dura_vin=SanitizeString($dura_vin);
	$costo_basico=SanitizeString($costo_basico);
	$descrip=SanitizeString($descrip);
	$sql="UPDATE anfacecoplancost SET tipo='$tip',recurso='$recu',descripcion='$descrip',relac_proy='$relproy',costo_bas_mes='$costo_basico',costo_ad_mes='$costo_adicional',porcent_dedic_proy='$porcentaje',dur_vin='$dura_vin',valor_total='$costo_basico'*'$dura_vin'+'$costo_adicional'*'$dura_vin' WHERE id_ficha='$var' AND numero='$numero'";
	mysql_query($sql);
				  $consul1="SELECT * FROM anfacecoplancost WHERE id_ficha='$var'";
				  $respu1=mysql_query($consul1);
				  while ($fila1=mysql_fetch_array($respu1)){
				  $total=$total+$fila1['valor_total'];
				  }
	$sql5="UPDATE ana_facti SET nomproy='$nombreproy',nomresp='$responsable',total='$total' WHERE id_ficha='$var'";
	mysql_query($sql5);
	}
	else
	{
	require_once('funciones.php');
	$nombreproy=_clean($nombreproy);
	$responsable=_clean($responsable);
	$tip=_clean($tip);
	$recu=_clean($recu);
	$relproy=_clean($relproy);
	$costo_adicional=_clean($costo_adicional);
	$porcentaje=_clean($porcentaje);
	$dura_vin=_clean($dura_vin);
	$costo_basico=_clean($costo_basico);
	$descrip=_clean($descrip);
	
	$nombreproy=SanitizeString($nombreproy);
	$responsable=SanitizeString($responsable);
	$tip=SanitizeString($tip);
	$recu=SanitizeString($recu);
	$relproy=SanitizeString($relproy);
	$costo_adicional=SanitizeString($costo_adicional);
	$porcentaje=SanitizeString($porcentaje);
	$dura_vin=SanitizeString($dura_vin);
	$costo_basico=SanitizeString($costo_basico);
	$descrip=SanitizeString($descrip);
        

                        
	$sql6 = "SELECT MAX(numero) AS Num FROM anfacecoplancost WHERE id_ficha='$var'";
	$result6=mysql_query($sql6);
	$row6=mysql_fetch_array($result6);
	$idf=$row6['Num']+1;

	
	$sql1="INSERT INTO anfacecoplancost (id_ficha,numero,tipo,recurso,descripcion,relac_proy,costo_bas_mes,costo_ad_mes,porcent_dedic_proy,dur_vin,valor_total) 
	VALUES ('$var','$idf','$tip','$recu','$descrip','$relproy','$costo_basico','$costo_adicional','$porcentaje','$dura_vin','$costo_basico'*'$dura_vin'+'$costo_adicional'*'$dura_vin');";
	mysql_query($sql1);
  
				 $consul2="SELECT * FROM anfacecoplancost WHERE id_ficha='$var'";
				  $respu2=mysql_query($consul2);
				  while ($fila2=mysql_fetch_array($respu2))
				  {
				  $total=$total+$fila2['valor_total'];
				  }
						$consul7="SELECT * FROM ana_facti WHERE id_ficha='$var'";
						$resul7=mysql_query($consul7);
						$fila7=mysql_fetch_array($resul7);
						if (!$fila7['total'])
						{$sql11="INSERT INTO ana_facti (id_ficha,nomproy,nomresp,total) VALUES ('$idficha','$nombreproy','$responsable','$total')"; 
						mysql_query($sql11);
						}
						else
						{
				 		$sql12="UPDATE ana_facti SET total='$total' WHERE id_ficha='$var'"; 
						mysql_query($sql12);
						}

	}
	
	header("location: anayplanifcostos_last.php?id_ficha=$var");
}
else 
{
include("top.php");
$id_ficha=($_GET['id_ficha']);
	
$sql = "SELECT * FROM anfacecoplancost WHERE id_ficha='$id_ficha'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);  
$sql3 = "SELECT * FROM ana_facti WHERE id_ficha='$id_ficha'";
$result3=mysql_query($sql3);
$row3=mysql_fetch_array($result3);  

if(isset($_REQUEST['numero'])){
	$numero=($_GET['numero']);
	$sql4 = "SELECT * FROM anfacecoplancost WHERE id_ficha='$id_ficha' AND numero='$numero' ";
}
else{
	$sql4 = "SELECT * FROM anfacecoplancost WHERE id_ficha='$id_ficha'";
}
	

$result4=mysql_query($sql4);
$row4=mysql_fetch_array($result4);  

?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addExists ( "nombreproy",  "Nombre del Proyecto, $errorMsgJs[empty]" );
$valid->addLength ( "nombreproy",  "Nombre del Proyecto, $errorMsgJs[length]" );
$valid->addIsNotEmpty ( "responsable",  "Nombre del Responsable, $errorMsgJs[empty]" );
$valid->addExists ( "recu",  "Recurso, $errorMsgJs[empty]" );
$valid->addExists ( "descrip",  "Descripcion, $errorMsgJs[empty]" );
$valid->addLength ( "descrip",  "Descripcion, $errorMsgJs[length]" );
$valid->addExists ( "relproy",  "Relacion con el Proyecto, $errorMsgJs[empty]" );
$valid->addIsNumber ( "costo_basico",  "Costo Basico, $errorMsgJs[number]" );
$valid->addIsNumber ( "costo_adicional",  "Costo Adicional, $errorMsgJs[number]" );
$valid->addIsNumber ( "porcentaje",  "Porcentaje Mensual, $errorMsgJs[number]" );
$valid->addIsNumber ( "dura_vin",  "Duracion de la Vinculacion, $errorMsgJs[number]" );
echo $valid->toHtml ();
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
<table width="85%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="anayplanifcostos_last.php" onKeyPress="return Form()">
   <input name="var" type="hidden" value="<?php echo $id_ficha;?>">
   <input name="numero" type="hidden" value="<?php echo $numero;?>">
	<tr> 
      <td height="300"> <table width="100%" border="1">
          <tr>
            <td height="20" colspan="2" bgcolor="#006699"> 
                    <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
            <strong>AN&Aacute;LISIS Y PLANIFICACI&Oacute;N DE COSTOS</strong></font></div></td>
          </tr>
        </table>

        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <td width="835" height="226"> 
              <table width="100%">
                <tr> 
					<td ><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Numero 
                      de Formulario :&nbsp; </font></div></td>
					   <?php echo '<td width="80%"><font size="2" face="Arial, Helvetica, sans-serif">'.$row3['id_ficha'].'</td>';?>
				</tr>
              </table>
			  <table width="100%">
                <tr> 
                  <td width="23%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Nombre 
                    del proyecto :&nbsp; </font></td>
                    <td width="77%">
					<select name="nombreproy" id="nombreproy">
                    <?php
					echo "<option value=\"0\"></option>";
					$sql0 = "SELECT DISTINCT Requerimiento FROM solicproydatos ORDER BY Requerimiento ASC";
 			  		$result0=mysql_query($sql0);
			  		while ($row0=mysql_fetch_array($result0)) {
						if ($row3['nomproy']==$row0['Requerimiento'])
							echo '<option value="'.$row0['Requerimiento'].'" selected>'.$row0['Requerimiento'].'</option>';
						else
							echo '<option value="'.$row0['Requerimiento'].'">'.$row0['Requerimiento'].'</option>';
					}
			        ?>
                    </select>					
                    </td>
				</tr>
              </table>
              <table width="100%">
                <tr> 
                  <td height="20"><font size="2" face="Arial, Helvetica, sans-serif"><font color="#000000">&nbsp;&nbsp;Nombre 
                    del responsable: </font><font size="2" face="Arial, Helvetica, sans-serif"> 
                    <font size="2" face="Arial, Helvetica, sans-serif"> 
                      <select name="responsable" id="responsable">
                        <option value="0"></option>
                        <?php 
			  			$sql1 = "SELECT * FROM users WHERE bloquear=0 AND tipo2_usr='T' OR tipo2_usr='C' ORDER BY apa_usr ASC";
			  			$result1 = mysql_query($sql1);
			  			while ($row1 = mysql_fetch_array($result1)) 
						{
				   		if ($row3['nomresp']==$row1['login_usr'])
				 			echo '<option value="'.$row1['login_usr'].'" selected>'.$row1['apa_usr'].' '.$row1['ama_usr'].' '.$row1['nom_usr'].'</option>';
					    else
							echo '<option value="'.$row1['login_usr'].'">'.$row1['apa_usr'].' '.$row1['ama_usr'].' '.$row1['nom_usr'].'</option>';
	            		}
			   			?>
                      </select>
                    </font> </font></font></td>
                </tr>
              </table>
              <table width="100%" border="1">
                <tr> 
                  <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Tipo 
                      de medio: 
                      <select name="tip">
                        <option value="Infraestructura" <?php if ($row4['tipo']=="Infraestructura") echo "selected";?>>Infraestructura</option>
                        <option value="Tecnologia" <?php if($row4['tipo']=="Tecnologia") echo "selected"?>>Tecnologia</option>
                        <option value="Aplicaciones" <?php if($row4['tipo']=="Aplicaciones") echo "selected"?>>Aplicaciones</option>
                        <option value="Datos" <?php if($row4['tipo']=="Datos") echo "selected"?>>Datos</option>
                        <option value="Gente" <?php if($row4['tipo']=="Gente") echo "selected"?>>Gente</option>
                      </select>
                      </font></div> 
                    <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">PARA 
                      REALIZAR CAMBIOS POR FAVOR ELIJA EL RECURSO</font></div></td>
                </tr>
              </table>
              <table width="100%" border="1">
                <tr> 
                  <td width="6%" rowspan="2" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ELEGIR</font></div></td>
				  <td width="6%" rowspan="2" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tipo&nbsp;</font></div></td>
                  <td width="10%" rowspan="2" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Recurso&nbsp;</font></div></td>
                  <td width="13%" rowspan="2" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Descripcion&nbsp;</font></div></td>
                  <td width="10%" rowspan="2" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Relacion 
                      con el proyecto&nbsp;</font></div></td>
                  <td height="24" colspan="2" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Costos 
                      mes&nbsp;</font></div></td>
                  <td width="13%" rowspan="2" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">%Mensual 
                      de dedicacion al proyecto&nbsp;</font></div></td>
                  <td width="12%" rowspan="2" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Duracion 
                      de la vinculacion (Meses) &nbsp;</font></div></td>
                  <td width="12%" rowspan="2" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Valor 
                      total&nbsp;</font></div></td>
                </tr>
                <tr bgcolor="#006699"> 
                  <td width="8%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Basico</font></div></td>
                  <td width="10%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Adicional</font></div></td>
                </tr>
        <?php
		$sql = "SELECT * FROM anfacecoplancost WHERE id_ficha='$id_ficha'";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> 
           	<?php echo "<td><a href=\"anayplanifcostos_last.php?id_ficha=$id_ficha&numero=".$row['numero']."\">elegir(".$row['numero'].")</a></font></td>";?>
			<td>&nbsp;<?php echo $row['tipo']?></td>
            <td>&nbsp;<?php echo $row['recurso']?>&nbsp;</td>
            <td>&nbsp;<?php echo $row['descripcion']?>&nbsp;</td>
            <td>&nbsp;<?php echo $row['relac_proy']?>&nbsp;</td>
            <td>&nbsp;<?php echo $row['costo_bas_mes']?>&nbsp;</td>
            <td>&nbsp;<?php echo $row['costo_ad_mes']?>&nbsp;</td>
            <td>&nbsp;<?php echo $row['porcent_dedic_proy']?>&nbsp;</td>
            <td>&nbsp;<?php echo $row['dur_vin']?>&nbsp;</td>
            <td>&nbsp;<?php echo $row['valor_total']?>&nbsp;</td>
          </tr>
          <?php 
		 }
		 ?>
				<tr>
				<td colspan=10>&nbsp;</td>
				</tr>
                
              </table>
			                <table width="100%" border="1">
                <tr>
                  <td><font size="2" face="Arial, Helvetica, sans-serif"><strong>Total:
				  <?php  echo $row3['total']; ?></strong></font></td>
                </tr>
              </table></td>
          </tr>
               </table>

	<?php 
if(isset($_REQUEST['numero']))
{
	$sql = "SELECT * FROM anfacecoplancost WHERE id_ficha='$id_ficha'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);  ?>

        <table width="100%" border="1">
          <tr> 
            <td bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><font color="#FFFFFF"></font></font></div></td>
            <td bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Recurso</font></div></td>
            <td bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Descripcion</font></div></td>
            <td bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Relacion 
                con el proyecto</font></div></td>
          </tr>
          <tr> 
            <td bgcolor="#006699"><div align="center"><font color="#FFFFFF">Nuevo</font></div></td>
            <td align="center"><input name="recu" type="text" value="<?php echo $row4['recurso'];?>" size="30" maxlength="30"></td>
            <td align="center"><textarea name="descrip" cols="40"><?php echo $row4['descripcion'];?></textarea></td>
            <td align="center"><input name="relproy" type="text" value="<?php echo $row4['relac_proy'];?>" size="30" maxlength="500"></td>
          </tr>
        </table>
        <table width="100%" border="1">
          <tr bgcolor="#006699"> 
            <td colspan="2"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Costo 
                mes </font></div></td>
            <td width="30%" rowspan="2"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">%Mensual 
                de dedicacion al proyecto</font></div>
              <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"></font></div></td>
            <td width="28%" rowspan="2"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Duracion 
                de la vinculacion (Meses)</font></div>
              <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"></font></div></td>
          </tr>
          <tr bgcolor="#006699"> 
            <td width="18%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Basico</font></div></td>
            <td width="24%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Adicional</font></div></td>
          </tr>
          <tr> 
            <td align="center"> <input name="costo_basico" type="text" value="<?php echo $row4['costo_bas_mes'];?>" size="12" maxlength="10"></td>
            <td align="center"> <input name="costo_adicional" type="text" value="<?php echo $row4['costo_ad_mes'];?>" size="12" maxlength="10"></td>
            <td align="center"> <input name="porcentaje" type="text" value="<?php echo $row4['porcent_dedic_proy'];?>" size="12" maxlength="3"></td>
            <td align="center"> <input name="dura_vin" type="text" value="<?php echo $row4['dur_vin'];?>" size="12" maxlength="3"></td>
          </tr>
        </table>
        <br>
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="file:///C|/apache/htdocs/ivan/images/fondo.jpg">
          <tr> 
            <td width="826" height="28" colspan="4" nowrap> <div align="center">
                <input name="Cambios" type="submit" id="Cambios" value="GUARDAR CAMBIOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="RETORNAR">
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<p>&nbsp;</p><p> 
</p>
 <?php  } //cierra if para elejir cual cambiar y obligar al usario a elegir 
        else
			;
 } ?> 
