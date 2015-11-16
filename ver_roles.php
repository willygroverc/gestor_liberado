<?php
// Version:		1.0
// Tipo:		Perfectivo, Correctivo;
// Objetivo:	Control acceso directo No autorizado.
//				Modificacion funciones php obsoletas para version 5.3
// Fecha:		27/DIC/2012 
// Autor:		Cesar Cuenca
//______________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
else{
	header('location:login.php');
}
include("datos_gral.php");
require("conexion.php");
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table align="center" width="80%" border="0" cellpadding="0" cellspacing="0" >
  <tr> 
    <td><div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">ROLES</font></u></b></div></td>
  </tr>
</table>
<table width="80%" align="center" border="0">
  <tr> 
    <td></td>
    <td width="15%"></td>
    <td width="23%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="11%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="19%"><font color="#000000" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="18%"><font color="#0000CC" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong>LOGIN 
      :</strong></font></td>
    <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
      <?php $_REQUEST['id'];?>
      </font></td>
    <td height="20"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td height="20"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td align="right" height="20"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td height="20"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong>USUARIO 
        :</strong></font></div></td>
    <td colspan="5"> <font size="2" face="Arial, Helvetica, sans-serif"> 
      <?php 
	$sql_us="SELECT CONCAT(nom_usr,' ', apa_usr,' ', ama_usr) AS nombre FROM users WHERE login_usr='$_REQUEST[id]'";
	$res_us=mysql_query($sql_us);
	$row_us=mysql_fetch_array($res_us);
	echo $row_us['nombre'];
	$sql_rol="SELECT * FROM roles WHERE login_usr='$_REQUEST[id]'";
	$res_rol=mysql_query($sql_rol);
	$row_rol=mysql_fetch_array($res_rol);
	?>
      </font></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2"><strong><font size="2" face="Arial, Helvetica, sans-serif">GESTION- 
      PRODAT</font></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><div align="right"><?php  if($row_rol['Contratos']=="r") echo '<img src="images/si1.gif" width="10" height="10">';?></div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">CONTRATOS-PROACT<br>
      </font></td>
    <td><div align="right"> 
        <?php  if($row_rol['Clasificacion']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">CLASIFICACION</font></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><div align="right"> 
        <?php  if($row_rol['Proyectos']=="r") echo '<img src="images/si1.gif" width="10" height="10">';?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">PROYECTOS<br>
      </font></td>
    <td><div align="right"> 
        <?php  if($row_rol['Actas']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">ACTAS</font><br></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><div align="right"> 
        <?php  if($row_rol['Proveedores']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">PROVEEDORES</font></td>
    <td><div align="right"> 
        <?php  if($row_rol['Vacaciones']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">VACACIONES</font></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><div align="right"> 
        <?php  if($row_rol['PlanifEstrat']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">PLANIFICACION 
      ESTRATEGICA<br>
      </font></td>
    <td><div align="right"> 
        <?php  if($row_rol['Riesgo']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">RIESGOS</font></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><div align="right"> 
        <?php  if($row_rol['Ans']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">ANS</font><br></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><div align="right"></div></td>
    <td><br></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SOPORTE 
        TECNICO - PROAST</strong></font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><div align="right"> 
        <?php  if($row_rol['FichasTecnicas']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">FICHAS 
      TECNICAS<br>
      </font></td>
    <td><div align="right"> 
        <?php  if($row_rol['Cronograma']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">CRONOGRAMA</font></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><div align="right"> 
        <?php  if($row_rol['MantFuera']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">MANTENIMIENTO 
      FUERA<br>
      </font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif"><strong>D 
      &amp; M-PROADM&nbsp;</strong></font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><div align="right"> 
        <?php  if($row_rol['DyM']=="r"){ echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";}?>
      </div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">D &amp; M</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif"><strong>PRODUCCION 
      -PROAPD&nbsp;</strong></font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><div align="right"> 
        <?php  if($row_rol['PropyResp']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">PROPIETARIOS 
      Y RESPONSABLES</font><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><div align="right"> 
        <?php  if($row_rol['UbicacRespal']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">UBICACION 
      DE RESPALDOS</font><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><div align="right"> 
        <?php  if($row_rol['ControlTyH']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">CONTROL 
      DE TEMP &amp; HUMEDAD</font><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><div align="right"> 
        <?php  if($row_rol['Calendariza']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">CALENDARIZACION</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><div align="right"> 
        <?php  if($row_rol['ControlInvent']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">CONTROL 
      INVENTARIOS </font><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif"><strong>PROBLEMAS-PROAPI 
      &nbsp;</strong></font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><div align="right"> 
        <?php  if($row_rol['Produccion']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">PRODUCCION<br>
      </font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><div align="right"> 
        <?php  if($row_rol['DesaMante']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">D &amp; M<br>
      </font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td colspan="3"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CONTINGENCIA-PROAPC 
      &nbsp;&nbsp;</strong></font></td>
    <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php  if($row_rol['Planificacion']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
        </font></div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">PLANIFICACION</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php  if($row_rol['Evaluacion']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
        </font></div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">EVALUACION</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php  if($row_rol['Ejecucion']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
        </font></div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">EJECUCION</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php  if($row_rol['Calen_cont']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
        </font></div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">CRONOGRAMA</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SEGURIDAD-PROASI&nbsp;</strong></font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php  if($row_rol['Usuarios']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
        </font></div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">USUARIOS</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
        <?php  if($row_rol['PistasAudi']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
        </font></div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">BACKUP BD</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CAMBIOS 
      - PROACP&nbsp;</strong></font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
  <tr> 
    <td><div align="right"> 
        <?php  if($row_rol['Repositorio']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">REPOSITORIO</font></td>
    <td><div align="right"> 
        <?php  if($row_rol['Archivos']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">ARCHIVOS<br>
      </font></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><div align="right"> 
        <?php  if($row_rol['Copia_trabajo']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">COPIA DE 
      TRABAJO</font></td>
    <td><div align="right"> 
        <?php  if($row_rol['Backups']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">BACKUPS</font></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><div align="right"> 
        <?php  if($row_rol['Replica']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">REPLICA</font></td>
    <td><div align="right"> 
        <?php  if($row_rol['Pistas_fuentes']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">PISTAS 
      DE AUDITORIA</font></td>
  </tr>
  <tr> 
    <td><div align="right"> 
        <?php  if($row_rol['Revision']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">REVISION</font></td>
    <td><div align="right"> 
        <?php  if($row_rol['Maestro']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">MAESTRO 
      DE CAMBIOS</font></td>
  </tr>
  <tr> 
    <td width="14%"><div align="right"> 
        <?php  if($row_rol['Modulos']=="r") echo "<img src=\"images/si1.gif\" width=\"10\" height=\"10\">";?>
      </div></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">MODULOS</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td>&nbsp;</td>
  </tr>
  <?php 
		  $sql1="SELECT * FROM control_parametros";
		  $rs1=mysql_query($sql1);
		  $row1=mysql_fetch_array($rs1);
		  if ($row1['agencia']=="si") {
	  }
	?>
</table>
</body>
</html>
