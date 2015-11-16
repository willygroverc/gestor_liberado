<?php
if (isset($_REQUEST['RETORNAR'])){header("location: lista_ficha.php");}
if (isset($_REQUEST['GyS']))
{   include("conexion.php");
	require_once('funciones.php');
	$Fecha=$_REQUEST['AnoD'].'-'.$_REQUEST['MesD'].'-'.$_REQUEST['DiaD'];
        $NombAsig=$_REQUEST['NombAsig'];
        $var=$_REQUEST['var'];
        
	$sql2= "SELECT * FROM users WHERE login_usr='$NombAsig'";
	$result2=mysql_db_query($db,$sql2,$link);
	$row2=mysql_fetch_array($result2);

	$var=SanitizeString($var);
	$NombAsig=SanitizeString($NombAsig);
	$row2['area_usr']=SanitizeString($row2['area_usr']);
	$Fecha=SanitizeString($Fecha);
	$sql="INSERT INTO ".
	"asigcustficha (IdFicha,Tipo,NombAsig,Area,Fecha) ".
	"VALUES ('$var','Asignado','$NombAsig','$row2[area_usr]','$Fecha')";
        //print_r($sql);exit;
	mysql_db_query($db,$sql,$link);
	header("location: lista_ficha.php");
}
else { 
include("top.php");
require_once('funciones.php');
$IdFi=SanitizeString($_GET['IdFicha']);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "NombAsig",  "Nombre, $errorMsgJs[empty]" );
$valid->addIsDate ( "DiaD", "MesD", "AnoD",  "Fecha de Recepcion, $errorMsgJs[date]" );
print $valid->toHtml();
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
<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $IdFi;?>">
	<tr> 
      <td height="91"> <p>&nbsp;&nbsp;&nbsp;<font size="2" face="Arial, Helvetica, sans-serif"><strong>Asignado 
          A :</strong></font> </p>
        <table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr bgcolor="#006699"> 
            <td background="images/main-button-tileR1.jpg" height="20"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF">NOMBRE</font></strong></font></div>
              <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong></strong></font></div></td>
            <td width="27%" background="images/main-button-tileR1.jpg" height="20"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF">FECHA 
                DE RECEPCION</font></strong></font></div></td>
          </tr>
          <tr> 
            <td> <div align="center">
                <select name="NombAsig">
                  <option value="0"></option>
                  <?php 
			  		$sql = "SELECT * FROM users";
			  		$result = mysql_db_query($db,$sql,$link);
			  		while ($row = mysql_fetch_array($result)) 
					{
					echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            	}
			   		?>
                </select>
              </div></td>
            <td><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <?php $fsist=date("Y-m-d"); ?>
                <select name="DiaD" id="select19">
                  <?php
  				$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
                </select>
                <select name="MesD" id="select20">
                  <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                </select>
                <select name="AnoD" id="select21">
                  <?php for($i=1990;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                </select>
                </font><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></strong></div></td>
          </tr>
        </table>
        
        <p align="center"> 
          <input type="submit" name="GyS" value="GUARDAR" <?php print $valid->onSubmit() ?>>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
        </p></td>
    </tr></form>
  </table>
<script language="JavaScript">
		<!-- 
		 var cal = new calendar1(document.forms['form2'].elements['DiaD'], document.forms['form2'].elements['MesD'], document.forms['form2'].elements['AnoD']);			
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>
<?php } ?>
<?php include("top_.php");?>