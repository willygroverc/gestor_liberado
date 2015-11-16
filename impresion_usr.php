<?php 
include("conexion.php");?>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<html>
<head><title> GesTor F1 - SEGURIDAD PROASI - CONTROL DE USUARIOS </title></head>
<?php 
$ficha=($_GET['ficha']);
$nomb=($_GET['var']);?>
<center>
<form name="form1" method="get" action="" target="_blank">
<input name="var2" type="hidden" value="<?php echo $ficha?>">
  <table width="70%" border="1">
    <tr>
      <td>
	    <table width="100%" background="images/fondo.jpg">
          <tr> 
      <td bgcolor="#006699">
<div align="center"><strong><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">ELIJA 
                EL TIPO DE IMPRESION QUE DESEA</font><font size="3" face="Arial, Helvetica, sans-serif"><br>
          </font></strong></div></td>
    </tr>
    <tr> 
      <td> <div align="center"><br>
          <select name="menu1" onChange="MM_jumpMenu('parent',this,1)">
            <?php if ($nomb=="0"){
            echo "<option value=\"impresion_usr.php?var=0&num=1&ficha=".$ficha."\" selected>TODO</option>";
            } else {
            echo "<option value=\"impresion_usr.php?var=0&num=1&ficha=".$ficha."\">TODO</option>";
            }?>
            <?php if ($nomb=="1"){
            echo "<option value=\"impresion_usr.php?var=1&num=1&ficha=".$ficha."\" selected>POR USUARIO</option>";
            } else {
            echo "<option value=\"impresion_usr.php?var=1&num=1&ficha=".$ficha."\">POR USUARIO</option>";
             }?>
            <?php if ($nomb=="2"){
            echo "<option value=\"impresion_usr.php?var=2&num=1&ficha=".$ficha."\" selected>POR SISTEMA</option>";
            } else {
            echo "<option value=\"impresion_usr.php?var=2&num=1&ficha=".$ficha."\">POR SISTEMA</option>";
             }?>
          </select>
          <?php if ($nomb=="1"){?>
          <select name="usuar">
            <?php
			  include("conexion.php");
			  $sql = "SELECT * FROM users ORDER BY apa_usr ASC";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";}
			   ?>
          </select>
                  <?php } 
		if ($nomb=="2"){?>
                  <select name="sist" id="sist">
                    <?php
			  $sql2 = "SELECT Id_Sistema, Descripcion FROM sistemas a, control_usr b WHERE a.Id_Sistema = b.AplicSistema GROUP BY Id_Sistema";
			  $result2 = mysql_db_query($db,$sql2,$link);
			  while ($row2 = mysql_fetch_array($result2)) echo "<option value=\"$row2[Id_Sistema]\">$row2[Descripcion]</option>";
			   ?>
                  </select>
                  <?php }

?></div></td>
                  
    </tr>
    <tr> 
      <td><div align="center"><br>
                  <input name="IMPRE" type="button" value="   VER   " onClick="OpenPrint()">
        </div></td>
    </tr>
  </table>
	  </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</center>
</html>
<script language="JavaScript">
<!--
	function OpenPrint () {
		var form=document.form1;
		var usuario = "";
		if (form.usuar){ var usuario=form.usuar.value;
		window.open ("ver_lista_controlu.php?im=" + usuario);}
		else{ 
			if (form.sist){ var sistema=form.sist.value;
			window.open ("ver_lista_controlu.php?sis=" + sistema);}
			else window.open ("ver_lista_controlu.php?im=" + usuario);
		}
	}
-->
</script>