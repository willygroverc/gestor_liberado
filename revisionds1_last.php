<?php
if ($reg_form)
{	include("conexion.php");
	$fecha_rr="$AS-$MS-$DS";
	$fecha_ra="$AR-$MR-$DR";
  	$sql = "UPDATE revision SET observaciones='$observaciones',nomb_rrevision='$nomb_rrevision',nomb_rauditoria='$nomb_rauditoria',".
		   "fecha_rr='$fecha_rr',fecha_ra='$fecha_ra' WHERE id_orden='$var'";
  	$result = mysql_query($sql);
  	mysql_db_query($db,$sql,$link);
    header("location: lista_ordenrev1.php");}

if ($reg_form2)
{	if($elegido==""){$elegido="No";}
 	include("conexion.php");
  	if ($numero=="NUEVO")	
  	{		
	$sql2 = "SELECT MAX(numero) AS num FROM detaller WHERE id_orden='$var'";
  	$result2=mysql_db_query($db,$sql2,$link);
  	$row2=mysql_fetch_array($result2);
	$numer=$row2[num]+1;
 	
	$sql = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ) VALUES ('$var','$numer','$descripcion','$elegido','$observ')";
   	mysql_db_query($db,$sql,$link);
 	header("location: revisionds1_last.php?id_orden=$var");}
  else 
  {$sql = "UPDATE detaller SET descripcion='$descripcion',elegido='$elegido',observ='$observ' WHERE id_orden='$var' AND numero='$numero'";
   	mysql_db_query($db,$sql,$link);
 	header("location: revisionds1_last.php?id_orden=$var");}
 
}
include("top.php");
$id_orden=($_GET['id_orden']);
$numer=($_GET['numero']);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addLength ( "observaciones",  "Observaciones, $errorMsgJs[length]" );
$valid->addIsNotEmpty ( "nomb_rrevision",  "Responsable de Revision, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "nomb_rauditoria",  "Responsable de Auditoria, $errorMsgJs[empty]" );
$valid->addIsDate   ( "DS", "MS", "AS", "Fecha de Revision, $errorMsgJs[date]" );
$valid->addIsDate   ( "DR", "MR", "AR", "Fecha de Auditoria, $errorMsgJs[date]" );
print $valid->toHtml ();
?>
<script language="JavaScript">
<!--
function validateForm1(){
	var form=document.form1;
	if (form.descripcion.value == '' || form.descripcion.lenght == 0) {
		alert ("Descripcion, no puede ser vacio.\n \nMensaje generado por GesTor F1.");
		form.descripcion.focus();
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
<form name="form1" method="post" action="revisionds1_last.php" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_orden;?>">
	<input name="var2" type="hidden" value="<?php echo $numer;?>">
  <table width="90%" border="2" align="center" background="images/fondo.jpg">
    <tr> 
      <th colspan="5"><font size="2" face="Arial, Helvetica, sans-serif">REVISION 
        DEL DIA SIGUIENTE</font></th>
    </tr>
    <tr> 
      <td colspan="5"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
        &nbsp;Descripcion de la Incidencia:</font></strong> <font size="2" face="Arial, Helvetica, sans-serif"> 
        <?php 
	  	$sql="SELECT desc_inc FROM ordenes WHERE id_orden=$id_orden";
		$rs=mysql_fetch_array(mysql_db_query($db, $sql, $link));
		print $rs[desc_inc];
	   ?>
        </font></td>
    </tr>
    <tr align="center"> 
      <td width="4%" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">N&ordm;</font></strong></td>
      <td width="31%" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">DESCRIPCION</font></strong></td>
      <td width="7%" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">SI</font></strong></td>
      <td width="6%" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">NO</font></strong></td>
      <td width="52%" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></strong></td>
    </tr>
    <?php
		$sql1 = "SELECT * FROM detaller WHERE id_orden='$id_orden'";
		$result1=mysql_db_query($db,$sql1,$link);
		while($row1=mysql_fetch_array($result1)) 
  		{
		 ?>
    <tr align="center"> <?php echo "<td><a href=\"revisionds1_last.php?id_orden=$id_orden&numero=".$row1[numero]."\">".$row1[numero]."</a></font></td>";?> 
      <td align="center">&nbsp;<?php echo $row1[descripcion]?></td>
      <?php if  ($row1[elegido]=="Si") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";
 									  echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}
  	  	elseif ($row1[elegido]=="No"){echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";
		   							   echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}?>
      <td align="center" >&nbsp;<?php echo $row1[observ]?></td>
    </tr>
    <?php 
		 }
		 ?>
  </table>
  <p>
  </p>
    
  <table width="90%" border="2" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="9%" bgcolor="#006699"> <div align="center"> 
          <p><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">N&ordm;</font></strong></p>
        </div></td>
      <td width="28%" height="20" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">DESCRIPCION</font></strong></div></td>
      <td width="6%" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">SI</font></strong></div></td>
      <td width="6%" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">NO</font></strong></div></td>
      <td width="51%" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></strong></div></td>
    </tr>
    	<?php    $sql3 = "SELECT * FROM detaller WHERE id_orden='$id_orden' AND numero='$numer'";
			  $result3 = mysql_db_query($db,$sql3,$link);
			  $row3 = mysql_fetch_array($result3); ?>
    <tr> 
      <td width="9%"> <select name="numero">
          <?php 
			     $sql2 = "SELECT * FROM detaller WHERE id_orden='$id_orden'";
			     $result2 = mysql_db_query($db,$sql2,$link);
			     while ($row2 = mysql_fetch_array($result2)) 
				{   if ($row2[numero]==$numero)
				{echo "<option value=\"$row2[numero]\"selected>$row2[numero]</option>";}
			  else
				{echo "<option value=\"$row2[numero]\">$row2[numero]</option>";}}
			   ?>
          <option value="NUEVO">NUEVO</option>
        </select></td>
      <td><div align="center"> 
          <input name="descripcion" type="text" value="<?php echo $row3[descripcion]?>" size="40" maxlength="50">
        </div></td>
      <td height="28"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif"> 
          <input type="radio" name="elegido" value="Si" <?php if ($row3[elegido]=="Si") echo "checked";?>>
          </font></div></td>
      <td> <div align="center"> 
          <input type="radio" name="elegido" value="No" <?php if ($row3[elegido]=="No") echo "checked";?>>
        </div></td>
      <td><div align="center"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="observ" type="text" value="<?php echo $row3[observ] ?>" size="80" maxlength="75">
          </font></font></font></font></div></td>
    </tr>
    <tr> 
      <td colspan="11"> <div align="center"><br>
          <input name="reg_form2" type="submit" value="MODIFICAR / ANADIR DESCRIPCION"  onClick="return validateForm1();">
        </div></td>
    </tr>
  </table>
   <br>
  <table width="80%" border="2" bgcolor="#CCCCCC" background="images/fondo.jpg" align="center" >
    <tr> 
      <td colspan="2" align="center"> 
        <table width="100%">
          <tr> 
       	<?php    $sql3 = "SELECT * FROM revision WHERE id_orden='$id_orden'";
			  $result3 = mysql_db_query($db,$sql3,$link);
			  $row3 = mysql_fetch_array($result3); ?>
			<td width="33%" height="50">
<div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Observaciones:</font></div></td>
            <td width="67%"><strong> 
              <textarea name="observaciones" cols="70" id="textarea"><?php echo $row3[observaciones] ?></textarea>
              </strong></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td width="67%" height="28" align="center"> <p align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;Responsable 
          de revision: </font><strong> 
          <select name="nomb_rrevision" id="select8">
            <option value="0"></option>
            <?php 
			  $sql0 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				 if ($row0[login_usr]==$row3[nomb_rrevision])
					echo "<option value=\"$row0[login_usr]\" selected>$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
				 else
                	echo "<option value=\"$row0[login_usr]\">$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
				}
			   ?>
          </select>
          </strong></p></td>
      <td align="center"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha:</font><strong> 
          <select name="DS" id="select">
            <?php
				   	$a1=substr($row3[fecha_rr],0,4);
					$m1=substr($row3[fecha_rr],5,2);
					$d1=substr($row3[fecha_rr],8,2);
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
          </select>
          <select name="MS" id="select2">
            <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
          </select>
          <select name="AS" id="select">
            <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
          </select>
          <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font> 
          </strong></p></td>
    </tr>
    <tr> 
      <td align="center"><p align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;Responsable 
          de Auditoria:</font><strong> 
          <select name="nomb_rauditoria" id="select3">
            <option value="0"></option>
            <?php 
			  $sql0 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				if ($row0[login_usr]==$row3[nomb_rauditoria])
					echo "<option value=\"$row0[login_usr]\" selected>$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
				 else
                	echo "<option value=\"$row0[login_usr]\">$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
                }
			   ?>
          </select>
          </strong></p></td>
      <td width="33%" align="center"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha:</font><strong> 
          <select name="DR" id="select4">
            <?php
				   	$a1=substr($row3[fecha_ra],0,4);
					$m1=substr($row3[fecha_ra],5,2);
					$d1=substr($row3[fecha_ra],8,2);
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
          </select>
          <select name="MR" id="select5">
            <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
          </select>
          <select name="AR" id="select6">
            <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
          </select>
          <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong></p></td>
    </tr>
    <tr> 
      <td height="47" colspan="2" align="center"><strong><br>
        <input name="reg_form" type="submit" id="reg_form4" value="GUARDAR CAMBIOS"  <?php print $valid->onSubmit() ?>>
        </strong></td>
    </tr>
  </table>
  </form>
  <script language="JavaScript">
		<!-- 
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['DS'], document.forms[form].elements['MS'], document.forms[form].elements['AS']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		 var cal1 = new calendar1(document.forms[form].elements['DR'], document.forms[form].elements['MR'], document.forms[form].elements['AR']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
//-->
</script>
<?php include("top_.php");?>