<?php 
//echo $list2[0]."*<br>";
if (isset($retornar)){header("location: lista_carpetas.php?id=$id");}
if (!empty($_GET['total'])){
session_start();
include ("conexion.php");
require_once('funciones.php');
$login=SanitizeString($_SESSION["login"]);
$total=SanitizeString($_GET['total']);
$id_mod=SanitizeString($id_mod);
for ($i=0;$i<=($total-1);$i++){

$tmp = str_replace(":"," ",$nombre_arch[$i]);
	$id_mod=SanitizeString($id_mod);
	$sql3 = "SELECT MAX(id_arch) as id_arch FROM datos_archivos WHERE nombre_arch='$tmp' AND id_mod='$id_mod'";
	$result3 = mysql_db_query($db,$sql3,$link);
	 
	$row3 = mysql_fetch_array($result3); 
	$sql = "SELECT * FROM datos_archivos WHERE id_arch='$row3[id_arch]'"; 
	$result = mysql_db_query($db,$sql,$link);
	$row = mysql_fetch_array($result);
	
	$fecha_hoy=date("Y-m-d");
	$hora_hoy=date("H:i:s");
		//echo  "------------------".$row[id_arch];
		$sql1 = "INSERT INTO control_archivos (id_arch, ubicacion, fecha_c, login_b) VALUES ('$row[id_arch]','c','$fecha_hoy','$usuario')";
		$result1 = mysql_db_query($db,$sql1,$link);
		$sql2 = "UPDATE datos_archivos SET estado=1 WHERE id_arch='$row[id_arch]' AND id_mod='$id_mod'";
		$result2 = mysql_db_query($db,$sql2,$link);
		$sql4 = "SELECT * FROM modulo WHERE id_mod='$id_mod'";
		$result4 = mysql_db_query($db,$sql4,$link);
		$row4 = mysql_fetch_array($result4);
		$sqlvar="SELECT * FROM users WHERE login_usr='$usuario'";
		$resultvar=mysql_db_query($db,$sqlvar,$link);
		$rowvar=mysql_fetch_array($resultvar);
		$nombre_usr1 = $rowvar['nom_usr']." ".$rowvar['apa_usr']." ".$rowvar['ama_usr'];
		$sql01 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod,id_arch)".
	   	         "VALUES ('$fecha_hoy','$hora_hoy','ctrabajo','$nombre_usr1','$row4[nombre_mod]','$row[nombre_arch]')";
		$rst01 = mysql_db_query($db,$sql01,$link);
	}
header("location: repositorio_archivos.php?id=$id&id_mod=$id_mod");
}
include("top.php");

?>	 
<table width="60%" align="center" background="images/fondo.jpg" border="1">
  <form name="form1" action="" method="post">
    <tr bgcolor="#006699"> 
    <?php
	require_once('funciones.php');
	$id_mod=SanitizeString($id_mod);
	$sql0 = "SELECT * FROM modulo WHERE id_mod='$id_mod'";
	$result0 = mysql_db_query($db,$sql0,$link);
	$row0 = mysql_fetch_array($result0);
	?>
    <th colspan="3">MODULO: <?php echo $row0['nombre_mod']; ?></th>
    </tr>
    <tr> 
      <td> <table background="images/fondo.jpg" cellpadding="10">
          <tr> 
            <td align="center"><font face="Arial, Helvetica, sans-serif" size="2">REPOSITORIO</font></td>
            <td>&nbsp;</td>
            <td align="center"><font face="Arial, Helvetica, sans-serif" size="2">COPIA 
              DE TRABAJO</font></td>
          </tr>
          <tr> 
            <td rowspan="2" align="right" width="34%"><select name="list1" size="12" style="width:200px">
              <?php 
				$total_reg=1;
				$sql = "SELECT * FROM datos_archivos WHERE eliminado=0 AND estado=0 AND id_mod='$id_mod' ORDER BY datos_archivos.nombre_arch ASC";
				$result=mysql_db_query($db,$sql,$link);
				while ($row=mysql_fetch_array($result)){
				?>
              <option value="$row[id_arch]">
              <?php 
				$sin="&nbsp;";
				echo ereg_replace(" ", ":",$row['nombre_arch']);

				//echo $row[nombre_arch];
				$total_reg++;
				?>
              </option>
              <?php
				}
				?>
            </select></td>
            <td width="28%" height="30" valign="bottom" align="center"> <input name="pasar1" type="button" value="   >>   " onClick="addItem()" > 
            </td>
            <td rowspan="2" align="left" width="38%"> <p> 
              <select name="list2" size="12" style="width:200px">
              </select>
            </p>
            </td>
          </tr>
          <tr> 
            <td align="center" valign="top"> <input name="pasar2" type="button" onClick="rmItem()" value="   <<   "> 
          </tr>
          <tr>
            <td align="right"><font face="Arial, Helvetica, sans-serif" size="2">ASIGNADO A:</font></td>
            <td colspan="2" align="left"><select name="us">
                <?php $sql02="SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 order by apa_usr";
						$result02=mysql_db_query($db,$sql02,$link);
						while($row02=mysql_fetch_array($result02)){
						$nombre_usr=$row02['apa_usr']." ".$row02['ama_usr']." ".$row02['nom_usr'];
				  		echo "<option value=$row02[login_usr]> $nombre_usr</option>";}
				?>
              </select>
            </td>
          </tr>
        </table></td>
    </tr>
  </form>
</table>
<form name="form2" method="post" action="">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="hidden" name="id_mod" value="<?php echo $id_mod; ?>">
<table align="center">
  	<tr>
  		<td width="120"><div align="center">
		<input name="guardar" type="button" value="GUARDAR" onClick="guardar_CT()"></div></td>
  		<td width="120"><div align="center"> 
          <input name="retornar" type="submit" value="RETORNAR">
        </div></td>
	</tr>
</table>
</form>
<script language="JavaScript">
<!--
	var total1=0;
-->
</script>
<script language="JavaScript">
<!--
function addItem(){	
	var list1=document.getElementById("list1");
	var list2=document.getElementById("list2");	
	if(list1.selectedIndex==-1)
	return;
	var option = document.createElement("option");
	var text= document.createTextNode(list1[list1.selectedIndex].text)
	list2.appendChild(option)
	option.appendChild(text)
	list1.removeChild(list1[list1.selectedIndex])
	//total1 = 2;
	total1++;
}
function rmItem(){	
	var list1=document.getElementById("list1");
	var list2=document.getElementById("list2");
	if(list2.selectedIndex==-1)
	return;
	var option = document.createElement("option");
	var text= document.createTextNode(list2[list2.selectedIndex].text);
	list1.appendChild(option);
	option.appendChild(text);
	list2.removeChild(list2[list2.selectedIndex]);
	total1--;
}
-->
</script>
<script language="JavaScript">
	var id_mod=<?php echo $id_mod;?>;
</script>
<script language="JavaScript">
	var id="<?php echo $id;?>";
</script>
<script language="JavaScript">
<!--
function guardar_CT(){
	var stationInteger, stationString, cadena;
	stationInteger = 0;
	cadena = "?";
	if (total1==0) {
		alert ( "Seleccione los archivos que desea llevar a Copia de Trabajo. \n \n Mensaje generado por GesTor F1.");
	}else{ 
		while (stationInteger<total1){
			stationString = document.form1.list2.options[stationInteger].text;
			cadena = cadena + "nombre_arch[" + stationInteger + "]=" + stationString + "&";
			stationInteger++;
		}
	    var is_confirmed = confirm("Desea llevar los archivos seleccionados a Copia de Trabajo"+ '\n' + '\n' + "Mensaje generado por GesTor F1." );
	    if (is_confirmed) {
		window.location.href="repositorio_archivos.php" + cadena + "total=" + total1 + "&id_mod=" + id_mod + "&id=" + id +"&usuario="+form1.us.value;
	    }
	    return is_confirmed;
	}
}
-->
</script>
<?php include("top_.php");?>