<?php 
//Descripcion: archivo modificado para corregir algunas funciones obsoletas de php4
//Fecha: 17/10/2013
//Autor: Alvaro Rodriguez
//Version: 1.0
session_start();	
if(!empty($_SESSION["path_backup"])) $path_backup = $_SESSION["path_backup"];
if(!empty($_SESSION["path"])) $dir = $_SESSION["path"];
if(!empty($_SESSION["path_pistas"])) $path_pistas=$_SESSION["path_pistas"];
include ("conexion.php");	
require_once('funciones.php');
if (isset($retornar)){ header("location: lista_backups.php");}
if ( !(empty($guardar)) )
{	include ("funciones.inc.php");
	if (strlen($DA) == 1){ $DA = "0".$DA; }
	if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
	$fec1 = $AA."-".$MA."-".$DA;   
	if (strlen($DE) == 1){ $DE = "0".$DE; }
	if (strlen($ME) == 1){ $ME = "0".$ME; }
	$fec2 = $AE."-".$ME."-".$DE; 
	$sql = "SELECT * FROM modulo";
	$res = mysql_db_query($db, $sql, $link);
	if ( mysql_num_rows ($res) > 0 )
	{	if ((ereg('^([0-9a-zA-Z_ -]{1,255})+$',$nom_back))) 
	  	{	$login = $_SESSION["login"];
			$sql02 = "SELECT * FROM users WHERE login_usr='$login'";
			$result02 = mysql_db_query($db,$sql02,$link);
			$row02 = mysql_fetch_array($result02);
			$nombre_usr = $row02['nom_usr']." ".$row02['apa_usr']." ".$row02['ama_usr'];
			switch ($opcion) 
			{	case "todo":
				if ( $eliminar == "1")					
				{ 	$estado = EnProceso($db, $link);
					if ( $estado == 0 )	
					{	BorrarDatos("modulo", $db, $link);
						BorrarDatos("datos_archivos", $db, $link);
						BorrarDatos("versiones", $db, $link);
						BorrarDatos("control_archivos", $db, $link);
						BorrarDatos("asignacion_cvs", $db, $link);
						BorrarDatos("archivos_eliminados", $db, $link);
						BorrarDatos("modulos_eliminados", $db, $link);
						BorrarDatos("versiones_eliminadas", $db, $link);
						deldir($dir."/replica");
						deldir($dir."/trash");
						mkdir($path_backup."/$nom_back"."_".$nom_c,0777);	
						CopiaDir($dir, $path_backup."/$nom_back"."_".$nom_c, $eliminar);
						$medio_otro = strtoupper($medio_otro);
						if ( $op_medio == "0" ) $sql2 = "INSERT INTO `gestor_edv_ori`.`controlinvent` (
						`Codigo` ,
						`FechaAlta` ,
						`FechaBaja` ,
						`FechaDestruc` ,
						`Observ` ,
						`codigo_usu` ,
						`tipo_medio` ,
						`tipo_dato` ,
						`nro_cds` ,
						`nro_corre`
						)
						VALUES (
						NULL , '".date("Y-m-d")."', '0000-00-00', '0000-00-00', '$obs', '0', '$medio', '0', '0', '0'
						)";
						
						
						else  $sql2 = "INSERT INTO `gestor_edv_ori`.`controlinvent` (
						`Codigo` ,
						`FechaAlta` ,
						`FechaBaja` ,
						`FechaDestruc` ,
						`Observ` ,
						`codigo_usu` ,
						`tipo_medio` ,
						`tipo_dato` ,
						`nro_cds` ,
						`nro_corre`
						)
						VALUES (
						NULL , '".date("Y-m-d")."', '0000-00-00', '0000-00-00', '$obs', '0', '$medio', '0', '0', '0'
						)";
						mysql_query($sql2);
						$sql2 = "SELECT MAX(Codigo) as id_medio FROM controlinvent"; 
						$res2 = mysql_db_query($db,$sql2,$link);
						$row2 = mysql_fetch_array($res2);
						$nomb = $nom_back."_".$nom_c;
						$sql = "INSERT INTO backups ( id_medio,nom_back,tipo_back, estado_back,fecha_creacion,login_back)".
						   "VALUES ('$row2[id_medio]','$nomb','Backup General','$eliminar','".date("Y-m-d")."','$login')";
						if (mysql_db_query($db,$sql,$link))			
						{	if ($eliminar == "1"){$observaciones = "El backup fue realizado con la opcion de eliminacion";}
							else{ $observaciones = "El backup fue realizado con la opcion de no eliminacion";}
							$sql01 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,observaciones)".
									"VALUES ('".date("Y-m-d")."','".date("H:i:s")."','Backup General','$nombre_usr','$observaciones')";
							$rst01 = mysql_db_query($db,$sql01,$link);
							header("location:lista_backups.php");
						}	
					}
					else $msg = "No se puede eliminar porque hay archivos en proceso de modificacion";
				}
				else 
				{	mkdir($path_backup."/$nom_back"."_".$nom_c,0777);	
					CopiaDir($dir, $path_backup."/$nom_back"."_".$nom_c, $eliminar);
					$medio_otro = strtoupper($medio_otro);
					if ( $op_medio == "0" ) $sql2 = "INSERT INTO "."controlinvent(FechaAlta,Tipo,Observ) VALUES('".date("Y-m-d")."','$medio_otro','$obs')";
					else  $sql2 = "INSERT INTO "."controlinvent(FechaAlta,Tipo,Observ) VALUES('".date("Y-m-d")."','$medio','$obs')";
					mysql_db_query($db,$sql2,$link);
					$sql2 = "SELECT MAX(Codigo) as id_medio FROM controlinvent"; 
					$res2 = mysql_db_query($db,$sql2,$link);
					$row2 = mysql_fetch_array($res2);
					$nomb = $nom_back."_".$nom_c;
					$sql = "INSERT INTO backups ( id_medio,nom_back,tipo_back, estado_back,fecha_creacion,login_back)".
							"VALUES ('$row2[id_medio]','$nomb','Backup General','$eliminar','".date("Y-m-d")."','$login')";
					if (mysql_db_query($db,$sql,$link))			
					{	if ($eliminar == "1"){$observaciones = "El backup fue realizado con la opcion de eliminacion";}
						else{$observaciones = "El backup fue realizado con la opcion de no eliminacion";}
						$sql01 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,observaciones)".
						"VALUES ('".date("Y-m-d")."','".date("H:i:s")."','Backup General','$nombre_usr','$observaciones')";
						$rst01 = mysql_db_query($db,$sql01,$link);
						header("location:lista_backups.php");
					}	
				}
				break;
				case "fechas":
				$condicion = "d.fecha_creado BETWEEN '$fec1' AND '$fec2'";
				$sql = "SELECT * FROM datos_archivos as d, modulo as m WHERE $condicion AND d.id_mod = m.id_mod AND d.eliminado<>1";
				
				$res = mysql_db_query($db,$sql,$link);
				if (mysql_num_rows($res) > 0)
				{	mkdir($path_backup."/$nom_back"."_".$nom_c,0777);			
					$dir_des = $path_backup."/$nom_back"."_".$nom_c;
					while ( $row = mysql_fetch_array($res) )
					{	$dir_ini = $dir."/".$row['nombre_mod']."/".$row['ombre_arch'];
						$dir2 = opendir($dir_des);
						$existe = 0;
						while ($elemento = readdir($dir2))
						{	if ($elemento == $row['nombre_mod']) $existe++; }
						if ($existe == 0)
						mkdir($dir_des."/".$row['nombre_mod'],0777);										
						$dir_cp = $dir_des."/".$row['nombre_mod']."/".$row['nombre_arch'];
						if ( !copy($dir_ini,$dir_cp) )	
						$msg = "Error en la copia, no se encuentra uno de los archivos";
					}
					//=== PARA GUARDAR LAS PISTAS
					$v_pista = explode("/",$path_pistas); 
					$pistas = $v_pista[count($v_pista)-1];
					$existe = 0;
					$sql3 = "SELECT * FROM registro_pistas WHERE fecha_pista BETWEEN '$fec1' AND '$fec2'";
					$res3 = mysql_db_query($db,$sql3,$link);
					if (mysql_num_rows($res3) > 0)
					{	mkdir($path_backup."/"."$nom_back"."_".$nom_c."/".$pistas,0777);
						while ( $row3 = mysql_fetch_array($res3) )
						{ 	$dir_p = opendir($path_pistas);
							$archi = $row3['ombre_pista'].".frm";
							$archi2 = $row3['nombre_pista'].".MYD";
							while ($elemento = readdir($dir_p))
							{	if ($elemento == $archi or $elemento == $archi2 ) 
								{	if ( !copy($path_pistas."/".$elemento, $path_backup."/"."$nom_back"."_".$nom_c."/".$pistas."/".$elemento) )							
									$msg = "Error en la copia, no se encuentra uno de los archivos";
								}	
							}
						}				
					}
					/// 
					$medio_otro = strtoupper($medio_otro);
					if ( $op_medio == "0" ) $sql2 = "INSERT INTO "."controlinvent(FechaAlta,Tipo,Observ) VALUES('".date("Y-m-d")."','$medio_otro','$obs')";
					else   $sql2 = "INSERT INTO "."controlinvent(FechaAlta,Tipo,Observ) VALUES('".date("Y-m-d")."','$medio','$obs')";
					mysql_db_query($db,$sql2,$link);
					$sql2 = "SELECT MAX(Codigo) as id_medio FROM controlinvent"; 
					$res2 = mysql_db_query($db,$sql2,$link);
					$row2 = mysql_fetch_array($res2);
					$id_medio = $row2['id_medio'];
					$nomb = $nom_back."_".$nom_c;				
					$sql = "INSERT INTO backups (id_medio,nom_back,tipo_back, estado_back,fecha_creacion,fec_del_back, fec_al_back, login_back)".
							"VALUES ('$id_medio','$nomb','Backup General por Fechas','0','".date("Y-m-d")."','$fec1','$fec2','$login')";
					if (mysql_db_query($db,$sql,$link))
					{	$observaciones="El backup fue realizado desde la fecha ".$fec1." hasta ".$fec2;
						$sql01 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,observaciones)".
								"VALUES ('".date("Y-m-d")."','".date("H:i:s")."','Backup General por Fechas','$nombre_usr','$observaciones')";
						$rst01 = mysql_db_query($db,$sql01,$link);
						header("location:lista_backups.php");
					}						
				}
				else $msg = "No hay archivos para copiar";	
				break;	
				case "mod":
				if (empty($modulo)) $msg = "Modulo no puede ser vacio";
				else					
				{	mkdir($path_backup."/$nom_back"."_".$nom_c,0777);
					mkdir($path_backup."/$nom_back"."_".$nom_c."/".$modulo,0777);
					$eliminar="0";
					CopiaDir($dir."/".$modulo, $path_backup."/$nom_back"."_".$nom_c."/".$modulo, "0");
					$medio_otro = strtoupper($medio_otro);
					if ( $op_medio == "0" ) $sql2 = "INSERT INTO "."controlinvent(FechaAlta,Tipo,Observ) VALUES('".date("Y-m-d")."','$medio_otro','$obs')";
					else   $sql2 = "INSERT INTO "."controlinvent(FechaAlta,Tipo,Observ) VALUES('".date("Y-m-d")."','$medio','$obs')";
					mysql_db_query($db,$sql2,$link);
					$sql2 = "SELECT MAX(Codigo) as id_medio FROM controlinvent"; 
					$res2 = mysql_db_query($db,$sql2,$link);
					$row2 = mysql_fetch_array($res2);
					$id_medio = $row2['id_medio'];
					$nomb = $nom_back."_".$nom_c;			
					$sql = "INSERT INTO backups ( id_medio,nom_back,tipo_back, modulo, estado_back,fecha_creacion,login_back)".
							"VALUES ('$id_medio','$nomb','Backup por Modulo','$modulo','$eliminar','".date("Y-m-d")."','$login')";
					if (mysql_db_query($db,$sql,$link))
					{	$observaciones="El backup realizado fue del modulo ".$modulo;
						$sql01 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,observaciones)".
								"VALUES ('".date("Y-m-d")."','".date("H:i:s")."','Backup por Modulo','$nombre_usr','$observaciones')";
						$rst01 = mysql_db_query($db,$sql01,$link);
						header("location:lista_backups.php");			
					}
				}						
				break;
				case "fec_mod":
				if (empty($modulo)) $msg = "Modulo no puede ser vacio";	
				else
				{	$condicion = "fecha_creado BETWEEN '$fec1' AND '$fec2'";
					$id_mod = XCampoc($modulo,"modulo","nombre_mod","id_mod",$link);
					$sql = "SELECT * FROM datos_archivos WHERE $condicion AND id_mod = $id_mod AND eliminado<>1";						
					$res = mysql_db_query($db,$sql,$link);			
					if (mysql_num_rows($res) > 0)
					{	mkdir($path_backup."/$nom_back"."_".$nom_c,0777);
						mkdir($path_backup."/$nom_back"."_".$nom_c."/".$modulo,0777);
						while ( $row = mysql_fetch_array($res) )
						{	$dir_cp  = $path_backup."/$nom_back"."_".$nom_c."/".$modulo."/".$row[nombre_arch];
							$dir_ini = $dir."/".$modulo."/".$row['nombre_arch'];
							if ( !copy($dir_ini,$dir_cp) )	
							$msg = "Error en la copia, no se encuentra uno de los archivos";
						}
						$medio_otro = strtoupper($medio_otro);
						if ( $op_medio == "0" ) $sql2 = "INSERT INTO "."controlinvent(FechaAlta,Tipo,Observ) VALUES('".date("Y-m-d")."','$medio_otro','$obs')";
						else  $sql2 = "INSERT INTO "."controlinvent(FechaAlta,Tipo,Observ) VALUES('".date("Y-m-d")."','$medio','$obs')";
						mysql_db_query($db,$sql2,$link);
						$sql2 = "SELECT MAX(Codigo) as id_medio FROM controlinvent"; 
						$res2 = mysql_db_query($db,$sql2,$link);
						$row2 = mysql_fetch_array($res2);
						$id_medio = $row2['id_medio'];
						$nomb = $nom_back."_".$nom_c;				
						$sql = "INSERT INTO backups (id_medio,nom_back,tipo_back, modulo, estado_back,fecha_creacion,fec_del_back, fec_al_back, login_back)".
								"VALUES ('$id_medio','$nomb','Backup por Modulo y Fechas','$modulo','0','".date("Y-m-d")."','$fec1','$fec2','$login')";
						if (mysql_db_query($db,$sql,$link))
						{	$observaciones="El backup realizado fue del modulo ".$modulo." desde la fecha ".$fec1." hasta ".$fec2;
							$sql01 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,observaciones)".
									"VALUES ('".date("Y-m-d")."','".date("H:i:s")."','Backup por Modulo y Fechas','$nombre_usr','$observaciones')";
							$rst01 = mysql_db_query($db,$sql01,$link);
							header("location:lista_backups.	php");
						}
					}
					else $msg = "No hay archivos para copiar";
				}
				break;
				default:
				break;
			}//end swicth
			unset($guardar);
			unset($opcion);
			unset($nomb);
		}
		else $msg = "EL nombre del backup no es valido";
	}	
	else  $msg = "No hay archivos para copiar";		 
} 
include ("top.php");
$fecha_hoy = date("d-m-Y");
$hora_hoy = date("H-i-s");
?>
<html>
<head>
<title>formularios - Iteraccion - ejemplo 7</title>
<script lenguaje="javascript" type="text/javascript">
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function cambio(numero){        
		 if (!foco_texto){
				 irapagina("backups.php?op="+numero);
		 } 
}
var foco_texto=false;
</script>
<style>
.cl { COLOR:#000000; }
.cl2 { FONT-SIZE:8PT;}
</style>	
</head>
<body bgcolor="#FFFFFF">
<script language="JavaScript" src="calendar.js"></script>
<?php
/*require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsDate ( "DA", "MA", "AA", "Fecha de Inicio, $errorMsgJs[date]" );
$valid->addIsDate ( "DE", "ME", "AE", "Fecha de Conclusion, $errorMsgJs[date]" );
$valid->addCompareDates   ( "DA", "MA", "AA","DE", "ME", "AE", "Fecha Del y Fecha Al, $errorMsgJs[compareDates]");
print $valid->toHtml ();*/

?>

<form action="backups.php"  method="post" name="form2" id="form2">  
  <table width="60%"  border="1" align="center" background="images/fondo.jpg">
    <tr bgcolor="#006699"><th background="images/main-button-tileR2.jpg">BACKUPS</th></tr>
	<tr>
      <td> 
        <table width="100%" border="0">
          <tr> 
            <td width="11" height="30"></td>
             <td width="554">
               <font face="Arial, Helvetica" size="2"><b>Eliga el tipo de Backup que desea: </b></font>
			 </td>
          </tr>
          <tr> 
            <td width="11"></td>
            <td> <table width="231" border="2">
                <tr>
                  <td width="209" height="95"> 
                    <input type="radio" name="opcion" value="todo" onClick="cambio(this.value)" <?php if ($op == todo) print "checked"; else print "checked"; ?>> 
                    <font face="Arial, Helvetica, sans-serif" size="1">BACKUP GENERAL</font> <br>  
                   	<input type="radio" name="opcion" value="fechas" onClick="cambio(this.value)" <?php if ($op == fechas) print "checked"; ?>> 
                    <font face="Arial, Helvetica, sans-serif" size="1"> BACKUP GENERAL POR FECHAS</font> <br> 
					<input type="radio" name="opcion" value="mod" onClick="cambio(this.value)" <?php if ($op == mod) print "checked"; ?>> 
                    <font face="Arial, Helvetica, sans-serif" size="1"> BACKUP POR MODULO</font> <br> 
					 <input type="radio" name="opcion" value="fec_mod" onClick="cambio(this.value)" <?php if ($op == fec_mod) print "checked"; ?>> 
					 <font face="Arial, Helvetica, sans-serif" size="1">BACKUP POR MODULO Y FECHAS</FONT>
					</td>
                </tr>
              </table><br></td>
          </tr>
		  <?php 
		  if ( $op == "mod" or $op == "fec_mod")
		  {
		  ?>
          <tr><td width="11"></td><td><font face="Arial, Helvetica" size="2"><b>Modulo:</b></font></td></tr>
          <tr><td width="11" height="26"></td> 
            <td> 
              <select name="modulo" >                
				<?php
					$sql = "SELECT id_mod, nombre_mod FROM modulo WHERE estado<>1";					
					$res = mysql_db_query ( $db, $sql, $link);					
					while ($fil = mysql_fetch_array( $res ) )
					{	if ($fil[id_mod] == $modulo)
						echo "<option value='$fil[nombre_mod]' selected>".$fil['nombre_mod']."</option>";
						else
						echo "<option value='$fil[nombre_mod]'>".$fil['nombre_mod']."</option>";  
					}				
				?>
               </select> 
            </td>
          </tr>		  		  
		  <?php }
		  if ( $op == "fechas" or $op == "fec_mod" )
		  {
		  ?>
          <tr><td width="11"></td><td><font face="Arial, Helvetica" size="2"><b>Por fechas: </b></font></td></tr>
          <tr><td width="11" height="26"></td> 
            <td> 
			Del: 
			<select name="DA" id="select">
  			<?php		  		
				$fsist = date("Y-m-d");				
  				$ano = substr($fsist,0,4);
				$mes = substr($fsist,5,2);
				$dia = substr($fsist,8,2);				
				for($i=1;$i<=31;$i++)
				{	if ( isset ($DA) ){ echo "<option value=\"$i\""; if($DA=="$i") echo "selected"; echo">$i</option>";	}
					else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
			</select>
			<select name="MA" id="select9">
                <?php
				for($i=1;$i<=12;$i++)
				{	if ( isset($MA) ) {echo "<option value=\"$i\""; if($MA=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
              </select>
          <select name="AA" id="select6">
          <?php
				for( $i=2003;$i<=2020;$i++ ) 
				{	if ( isset($AA) ) {echo "<option value=\"$i\""; if($AA=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($ano=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
        </select>
		<font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a>&nbsp;&nbsp;</font>
        Al:<select name="DE" id="select7">
        <?php
			$fsist=date("Y-m-d");
  			$ano=substr($fsist,0,4);
			$mes=substr($fsist,5,2);
			$dia=substr($fsist,8,2);				
			for($i=1;$i<=31;$i++)
			{	if (isset($DE)) {echo "<option value=\"$i\""; if($DE=="$i") echo "selected"; echo">$i</option>";}
				else {echo "<option value=\"$i\""; if($dia=="$i") echo "selected"; echo">$i</option>";}
			}
				?>
         </select>
        <select name="ME" id="select2">
          <?php
				for($i=1;$i<=12;$i++)
				{	if (isset($ME)) {echo "<option value=\"$i\""; if($ME=="$i") echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if($mes=="$i") echo "selected"; echo">$i</option>";}
				}
				?>
        </select>
        <select name="AE" id="select4">
          <?php
				for($i=2003;$i<=2020;$i++)
				{	if (isset($AE)) {echo "<option value=\"$i\""; if( $AE=="$i" ) echo "selected"; echo">$i</option>";}
					else {echo "<option value=\"$i\""; if( $ano=="$i" ) echo "selected"; echo">$i</option>";}
				}
				?>
        </select>
       <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font>		
		</center>
		<script language="JavaScript">
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DA'], document.forms[form].elements['MA'], document.forms[form].elements['AA']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DE'], document.forms[form].elements['ME'], document.forms[form].elements['AE']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;		
	    </script>		              
            </td>
          </tr>		  
		  <?php }?>		  
          <tr> 
            <td width="11"></td>
            <td height="30"><font face="Arial, Helvetica" size="2"><b> Nombre backup:</b></font> </td>
          </tr>
          <tr> 
            <td width="11"></td>
            <td><input type="text" name="nom_back" size="35" maxlength="50" class="cl">
              <input type="text" size="15" name="nom_com" disabled class="cl" value=<?php print $fecha_hoy."_".$hora_hoy;?> >
			  <input type="hidden" name="nom_c" value=<?php print $fecha_hoy."_".$hora_hoy;?>>
			 </td>
          </tr>
          <tr> 
            <td width="11"></td>
            <td height="30"><font face="Arial, Helvetica" size="2"><b>Ubicacion por defecto del backup:</b></font>
             </td>
          </tr>
          <tr> 
            <td width="11"></td>
            <td><input type="text" name="ubi_back" size="75" maxlength="150" class="cl" value=<?php print $path_backup;?> disabled> 
              <!--input type="submit" value="   ...  " name="enviar"-->
            </td>
          </tr>
          <tr> 
            <td width="11" height="30"></td>
            <td><font face="Arial, Helvetica" size="2"><b>Nombre del dispositivo fisico donde se almacenara al backup :</b></font> 
            </td>
          </tr>		
          <tr> 
            <td width="11" height="26"></td>
            <td> 	
			<input type="radio" name="op_medio" value="1" checked><FONT face="Arial, Helvetica, sans-serif" size="1">DISPOSITIVO:</FONT>&nbsp;&nbsp;&nbsp;
			 <select name="medio" class="cl2"> 
                <?php	
					$sql2 = "SELECT distinct(Tipo) FROM controlinvent";
					$res2 = mysql_db_query ( $db, $sql2, $link);					
					while ($fila = mysql_fetch_array($res2))
					{
						if (strlen($fila[Tipo])>20) { echo "<option value='$fila[Tipo]'>".substr($fila[Tipo],0,20)."..."; }
						else { echo "<option value='$fila[Tipo]'>$fila[Tipo]"; }
					}
				?>
              </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <input type="radio" name="op_medio" value="0"><font face="Arial, Helvetica, sans-serif" size="1">OTRO:</font>
			  <input type="text" name="medio_otro" size="15" maxlength="25" class="cl"><br><BR>
			  <font face="Arial, Helvetica, sans-serif" size="1">&nbsp;&nbsp;OBSERVACIONES:</font>
              <textarea name="obs" cols="40" onKeyDown="textCounter(form2.obs,form2.remLen,150);" onKeyUp="textCounter(form2.obs,form2.remLen,150);"></textarea>
          <input name="remLen" type="hidden" value="150">
            </td>
          </tr>
          <tr> 
            <td width="11" height="30"></td>
            <td height="21"> 
              <?php if ( $op == "todo" or $op == "") {?>
              <font face="Arial, Helvetica" size="2"><b>Sacar backup sin eliminar</b></font> 
              <input type="radio" name="eliminar" value="0" checked>&nbsp;&nbsp;&nbsp;&nbsp;
				<font face="Arial, Helvetica" size="2"><b>Sacar backup y eliminar</b></font>
				<input type="radio" name="eliminar" value="1" onClick="msgFile()">
			<?php }?>	
			 </td>
          </tr>
          <tr> 
            <td colspan="2" height="2"></td>
          </tr>		  		  
        </table></td>
	</tr>	
</table>
  <table width="311" align="center">
    <tr>
      <td height="40" align="center"> 
	  	<BR>&nbsp;
	 	<input type="submit" name="guardar" value="GENERAR"   onClick="return ValidaArchivo()" <?php //print $valid->onSubmit(); ?>>
         &nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;&nbsp;		 
        <input type="submit" name="retornar" value="RETORNAR">
	 <td>
    </tr>						
</table>
	
</form>
</body>
</html>
<?php include("top_.php");?>
<script language="JavaScript">
<?php
 if ($msg) 
   	{	print "var msg=\"$msg\";\n";
		print "alert ( msg + \"\\n \\n\Mensaje generado por GesTor F1.\");\n";		
	} 	
?>
	function mostrar(){
	//print "jhooa";
	var opc;
	//opc="modulo";
	window.location.href="usuarios.php";
	}	
	function ValidaArchivo ()
	{				
		var form=document.form2;
		var $nombre = form.nom_back.value;
		if (form.nom_back.value == ""){	
			alert ("Nombre backup no puede ser vacio \n\nMensaje generado por GesTor F1.");			
			return false;
		}
		if (form.op_medio[1].checked)	
		{	if (form.medio_otro.value == ""){	
			alert ("Nombre del dispositivo  no puede ser vacio \n\nMensaje generado por GesTor F1.");			
			return false;}
		}
		if (form.obs.value == "")	
		{	alert ("Observacion no puede ser vacio \n\nMensaje generado por GesTor F1.");			
			return false;
		}
		/*if (form.modulo.value == "")
		{	alert ("Modulo no puede ser vacio \n\nMensaje generado por GesTor F1.");			
			return false;
		}*/
		return true;
	}	
		<?php
		 print "function msgFile () {\n
				alert (\"Atencion, si elige esta opcion se borraran todos sus datos\\n \\nMensaje generado por GesTor F1.\");\n
		}\n";
		?>			
</script>
<SCRIPT LANGUAGE="JavaScript">
function textCounter(field, countfield, maxlimit) {
if (field.value.length > maxlimit) // if too long...trim it!
field.value = field.value.substring(0, maxlimit);
// otherwise, update 'characters left' counter
else 
countfield.value = maxlimit - field.value.length;
}
// End -->
</script>
