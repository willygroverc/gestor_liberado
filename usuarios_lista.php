<?php 
include("top.php");
$_SESSION['modulo']='usuarios';
?>
<script language="javascript" src="js/usuarios.js"></script>
<script language="javascript" src="js/ajax.js"></script>
  <table border="1" align="center" bgcolor="#006699">
    <tr> 
		<td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Agencia:</font></td>
		<td><?php include('lib/cmb_agencia.php');?></td>
		<td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Area:</font></td>
		<td><?php include('lib/cmb_area.php');?></td>
		<td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Con las palabras:</font></td>
		<td><input type="text" id="txt_busq" name="txt_busq" onkeyup="filtrar_usuarios();"></td>
    </tr>
  </table>
<input name="pg" id="pg" type="hidden" size="5" value="1"></input>
<table width="95%" border="1" align="center" background="images/fondo.jpg">
  <tr align="center"> 
    <th colspan="13">LISTA DE USUARIOS</th>
  </tr>
  <tr align="center" bgcolor="#006699">
	  <td colspan="13">
		<table>
		<tr>
			<td width="272" align="center">&nbsp;<font color="#FFFFFF">USUARIOS CON CUENTA BLOQUEADA</font></td>
			<td width="187" align="center">&nbsp;<font color="#FFFFFF">USUARIOS INTERNOS</font></td>
			<td width="180" align="center">&nbsp;<font color="#FFFFFF">USUARIOS EXTERNOS</font></td>
			<td width="163" align="center">&nbsp;<font color="#FFFFFF">USUARIOS ELIMINADOS</font></td>
		</tr>
		<tr>
		    <td height="21" align="center">&nbsp;<input type="checkbox"  name="usrbloq" id="usrbloq" onClick="filtrar_usuarios();" checked></td>
		    <td align="center">&nbsp;<input type="checkbox" name="usrint" id="usrint" onClick="filtrar_usuarios()" checked></td>
		    <td align="center">&nbsp;<input type="checkbox" name="usrext" id="usrext" onClick="filtrar_usuarios()" checked></td>
		    <td align="center">&nbsp;<input type="checkbox" name="usrelim" id="usrelim" onClick="filtrar_usuarios()" checked></td>
		</tr>
		</table>
	</td>
  </tr>
  </table>
  <div id="tbl_ajax"></div>
<script language="JavaScript">
filtrar_usuarios();
function openStat_2() {
	window.open("impresion_seleccionar.php",'Usuarios', 'width=590,height=180,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
function ver_roles(login){
	open("ver_roles.php?id="+login, "Roles", 'width=800,height=500,status=no,resizable=yes,top=50,left=50,dependent=yes,alwaysRaised=yes,Scrollbars=yes')
}
</script>