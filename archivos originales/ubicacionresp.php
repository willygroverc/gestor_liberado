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
{   header ("location: lista_ubicacionr.php");}
if (isset($reg_form))
{   require("conexion.php");
	if (!isset($Sistema)) {$Sistema="0";}
	if (!isset($Negocio)) {$Negocio="0";}
	if (!isset($SE1)) {$SE1="0";}
	if (!isset($SE2)) {$SE2="0";}
	$fecha="$anio-$mes-$dia";
	$sql="INSERT INTO ".
	"ubicacionresp (codigo,fecha,contenido,ubi_sistema,ubi_negocio,ubi_SE1,ubi_SE2,observ) ".
	"VALUES ('$codigo','$fecha','$contenido','$Sistema','$Negocio','$SE1','$SE2','$observ')";
	mysql_query($sql);
	$var=$var+1;
	header("location: ubicacionresp.php?var=$var");
//	header("location: caracteristica.php?variable1=$var&variable2=$var2");
}
else { 
include("top.php");
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
$valid->addIsNotEmpty ( "codigo",  "Codigo, $errorMsgJs[empty]" );
$valid->addIsDate   ( "dia", "mes", "anio", "Fecha, $errorMsgJs[date]" );
$valid->addIsTextNormal ( "contenido",  "Contenido, $errorMsgJs[expresion]" );
$valid->addLength ( "contenido",  "Contenido, $errorMsgJs[length]" );
print $valid->toHtml ();
if(!isset($var)) $var=0;
?>
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<tr> 
      <td> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="9" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">UBICACION 
              DE RESPALDOS</font></th>
          </tr>
          <tr> 
            <th width="45" rowspan="2" nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Codigo</font></th>
            <th width="39" rowspan="2" nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tipo</font></th>
            <th width="140" rowspan="2" nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha</font></th>
            <th width="175" rowspan="2" nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Contenido</font></th>
            <th colspan="4" nowrap background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Ubicacion</font></th>
            <th width="150" rowspan="2" nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Observaciones</font></th>
          </tr>
          <tr> 
            <th width="60" nowrap background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Sistema</font></div></th>
            <th width="60" nowrap background="images/main-button-tileR1.jpg"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Negocio 
                </font></div></th>
            <th width="60" nowrap background="images/main-button-tileR1.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">SE1</font></div></th>
            <th width="60" nowrap background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">SE2</font></th>
          </tr>
          <?php
		$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp ORDER BY codub DESC LIMIT $var";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr align="center"> 
            <td><?php echo $row['codigo'];?></td>
 		    <?php
			$sql0="SELECT * FROM controlinvent WHERE codigo_usu='$row[codigo]'";
			$result0=mysql_query($sql0);
			$row0=mysql_fetch_array($result0);?>
			<td><?php echo $row0['tipo_medio'];?></td>
            <td><?php echo $row['fecha'];?></td>
            <td><?php echo $row['contenido'];?></td>
            <?php if  ($row['ubi_sistema']=="1") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
			  	  	else{ echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}?>
            <?php if  ($row['ubi_negocio']=="1") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
  					else{ echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}?>
            <?php if  ($row['ubi_SE1']=="1") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
  					else{ echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";} ?>
			<?php if  ($row['ubi_SE2']=="1") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
  					else{ echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}?>
					<td><?php echo $row['observ'];?></td>
          </tr>
        <?php
		 }
		 ?>
          <tr> 
            <td colspan="9" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center">
                <input name="var" type="hidden" id="var" value="<?php echo $var?>">
              </div></td>
          </tr>
          <tr> 
            <td align="center" colspan="2" nowrap>
              <select name="codigo">
                <option value="0"></option>
                <?php 
			  $sql = "SELECT * FROM controlinvent";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{if($row['FechaBaja']=="0000-00-00")
					{echo '<option value="'.$row['codigo_usu'].'">'.$row['codigo_usu'].'. '.$row['tipo_medio'].'</option>';}
	            }
			   ?>
              </select>
            </td>
			  
            <td nowrap height="7" align="center">
              <select name="dia" id="select">
                <?php
				  	$a=date("Y-m-d");
				   	$a1=substr($a,0,4);
					$m1=substr($a,5,2);
					$d1=substr($a,8,2);
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
              </select>
              <select name="mes" id="select2">
                <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select>
              <select name="anio" id="select3">
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
              <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></td>
            <td nowrap height="7"><div align="center"><strong> 
                <textarea name="contenido" cols="25"></textarea>
                </strong> </div></td>
            <td nowrap height="7" align="center"><strong>
              <input type="checkbox" name="Sistema" value="1">
              </strong></td>
            <td nowrap height="7"> <div align="center"><strong>
                <input type="checkbox" name="Negocio" value="1">
                </strong></div></td>
            <td nowrap height="7" align="center"><input type="checkbox" name="SE1" value="1"></td>
            <td nowrap align="center"><input type="checkbox" name="SE2" value="1"></td>
			<td><strong>
			  <textarea name="observ" cols="20" id="observ"></textarea>
			</strong></td>
          </tr>
          <tr> 
            <td height="30" colspan="9" nowrap align="center"> 
              <input name="reg_form" type="submit" id="reg_form3" value="INSERTAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="RETORNAR" type="submit" id="reg_form" value="RETORNAR">
            </td>
          </tr>
        </table>
      </td>
    </tr>
</form>
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
  <?php } ?>
</p>