<?php
require('conexion.php');
if (isset($RETORNAR)){header("location: lista_planifpru2.php");}
if (isset($GUARDATOS)){   	
	$feceval="$Ano-$Mes-$Dia";
	$fecrev="$A1-$M1-$D1";
	$sql5="SELECT MAX(idresulpru) AS num FROM resulpru";
		$result5=mysql_query($sql5);
		$row5=mysql_fetch_array($result5);
		$r=$row5['num']+1; 

  	$sql8= "INSERT INTO resulpru (ordayuda,feceval,fecrev,objprue,tipocontin,condicion,fecrelac,varios,rechard,recsoft,recresp,facilidad,costo,moneda,jefeus,jefeapc)".
	"VALUES ('$OrdAyuda','$feceval','$fecrev','$objprue','$tipcontin','$condicion','$fecrelac','$varios','$rechard','$recsoft','$recresp','$facilidad','$costo','$moneda','$jefeus','-')";
	mysql_query($sql8);
 	header("location: resprelac_result.php?varia1=$OrdAyuda&varia2=$r");
}
else
{ include("top.php");
$OrdAyuda=($_GET['idresulpru']);

$sql = "SELECT * FROM planprueba WHERE ordayuda='$OrdAyuda'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?> 
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addLength ( "objprue",  "Objetivo de la Prueba, $errorMsgJs[length]" );
$valid->addLength ( "tipcontin",  "Tipo de Contingencia, $errorMsgJs[length]" );
$valid->addLength ( "condicion",  "Condiciones, $errorMsgJs[length]" );
$valid->addLength ( "fecrelac",  "Fechas Relacionadas, $errorMsgJs[length]" );
$valid->addLength ( "varios",  "Varios, $errorMsgJs[length]" );
$valid->addLength ( "rechard",  "Recursos de Hardware, $errorMsgJs[length]" );

$valid->addLength ( "recsoft",  "Recursos de Software, $errorMsgJs[length]" );
$valid->addLength ( "recresp",  "Recursos de Respaldo, $errorMsgJs[length]" );
$valid->addLength ( "facilidad",  "Facilidades, $errorMsgJs[length]" );
$valid->addIsDate   ( "Dia", "Mes", "Ano", "Fecha De Evaluacion, $errorMsgJs[date]" );
$valid->addIsDate   ( "D1", "M1", "A1", "Fecha de Revision, $errorMsgJs[date]" );
$valid->addCompareDates  ( "Dia", "Mes", "Ano", "D1", "M1", "A1", "Fecha De Evaluacion y Fecha de Revision, $errorMsgJs[compareDates]" );
$valid->addIsNumber   ( "costo", "Costo, $errorMsgJs[number]" );
$valid->addIsNotEmpty ( "jefeus",  "Nombre de Jefe US, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "jefeapc",  "Nombre de Jefe APC, $errorMsgJs[empty]" );
print $valid->toHtml ();
?> 
<form name="form1" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
   <input name="OrdAyuda" type="hidden" value="<?php echo $OrdAyuda;?>">
  <table width="89%" height="800" border="0" align="center" background="images/fondo.jpg">
    <tr> 
      <td height="800"> 
        <table width="100%" border="1">
          <tr bordercolor="#000000" bgcolor="#006699"> 
            <td colspan="2"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>RESULTADOS 
                DE PRUEBAS</strong></font></div></td>
          </tr>
          <tr bordercolor="#000000" bgcolor="#006699"> 
            <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">FECHA 
                DE EVALUACION</font></div></td>
            <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">FECHA 
                DE REVISION</font></div></td>
          </tr>
          <tr bordercolor="#000000"> 
            <td height="37"> 
              <div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font> 
                <select name="Dia" id="select15">
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
                <select name="Mes" id="select16">
                  <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                </select>
                <select name="Ano" id="select17">
                  <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                </select>
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font> 
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font></strong></div></td>
            <td><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font> 
                <select name="D1" id="select18">
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
                <select name="M1" id="select19">
                  <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                </select>
                <select name="A1" id="select20">
                  <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                </select>
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font> 
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font></strong></div>
              <div align="center"></div></td>
          </tr>
        </table>
        <table width="100%" border="1">
          <tr> 
            <td width="34%"><blockquote> 
                <blockquote> 
                  <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Objetivo 
                    de la Prueba</font></div>
                </blockquote>
              </blockquote></td>
            <td width="66%"><textarea name="objprue" cols="108"><?php echo $row['objprue'];?></textarea></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Tipo de 
                    Contingencia</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="tipcontin" cols="108"><?php echo $row['tipcontin'];?></textarea></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Condiciones</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="condicion" cols="108"><?php echo $row['condicion'];?></textarea></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Fechas 
                    Relacionadas</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="fecrelac" cols="108"><?php echo $row['fecrelac'];?></textarea></td>
          </tr>
          <tr> 
            <td height="69"> <blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Varios</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="varios" cols="108"><?php echo $row['varios'];?></textarea></td>
          </tr>
          <tr bordercolor="#000000" bgcolor="#006699"> 
            <td><blockquote>&nbsp;</blockquote></td>
            <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">RECURSOS 
                NECESARIOS</font></div></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Recursos 
                    de Hardware</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="rechard" cols="108"><?php echo $row['rechard'];?></textarea></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Recursos 
                    de Software</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="recsoft" cols="108"><?php echo $row['recsoft'];?></textarea></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Recursos 
                    de Respaldo</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="recresp" cols="108"><?php echo $row['recresp'];?></textarea></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Facilidades</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="facilidad" cols="108"><?php echo $row['facilidad']; ?></textarea></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Costo</font></p>
                </blockquote>
              </blockquote></td>
            <td><input name="costo" type="text" value="<?php echo $row['costo']; ?>" size="20" maxlength="10">
            <select name="moneda">
                <option value="Bs" <?php if ($row['moneda']=="Bs") echo "selected";?>>Bs</option>
          		<option value="Sus" <?php if ($row['moneda']=="Sus") echo "selected";?>>$us</option>
			 </select>
			</td>
          </tr>
          <tr> 
            <td height="124" colspan="2">
<div align="center">
                <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr bgcolor="#006699"> 
                    <td width="49%" height="30"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">NOMBRE 
                        DE JEFE DE AREA</font></div></td>
                  </tr>
                  <tr> 
                    <td height="26"> <div align="center"><br>
                        <select name="jefeus" id="select13">
                          <option value="0"></option>
                          <?php 
					  
					  $sql11 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
					  $result11 = mysql_query($sql11);
					  while ($row11 = mysql_fetch_array($result11)) 
						{
						echo "<option value=\"$row11[login_usr]\"";
						if ($row11['login_usr']==$row['jefeus']) echo "selected";
						echo " >$row11[apa_usr] $row11[ama_usr] $row11[nom_usr]</option>";
						// echo "<option value=\"$row11[login_usr]\">  $row11[nom_usr] $row11[apa_usr] $row11[ama_usr]</option>";
			            }
			   ?>
                        </select>
                      </div></td>
                  </tr>
                </table>
                <br>
                <input name="GUARDATOS" type="submit" id="GUARDATOS" value="GUARDAR Y CONTINUAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
              </div></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <tr>
    <td colspan="1">
  <?php } ?>       
</form>
  <script language="JavaScript">
		<!-- 
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['Dia'], document.forms[form].elements['Mes'], document.forms[form].elements['Ano']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		 var cal1 = new calendar1(document.forms[form].elements['D1'], document.forms[form].elements['M1'], document.forms[form].elements['A1']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
	function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
//-->
</script>