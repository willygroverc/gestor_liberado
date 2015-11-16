<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		24/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

include("top_ver.php");
$impres=($_GET['im']);
$tipo_imp=($_GET['im2']);
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - ACUERDO DE NIVEL DE SERVICIO </title>
</head>
<body>
<p><?php
include("datos_gral.php");
?>
<table width="100%" border="0">
  <tr>
    <td><div align="center"><font size="4" face="Arial, Helvetica, sans-serif"><u><strong>ACUERDO 
        DE NIVEL DE SERVICIO</strong></u></font></div></td>
  </tr>
</table>

<br>
<table width="100%" border="1">
  <tr bgcolor="#CCCCCC"> 
    <td rowspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NUMERO</strong></font></div></td>
    <td rowspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>
	<?php if ($tipo_imp=="TECNICO" || $tipo_imp=="USUARIOS")
	   {echo "TECNICO";}
	   elseif ($tipo_imp=="PROVEEDOR" || $tipo_imp=="PROVEEDORES")
	   {echo "PROVEEDOR";}
	    elseif ($tipo_imp=="TODO" || $tipo_imp=="")
	   {echo "TECNICO / PROVEEDOR";}
	?>
	</strong></font></div>
    <div align="center"><font size="2"><font face="Arial, Helvetica, sans-serif"></font></font></div></td>
    <td rowspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>DESCRIPCION</strong></font></div>
    <div align="center"><font size="2"><font face="Arial, Helvetica, sans-serif"></font></font></div></td>
    <td colspan="3"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>RESPONSABILIDAD/ 
        PRE REQUISITOS</strong></font></div>
      <div align="center"><font size="2"><font face="Arial, Helvetica, sans-serif"></font></font></div>
    <div align="center"><font size="2"><font face="Arial, Helvetica, sans-serif"></font></font></div></td>
    <td rowspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>TIEMPO</strong></font></div>
    <div align="center"><font size="2"><font face="Arial, Helvetica, sans-serif"></font></font></div></td>
    <td rowspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>HORARIO</strong></font></div>
    <div align="center"><font size="2"><font face="Arial, Helvetica, sans-serif"></font></font></div></td>
    <td rowspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>VIGENCIA</strong></font></div>
    <div align="center"><font size="2"><font face="Arial, Helvetica, sans-serif"></font></font></div></td>
  </tr>
  <tr> 
    <td bgcolor="#CCCCCC"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CLIENTE</strong></font></div></td>
    <td bgcolor="#CCCCCC"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>
	<?php if ($tipo_imp=="TECNICO" || $tipo_imp=="USUARIOS")
	   {echo "TECNICO";}
	   elseif ($tipo_imp=="PROVEEDOR" || $tipo_imp=="PROVEEDORES")
	   {echo "PROVEEDOR";}
	    elseif ($tipo_imp=="TODO" || $tipo_imp=="")
	   {echo "TECNICO / PROVEEDOR";}
	?>
	</strong></font></div></td>
    <td bgcolor="#CCCCCC"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NEGOCIO</strong></font></div></td>
  </tr>
<?php
if ($impres=="" AND ($tipo_imp=="" OR $tipo_imp=="TODO"))
{$sql="SELECT *, DATE_FORMAT(vigencia, '%d/%m/%Y') AS vigencia FROM nivservicio";}
elseif ($impres=="" AND $tipo_imp=="USUARIOS")
{$sql="SELECT *, DATE_FORMAT(vigencia, '%d/%m/%Y') AS vigencia FROM nivservicio WHERE tip_acuerdo='T'";}
elseif ($impres=="" AND $tipo_imp=="PROVEEDORES")
{$sql="SELECT *, DATE_FORMAT(vigencia, '%d/%m/%Y') AS vigencia FROM nivservicio WHERE tip_acuerdo='P'";}
else
{$sql="SELECT *, DATE_FORMAT(vigencia, '%d/%m/%Y') AS vigencia FROM nivservicio WHERE tecnico='$impres'";}
$resul=mysql_db_query($db,$sql,$link);
while($row=mysql_fetch_array($resul))
{
	echo "<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[id_servi]</font></td>";
	if ($tipo_imp=="TECNICO" || $tipo_imp=="USUARIOS" )
	{
	$sql2="SELECT * FROM users WHERE login_usr='$row[tecnico]'";
	$resul2=mysql_db_query($db,$sql2,$link);
	$row2=mysql_fetch_array($resul2);
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row2[nom_usr]&nbsp;$row2[apa_usr]&nbsp;$row2[ama_usr]</font></td>";
	}
	elseif ($tipo_imp=="PROVEEDOR" || $tipo_imp=="PROVEEDORES")
	{
	$sql2="SELECT NombProv FROM proveedor WHERE IdProv='$row[tecnico]'";
	$resul2=mysql_db_query($db,$sql2,$link);
	$row2=mysql_fetch_array($resul2);
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row2[NombProv]</font></td>";
	}
	elseif ($tipo_imp=="TODO" || $tipo_imp=="" )
	{
	$sql2="SELECT * FROM users WHERE login_usr='$row[tecnico]'";
	$resul2=mysql_db_query($db,$sql2,$link);
	$row2=mysql_fetch_array($resul2);
	if (!empty($row2))
	{echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row2[nom_usr]&nbsp;$row2[apa_usr]&nbsp;$row2[ama_usr]</font></td>";}
	else
	{$sql2="SELECT NombProv FROM proveedor WHERE IdProv='$row[tecnico]'";
	$resul2=mysql_db_query($db,$sql2,$link);
	$row2=mysql_fetch_array($resul2);
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row2[NombProv]</font></td>";
	}}
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[desc_ser]</font></td>";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[clie_ser]</font></td>";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[especiali]</font></td>";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[negocios]</font></td>";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[tiem_ser]</font></td>";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[hora_ser]</font></td>";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[vigencia]</font></td>";
	echo "</tr>";
}	
?>
</table>
</body>
</html>