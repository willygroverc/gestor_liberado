<?php
if (isset($retorna))
{ header("location: lista_gestion.php?Naveg=Gestion >> Reportes y Estadisticas");
}

?>
<?php
include ("conexion.php");
include ("top.php");
?>
<p>
<font color="#FF0000" face="Arial, Helvetica, sans-serif"><strong><?php echo $msg;?></strong></font>
<table width="55%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#F4F2EA" >
  <tr> 
    <td><table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
          <tr> 
            
          <th>PANEL DE CONTROL DE REPORTES Y ESTADISTICAS</th>
          </tr>
          <tr align="center"> 
            
          <td> <table width="75%" border="0">
              <tr> 
                <td width="32%"><div align="center"><a href="panel_estadisticas.php?Naveg=Gestion >> Reportes y Estadisticas >> Estadisticas"><img src="images/estadisticas.gif" width="46" height="41" border="0"><br>
                    Estadisticas</a></div></td>
                <td width="38%"><div align="center"><a href="panel_impresiones.php?Naveg=Gestion >> Reportes y Estadisticas >> Impresiones"><img src="images/print.gif" width="36" height="29" border="0"><br>
                    Reportes</a></div></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                
              </tr>
            </table></td>
          </tr>
        </table></td>
  </tr>
</table>
<form name="form1" action="" method="post">
  <input name="retorna" type="submit" value="RETORNAR">
  <?php include("top_.php");?>
</form>
