<?php
// version: 	1.0
// Tipo: 		Perfectivo, Correctivo
// Objetivo:	Control acceso directo No autorizado.
//				Modificacion funciones php obsoletas para version 5.3
// Fecha:		23/NOV/2012 
// Autor:		Cesar Cuenca
//____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	Sanitizacion de variables para evitar ataques de SQL injection
// Fecha: 		02/OCT/2013
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if (isset($_SESSION['tipo']) && $_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
else{
	header('location:login.php');
}
include("top_ver.php");
require_once('funciones.php');
$codigo=SanitizeString($_GET['variable']);
$sql="SELECT *, DATE_FORMAT(FechSolic, '%d/%m/%Y') AS FechSolic, DATE_FORMAT(FechaPlanif, '%d/%m/%Y') AS FechaPlanif 
	 FROM solicproydatos WHERE Codigo='$codigo'";
$resul=mysql_query($sql);
$row=mysql_fetch_array($resul); 

$sql_pepe="SELECT nombre FROM control_parametros";
$res_hola=mysql_query($sql_pepe);
$row_martin=mysql_fetch_array($res_hola);
?>

<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - SOLICITUD DE PROYECTOS</title>
</head>
<body>
<div align="center"></div>
<?php
include("datos_gral.php");
?>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font size="4" face="Arial, Helvetica, sans-serif"><u>SOLICITUD DE PROYECTOS</u></font></strong></div></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="159"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CODIGO 
      DE SOLICITUD:</strong></font></td>
    <td width="61">&nbsp;&nbsp;&nbsp;&nbsp;<font face="Arial, Helvetica, sans-serif"><?php echo $row['Codigo']; ?></font>&nbsp;</td>
    <td width="417">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="121"><font size="2" face="Arial, Helvetica, sans-serif"><strong>REQUERIMIENTO:</strong></font></td>
    <td width="516"><font face="Arial, Helvetica, sans-serif"><?php echo $row['Requerimiento']; ?></font>&nbsp;</td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>

</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="155"><font size="2" face="Arial, Helvetica, sans-serif"><strong>LIDER DEL PROYECTO:</strong></font></td>
    <td width="143">&nbsp;
	  <font face="Arial, Helvetica, sans-serif">
	  <?php 
	$sql2="SELECT * FROM users WHERE login_usr='".$row['LiderProyecto']."'";
	$resul2=mysql_query($sql2);
	$row2=mysql_fetch_array($resul2);
	echo $row2['nom_usr']."&nbsp;".$row2['apa_usr']."&nbsp;".$row2['ama_usr']; ?>
    </font></td>
    <td width="169"><font size="2" face="Arial, Helvetica, sans-serif"><strong>LIDER DEL PROYECTO US:</strong></font></td>
    <td width="170">&nbsp;<font face="Arial, Helvetica, sans-serif">
      <?php
	$sql3="SELECT * FROM users WHERE login_usr='$row[LiderProyUS]'";
	$resul3=mysql_query($sql3);
	$row3=mysql_fetch_array($resul3);
	echo $row3['nom_usr']."&nbsp;".$row3['apa_usr']."&nbsp;".$row3['ama_usr']; ?>
    </font></td>
  </tr>
   <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>

</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="204"><font size="2" face="Arial, Helvetica, sans-serif"><strong>DESCRIPCION 
      DEL PROYECTO:</strong></font></td>
    <td width="433">&nbsp;<font face="Arial, Helvetica, sans-serif"><?php echo $row['DescProyecto']; ?></font></td>
  </tr>
    </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="204"><font size="2" face="Arial, Helvetica, sans-serif"><strong>PROPOSITO
      DEL PROYECTO:</strong></font></td>
    <td width="433">&nbsp;<font face="Arial, Helvetica, sans-serif"><?php echo $row['PropProyecto']; ?></font></td>
  </tr>
    </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="639" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="144"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA DE 
      SOLICITUD:</strong></font></td>
    <td width="77"><div align="center"><font face="Arial, Helvetica, sans-serif"><?php echo $row['FechSolic']; ?></font></div></td>
    <td width="418">&nbsp;</td>
  </tr>
    </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  
  </tr>
</table>
<table width="638" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="80"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CRITICIDAD:</strong></font></td>
    <td width="70"><div align="center"><font face="Arial, Helvetica, sans-serif">
	  <?php echo $row['Criticidad']; 
	/*if ($row['Criticidad']=="Alta")	
		echo "Alta";
	if ($row['Criticidad']=="Media")
		echo "Media";
	if ($row['Criticidad']=="Baja")
		echo "Baja";*/
	 
	 ?>
    </font></div></td>
    <td width="488">&nbsp;</td>
  </tr>
    </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    
  </tr>
</table>
<br>
<table width="637" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
    <th width="238"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">RESPONSABILIDAD</font></strong></div></th>
    <th width="228"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOMBRE</font></strong></div></th>
    <th width="163"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA 
        DE ASINACION </font></strong></div></th>
  </tr>
  <tr> 
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">PLANIFICACION 
        E INTEGRACION</font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
        <?php 
	$sql5="SELECT *, DATE_FORMAT(FechDesignac, '%d/%m/%Y') AS FechDesignac FROM solicproyresponsab WHERE Codigo='$codigo' AND Responsabilid='Planificacion e Integracion'";
	$resul5=mysql_query($sql5);
	$row5=mysql_fetch_array($resul5);	
	$sql4="SELECT * FROM users WHERE login_usr='$row5[Nombre]'";
	$resul4=mysql_query($sql4);
	$row4=mysql_fetch_array($resul4);
	echo $row4['nom_usr']."&nbsp;".$row4['apa_usr']."&nbsp;".$row4['ama_usr']; ?>
        </font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row5['FechDesignac']; ?></font></div></td>
  </tr>
  <tr> 
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">ALCANCE</font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
        <?php
	$sql6="SELECT *, DATE_FORMAT(FechDesignac, '%d/%m/%Y') AS FechDesignac FROM solicproyresponsab WHERE Codigo='$codigo' AND Responsabilid='Alcance'";
	$resul6=mysql_query($sql6);
	$row6=mysql_fetch_array($resul6);	
	$sql7="SELECT * FROM users WHERE login_usr='$row6[Nombre]'";
	$resul7=mysql_query($sql7);
	$row7=mysql_fetch_array($resul7);
	echo $row7['nom_usr']."&nbsp;".$row7['apa_usr']."&nbsp;".$row7['ama_usr']; ?>
        </font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row6['FechDesignac']; ?></font></div></td>
  </tr>
  <tr> 
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">CRONOGRAMAS</font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
        <?php 
	$sql8="SELECT *, DATE_FORMAT(FechDesignac, '%d/%m/%Y') AS FechDesignac FROM solicproyresponsab WHERE Codigo='$codigo' AND Responsabilid='Cronogramas'";
	$resul8=mysql_query($sql8);
	$row8=mysql_fetch_array($resul8);	
	$sql9="SELECT * FROM users WHERE login_usr='$row8[Nombre]'";
	$resul9=mysql_query($sql9);
	$row9=mysql_fetch_array($resul9);
	echo $row9['nom_usr']."&nbsp;".$row9['apa_usr']."&nbsp;".$row9['ama_usr']; ?>
        </font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row8['FechDesignac']; ?></font></div></td>
  </tr>
  <tr> 
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">COSTO</font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
        <?php  // here
	$sql10="SELECT *, DATE_FORMAT(FechDesignac, '%d/%m/%Y') AS FechDesignac FROM solicproyresponsab WHERE Codigo='$codigo' AND Responsabilid='Costo'";
	$resul10=mysql_query($sql10);
	$row10=mysql_fetch_array($resul10);	
	$sql11="SELECT * FROM users WHERE login_usr='$row10[Nombre]'";
	$resul11=mysql_query($sql11);
	$row11=mysql_fetch_array($resul11);
	echo $row11['nom_usr']."&nbsp;".$row11['apa_usr']."&nbsp;".$row11['ama_usr']; ?>
        </font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row10['FechDesignac']; ?></font></div></td>
  </tr>
  <tr> 
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">CALIDAD</font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
        <?php  
	$sql12="SELECT *, DATE_FORMAT(FechDesignac, '%d/%m/%Y') AS FechDesignac FROM solicproyresponsab WHERE Codigo='$codigo' AND Responsabilid='Calidad'";
	$resul12=mysql_query($sql12);
	$row12=mysql_fetch_array($resul12);	
	$sql13="SELECT * FROM users WHERE login_usr='$row12[Nombre]'";
	$resul13=mysql_query($sql13);
	$row13=mysql_fetch_array($resul13);
	echo $row13['nom_usr']."&nbsp;".$row13['apa_usr']."&nbsp;".$row13['ama_usr']; ?>
        </font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row12['FechDesignac']; ?></font></div></td>
  </tr>
  <tr> 
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">RECURSOS 
        HUMANOS </font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
        <?php 
	$sql14="SELECT *, DATE_FORMAT(FechDesignac, '%d/%m/%Y') AS FechDesignac FROM solicproyresponsab WHERE Codigo='$codigo' AND Responsabilid='Recursos Humanos'";
	$resul14=mysql_query($sql14);
	$row14=mysql_fetch_array($resul14);	
	$sql15="SELECT * FROM users WHERE login_usr='$row14[Nombre]'";
	$resul15=mysql_query($sql15);
	$row15=mysql_fetch_array($resul15);
	echo $row15['nom_usr']."&nbsp;".$row15['apa_usr']."&nbsp;".$row15['ama_usr']; ?>
        </font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row14['FechDesignac']; ?></font></div></td>
  </tr>
  <tr> 
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">COMUNICACION</font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
        <?php 
	$sql16="SELECT *, DATE_FORMAT(FechDesignac, '%d/%m/%Y') AS FechDesignac FROM solicproyresponsab WHERE Codigo='$codigo' AND Responsabilid='Comunicacion'";
	$resul16=mysql_query($sql16);
	$row16=mysql_fetch_array($resul16);	
	$sql17="SELECT * FROM users WHERE login_usr='$row16[Nombre]'";
	$resul17=mysql_query($sql17);
	$row17=mysql_fetch_array($resul17);
	echo $row17['nom_usr']."&nbsp;".$row17['apa_usr']."&nbsp;".$row17['ama_usr']; ?>
        </font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row16['FechDesignac']; ?></font></div></td>
  </tr>
  <tr> 
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">ADMINISTRACION 
        DE RIESGOS</font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
        <?php 
	$sql18="SELECT *, DATE_FORMAT(FechDesignac, '%d/%m/%Y') AS FechDesignac FROM solicproyresponsab WHERE Codigo='$codigo' AND Responsabilid='Administracion de Riesgos'";
	$resul18=mysql_query($sql18);
	$row18=mysql_fetch_array($resul18);	
	$sql19="SELECT * FROM users WHERE login_usr='$row18[Nombre]'";
	$resul19=mysql_query($sql19);
	$row19=mysql_fetch_array($resul19);
	echo $row19['nom_usr']."&nbsp;".$row19['apa_usr']."&nbsp;".$row19['ama_usr']; ?>
        </font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row18['FechDesignac']; ?></font></div></td>
  </tr>
  <tr> 
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">COMPRAS</font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
        <?php  
	$sql20="SELECT *, DATE_FORMAT(FechDesignac, '%d/%m/%Y') AS FechDesignac FROM solicproyresponsab WHERE Codigo='$codigo' AND Responsabilid='Compras'";
	$resul20=mysql_query($sql20);
	$row20=mysql_fetch_array($resul20);	
	$sql21="SELECT * FROM users WHERE login_usr='$row20[Nombre]'";
	$resul21=mysql_query($sql21);
	$row21=mysql_fetch_array($resul21);
	echo $row21['nom_usr']."&nbsp;".$row21['apa_usr']."&nbsp;".$row21['ama_usr']; ?>
        </font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row20['FechDesignac']; ?></font></div></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">GRUPO 
        PARA LA IMPLEMENTACION DEL PROYECTO</font></strong></div></td>
  </tr>
</table>
<table width="637" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">ESPECIALIDAD 
    DEL PROYECTO</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">EQUIPO 
    INVOLUCRADO EN EL PROYECTO</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">CONTRAPARTE 
    PARA PRUEBAS</font></strong></div></td>
  </tr>
<?php
$consul1="SELECT * FROM solicproygrupoproy WHERE Codigo='$codigo'";
//echo $consul1;
$resultado1=mysql_query($consul1);
while ($fila1=mysql_fetch_array($resultado1))
{
	echo "<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$fila1[EspecialidProy]</font></td>";
	$consul2="SELECT * FROM users WHERE login_usr='$fila1[InvolucProy]'";
	$resultado2=mysql_query($consul2);
	$fila2=mysql_fetch_array($resultado2);
	echo '<td align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'.$fila2['nom_usr'].' '.$fila2['apa_usr'].' '.$fila2['ama_usr'].'</font></td>';	
	$consul3="SELECT * FROM users WHERE login_usr='".$fila1['ContraProy']."'";
	$resultado3=mysql_query($consul3);
	$fila3=mysql_fetch_array($resultado3);
	echo '<td align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'.$fila3['nom_usr'].' '.$fila3['apa_usr'].' '.$fila3['ama_usr'].'</font></td>';
	echo "</tr>";

}
?>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">FASE 
        DE PLANIFICACION</font></strong></div></td>
  </tr>
</table>
<table width="637" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
  	<td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">No.</font></strong></div></td>
    <td width="139" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">ACTIVIDADES</font></strong></div></td>
    <td width="196" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">PLANIFICACION 
    (ANALISIS DE FACTIBILIDAD)</font></strong></div></td>
    <td colspan="3"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">APROBACION</font></strong></div>
    <div align="center"><strong></strong></div></td>
  </tr>
  <tr> 
    <td width="52" bgcolor="#CCCCCC"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SI</strong></font></div></td>
    <td width="64" bgcolor="#CCCCCC"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NO</strong></font></div></td>
    <td width="174" bgcolor="#CCCCCC"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>OBSERVACIONES</strong></font></div></td>
  </tr>
  <?php
$cons="SELECT * FROM solicproyplanif WHERE Codigo='$codigo'";
$result=mysql_query($cons);
$ass=array();
$i=1;
while ($f1=mysql_fetch_array($result))
{
	$ass[$f1['Responsabilid']]=$i;
	echo "<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;".$ass[$f1['Responsabilid']]."</font></td>";
	$i++;
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f1[Responsabilid]</font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f1[Actividades]</font></td>";	
	if ($f1['Aprobacion']=="SI")
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"> </font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/no1.gif\" border=\"1\"></font></td>";
	}
	else
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/no1.gif\" border=\"1\"></font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"></font></td>";
	}
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f1[Observac]</font></td>";	
	echo "</tr>";
}
?>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">FASE 
        DE EJECUCION</font></strong></div></td>
  </tr>
</table>
<table width="637" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
  <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">No.</font></strong></div></td>
    <td width="139" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">RESPONSABILIDAD</font></strong></div></td>
    <td width="196" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">ACTIVIDADES 
    PLANIFICADAS </font></strong></div></td>
    <td colspan="3"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">APROBACION</font></strong></div>
    <div align="center"><strong></strong></div></td>
  </tr>
  <tr> 
    <td width="52" bgcolor="#CCCCCC"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SI</strong></font></div></td>
    <td width="64" bgcolor="#CCCCCC"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NO</strong></font></div></td>
    <td width="174" bgcolor="#CCCCCC"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>OBSERVACIONES</strong></font></div></td>
  </tr>
  <?php
$cons1="SELECT * FROM solicproyejecucion WHERE Codigo='$codigo'";
$result1=mysql_query($cons1);
while ($f2=mysql_fetch_array($result1))
{
	echo "<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;".isset($ass[$f2['Responsabilid']])."</font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;".$f2['Responsabilid']."</font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;".$f2['Actividades']."</font></td>";	
	if ($f2['Aprobacion']=="SI")
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"> </font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/no1.gif\" border=\"1\"></font></td>";
	}
	else
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/no1.gif\" border=\"1\"></font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"></font></td>";
	}
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f2[Observac]</font></td>";	
	echo "</tr>";
}
?>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">FASE 
        DE CONTROL</font></strong></div></td>
  </tr>
</table>
<table width="637" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
  <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">No.</font></strong></div></td>
    <td width="139" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">RESPONSABILIDAD</font></strong></div></td>
    <td width="196" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">ACTIVIDADES 
    PLANIFICADAS </font></strong></div></td>
    <td colspan="3"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">APROBACION</font></strong></div>
    <div align="center"><strong></strong></div></td>
  </tr>
  <tr> 
    <td width="52" bgcolor="#CCCCCC"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SI</strong></font></div></td>
    <td width="64" bgcolor="#CCCCCC"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NO</strong></font></div></td>
    <td width="174" bgcolor="#CCCCCC"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>OBSERVACIONES</strong></font></div></td>
  </tr>
  <?php
$cons2="SELECT * FROM solicproycontrol WHERE Codigo='$codigo'";
$result2=mysql_query($cons2);
while ($f3=mysql_fetch_array($result2))
{
	echo "<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;".isset($ass[$f3['Responsabilid']])."</font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f3[Responsabilid]</font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f3[Actividades]</font></td>";	
	if ($f3['Aprobacion']=="SI")
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"> </font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/no1.gif\" border=\"1\"></font></td>";
	}
	else
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/no1.gif\" border=\"1\"></font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"></font></td>";
	}
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f3[Observac]</font></td>";	
	echo "</tr>";
}
?>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">FASE 
        DE CIERRE</font></strong></div></td>
  </tr>
</table>
<table width="637" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
  <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">No.</font></strong></div></td>
    <td width="139" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">RESPONSABILIDAD</font></strong></div></td>
    <td width="196" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">ACTIVIDADES 
    PLANIFICADAS </font></strong></div></td>
    <td colspan="3"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">APROBACION</font></strong></div>
    <div align="center"><strong></strong></div></td>
  </tr>
  <tr> 
    <td width="52" bgcolor="#CCCCCC"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SI</strong></font></div></td>
    <td width="64" bgcolor="#CCCCCC"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NO</strong></font></div></td>
    <td width="174" bgcolor="#CCCCCC"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>OBSERVACIONES</strong></font></div></td>
  </tr>
  <?php
$cons3="SELECT * FROM solicproycierre WHERE Codigo='$codigo'";
$result3=mysql_query($cons3);
while ($f4=mysql_fetch_array($result3))
{
	echo "<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;".isset($ass[$f4['Responsabilid']])."</font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f4[Responsabilid]</font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f4[Actividades]</font></td>";	
	if ($f4['Aprobacion']=="SI")
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"> </font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/no1.gif\" border=\"1\"></font></td>";
	}
	else
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/no1.gif\" border=\"1\"></font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"></font></td>";
	}
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f4[Observac]</font></td>";	
	echo "</tr>";
}
?>
</table>

<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="99"><font size="2" face="Arial, Helvetica, sans-serif"><strong>APROBACION:</strong></font></td>
    <td width="329">&nbsp;
	<?php 
	$sq2="SELECT * FROM users WHERE login_usr='".$row['NombAprob']."'";
	$resu2=mysql_query($sq2);
	$ro2=mysql_fetch_array($resu2);
	echo $ro2['nom_usr']."&nbsp;".$ro2['apa_usr']."&nbsp;".$ro2['ama_usr']; ?></td>
    <td width="54"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA:</strong></font></td>
    <td width="155">&nbsp;<?php if($row['FechaPlanif']!="00/00/0000") echo $row['FechaPlanif'];?></td>
  </tr>
   <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>

</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="167"><font size="2" face="Arial, Helvetica, sans-serif"><strong>COMISION 
      DE SISTEMAS:</strong></font></td>
    <td width="470">&nbsp;<?php 
	$sq3="SELECT * FROM users WHERE login_usr='$row[NombComisSist]'";
	$resu3=mysql_query($sq3);
	$ro3=mysql_fetch_array($resu3);
	echo $ro3['nom_usr']."&nbsp;".$ro3['apa_usr']."&nbsp;".$ro3['ama_usr']; ?></td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>