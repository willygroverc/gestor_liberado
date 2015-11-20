<?php 
// version: 	1.0
// Tipo: 		Perfectivo, Correctivo
// Objetivo:	Control acceso directo No autorizado.
//				Modificacion funciones php obsoletas para version 5.3
// Fecha:		17/julio/2012 
// Autor:		Alvaro Rodoriguez
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

if (isset($_REQUEST['RETORNAR'])){header("location: lista_solicproyecto.php");}
if (isset($_REQUEST['GyC'])) 
{		
	require ("conexion.php");
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
	require_once("funciones.php");
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
	$sql="INSERT INTO ".
	"solicproydatos (Requerimiento,LiderProyecto,LiderProyUS,DescProyecto,PropProyecto,FechSolic,Criticidad,NombAprob,NombComisSist,FechaPlanif) ".
	"VALUES ('$Requerimiento','$LiderProyecto','$LiderProyUS','$DescProyecto','$PropProyecto','$FechSolic','$Criticidad','$LiderProyecto','$LiderProyUS','".date('Y-m-d')."')";

        mysql_query($sql);
	$sql_c = "SELECT MAX(Codigo) AS Cod FROM solicproydatos";
	$result_c=mysql_query($sql_c);
	$row_c=mysql_fetch_array($result_c);
	$Codigo=$row_c['Cod'];
	$sql2 = "SELECT MAX(Codigo) AS Cod FROM solicproydatos";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	require_once("funciones.php");
	$row2['Cod']=_clean($row2['Cod']);
	$Nombre1=_clean($Nombre1);
	$FechDesignac1=_clean($FechDesignac1);
	$FechDesignac2=_clean($FechDesignac2);
	$FechDesignac3=_clean($FechDesignac3);
	$FechDesignac4=_clean($FechDesignac4);
	$FechDesignac5=_clean($FechDesignac5);
	$FechDesignac6=_clean($FechDesignac6);
	$FechDesignac7=_clean($FechDesignac7);
	$FechDesignac8=_clean($FechDesignac8);
	$FechDesignac9=_clean($FechDesignac9);
	
	
	$row2['Cod']=SanitizeString($row2['Cod']);
	$Nombre1=SanitizeString($Nombre1);
	$FechDesignac1=SanitizeString($FechDesignac1);
	$FechDesignac2=SanitizeString($FechDesignac2);
	$FechDesignac3=SanitizeString($FechDesignac3);
	$FechDesignac4=SanitizeString($FechDesignac4);
	$FechDesignac5=SanitizeString($FechDesignac5);
	$FechDesignac6=SanitizeString($FechDesignac6);
	$FechDesignac7=SanitizeString($FechDesignac7);
	$FechDesignac8=SanitizeString($FechDesignac8);
	$FechDesignac9=SanitizeString($FechDesignac9);
        
	$Nombre1=$_REQUEST['Nombre1'];
        $Nombre2=$_REQUEST['Nombre2'];
        $Nombre3=$_REQUEST['Nombre3'];
        $Nombre4=$_REQUEST['Nombre4'];
        $Nombre5=$_REQUEST['Nombre5'];
        $Nombre6=$_REQUEST['Nombre6'];
        $Nombre7=$_REQUEST['Nombre7'];
        $Nombre8=$_REQUEST['Nombre8'];
        $Nombre9=$_REQUEST['Nombre9'];
        
	$sql3 = "INSERT INTO solicproyresponsab (Codigo,Responsabilid,Nombre,FechDesignac) ".
    		"VALUES ('$row2[Cod]','Planificacion e Integracion','$Nombre1','$FechDesignac1')";
	$result3=mysql_query($sql3);
	$sql3 = "INSERT INTO solicproyresponsab (Codigo,Responsabilid,Nombre,FechDesignac) ".
    		"VALUES ('$row2[Cod]','Alcance','$Nombre2','$FechDesignac2')";
	$result3=mysql_query($sql3);	
	$sql3 = "INSERT INTO solicproyresponsab (Codigo,Responsabilid,Nombre,FechDesignac) ".
    		"VALUES ('$row2[Cod]','Cronogramas','$Nombre3','$FechDesignac3')";
	$result3=mysql_query($sql3);
	$sql3 = "INSERT INTO solicproyresponsab (Codigo,Responsabilid,Nombre,FechDesignac) ".
    		"VALUES ('$row2[Cod]','Costo','$Nombre4','$FechDesignac4')";
	$result3=mysql_query($sql3);
	$sql3 = "INSERT INTO solicproyresponsab (Codigo,Responsabilid,Nombre,FechDesignac) ".
    		"VALUES ('$row2[Cod]','Calidad','$Nombre5','$FechDesignac5')";
	$result3=mysql_query($sql3);
	$sql3 = "INSERT INTO solicproyresponsab (Codigo,Responsabilid,Nombre,FechDesignac) ".
    		"VALUES ('$row2[Cod]','Recursos Humanos','$Nombre6','$FechDesignac6')";
	$result3=mysql_query($sql3);
	$sql3 = "INSERT INTO solicproyresponsab (Codigo,Responsabilid,Nombre,FechDesignac) ".
    		"VALUES ('$row2[Cod]','Comunicacion','$Nombre7','$FechDesignac7')";
	$result3=mysql_query($sql3);
	$sql3 = "INSERT INTO solicproyresponsab (Codigo,Responsabilid,Nombre,FechDesignac) ".
    		"VALUES ('$row2[Cod]','Administracion de Riesgos','$Nombre8','$FechDesignac8')";
	$result3=mysql_query($sql3);
	$sql3 = "INSERT INTO solicproyresponsab (Codigo,Responsabilid,Nombre,FechDesignac) ".
    		"VALUES ('$row2[Cod]','Compras','$Nombre9','$FechDesignac9')";
	$result3=mysql_query($sql3);

	$sql_c = "SELECT MAX(Codigo) AS Cod FROM solicproydatos";
	$result_c=mysql_query($sql_c);
	$row_c=mysql_fetch_array($result_c);
	$var=$row_c['Cod'];
	if(empty($var))
		$var=1;
	header("location: solicproyecto2.php?Codigo=$var");	
}
else {
include ("top.php");
$sql_c = "SELECT MAX(Codigo) AS Cod FROM solicproydatos";
//echo $sql_c;
$result_c=mysql_query($sql_c);
$row_c=mysql_fetch_array($result_c);
$Codigo=$row_c['Cod'];
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTextNormal ( "Requerimiento",  "Requerimiento, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "LiderProyecto",  "Lider Proyecto, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "LiderProyUS",  "Lider Proyecto US, $errorMsgJs[empty]" );
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
  
echo '<table width="85%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr> 
      <td> 
        <form name="form1" method="post" action="" onKeyPress="return Form()">
		<input name="var" type="hidden" value="'; echo $Codigo; echo '">
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr>
            <td background="images/main-button-tileR1.jpg" height="20"><div align="center"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"><strong>SOLICITUD 
                DE PROYECTOS</strong></font></div></td>
          </tr>
        </table>
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td width="82%" background="images/main-button-tileR1.jpg" height="20"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;REQUERIMIENTO 
              : 
                
              <input name="Requerimiento" type="text" size="55" maxlength="50">
              </font></td>
            <td width="18%" background="images/main-button-tileR1.jpg" height="20"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;CODIGO 
              : <?php echo $Codigo ?></font></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="49%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Lider 
              Proyecto : 
              <select name="LiderProyecto">
              <option value="0"></option>';
			  $sql = "SELECT * FROM users WHERE bloquear=0 AND tipo2_usr='T' OR tipo2_usr='C' ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
	            }
			  echo '</select>
              </font></td>
            <td width="51%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;Lider 
              Proyecto Sistemas : 
              <select name="LiderProyUS">
              <option value="0"></option>';
			  $sql = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear='0' ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
	            }
			  echo '</select>
              </font></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Descripcion 
              del Proyecto : 
              <textarea name="DescProyecto" cols="100" rows="2"></textarea>
              </font></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Proposito 
              del Proyecto&nbsp;&nbsp; :&nbsp; 
              <textarea name="PropProyecto" cols="100" rows="2"></textarea>
              </font></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Fecha 
              Solicitada :'; 
			  $fsist=date("Y-m-d");
			  
              echo '<select name="DiaS" id="select19">';
                
  				$a1=substr($fsist,0,4);
				$m1=substr($fsist,5,2);
				$d1=substr($fsist,8,2);
					for($i=1;$i<=31;$i++)
					{
	                echo '<option value="'.$i.'"'; if($d1=="$i") echo "selected"; echo '>'.$i.'</option>';
					}
              echo '</select>
              <select name="MesS" id="select20">'; 
					for($i=1;$i<=12;$i++)
					  {
    	              echo '<option value="'.$i.'"'; if($m1=="$i") echo "selected"; echo '>'.$i.'</option>';
					  }
			   
              echo '</select>
              <select name="AnoS" id="select21">'; 
				for($i=2003;$i<=2020;$i++)
				      {
        	          echo '<option value="'.$i.'"'; if($a1=="$i") echo "selected"; echo'>'.$i.'</option>';
				      }
              echo '</select>
              <strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong> 
              </font></td>
            <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">Criticidad 
              :
              <select name="Criticidad">
                <option value="Alta">ALTA</option>
                <option value="Media">MEDIA</option>
                <option value="Baja">BAJA</option>
              </select>
              </font></td>
          </tr>
        </table>
        <br>
        <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td width="28%" background="images/main-button-tileR1.jpg" height="20"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Responsabilidad</font></div></td>
            <td width="47%" background="images/main-button-tileR1.jpg" height="20"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombre</font></div></td>
            <td width="25%" background="images/main-button-tileR1.jpg" height="20"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
                Asignacion</font></div></td>
          </tr>
        </table>
          
        <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
          <tr> 
              <td width="28%"><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Planificacion 
                e Integracion</font></p></td>
              <td width="47%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp; 
                <select name="Nombre1">
                  <option value="0"></option>';
                  
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
	            }
                echo '</select>
                </font></div></td>
              <td width="25%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                <select name="Dia1" id="select">'; 
				  for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
                echo '</select>
                <select name="Mes1" id="select2">';
				  for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
                echo '</select>
                <select name="Ano1" id="select3">';
				  for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  
                echo '</select>
                <strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong> 
                </font></div></td>
            </tr>
            <tr> 
              <td><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Alcance</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                &nbsp;&nbsp; 
                <select name="Nombre2">
                  <option value="0"></option>';
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
	            }
                echo '</select>
                </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                <select name="Dia2" id="select4">';
				  for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  
                echo '</select>
                <select name="Mes2" id="select5">';
					for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  
                echo '</select>
                <select name="Ano2" id="select6">';
				  for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  
                echo '</select>
                <strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal2.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong> 
                </font></div></td>
            </tr>
            <tr> 
              <td><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Cronogramas</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                &nbsp;&nbsp; 
                <select name="Nombre3">
                  <option value="0"></option>';
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
	            }
                echo '</select>
                </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                <select name="Dia3" id="select7">';
					for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  
                echo '</select>
                <select name="Mes3" id="select8">';
					for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  
                echo '</select>
                <select name="Ano3" id="select9">';
					for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  
                echo '</select>
                <strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal3.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong> 
                </font></div></td>
            </tr>
            <tr> 
              <td><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Costo</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                &nbsp;&nbsp; 
                <select name="Nombre4" id="Nombre4">
                  <option value="0"></option>';
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
	            }
                echo '</select>
                </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                <select name="Dia4" id="select10">';
					for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  
                echo '</select>
                <select name="Mes4" id="select11">';
					for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  
                echo '</select>
                <select name="Ano4" id="select12">';
					for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  
                echo '</select>
                <strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal4.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong> 
                </font></div></td>
            </tr>
            <tr> 
              <td><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Calidad</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                &nbsp;&nbsp; 
                <select name="Nombre5" id="Nombre5">
                  <option value="0"></option>';
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
	            }
                echo '</select>
                </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                <select name="Dia5" id="select13">';
					for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  
                echo '</select>
                <select name="Mes5" id="select14">';
					for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  
                echo '</select>
                <select name="Ano5" id="select15">';
					for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  
                echo '</select>
                <strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal5.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong> 
                </font></div></td>
            </tr>
            <tr> 
              <td><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Recursos 
                  Humanos</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                &nbsp;&nbsp; 
                <select name="Nombre6" id="Nombre6">
                  <option value="0"></option>';
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
	            }
                echo '</select>
                </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                <select name="Dia6" id="select16">';
					for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  
                echo '</select>
                <select name="Mes6" id="select17">';
                   for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  
                echo '</select>
                <select name="Ano6" id="select18">';
					for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  
                echo '</select>
                <strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal6.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong> 
                </font></div></td>
            </tr>
            <tr> 
              <td><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Comunicacion</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                &nbsp;&nbsp; 
                <select name="Nombre7" id="Nombre7">
                  <option value="0"></option>';
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
	            }
                echo '</select>
                </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                <select name="Dia7" id="select22">';
					for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  
                echo '</select>
                <select name="Mes7" id="select23">';
					for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  
                echo '</select>
                <select name="Ano7" id="select24">';
					for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  
                echo '</select>
                <strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal7.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong> 
                </font></div></td>
            </tr>
            <tr> 
              <td><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Administracion 
                  de Riesgos</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                &nbsp;&nbsp; 
                <select name="Nombre8" id="Nombre8">
                  <option value="0"></option>';
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
	            }
                echo '</select>
                </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                <select name="Dia8" id="select25">';
					for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  
                echo '</select>
                <select name="Mes8" id="select26">';
					for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  
                echo '</select>
                <select name="Ano8" id="select27">';
					for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  
                echo '</select>
                <strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal8.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong> 
                </font></div></td>
            </tr>
            <tr> 
              <td><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Compras</font></p></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                &nbsp;&nbsp; 
                <select name="Nombre9" id="Nombre9">
                  <option value="0"></option>';
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear='0' ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
	            }
                echo '</select>
                </font></div></td>
              <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                <select name="Dia9" id="select28">';
					for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  
                echo '</select>
                <select name="Mes9" id="select29">';
					for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  
                echo '</select>
                <select name="Ano9" id="select30">';
					for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  
                echo '</select>
                <strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal9.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></font></div></td>
            </tr>
            
          </table>
         <div align="center"><br>
            <input name="GyC" type="submit" id="GyC" value="GUARDAR Y CONTINUAR"';  print $valid->onSubmit(); echo '>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <input name="RETORNAR" type="submit" id="RETORNAR2" value="RETORNAR">
          </div>
        </form>
    </td>
  </tr>
</table>';?>
  <script language="JavaScript">
		<!-- 
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['DiaS'], document.forms[form].elements['MesS'], document.forms[form].elements['AnoS']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['Dia1'], document.forms[form].elements['Mes1'], document.forms[form].elements['Ano1']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
		var cal2 = new calendar1(document.forms[form].elements['Dia2'], document.forms[form].elements['Mes2'], document.forms[form].elements['Ano2']);
		 	cal2.year_scroll = true;
			cal2.time_comp = false;
		var cal3 = new calendar1(document.forms[form].elements['Dia3'], document.forms[form].elements['Mes3'], document.forms[form].elements['Ano3']);
		 	cal3.year_scroll = true;
			cal3.time_comp = false;
		var cal4 = new calendar1(document.forms[form].elements['Dia4'], document.forms[form].elements['Mes4'], document.forms[form].elements['Ano4']);
		 	cal4.year_scroll = true;
			cal4.time_comp = false;
		var cal5 = new calendar1(document.forms[form].elements['Dia5'], document.forms[form].elements['Mes5'], document.forms[form].elements['Ano5']);
		 	cal5.year_scroll = true;
			cal5.time_comp = false;
		var cal6 = new calendar1(document.forms[form].elements['Dia6'], document.forms[form].elements['Mes6'], document.forms[form].elements['Ano6']);
		 	cal6.year_scroll = true;
			cal6.time_comp = false;
		var cal7 = new calendar1(document.forms[form].elements['Dia7'], document.forms[form].elements['Mes7'], document.forms[form].elements['Ano7']);
		 	cal7.year_scroll = true;
			cal7.time_comp = false;
		var cal8 = new calendar1(document.forms[form].elements['Dia8'], document.forms[form].elements['Mes8'], document.forms[form].elements['Ano8']);
		 	cal8.year_scroll = true;
			cal8.time_comp = false;
		var cal9 = new calendar1(document.forms[form].elements['Dia9'], document.forms[form].elements['Mes9'], document.forms[form].elements['Ano9']);
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