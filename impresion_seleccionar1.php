<?php
include ("conexion.php");
$sql="SELECT login_usr, CONCAT(nom_usr, ' ', apa_usr, ' ', ama_usr) AS nombre FROM users WHERE tipo2_usr='T' ORDER BY apa_usr";
$rs=mysql_db_query($db,$sql,$link);
while ($tmp=mysql_fetch_array($rs)) {
	$lstTecnico[$tmp[login_usr]]=$tmp[nombre];
}

$sql="SELECT DISTINCT area_usr as area FROM users ORDER BY area_usr";
$rs=mysql_db_query($db,$sql,$link);
while ($tmp=mysql_fetch_array($rs)) {
	$lstArea[$tmp[area]]=$tmp[area];
}
?>
<html>
<head>
	<title>IMPRESION</title>
	<style>
	input {
	font-family:Verdana, Arial; Font-size: 8pt;
	}
	</style>
</head>

<?php
if ( isset($enviar) )
{	if ( isset($genaral))
	{
	
	}	

}
	
?>

<body topmargin="0" background="images/fondo.jpg">
<form action="impresion_seleccionar1.php" method="POST" name="form1" target="_blank">
  <table width="94%" border="1" align="center">
    <tr>
      <td height="158"> 
        <table width="103%" height="151%" >
          <tr> 
            <td height="21" colspan="4" bgcolor="#006699"> 
              <div align="center"><strong><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">ELIJA 
                EL TIPO DE IMPRESION QUE DESEA</font><font size="3" face="Arial, Helvetica, sans-serif"><br>
                </font></strong></div></td>
          </tr>
          <tr> 
            <td width="12%" height="58" align="right">&nbsp;</td>						
            <td width="76%" align="left">
			<INPUT type=checkbox  value=1  name=general checked>
              <font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000099">General&nbsp;&nbsp;&nbsp;</font>
              <INPUT  type=checkbox value=2 name=tipo >
			  <font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000099">Tipo de Usuario&nbsp;&nbsp;&nbsp;</font>
			<INPUT  type=checkbox value=3 name=area>
			<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000099">Area</font>
			<INPUT  type=submit value='Elegir Opción'  name=enviar>
			<hr>
			</td>
            <td width="12%" align="left">			
			</td>
          </tr>
          <tr> 
            <td colspan="3">
			
			
			</td>
          </tr>
        </table>
	  </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<script language="JavaScript">
<!--
	function OpenPrint () {
		var form=document.form1;
		if (form.menu.value==0) {
			alert ("Debe seleccionar una opcion valida.\n\nMensaje generado por YanapTI.");
			return false;
		}		
		window.open ( "ver_usuarios.php?menu=" + form.menu.value + "");
		return false;	
	}
-->
</script>
<center>
<?php include("top_.php");?>
</center>
</body>
</html>