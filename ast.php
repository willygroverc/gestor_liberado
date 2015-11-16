<?php include("top.php");
include("top_gestion.php");?>
<?php
if (isset($reg_form2))
{
	if ($medio_ret == "Impreso")
{
	$medio_dest = "Triturado";
}

	$tiempo_ret="$numero $tiempo";
	$sql4="INSERT INTO ".
	"informacionast(des_infAST,clasifi,tiempo_ret,medio_ret,medio_dest,control_dest,acta_dest,control,tecnico) ".
	"VALUES('$des_infAST','$clasifi','$tiempo_ret','$medio_ret','$medio_dest','$control_dest','$acta_dest','$control','$tecnico')";
	mysql_db_query($db,$sql4,$link);
//    header("location: ast.php")
}
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
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#EAEAEA"  background="images/fondo.jpg">   
   	<form name="form1" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
	  <table width="182%" border="2">
	  <tr bgcolor="#006699"> 
	  	   <td colspan="9"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CLASIFICACION 
          DE LA INFORMACION MANEJADA POR EL AST</font></div></td>
    </tr>
    <tr> 
      <td width="7%" rowspan="2" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tecnico</font></div></td>
      <td width="7%" rowspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Descripcion</font></div></td>
      <td width="9%" rowspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Clasificacion 
          </font></div></td>
      <td colspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Retencion</font></div></td>
      <td colspan="3" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Destruccion</font></div></td>
      <td width="18%" rowspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Control</font></div></td>
    </tr>
    <tr> 
      <td width="14%" height="17" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tiempo</font></div></td>
      <td width="11%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Medio</font></div></td>
      <td width="10%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Medio</font></div></td>
      <td width="12%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Control</font></div></td>
      <td width="12%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Acta</font></div></td>
    </tr>
    <?php
		$sql = "SELECT * FROM informacionast  ORDER BY id_infAST ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
    <tr> 
      <td><?php echo $row[tecnico]?></td>
      <td><?php echo $row[des_infAST]?></td>
      <td><?php echo $row[clasifi]?></td>
      <td><?php echo $row[tiempo_ret]?></td>
      <td><?php echo $row[medio_ret]?></td>
      <td><?php echo $row[medio_dest]?></td>
      <td><?php echo $row[control_dest]?></td>
      <td><?php echo $row[acta_dest]?></td>
      <td>&nbsp;<?php echo $row[control]?></td>
    </tr>
    <?php
		 }
		 ?>
  </table>
    <p>&nbsp;</p>
    
  <table width="182%" border="2">
    <tr> 
      <td width="4%" rowspan="2" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tecnico</font></div></td>
      <td width="10%" rowspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Descripcion</font></div></td>
      <td width="8%" rowspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Clasificacion</font></div></td>
      <td colspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Retencion</font></div></td>
      <td colspan="3" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Destrucion 
          </font></div></td>
      <td width="13%" rowspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Control</font></div></td>
    </tr>
    <tr> 
      <td width="17%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tiempo</font></div></td>
      <td width="9%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Medio</font></div></td>
      <td width="10%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Medio</font></div></td>
      <td width="11%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Control</font></div></td>
      <td width="18%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Acta</font></div></td>
    </tr>
    <tr> 
      <td rowspan="2"><select name="tecnico" id="select">
          <option value="0"></option>
          <?php 
			  include ("conexion.php");
			  $link = mysql_connect($host,$user,$pass) or die ("Error durante la conexion a la base de datos"); 
			  $sql = "SELECT * FROM users WHERE tipo2_usr='T' ORDER BY apa_usr ASC";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            }
			   ?>
        </select></td>
      <td rowspan="2"> <div align="center"> 
          <textarea name="des_infAST" cols="15"></textarea>
        </div></td>
      <td rowspan="2"><div align="center"> 
          <select name="clasifi">
            <option value="Confidencial">Confidencial</option>
            <option value="Reservada">Reservada</option>
            <option value="Interna">Interna</option>
            <option value="Publica">Publica</option>
          </select>
        </div></td>
      <td rowspan="2"> <div align="center"> 
          <input name="numero" type="text" size="5">
          <select name="tiempo">
            <option value="Dias">Dias</option>
            <option value="Semanas">Semanas</option>
            <option value="Meses">Meses</option>
            <option value="Anos">Anos</option>
          </select>
        </div></td>
      <td height="35"> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif"> 
          <input type="radio" name="medio_ret" value="Impreso" id="1">
          Impreso</font></div></td>
      <td><div align="center"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          </font></font></font></font></div></td>
      <td rowspan="2"><div align="center"> 
          <select name="control_dest">
            <option value="Dual">Dual</option>
            <option value="Personal">Personal</option>
          </select>
        </div></td>
      <td rowspan="2"><div align="center"> 
          <input name="acta_dest" type="text" size="20">
        </div></td>
      <td rowspan="2"><div align="center"> 
          <input name="control" type="text" size="20">
        </div></td>
    </tr>
    <tr> 
      <td><div align="center"> <font size="1" face="Arial, Helvetica, sans-serif"> 
          <input type="radio" name="medio_ret" value="Digitalizado" id="2">
          Digitalizado</font></div></td>
      <td><p align="center"> <font size="1" face="Arial, Helvetica, sans-serif"> 
          </font><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          </font><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <input type="radio" name="medio_dest" value="Triturado">
          </font></font></font></font><font size="1" face="Arial, Helvetica, sans-serif"> 
          </font></font></font><font size="1"></font></font><font size="1" face="Arial, Helvetica, sans-serif">Triturado</font></p>
        <p align="center"> <font size="1" face="Arial, Helvetica, sans-serif"> 
          <input type="radio" name="medio_dest" value="Picado">
          Picado </font></p></td>
    </tr>
    <tr> 
      <td colspan="10"> <div align="center"> 
          <input name="reg_form2" type="submit" id="reg_form2" value="ANADIR">
        </div></td>
    </tr>
  </table>
    <font size="1" face="Arial, Helvetica, sans-serif"> </font> 
    <p>&nbsp;</p>
  </form>
<p>&nbsp;</p>
<p> <br>
</p>
<?php include("top_.php");?>