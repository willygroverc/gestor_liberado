<?php
if (isset($_REQUEST['RETORNAR'])){header("location: lista_admyaseg.php");}
if (isset($_REQUEST['GUARDATOS'])) {
  include ("conexion.php");
  //$FechaAdAs="$ano1-$mes1-$dia1";
  $FechaAdAs=$_REQUEST['ano1'].'-'.$_REQUEST['mes1'].'-'.$_REQUEST['dia1'];
  $Tipo=$_REQUEST['Tipo'];
  $IdAdm=$_REQUEST['IdAdm'];
  $NombProy=$_REQUEST['NombProy'];
  $NombResp=$_REQUEST['NombResp'];
  $DocuRef=$_REQUEST['DocuRef'];
  $DocuSoporte=$_REQUEST['DocuSoporte'];
  $sql2 = "SELECT MAX(IdAdmyAseg) AS ID FROM admyasegdatos WHERE Tipo='$Tipo'";

  $result2=mysql_db_query($db,$sql2,$link);
  $row2=mysql_fetch_array($result2);
  $IdAdm=$row2['ID']+1;
  $sql = "INSERT INTO admyasegdatos (IdAdmyAseg,Tipo,NombProy,NombResp,DocuRef,DocuSoporte,FechaAdAs) ".
         "VALUES ('$IdAdm','$Tipo','$NombProy','$NombResp','$DocuRef','$DocuSoporte','$FechaAdAs')";
  $sql1 = "SELECT * FROM admyasegdatos WHERE Tipo='$Tipo' AND NombProy='$NombProy'";

  $result1 = mysql_db_query($db,$sql1,$link);
  $row1 = mysql_fetch_array($result1);

  if (!$row1['IdAdmyAseg'])
  {
  	$result=mysql_db_query($db,$sql,$link);
  	if ($Tipo=="ADMINISTRACION DE RECURSOS HUMANOS")
    {header("location: admrhumanos1.php?variable1=$IdAdm&variable2=$Tipo");}
    else
    {header("location: AdmyAsegAlcance.php?variable1=$IdAdm&variable2=$Tipo");}
  }
  else
  {$msg="Ya existe un proyecto de tipo ".$Tipo." con el nombre ".$NombProy." registrado ";}
} 
 
?>
<?php include ("top.php");?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addExists ( "NombProy",  "Nombre del Proyecto, $errorMsgJs[empty]" );
$valid->addLength( "NombProy",  "Nombre del Proyecto, $errorMsgJs[length]" );
$valid->addIsNotEmpty ( "NombResp",  "Nombre del Responsable, $errorMsgJs[empty]" );
$valid->addIsDate   ( "dia1", "mes1", "ano1", "Fecha, $errorMsgJs[date]" );
$valid->addExists ( "DocuRef",  "Documentacion de Referencia, $errorMsgJs[empty]" );
$valid->addLength( "DocuRef",  "Documentacion de Referencia, $errorMsgJs[length]" );
$valid->addExists ( "DocuSoporte",  "Documentacion de Soporte, $errorMsgJs[empty]" );
$valid->addLength( "DocuSoporte",  "Documentacion de Soporte, $errorMsgJs[length]" );
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
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" onKeyPress="return Form()">


    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr> 
        <td height="300"><div align="center"> 
            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
              <tr> 
                <td><div align="center"><strong><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">ADMINISTRACION 
                    / ASEGURAMIENTO DE PROYECTOS</font></strong></div></td>
              </tr>
            </table>
            <table width="100%" border="1" cellpadding="1" cellspacing="0" background="images/fondo.jpg">
              <tr> 
                <td height="237"> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td colspan="3"><div align="center"> 
                          <p><strong><font size="2" face="Arial, Helvetica, sans-serif"><br>
                            TIPO DE FORMULARIO :</font> </strong> 
                            <select name="Tipo">
                              <option value="ADMINISTRACION DEL ALCANCE"><strong>ADMINISTRACION 
                              DEL ALCANCE</strong></option>
                              <option value="ASEGURAMIENTO DE LA CALIDAD">ASEGURAMIENTO 
                              DE LA CALIDAD</option>
                              <option value="ADMINISTRACION DE LA COMUNICACION">ADMINISTRACION 
                              DE LA COMUNICACION</option>
                              <option value="ADMINISTRACION DE RECURSOS HUMANOS">ADMINISTRACION 
                              DE RECURSOS HUMANOS</option>
                            </select>
                            &nbsp;</p>
                          <p>&nbsp;</p>
                        </div></td>
                    </tr>
                    <tr> 
                      <td width="19%" height="11"> <div align="center">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;Nombre 
                          del proyecto :</font> </div></td>
                      <td width="81%">
				<select name="NombProy" id="NombProy">
                <?php
				
					echo "<option value=\"0\"></option>";
					$sql0 = "SELECT DISTINCT Requerimiento FROM solicproydatos ORDER BY Requerimiento ASC";
 			  		$result0=mysql_db_query($db,$sql0,$link);
			  		while ($row0=mysql_fetch_array($result0)) {
							echo "<option value=\"$row0[Requerimiento]\">$row0[Requerimiento]</option>";
					}
			   ?>
              </select>					  
					  </td>
                      <td width="0%" height="11">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td height="22" colspan="3">&nbsp;</td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td height="25" colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Nombre 
                        del Responsable :</font> <strong> 
                        <select name="NombResp" id="select2">
                          <option value="0"></option>
                          <?php 
			  $sql = "SELECT * FROM users WHERE bloquear=0 AND tipo2_usr='T' OR tipo2_usr='C' ORDER BY apa_usr ASC";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            }
			   ?>
                        </select>
                        </strong></td>
                      <td height="25" colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha 
                        :</font>&nbsp;<strong> 
                        <?php 
			  $fsist=date("Y-m-d");
			  
			   ?>
                        <select name="dia1" >
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
                        <select name="mes1">
                          <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                        </select>
                        <select name="ano1">
                          <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                        </select>
                        <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font> 
                        </strong></td>
                    </tr>
                    <tr> 
                      <td width="19%" height="22"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Documentacion 
                          de Referencia&nbsp;&nbsp;:&nbsp;</font>&nbsp;&nbsp;&nbsp; 
                        </div></td>
                      <td width="34%"> <div align="left"> 
                          <textarea name="DocuRef" cols="30"></textarea>
                        </div></td>
                      <td width="17%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                          Documentacion de Soporte :</font> </div></td>
                      <td width="30%"> <div align="left"> 
                          <textarea name="DocuSoporte" cols="30"></textarea>
                        </div></td>
                    </tr>
                    <tr> 
                      <td colspan="2">&nbsp;</td>
                      <td colspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<br>
                          </font></div></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="100%" height="41"> <p align="center"><br>
                          <input type="submit" name="GUARDATOS" value="GUARDAR DATOS Y CONTINUAR" <?php print $valid->onSubmit() ?>>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                          <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
                        </p></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            <p><strong> </strong></p>
          </div></td>
      </tr>
    </table>
  </form>
  <script language="JavaScript">
		<!-- 
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['dia1'], document.forms[form].elements['mes1'], document.forms[form].elements['ano1']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>
<script language="JavaScript">
		<!-- 
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
//-->
</script>
<?php include("top_.php");?>