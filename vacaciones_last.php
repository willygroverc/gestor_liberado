<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		12/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($_REQUEST['RETORNAR'])){header("location: lista_vacaciones.php");}
if (isset($_REQUEST['reg_form']))
{   require("conexion.php");
	$fecha_del=$_REQUEST['AA1'].'-'.$_REQUEST['MA1'].'-'.$_REQUEST['DA1'];
	$fecha_al=$_REQUEST['AA'].'-'.$_REQUEST['MA'].'-'.$_REQUEST['DA'];
        $var1=$_REQUEST['var1'];
        $var=$_REQUEST['var'];
        $ausencia=$_REQUEST['ausencia'];

	//$fecha_del="$AA1-$MA1-$DA1";
	//$fecha_al="$AA-$MA-$DA";
	$sql3="INSERT INTO ".
	"vacaciones (id_vacac,Nombre,estado,fecha_al,fecha_del, ausencia) ".
	"VALUES ('$var','$var1','Realizado','$fecha_al','$fecha_del','$ausencia')";
	mysql_query($sql3);
	
	header("location: lista_vacaciones.php");
}
else {
include("top.php"); 
$IdRe=($_GET['id_vacac']);
$IdRe1=($_GET['Nombre']);?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
//$valid->addIsNotEmpty ( "Nombre",  "Nombre, $errorMsgJs[empty]" );
$valid->addIsDate   ( "DA1", "MA1", "AA1", "Fecha del, $errorMsgJs[date]" );
$valid->addIsDate   ( "DA", "MA", "AA", "Fecha al, $errorMsgJs[date]" );
$valid->addCompareDates   ( "DA1", "MA1", "AA1", "DA", "MA", "AA",   "Fecha Final y Fecha Inicio, $errorMsgJs[compareDates]" );
$valid->addFunction( "compareYear",  "" );
print $valid->toHtml ();
?> 
<script language="JavaScript">
<!--
function compareYear () {
	var form=document.form2;
	if (form.AA1.value != form.AA.value) {
		alert ("Los anos deben ser los mismos. \n \n Mensaje generado por GesTor F1.");
		return false;
	}	
	return true;
}
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}

-->
</script>
  <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" >
    <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $IdRe;?>">
	<input name="var1" type="hidden" value="<?php echo $IdRe1;?>">
	<tr> 
      <td height="173"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="6" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">CALENDARIZACION 
              DE AUSENCIA PROGRAMADA</font></th>
          </tr>
          <tr> 
            <th width="58" nowrap bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro.</font></div></th>
            <th width="141" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Nombre</font></th>
            <th width="181" nowrap bgcolor="#006699"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Estado</font></div></th>
            <th width="179" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Fecha 
                Inicio</font></div></th>
            <th width="194" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
              final</font></th>
			<th width="116" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Ausencia</font></th>
          </tr>
          <?php
			
		$sql = "SELECT *, DATE_FORMAT(fecha_del, '%d/%m/%Y') AS fecha_del, DATE_FORMAT(fecha_al, '%d/%m/%Y') AS fecha_al 
				FROM vacaciones WHERE id_vacac='$IdRe'";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 	
  		{
		 ?>
          <tr> 
            <td><div align="center">&nbsp; &nbsp;<?php echo $IdRe?></div></td>
            <?php 
	 		  $sql5 = "SELECT * FROM users WHERE login_usr='$row[Nombre]'";
			  $result5 = mysql_query($sql5);
			  $row5 = mysql_fetch_array($result5);
			echo '<td>'.$row5['nom_usr'].' '.$row5['apa_usr'].' '.$row5['ama_usr'].'</td>';?>
			<td><div align="center">&nbsp;<?php echo $row['estado']?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['fecha_del']?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['fecha_al']?></div></td>
			<td><div align="center">&nbsp;<?php echo $row['ausencia']?></div></td>
          </tr>
          <input name="var2" type="hidden" value="<?php echo $row['AdicUSI'];?>">
          <?php 
		  $motivo = $row['ausencia'];
		 }
		 ?>
          <tr> 
            <td colspan="6" height="7" nowrap><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font> 
              </div>
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td height="30" nowrap><font size="2" face="Arial, Helvetica, sans-serif"><div align="center"><?php echo $IdRe?> 
            </td>
              <?php 
	 		  $sql5 = "SELECT * FROM users WHERE login_usr='$IdRe1'";
			  $result5 = mysql_query($sql5);
			  $row5 = mysql_fetch_array($result5);
			echo '<td>'.$row5['nom_usr'].' '.$row5['apa_usr'].' '.$row5['ama_usr'].'</td>';?>
            <td width="141" nowrap height="30"> <strong> <div align="center">Realizado 
              </div></td>
            <td width="181" nowrap height="30"> <div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
<?php   $sql01 = "SELECT * FROM vacaciones WHERE id_vacac='$IdRe'";
		$result01=mysql_query($sql01);
		$row01=mysql_fetch_array($result01); 
		?> 
		        <select name="DA1" id="select">
                  <?php
				  
				$vfecha=date("Y-m-d");
				$a1=substr($vfecha,0,4);
				$m1=substr($vfecha,5,2);
				$d1=substr($vfecha,8,2);
		
				  
	for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
				
                </select>
                <select name="MA1">
                  <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                </select>
                <select name="AA1">
                  <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                </select>
                <strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong>
                
                </font> </strong></div></td>
            <td width="179" nowrap><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="DA" id="select13">
                  <?php
				  
				$vfecha=date("Y-m-d");
				$a1=substr($vfecha,0,4);
				$m1=substr($vfecha,5,2);
				$d1=substr($vfecha,8,2);
		
				  
	for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
				
                </select>
                <select name="MA">
                  <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                </select>
                <select name="AA">
                  <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                </select>                <strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong> 
                </font></strong></div></td>
			<td nowrap align="center">
				<strong><textarea name="ausencia" id="ausen" rows="3"><?php=$motivo?></textarea></strong>
			</td>
          </tr>
          <tr> 
            <td height="28" colspan="5" nowrap> <div align="left"><br>
              </div>
              <div align="center"> 
                <input name="reg_form" type="submit" id="reg_form3" value="GUARDAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DA1'], document.forms[form].elements['MA1'], document.forms[form].elements['AA1']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
//-->
</script>
<p> 
  <?php } ?>
</p>