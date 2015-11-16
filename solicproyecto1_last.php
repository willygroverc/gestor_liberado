<?php
// version: 	1.0
// Tipo: 		Perfectivo, Correctivo
// Objetivo:	Control acceso directo No autorizado.
//				Modificacion funciones php obsoletas para version 5.3
// Fecha:		23/NOV/2012 
// Autor:		Cesar Cuenca
//____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if (isset($_SESSION['tipo']) && $_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
else{
	header('location:login.php');
}
require_once('funciones.php');

$Codigo=SanitizeString($_GET['Codigo']);

if (isset($_REQUEST['RETORNAR'])){header("location: lista_solicproyecto.php");}
if (isset($_REQUEST['MPLANIF'])){header("location: solicproyecto3_last.php?Codigo=$_REQUEST[var]");}
if (isset($_REQUEST['MEJECUC'])){header("location: solicproyecto4_last.php?Codigo=$_REQUEST[var]");}
if (isset($_REQUEST['MCONTROL'])){header("location: solicproyecto5_last.php?Codigo=$_REQUEST[var]");}
if (isset($_REQUEST['MCIERRE'])){header("location: solicproyecto6_last.php?Codigo=$_REQUEST[var]");}
if (isset($_REQUEST['GyC'])){	
	require("conexion.php");
            $FechSolic=$_REQUEST['AnoS'].'-'.$_REQUEST['MesS'].'-'.$_REQUEST['DiaS'];
	$FechDesignac1=$_REQUEST['Ano1'].'-'.$_REQUEST['Mes1'].'-'.$_REQUEST['Dia1'];
	$FechDesignac2=$_REQUEST['Ano2'].'-'.$_REQUEST['Mes2'].'-'.$_REQUEST['Dia2'];
	$FechDesignac3=$_REQUEST['Ano3'].'-'.$_REQUEST['Mes3'].'-'.$_REQUEST['Dia3'];
	$FechDesignac4=$_REQUEST['Ano4'].'-'.$_REQUEST['Mes4'].'-'.$_REQUEST['Dia4'];
	$FechDesignac5=$_REQUEST['Ano5'].'-'.$_REQUEST['Mes5'].'-'.$_REQUEST['Dia5'];
	$FechDesignac6=$_REQUEST['Ano6'].'-'.$_REQUEST['Mes6'].'-'.$_REQUEST['Dia6'];
	$FechDesignac7=$_REQUEST['Ano7'].'-'.$_REQUEST['Mes7'].'-'.$_REQUEST['Dia7'];
	$FechDesignac8=$_REQUEST['Ano8'].'-'.$_REQUEST['Mes8'].'-'.$_REQUEST['Dia8'];
	$FechDesignac9=$_REQUEST['Ano9'].'-'.$_REQUEST['Mes9'].'-'.$_REQUEST['Dia9'];
       
	require_once('funciones.php');
	$Requerimiento=_clean($Requerimiento);
	$LiderProyecto=_clean($LiderProyecto);
	$LiderProyUS=_clean($LiderProyUS);
	$DescProyecto=_clean($DescProyecto);
	$PropProyecto=_clean($PropProyecto);
	$FechSolic=_clean($FechSolic);
	$Criticidad=_clean($Criticidad);
	
	$Requerimiento=SanitizeString($Requerimiento);
	$LiderProyecto=SanitizeString($LiderProyecto);
	$LiderProyUS=SanitizeString($LiderProyUS);
	$DescProyecto=SanitizeString($DescProyecto);
	$PropProyecto=SanitizeString($PropProyecto);
	$FechSolic=SanitizeString($FechSolic);
	$Criticidad=SanitizeString($Criticidad);
        
        $Requerimiento=$_REQUEST['Requerimiento'];
	$LiderProyecto=$_REQUEST['LiderProyecto'];
	$LiderProyUS=$_REQUEST['LiderProyUS'];
	$DescProyecto=$_REQUEST['DescProyecto'];
	$PropProyecto=$_REQUEST['PropProyecto'];
	$Criticidad=$_REQUEST['Criticidad'];
	$sql="UPDATE solicproydatos SET Requerimiento='$Requerimiento',LiderProyecto='$LiderProyecto',LiderProyUS='$LiderProyUS',".
		 "DescProyecto='$DescProyecto',PropProyecto='$PropProyecto',FechSolic='$FechSolic',Criticidad='$Criticidad' WHERE Codigo=$_REQUEST[var]";
 
        mysql_query($sql);
	require_once('funciones.php');
	$Nombre1=_clean($Nombre1);
	$Nombre2=_clean($Nombre2);
	$Nombre3=_clean($Nombre3);
	$Nombre4=_clean($Nombre4);
	$Nombre5=_clean($Nombre5);
	$Nombre6=_clean($Nombre6);
	$Nombre7=_clean($Nombre7);
	$Nombre8=_clean($Nombre8);
	$Nombre9=_clean($Nombre9);
	
	$Nombre1=SanitizeString($Nombre1);
	$Nombre2=SanitizeString($Nombre2);
	$Nombre3=SanitizeString($Nombre3);
	$Nombre4=SanitizeString($Nombre4);
	$Nombre5=SanitizeString($Nombre5);
	$Nombre6=SanitizeString($Nombre6);
	$Nombre7=SanitizeString($Nombre7);
	$Nombre8=SanitizeString($Nombre8);
	$Nombre9=SanitizeString($Nombre9);
        
        $Nombre1=$_REQUEST['Nombre1'];
        $Nombre2=$_REQUEST['Nombre2'];
        $Nombre3=$_REQUEST['Nombre3'];
        $Nombre4=$_REQUEST['Nombre4'];
        $Nombre5=$_REQUEST['Nombre5'];
        $Nombre6=$_REQUEST['Nombre6'];
        $Nombre7=$_REQUEST['Nombre7'];
        $Nombre8=$_REQUEST['Nombre8'];
        $Nombre9=$_REQUEST['Nombre9'];
        
	$sql3 = "UPDATE solicproyresponsab SET Nombre='$Nombre1',FechDesignac='$FechDesignac1' WHERE Codigo=$_REQUEST[var] AND Responsabilid='Planificacion e Integracion'";
	$result3=mysql_query($sql3);
	$sql3 = "UPDATE solicproyresponsab SET Nombre='$Nombre2',FechDesignac='$FechDesignac2' WHERE Codigo=$_REQUEST[var] AND Responsabilid='Alcance'";
	$result3=mysql_query($sql3);
	$sql3 = "UPDATE solicproyresponsab SET Nombre='$Nombre3',FechDesignac='$FechDesignac3' WHERE Codigo=$_REQUEST[var] AND Responsabilid='Cronogramas'";
	$result3=mysql_query($sql3);
	$sql3 = "UPDATE solicproyresponsab SET Nombre='$Nombre4',FechDesignac='$FechDesignac4' WHERE Codigo=$_REQUEST[var] AND Responsabilid='Costo'";
	$result3=mysql_query($sql3);
	$sql3 = "UPDATE solicproyresponsab SET Nombre='$Nombre5',FechDesignac='$FechDesignac5' WHERE Codigo=$_REQUEST[var] AND Responsabilid='Calidad'";
	$result3=mysql_query($sql3);
	$sql3 = "UPDATE solicproyresponsab SET Nombre='$Nombre6',FechDesignac='$FechDesignac6' WHERE Codigo=$_REQUEST[var] AND Responsabilid='Recursos Humanos'";
	$result3=mysql_query($sql3);
	$sql3 = "UPDATE solicproyresponsab SET Nombre='$Nombre7',FechDesignac='$FechDesignac7' WHERE Codigo=$_REQUEST[var] AND Responsabilid='Comunicacion'";
	$result3=mysql_query($sql3);
	$sql3 = "UPDATE solicproyresponsab SET Nombre='$Nombre8',FechDesignac='$FechDesignac8' WHERE Codigo=$_REQUEST[var] AND Responsabilid='Administracion de Riesgos'";
	$result3=mysql_query($sql3);
	$sql3 = "UPDATE solicproyresponsab SET Nombre='$Nombre9',FechDesignac='$FechDesignac9' WHERE Codigo=$_REQUEST[var] AND Responsabilid='Compras'";
	$result3=mysql_query($sql3);

	header("location: solicproyecto2_last.php?Codigo=$_REQUEST[var]");	
}
else {
include ("top.php");
require_once('funciones.php');

$Codigo=SanitizeString($_GET['Codigo']);
$sql = "SELECT * FROM solicproydatos WHERE Codigo='$Codigo'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result); ?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTextNormal ( "Requerimiento",  "Requerimiento, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "LiderProyecto",  "Lider Proyecto, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "LiderProyUS",  "Lider Proyecto Sistemas, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "DescProyecto",  "Descripcion del Proyecto, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "PropProyecto",  "Proposito del Proyecto, $errorMsgJs[expresion]" );
$valid->addIsDate ( "DiaS", "MesS", "AnoS", "Fecha de Solicitud, $errorMsgJs[date]" );
$valid->addIsNotEmpty ( "Nombre1",  "Planificacion e Integracion, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "Nombre2",  "Alcance, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "Nombre3",  "Cronogramas, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "Nombre4",  "Costo, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "Nombre5",  "Calidad, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "Nombre6",  "Recursos Humanos, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "Nombre7",  "Comunicacion, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "Nombre8",  "Administracion de Riesgos, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "Nombre9",  "Compras, $errorMsgJs[expresion]" );
$valid->addIsDate ( "Dia1", "Mes1", "Ano1", "Fecha de Planificacion e Integracion, $errorMsgJs[date]" );
$valid->addIsDate ( "Dia2", "Mes2", "Ano2", "Fecha de Alcances, $errorMsgJs[date]" );
$valid->addIsDate ( "Dia3", "Mes3", "Ano3", "Fecha de Cronogramas, $errorMsgJs[date]" );
$valid->addIsDate ( "Dia4", "Mes4", "Ano4", "Fecha de Costo, $errorMsgJs[date]" );
$valid->addIsDate ( "Dia5", "Mes5", "Ano5", "Fecha de Calidad, $errorMsgJs[date]" );
$valid->addIsDate ( "Dia6", "Mes6", "Ano6", "Fecha de Recursos Humanos, $errorMsgJs[date]" );
$valid->addIsDate ( "Dia7", "Mes7", "Ano7", "Fecha de Comunicacion, $errorMsgJs[date]" );
$valid->addIsDate ( "Dia8", "Mes8", "Ano8", "Fecha de Aministracion de Riesgos, $errorMsgJs[date]" );
$valid->addIsDate ( "Dia9", "Mes9", "Ano9", "Fecha de Compras, $errorMsgJs[date]" );
print $valid->toHtml ();
?>
<table width="85%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr> 
    <td height="450"> <form name="form1" method="post" action="" onKeyPress="return Form()">
        <div align="center"> 
          <input name="var" type="hidden" value="<?php echo $Codigo;?>">
          <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
            <tr> 
              <td><div align="center"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"><strong>SOLICITUD 
                  DE PROYECTOS</strong></font></div></td>
            </tr>
          </table>
          <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
            <tr> 
              <td width="82%"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;REQUERIMIENTO 
                : 
                <input name="Requerimiento" type="text" size="55" maxlength="50" value="<?php echo $row['Requerimiento'];?>">
                </font></td>
              <td width="18%"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;CODIGO 
                : <?php require_once('funciones.php');
					$Codigo=SanitizeString($Codigo); echo $Codigo; ?></font></td>
            </tr>
          </table>
          <table width="100%" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="49%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Lider 
                Proyecto : 
                <select name="LiderProyecto">
                  <option value="0"></option>
                  <?php 
			  	$sql2 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  	$result2 = mysql_query($sql2);
			  	while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row['LiderProyecto']==$row2['login_usr'])
					echo '<option value="'.$row2['login_usr'].'" selected>'.$row2['apa_usr'].' '.$row2['ama_usr'].' '.$row2['nom_usr'].'</option>';
				else
					echo '<option value="'.$row2['login_usr'].'">'.$row2['apa_usr'].' '.$row2['ama_usr'].' '.$row2['nom_usr'].'</option>';
	            }  ?>
                </select>
                </font></td>
              <td width="51%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;Lider 
                Proyecto Sistemas : 
                <select name="LiderProyUS">
                  <option value="0"></option>
                  <?php 
			  $sql2 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear='0' ORDER BY apa_usr ASC";
			  	$result2 = mysql_query($sql2);
			  	while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row['LiderProyUS']==$row2['login_usr'])
					echo '<option value="'.$row2['login_usr'].'" selected>'.$row2['apa_usr'].' '.$row2['ama_usr'].' '.$row2['nom_usr'].'</option>';
				else
					echo '<option value="'.$row2['login_usr'].'">'.$row2['apa_usr'].' '.$row2['ama_usr'].' '.$row2['nom_usr'].'</option>';
	            }
			   ?>
                </select>
                </font></td>
            </tr>
          </table>
          <table width="100%" cellspacing="0" cellpadding="0">
            <tr> 
              <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Descripcion 
                del Proyecto : 
                <textarea name="DescProyecto" cols="100" rows="2"><?php echo $row['DescProyecto'];?></textarea>
                </font></td>
            </tr>
          </table>
          <table width="100%" cellspacing="0" cellpadding="0">
            <tr> 
              <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Proposito 
                del Proyecto&nbsp;&nbsp; :&nbsp; 
                <textarea name="PropProyecto" cols="100" rows="2"><?php echo $row['PropProyecto'];?></textarea>
                </font></td>
            </tr>
          </table>
          <table width="100%" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Fecha 
                Solicitada : 
                <select name="DiaS" id="select19">
                  <?php
  				$a1=substr($row['FechSolic'],0,4);
				$m1=substr($row['FechSolic'],5,2);
				$d1=substr($row['FechSolic'],8,2);
					for($i=1;$i<=31;$i++)
					{
	                echo '<option value="'.$i.'"'; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
                </select>
                <select name="MesS" id="select20">
                  <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                </select>
                <select name="AnoS" id="select21">
                  <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                </select>
                <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> 
                </font></td>
              <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">Criticidad 
                :
			<select name="Criticidad">
	        	<option value="1" <?php if ($row['Criticidad']=="1") echo "selected";?>>ALTA</option>
				<option value="2" <?php if ($row['Criticidad']=="2") echo "selected";?>>MEDIA</option>
        	  	<option value="3" <?php if ($row['Criticidad']=="3") echo "selected";?>>BAJA</option>
            </select>
                </font></td>
            </tr>
          </table>
          <br>
          <table width="90%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
            <tr> 
              <td width="28%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Responsabilidad</font></div></td>
              <td width="47%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombre</font></div></td>
              <td width="25%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
                  Asignacion</font></div></td>
            </tr>
          </table>
          <table width="90%" border="1" cellspacing="0" cellpadding="0">
            <tr align="center"> 
              <td width="28%"><p align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Planificacion 
                  e Integracion</font></p></td>
              <td width="47%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp; 
                  <?php $sql3 = "SELECT * FROM solicproyresponsab WHERE Codigo='$Codigo' AND Responsabilid='Planificacion e Integracion'";
				 $result3=mysql_query($sql3);
				 $row3=mysql_fetch_array($result3); ?>
                  <select name="Nombre1">
                    <option value="0"></option>
                    <?php 
			  	$sql2 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  	$result2 = mysql_query($sql2);
			  	while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row3['Nombre']==$row2['login_usr'])
					echo "<option value=\"$row2[login_usr]\" selected>$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
				else
					echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
	            }
			   ?>
                  </select>
                  </font></div></td>
              <td width="25%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="Dia1" id="select">
                    <?php 
				    $a1=substr($row3[FechDesignac],0,4);
					$m1=substr($row3[FechDesignac],5,2);
				    $d1=substr($row3[FechDesignac],8,2);
				  for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  ?>
                  </select>
                  <select name="Mes1" id="select2">
                    <?php for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  ?>
                  </select>
                  <select name="Ano1" id="select3">
                    <?php for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  ?>
                  </select>
                  <a href="javascript:cal1.popup();"> <img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> 
                  </font></div></td>
            </tr>
            <tr> 
              <td height="26"> <p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Alcance</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  &nbsp;&nbsp; 
                  <?php $sql4 = "SELECT * FROM solicproyresponsab WHERE Codigo='$Codigo' AND Responsabilid='Alcance'";
				 $result4=mysql_query($sql4);
				 $row4=mysql_fetch_array($result4); ?>
                  <select name="Nombre2">
                    <option value="0"></option>
                    <?php 
			  	$sql2 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  	$result2 = mysql_query($sql2);
			  	while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row4[Nombre]==$row2[login_usr])
					echo "<option value=\"$row2[login_usr]\" selected>$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
				else
					echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
	            }
			   ?>
                  </select>
                  </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="Dia2" id="select4">
                    <?php 
					$a1=substr($row4[FechDesignac],0,4);
					$m1=substr($row4[FechDesignac],5,2);
				    $d1=substr($row4[FechDesignac],8,2);
					for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  ?>
                  </select>
                  <select name="Mes2" id="select5">
                    <?php for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  ?>
                  </select>
                  <select name="Ano2" id="select6">
                    <?php for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  ?>
                  </select>
                  <a href="javascript:cal2.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> 
                  </font></div></td>
            </tr>
            <tr> 
              <td><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Cronogramas</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  &nbsp;&nbsp; 
                  <?php $sql5 = "SELECT * FROM solicproyresponsab WHERE Codigo='$Codigo' AND Responsabilid='Cronogramas'";
				 $result5=mysql_query($sql5);
				 $row5=mysql_fetch_array($result5); ?>
                  <select name="Nombre3">
                    <option value="0"></option>
                    <?php 
			  	$sql2 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  	$result2 = mysql_query($sql2);
			  	while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row5[Nombre]==$row2[login_usr])
					echo "<option value=\"$row2[login_usr]\" selected>$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
				else
					echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
	            }
			   ?>
                  </select>
                  </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="Dia3" id="select7">
                    <?php 
					$a1=substr($row5[FechDesignac],0,4);
					$m1=substr($row5[FechDesignac],5,2);
				    $d1=substr($row5[FechDesignac],8,2);
					for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  ?>
                  </select>
                  <select name="Mes3" id="select8">
                    <?php for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  ?>
                  </select>
                  <select name="Ano3" id="select9">
                    <?php for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  ?>
                  </select>
                  <a href="javascript:cal3.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> 
                  </font></div></td>
            </tr>
            <tr> 
              <td><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Costo</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  &nbsp;&nbsp; 
                  <?php $sql6 = "SELECT * FROM solicproyresponsab WHERE Codigo='$Codigo' AND Responsabilid='Costo'";
				 $result6=mysql_query($sql6);
				 $row6=mysql_fetch_array($result6); ?>
                  <select name="Nombre4" id="Nombre4">
                    <option value="0"></option>
                    <?php 
			  	$sql2 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  	$result2 = mysql_query($sql2);
			  	while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row6[Nombre]==$row2[login_usr])
					echo "<option value=\"$row2[login_usr]\" selected>$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
				else
					echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
	            } ?>
                  </select>
                  </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="Dia4" id="select10">
                    <?php 
				  	$a1=substr($row6[FechDesignac],0,4);
					$m1=substr($row6[FechDesignac],5,2);
				    $d1=substr($row6[FechDesignac],8,2);
				  for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  ?>
                  </select>
                  <select name="Mes4" id="select11">
                    <?php for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  ?>
                  </select>
                  <select name="Ano4" id="select12">
                    <?php for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  ?>
                  </select>
                  <a href="javascript:cal4.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> 
                  </font></div></td>
            </tr>
            <tr> 
              <td><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Calidad</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  &nbsp;&nbsp; 
                  <?php $sql7 = "SELECT * FROM solicproyresponsab WHERE Codigo='$Codigo' AND Responsabilid='Calidad'";
				 $result7=mysql_query($sql7);
				 $row7=mysql_fetch_array($result7); ?>
                  <select name="Nombre5" id="Nombre5">
                    <option value="0"></option>
                    <?php 
			  $sql2 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  	$result2 = mysql_query($sql2);
			  	while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row7[Nombre]==$row2[login_usr])
					echo "<option value=\"$row2[login_usr]\" selected>$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
				else
					echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
	            } ?>
                  </select>
                  </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="Dia5" id="select13">
                    <?php 
				  	$a1=substr($row7[FechDesignac],0,4);
					$m1=substr($row7[FechDesignac],5,2);
				    $d1=substr($row7[FechDesignac],8,2);
				  for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  ?>
                  </select>
                  <select name="Mes5" id="select14">
                    <?php for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  ?>
                  </select>
                  <select name="Ano5" id="select15">
                    <?php for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  ?>
                  </select>
                  <a href="javascript:cal5.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></div></td>
            </tr>
            <tr> 
              <td><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Recursos 
                  Humanos</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  &nbsp;&nbsp; 
                  <?php $sql8 = "SELECT * FROM solicproyresponsab WHERE Codigo='$Codigo' AND Responsabilid='Recursos Humanos'";
				 $result8=mysql_query($sql8);
				 $row8=mysql_fetch_array($result8); ?>
                  <select name="Nombre6" id="Nombre6">
                    <option value="0"></option>
                    <?php 
			  	$sql2 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  	$result2 = mysql_query($sql2);
			  	while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row8[Nombre]==$row2[login_usr])
					echo "<option value=\"$row2[login_usr]\" selected>$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
				else
					echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
	            } ?>
                  </select>
                  </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="Dia6" id="select16">
                    <?php 
				  	$a1=substr($row8[FechDesignac],0,4);
					$m1=substr($row8[FechDesignac],5,2);
				    $d1=substr($row8[FechDesignac],8,2);
				  for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  ?>
                  </select>
                  <select name="Mes6" id="select17">
                    <?php for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  ?>
                  </select>
                  <select name="Ano6" id="select18">
                    <?php for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  ?>
                  </select>
                  <a href="javascript:cal6.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></div></td>
            </tr>
            <tr> 
              <td><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Comunicacion</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  &nbsp;&nbsp; 
                  <?php $sql9 = "SELECT * FROM solicproyresponsab WHERE Codigo='$Codigo' AND Responsabilid='Comunicacion'";
				 $result9=mysql_query($sql9);
				 $row9=mysql_fetch_array($result9); ?>
                  <select name="Nombre7" id="Nombre7">
                    <option value="0"></option>
                    <?php 
			  	$sql2 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  	$result2 = mysql_query($sql2);
			  	while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row9[Nombre]==$row2[login_usr])
					echo "<option value=\"$row2[login_usr]\" selected>$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
				else
					echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
	            } ?>
                  </select>
                  </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="Dia7" id="select22">
                    <?php 
				  	$a1=substr($row9[FechDesignac],0,4);
					$m1=substr($row9[FechDesignac],5,2);
				    $d1=substr($row9[FechDesignac],8,2);
				  for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  ?>
                  </select>
                  <select name="Mes7" id="select23">
                    <?php for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  ?>
                  </select>
                  <select name="Ano7" id="select24">
                    <?php for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  ?>
                  </select>
                  <a href="javascript:cal7.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> 
                  </font></div></td>
            </tr>
            <tr> 
              <td><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Administracion 
                  de Riesgos</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  &nbsp;&nbsp; 
                  <?php $sql10 = "SELECT * FROM solicproyresponsab WHERE Codigo='$Codigo' AND Responsabilid='Administracion de Riesgos'";
				 $result10=mysql_query($sql10);
				 $row10=mysql_fetch_array($result10); ?>
                  <select name="Nombre8" id="Nombre8">
                    <option value="0"></option>
                    <?php 
			  $sql2 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  	$result2 = mysql_query($sql2);
			  	while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row10[Nombre]==$row2[login_usr])
					echo "<option value=\"$row2[login_usr]\" selected>$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
				else
					echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
	            } ?>
                  </select>
                  </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="Dia8" id="select25">
                    <?php 
				  	$a1=substr($row10[FechDesignac],0,4);
					$m1=substr($row10[FechDesignac],5,2);
				    $d1=substr($row10[FechDesignac],8,2);
				  for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  ?>
                  </select>
                  <select name="Mes8" id="select26">
                    <?php for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  ?>
                  </select>
                  <select name="Ano8" id="select27">
                    <?php for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  ?>
                  </select>
                  <a href="javascript:cal8.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> 
                  </font></div></td>
            </tr>
            <tr> 
              <td><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Compras</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  &nbsp;&nbsp; 
                  <?php $sql11 = "SELECT * FROM solicproyresponsab WHERE Codigo='$Codigo' AND Responsabilid='Compras'";
				 $result11=mysql_query($sql11);
				 $row11=mysql_fetch_array($result11); ?>
                  <select name="Nombre9" id="Nombre9">
                    <option value="0"></option>
                    <?php 
			    $sql2 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  	$result2 = mysql_query($sql2);
			  	while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row11[Nombre]==$row2[login_usr])
					echo "<option value=\"$row2[login_usr]\" selected>$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
				else
					echo "<option value=\"$row2[login_usr]\">$row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
	            } ?>
                  </select>
                  </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="Dia9" id="select28">
                    <?php 
				  	$a1=substr($row11[FechDesignac],0,4);
					$m1=substr($row11[FechDesignac],5,2);
				    $d1=substr($row11[FechDesignac],8,2);
				  for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  ?>
                  </select>
                  <select name="Mes9" id="select29">
                    <?php for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  ?>
                  </select>
                  <select name="Ano9" id="select30">
                    <?php for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  ?>
                  </select>
                  <a href="javascript:cal9.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a> 
                  </font></div></td>
            </tr>
          </table>
        </div>
        <p align="center"> 
          <input name="GyC" type="submit" id="GyC" value="GUARDAR Y CONTINUAR" <?php print $valid->onSubmit() ?>>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input name="RETORNAR" type="submit" id="RETORNAR2" value="RETORNAR">
        </p>
        <div align="center"> 
          <table width="100%" border="1">
            <tr bgcolor="#006699"> 
              <td colspan="4"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>MODIFICAR 
                  FASES</strong></font></div></td>
            </tr>
            <tr> 
              <td><div align="center"> 
                  <input name="MPLANIF" type="submit" id="MPLANIF" value="MODIFICAR PLANIFICACION">
                </div></td>
              <td><div align="center"> 
                  <input name="MEJECUC" type="submit" id="MEJECUC" value="MODIFICAR EJECUCION">
                </div></td>
              <td><div align="center"> 
                  <input name="MCONTROL" type="submit" id="MCONTROL" value="MODIFICAR CONTROL">
                </div></td>
              <td><div align="center"> 
                  <input name="MCIERRE" type="submit" id="MCIERRE" value="MODIFICAR CIERRE">
                </div></td>
            </tr>
          </table>
        </div>
      </form></td>
  </tr>
</table>
<script language="JavaScript">
		<!-- 
		 var cal1 = new calendar1(document.forms['form1'].elements['Dia1'], document.forms['form1'].elements['Mes1'], document.forms['form1'].elements['Ano1']);
			cal1.year_scroll = true;
			cal1.time_comp = false;
		 var cal2 = new calendar1(document.forms['form1'].elements['Dia2'], document.forms['form1'].elements['Mes2'], document.forms['form1'].elements['Ano2']);
			cal2.year_scroll = true;
			cal2.time_comp = false;
		 var cal3 = new calendar1(document.forms['form1'].elements['Dia3'], document.forms['form1'].elements['Mes3'], document.forms['form1'].elements['Ano3']);
			cal3.year_scroll = true;
			cal3.time_comp = false;
		 var cal4 = new calendar1(document.forms['form1'].elements['Dia4'], document.forms['form1'].elements['Mes4'], document.forms['form1'].elements['Ano4']);
			cal4.year_scroll = true;
			cal4.time_comp = false;
		 var cal5 = new calendar1(document.forms['form1'].elements['Dia5'], document.forms['form1'].elements['Mes5'], document.forms['form1'].elements['Ano5']);
			cal5.year_scroll = true;
			cal5.time_comp = false;
		 var cal6 = new calendar1(document.forms['form1'].elements['Dia6'], document.forms['form1'].elements['Mes6'], document.forms['form1'].elements['Ano6']);
			cal6.year_scroll = true;
			cal6.time_comp = false;
		 var cal7 = new calendar1(document.forms['form1'].elements['Dia7'], document.forms['form1'].elements['Mes7'], document.forms['form1'].elements['Ano7']);
			cal7.year_scroll = true;
			cal7.time_comp = false;
		 var cal8 = new calendar1(document.forms['form1'].elements['Dia8'], document.forms['form1'].elements['Mes8'], document.forms['form1'].elements['Ano8']);
			cal8.year_scroll = true;
			cal8.time_comp = false;
		 var cal = new calendar1(document.forms['form1'].elements['DiaS'], document.forms['form1'].elements['MesS'], document.forms['form1'].elements['AnoS']);
			cal.year_scroll = true;
			cal.time_comp = false;
		 var cal9 = new calendar1(document.forms['form1'].elements['Dia9'], document.forms['form1'].elements['Mes9'], document.forms['form1'].elements['Ano9']);
			cal9.year_scroll = true;
			cal9.time_comp = false;
		function Form () {
		var key = window.event.keyCode;
		if (key==13) return false;
		else return true; 
		}

		//-->
		</script>
<?php } ?> 
