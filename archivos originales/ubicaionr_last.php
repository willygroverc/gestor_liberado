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
if (isset($RETORNAR))
{   header("location: lista_ubicacionr.php");}?>
<?php if (isset($insertar))
    {
	require("conexion.php");
	$fecha="$anio-$mes-$dia";
	if (!isset($Sistema)) {$Sistema="0";}
	if (!isset($Negocio)) {$Negocio="0";}
	if (!isset($SE1)) {$SE1="0";}
	if (!isset($SE2)) {$SE2="0";}
	 $sql5="UPDATE ubicacionresp SET codigo='$codigo',fecha='$fecha',contenido='$contenido',ubi_sistema='$Sistema',ubi_negocio='$Negocio',ubi_SE1='$SE1',ubi_SE2='$SE2'".
		" ,observ='$observ' WHERE codub='$var'";
	  mysql_query($sql5);
	  header("location: ubicaionr_last.php?codub=$var");}

else { 
include("top.php");
$codub=($_GET['codub']);
?>
<script language="JavaScript" src="calendar.js"></script>
<SCRIPT language="JavaScript">
<!--
function validateCheck (){
	var form=document.form2;
	if (!form.Sistema.checked && !form.Negocio.checked && !form.SE1.checked && !form.SE2.checked ) {
		alert ("Ubicacion, debe seleccionar una opcion.\n \nMensaje generado por GesTor F1.");
		return false;
	}
	return true;
}
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
//-->
</SCRIPT>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addFunction( "validateCheck",  "" );
$valid->addIsDate   ( "dia", "mes", "anio", "Fecha, $errorMsgJs[date]" );
$valid->addIsNotEmpty ( "codigo",  "Codigo, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "contenido",  "Contenido, $errorMsgJs[expresion]" );
$valid->addLength ( "contenido",  "Contenido, $errorMsgJs[length]" );
print $valid->toHtml ();
?>
  
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $codub;?>">
	<tr> 
      <td height="150"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr align="center"> 
            <th width="60" rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CODIGO</font></th>
            <th width="154" rowspan="2" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">FECHA</font></div></th>
            <th width="175" rowspan="2" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">CONTENIDO</font></th>
            <th colspan="4" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">UBICACION</font></th>
			<th width="165" rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Observaciones</font></th>
		   </tr>
          <tr align="center"> 
            <th width="68" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">SISTEMA</font></th>
            <th width="60" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">NEGOCIO</font></th>
            <th width="36" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">SE1</font></th>
            <th width="51" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">SE2</font></th>
          </tr>
          <?php
			
		$sql1 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp WHERE codub='$codub'";
		$result1=mysql_query($sql1);
		while($row1=mysql_fetch_array($result1)) 
  		{ 
		 ?>
          <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['codigo'];?></font></div></td>
            <td> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['fecha'];?></font></div></td>
          <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['contenido'];?></font></div></td>
          <?php if  ($row1['ubi_sistema']=="1") {echo "<td align=\"center\"><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
			  	  	else{ echo "<td align=\"center\"><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}?>
          <?php if  ($row1['ubi_negocio']=="1") {echo "<td align=\"center\"><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
  					else{ echo "<td align=\"center\"><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}?>
          <?php if  ($row1['ubi_SE1']=="1") {echo "<td align=\"center\"><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
  					else{ echo "<td align=\"center\"><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";} ?>
          <?php if  ($row1['ubi_SE2']=="1") {echo "<td align=\"center\"><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
  					else{ echo "<td align=\"center\"><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}?>
          <td align="center"><?php echo $row1['observ'];?></td>
		  </tr>
          <tr> 
            <td colspan="7" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="60" nowrap height="7"><div align="center"> 
                <p><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="codigo">
                    <?php 
			

			     $sql2 = "SELECT * FROM controlinvent ";
			     $result2 = mysql_query($sql2);
			     while ($row2 = mysql_fetch_array($result2)) 
				{   if ($row2['Codigo']==$row1['codigo'])
				{echo '<option value="'.$row2['Codigo'].'" selected>'.$row2['Codigo'].'. '.$row2['Tipo'].'</option>';}
			  else{
				echo '<option value="'.$row2['Codigo'].'">'.$row2['Codigo'].'. '.$row2['tipo_medio'].'</option>';}}
			   ?>
                  </select>
                  </font></p>
              </div></td>
            <td nowrap height="7">
<div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="dia" id="select4">
                  <?php
				   	$a1=substr($row1['fecha'],5,4);
					$m1=substr($row1['fecha'],3,2);
					$d1=substr($row1['fecha'],0,2);
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
                </select>
                <select name="mes" id="select5">
                  <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                </select>
                <select name="anio" id="select6">
                  <?php for($i=2004;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                </select>
                <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> 
                </font></div></td>
            <td width="175" nowrap height="7"><div align="center"> 
                <textarea name="contenido" cols="25"><?php echo $row1['contenido'];?></textarea>
                 </div></td>
            <td align="center"> 
              <input name="Sistema" type="checkbox" value="1" <?php if ($row1['ubi_sistema']=="1") echo "checked";?>> 
            </td>
            <td align="center"><input type="checkbox" name="Negocio" value="1" <?php if ($row1['ubi_negocio']=="1") echo "checked";?>> 
            </td>
            <td align="center"> <input type="checkbox" name="SE1" value="1"<?php if ($row1['ubi_SE1']=="1") echo "checked";?>> 
            </td>
            <td align="center"> <input type="checkbox" name="SE2" value="1"<?php if ($row1['ubi_SE2']=="1") echo "checked";?>> 
            </td>
			<td><strong>
			  <textarea name="observ" cols="25" id="observ"><?php=$row1['observ'];?></textarea>
			</strong></td>
          </tr>
          <tr> 
            <td height="28" colspan="7" nowrap> <div align="center"><br>
                <input name="insertar" type="submit" id="reg_form3" value="GUARDAR CAMBIOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
              </div></td>
          </tr>
        </table>
      </td>
    </tr></form>
  </table>
<script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['dia'], document.forms[form].elements['mes'], document.forms[form].elements['anio']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>
<p> 
          <?php 
		 }
		 ?>
  <?php } ?>
</p>