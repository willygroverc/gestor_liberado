<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		23/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	Limpieza de datos de entrada de texto.
// Fecha: 		09/AGO/2013
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require_once('funciones.php');
$idficha=$_REQUEST['idficha'];
$idficha=_clean($idficha);
$idficha=SanitizeString($idficha);
if (isset($_REQUEST['Terminar']))
header("location: lista_anayplanifcostos.php");

if (isset($_REQUEST['Guardar'])){   
	require("conexion.php");
	$idficha=$_REQUEST['idficha'];				
	$consul10="SELECT * FROM anfacecoplancost WHERE id_ficha='$idficha'";
	$resul10=mysql_query($consul10);
	$fila10=mysql_fetch_array($resul10);
	if (!$fila10)
	{	
	require_once('funciones.php');
	$idficha=_clean($idficha);
        
        $tip=$_REQUEST['tip'];
	$recu=$_REQUEST['recu'];
	$relproy=$_REQUEST['relproy'];
	$costo_basico=$_REQUEST['costo_basico'];
	$costo_adicional=$_REQUEST['costo_adicional'];
	$porcentaje=$_REQUEST['porcentaje'];
	$dura_vin=$_REQUEST['dura_vin'];
	$costo_basico=$_REQUEST['costo_basico'];
	$descrip=$_REQUEST['descrip'];
        
	$tip=_clean($tip);
	$recu=_clean($recu);
	$relproy=_clean($relproy);
	$costo_basico=_clean($costo_basico);
	$costo_adicional=_clean($costo_adicional);
	$porcentaje=_clean($porcentaje);
	$dura_vin=_clean($dura_vin);
	$costo_basico=_clean($costo_basico);
	$descrip=_clean($descrip);
	
	$idficha=SanitizeString($idficha);
	$tip=SanitizeString($tip);
	$recu=SanitizeString($recu);
	$relproy=SanitizeString($relproy);
	$costo_basico=SanitizeString($costo_basico);
	$costo_adicional=SanitizeString($costo_adicional);
	$porcentaje=SanitizeString($porcentaje);
	$dura_vin=SanitizeString($dura_vin);
	$costo_basico=SanitizeString($costo_basico);
	$descrip=SanitizeString($descrip);
	$sql="INSERT INTO anfacecoplancost (id_ficha,numero,tipo,recurso,descripcion,relac_proy,costo_bas_mes,costo_ad_mes,porcent_dedic_proy,dur_vin,valor_total) 
	VALUES ('$idficha','1','$tip','$recu','$descrip','$relproy','$costo_basico','$costo_adicional','$porcentaje','$dura_vin','$costo_basico'*'$dura_vin'+'$costo_adicional'*'$dura_vin');";
        mysql_query($sql);}
	else
	{
	$sql6 = "SELECT MAX(numero) AS Num FROM anfacecoplancost WHERE id_ficha='$idficha'";
          
	$result6=mysql_query($sql6);
	$row6=mysql_fetch_array($result6);
	$idf=$row6['Num']+1;
	require_once('funciones.php');
        $tip=$_REQUEST['tip'];
	$recu=$_REQUEST['recu'];
	$relproy=$_REQUEST['relproy'];
	$costo_basico=$_REQUEST['costo_basico'];
	$costo_adicional=$_REQUEST['costo_adicional'];
	$porcentaje=$_REQUEST['porcentaje'];
	$dura_vin=$_REQUEST['dura_vin'];
	$costo_basico=$_REQUEST['costo_basico'];
	$descrip=$_REQUEST['descrip'];
        
	$idficha=_clean($idficha);
	$tip=_clean($tip);
	$recu=_clean($recu);
	$relproy=_clean($relproy);
	$costo_basico=_clean($costo_basico);
	$costo_adicional=_clean($costo_adicional);
	$porcentaje=_clean($porcentaje);
	$dura_vin=_clean($dura_vin);
	$costo_basico=_clean($costo_basico);
	$descrip=_clean($descrip);
	
	$idficha=SanitizeString($idficha);
	$tip=SanitizeString($tip);
	$recu=SanitizeString($recu);
	$relproy=SanitizeString($relproy);
	$costo_basico=SanitizeString($costo_basico);
	$costo_adicional=SanitizeString($costo_adicional);
	$porcentaje=SanitizeString($porcentaje);
	$dura_vin=SanitizeString($dura_vin);
	$costo_basico=SanitizeString($costo_basico);
	$descrip=SanitizeString($descrip);
	$sql="INSERT INTO anfacecoplancost (id_ficha,numero,tipo,recurso,descripcion,relac_proy,costo_bas_mes,costo_ad_mes,porcent_dedic_proy,dur_vin,valor_total) 
	VALUES ('$idficha','$idf','$tip','$recu','$descrip','$relproy','$costo_basico','$costo_adicional','$porcentaje','$dura_vin','$costo_basico'*'$dura_vin'+'$costo_adicional'*'$dura_vin');";
	
        mysql_query($sql);
	}
				  
				 $consul1="SELECT * FROM anfacecoplancost WHERE id_ficha='$idficha'";
				  $respu1=mysql_query($consul1);
                                  
				  while ($fila1=mysql_fetch_array($respu1))
				  {
				  $total=$total+$fila1['valor_total'];
				  }
						$consul7="SELECT * FROM ana_facti WHERE id_ficha='$idficha'";
						$resul7=mysql_query($consul7);
						$fila7=mysql_fetch_array($resul7);
						if (!$fila7['total'])
						{
						require_once('funciones.php');
                                                $nombreproy=$_REQUEST['nombreproy'];
						$responsable=$_REQUEST['responsable'];
						
                                                $idficha=_clean($idficha);
						$nombreproy=_clean($nombreproy);
						$responsable=_clean($responsable);
						$totaltotal=_clean($total);
						
						$idficha=SanitizeString($idficha);
						$nombreproy=SanitizeString($nombreproy);
						$responsable=SanitizeString($responsable);
						$total=SanitizeString($total);
						$sql11="INSERT INTO ana_facti (id_ficha,nomproy,nomresp,total) VALUES ('$idficha','$nombreproy','$responsable','$total')"; 
						
                                                mysql_query($sql11);
						}
						else
						{
						require_once('funciones.php');
						$total=_clean($total);
						$total=SanitizeString($total);
				 		$sql12="UPDATE ana_facti SET total='$total' WHERE id_ficha='$idficha'"; 
                                               
						mysql_query($sql12);
						}
	header("location: anayplanifcostos.php?idficha=$idficha");
}
else 
include("top.php");
$idficha=($_GET['idficha']);

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
  <form name="form2" method="post" action="anayplanifcostos.php" onKeyPress="return Form()">
   <input name="idficha" type="hidden" value="<?php echo $idficha;?>">
  	<tr> 
      <td> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <td width="835"> 
              <table width="100%" border="1">
                <tr> 
                  <td height="20" colspan="2" background="images/main-button-tileR1.jpg"> 
                    <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                      <strong>AN�LISIS Y PLANIFICACI�N DE COSTOS</strong></font></div></td>
              </tr>              </table>
            <table width="100%">
			   
                <tr> 
                  <td width="24%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Nombre 
                    del proyecto :&nbsp; </font></td>
 	               <td width="76%">   <p><font size="2" face="Arial, Helvetica, sans-serif"> 
                      <?php
						$consul3="SELECT * FROM ana_facti WHERE id_ficha='$idficha'";
						$resul3=mysql_query($consul3);
						$fila3=mysql_fetch_array($resul3);
						if (!$fila3['id_ficha'])
						{ ?>
					<select name="nombreproy" id="nombreproy">
					<?php
					
						echo "<option value=\"0\"></option>";
						$sql0 = "SELECT DISTINCT Requerimiento FROM solicproydatos ORDER BY Requerimiento ASC";
						$result0=mysql_query($sql0);
						while ($row0=mysql_fetch_array($result0)) {
								echo '<option value="'.$row0['Requerimiento'].'">'.$row0['Requerimiento'].'</option>';
						}
				   ?>
				   </select>					  
                      <?php }
						else
						{ echo $fila3['nomproy'];}
						?>
                      </font></p>
                  </td>
                </tr>
              </table>
              <table width="100%">
                <tr> 
                  <td height="20"><font size="2" face="Arial, Helvetica, sans-serif"><font color="#000000">&nbsp;&nbsp;Nombre 
                    del responsable: </font><font size="2" face="Arial, Helvetica, sans-serif"> 
                    <font size="2" face="Arial, Helvetica, sans-serif"> 
				<?php
						$consul4="SELECT * FROM ana_facti WHERE id_ficha='$idficha'";
						$resul4=mysql_query($consul4);
						$fila4=mysql_fetch_array($resul4);
						if (!$fila4['id_ficha'])
						{?>
                    <select name="responsable">
                      <option value="0"></option>
                      <?php 
				  $sql1 = "SELECT * FROM users WHERE bloquear=0 AND tipo2_usr='T' OR tipo2_usr='C' ORDER BY apa_usr ASC";
				  $result1 = mysql_query($sql1);
				  while ($row1 = mysql_fetch_array($result1)) 
				{
				echo '<option value="'.$row1['login_usr'].'">'.$row1['apa_usr'].' '.$row1['ama_usr'].' '.$row1['nom_usr'].'</option>';
	            }
			   ?>
                    </select> <?php } 
				else
				{ 
				$consul5="SELECT * FROM users WHERE login_usr='$fila4[nomresp]'";
				$result5=mysql_query($consul5);
				$fila5=mysql_fetch_array($result5);
				echo $fila5['nom_usr']."&nbsp;".$fila5['apa_usr']."&nbsp;".$fila5['ama_usr'];
				}	
					?>
                    </font> </font></font></td>
                </tr>
              </table>
              <table width="100%" border="1">
                <tr> 
                  <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Tipo 
                      de medio: 
                      <select name="tip">
                        <option>Infraestructura </option>
                        <option>Tecnologia </option>
                        <option>Aplicaciones</option>
                        <option>Datos</option>
                        <option>Gente</option>
                      </select>
                      </font></div></td>
                </tr>
              </table>
              <table width="100%" border="1">
                <tr> 
                  <td width="5%" rowspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N�&nbsp;</font></div></td>
                  <td width="6%" rowspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tipo&nbsp;</font></div></td>
                  <td width="10%" rowspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Recurso&nbsp;</font></div></td>
                  <td width="13%" rowspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Descripcion&nbsp;</font></div></td>
                  <td width="10%" rowspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Relacion 
                      con el proyecto&nbsp;</font></div></td>
                  <td height="24" colspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Costos 
                      mes&nbsp;</font></div></td>
                  <td width="14%" rowspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">%Mensual 
                      de dedicacion al proyecto&nbsp;</font></div></td>
                  <td width="12%" rowspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Duracion 
                      de la vinculacion (Meses) &nbsp;</font></div></td>
                  <td width="12%" rowspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Valor 
                      total&nbsp;</font></div></td>
                </tr>
                <tr bgcolor="#006699"> 
                  <td width="8%" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Basico</font></div></td>
                  <td width="10%" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Adicional</font></div></td>
                </tr>
        <?php
			
		$sql = "SELECT * FROM anfacecoplancost WHERE id_ficha='$idficha'";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> 
            <td>&nbsp;<?php echo $row['numero']; ?></td>
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
                  <td height="22"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Total: 
                    <?php 
				  $consul2="SELECT * FROM ana_facti WHERE id_ficha='$idficha'";
				  $resul2=mysql_query($consul2);
				  $fila2=mysql_fetch_array($resul2);
				  echo $fila2['total']; ?>
                    </strong></font></td>
                </tr>
              </table></td>
          </tr>
               </table>
        <table width="100%" border="1">
          <tr> 
            <td width="10%" background="images/main-button-tileR1.jpg"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><font color="#FFFFFF"></font></font></div></td>
            <td width="26%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Recurso</font></div></td>
            <td width="41%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Descripcion</font></div></td>
            <td width="23%" background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Relacion 
                con el proyecto</font></div></td>
          </tr>
          <tr> 
            <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF">Nuevo</font></div></td>
            <td align="center"><input name="recu" type="text" size="35" maxlength="30"></td>
            <td align="center"><textarea name="descrip" cols="50"></textarea></td>
            <td align="center"><input name="relproy" type="text" size="30" maxlength="500"></td>
          </tr>
        </table>
        <table width="100%" border="1">
          <tr bgcolor="#006699"> 
            <td colspan="2" background="images/main-button-tileR1.jpg"><div align ="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Costo 
                mes </font></div></td>
            <td width="25%" rowspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">%Mensual 
                de dedicacion al proyecto</font></div>
              <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"></font></div></td>
            <td width="27%" rowspan="2" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Duracion 
                de la vinculacion (Meses)</font></div>
              <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"></font></div></td>
          </tr>
          <tr bgcolor="#006699"> 
            <td width="23%" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Basico</font></div></td>
            <td width="25%" background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Adicional</font></div></td>
          </tr>
          <tr> 
            <td align="center"><input name="costo_basico" type="text" size="12" maxlength="10" value="0.00"></td>
            <td align="center"><input name="costo_adicional" type="text" size="12" maxlength="10" value="0.00"></td>
            <?php $valortotal='$costo_basico'+'$costo_adicional'?>
            <td align="center"><input name="porcentaje" type="text" size="10" maxlength="3"></td>
            <td align="center"><input name="dura_vin" type="text" size="20" maxlength="3"></td>
          </tr>
        </table>
        <br>
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="file:///C|/apache/htdocs/ivan/images/fondo.jpg">
          <tr> 
            <td width="826" height="49" colspan="4" nowrap> 
              <div align="center">
                <input name="Guardar" type="submit" id="Guardar" value="GUARDAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
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
