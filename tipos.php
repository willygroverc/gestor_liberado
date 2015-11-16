<?php
//include ("top.php");
///header('Content-Type: text/html; charset=iso-8859-1');
if (isset($_REQUEST['cancelar'])) 
{	
	header('location:lista_tipos.php');
}
include("conexion.php");
$n1=$_REQUEST['n1'];
$n2=$_REQUEST['n2'];
$n3=$_REQUEST['n3'];
if (isset($_REQUEST['save'])) 
{	$area=$_GET['area'];
        $dominio=$_GET['dominio'];
        $objetivo=$_REQUEST['objetivo'];
          $id_orden=$_GET['id_orden'];
	$sCon = "update ordenes set area=$area, dominio=$dominio, objetivo=$objetivo where id_orden=$id_orden";
        //print_r($sCon);exit;
	if (mysql_query($sCon)){
		echo '<script>alert("La operacion se ha completado con exito;");</script>';
		header('location:lista_tipos.php');	
	}
	?>
	<script type="text/javascript">
		opener.document.location.reload();
		window.close();
	</script>
<?php
	//header("location: lista_tipos.php?Naveg=Tipificacion&pg=$pg");
}
?>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<style>
.link{
	font:Verdana;
	font-size:12px;
	text-decoration:none;
	color:#000066;
	font-weight: bold;
}
.link:hover{
	font:Verdana;
	font-size:12px;
	text-decoration:underline;
	color:#000066;
	font-weight: bold;
}

</style>
<form name="form1" method="post" enctype="multipart/form-data" onKeyPress="return Form()">
<input type="hidden" name="id_orden" value="<?php=$_GET['id_orden'];?>">
<input type="hidden" name="pg" value="<?php=@$pg?>">
<table border="1"  align="center" cellpadding="0" cellspacing="0" width="50%">
  <tr><td>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg" >
    <tr> 
      <td> 
        <table width="101%" height="265" border="0" align="center" cellpadding="0" cellspacing="4">
          <tr bgcolor="#006699"> 
            <th colspan="2" background="images/main-button-tileR2.jpg"><font face="verdana" size="3" color="#FFFFFF">ASIGNAR TIPIFICACI�N - ORDEN No <?php=$_REQUEST['id_orden'];?></font></th>
          </tr>
		  
          <tr> 
            <td colspan="2" align="center"><strong>FECHA : <?php echo date("d/m/Y");?></strong><strong>&nbsp;&nbsp; 
              HORA : <?php echo date("H:i:s");?></strong></td>
          </tr>
		  <tr>		  
            <td colspan="2" class="normal"><div align="center"><strong>Descripcion de la Incidencia :</strong> </div></td>
          </tr>
          <tr> 
            <td colspan="2"> <div align="center"><strong><?php=incidencia($_GET['id_orden'])?></strong> </div></td>
          </tr>
		  <!------------------------------------------------------------------------------------------------------>
		   <!---->
		  <tr align="center"> 
		  	<td>&nbsp;</td>
			<td >
				<table width="393">
				  <tr>
					<td width="104" class="titulo" align="right">
					<font face="verdana" size="1"><b>Nivel 1 : </b></font>
					</td>
					<td width="277">
                      <select name="area" onChange="tipo(this.value)">
					  	<option value="0" >  General  </option>
						<?php
                                                    $area=$_GET['area'];
                                                     $dominio=$_GET['dominio'];
                                                     $objetivo=$_GET['objetivo'];
                                                     $id_orden=$_GET['id_orden'];
                                                     
							$sql = "select *from area ORDER BY area_nombre";
							$res = mysql_query($sql);
							while($row = mysql_fetch_array($res))
							{
								/*echo "<option value=\"$row[area_cod]\"";
								if ($row[area_cod]==$menu){echo"selected";}
								else
								{
									if ($sFil[area_cod]==$area){echo"selected";}
								}
								echo">$row[area_nombre]</option>";*/
								if($row['area_cod'] == $n1)
								{
									echo"<option value='$row[area_cod]' selected>".$row['area_nombre']."</option>";	
								}
								else if($row['area_cod'] == $area)
								{
									echo"<option value='$row[area_cod]' selected>".$row['area_nombre']."</option>";	
								}
								else
								{
									echo"<option value='$row[area_cod]'>".$row['area_nombre']."</option>";
								} 
							}
						?>
					  </select>
					  &nbsp;&nbsp;&nbsp;&nbsp;<a href="impresion_niveles.php" class="link" target="_blank">ver niveles</a>
					</td>
				  </tr>
				  <tr>
					<td width="104" class="titulo" align="right">
					<font face="verdana" size="1"><b>Nivel 2 : </b></font>
					</td>
					<td>
                      <select name="dominio" onChange="tipo1(<?php if (empty($menu)){echo "0";} else {echo "$menu";}?>,this.value)">
					  	<option value="0">  General  </option>
						<?php
							if($area == ''){$area = $n1;}
							$sql1 = "SELECT * FROM dominio WHERE id_area='$area' ORDER BY dominio";
							$res1 = mysql_query($sql1);
							while($row1 = mysql_fetch_array($res1))
							{
								/*echo "<option value=\"$row1[id_dominio]\"";
								if ($row1[id_dominio]==$obco){echo"selected";}
								else
								 {
									if ($sFil[id_dominio]==$dominio){echo"selected";}
								 }
								echo ">$row1[dominio]</option>";*/
								if($row1['id_dominio'] == $n2)
								{
									echo"<option value='$row1[id_dominio]' selected>".$row1['dominio']."</option>";	
								}
								else if($row1['id_dominio'] == $dominio)
								{
									echo"<option value='$row1[id_dominio]' selected>".$row1['dominio']."</option>";	
								}
								else
								{
									echo"<option value='$row1[id_dominio]'>".$row1['dominio']."</option>";
								} 
							} 
						?>
					  </select>
					</td>
				  </tr>
				  <tr>
					<td width="104" class="titulo" align="right">
					<font face="verdana" size="1"><b>Nivel 3 : </b></font>
					</td>
					<td>
                      <select name="objetivo" >
					  	<option value="0" >  General  </option>
						<?php //$dominio=$_GET['dominio'];
							if($dominio == ''){$dominio = $n2;}
							$sql2 = "SELECT * FROM objetivos WHERE id_dominio='$dominio'";
							$res2 = mysql_query($sql2);
							while($row2 = mysql_fetch_array($res2))
							{
								if($row2['id_objetivo'] == $n3)
								{
									echo"<option value='$row2[id_objetivo]' selected>".$row2['objetivo']."</option>";	
								}
								else
								{
									echo"<option value='$row2[id_objetivo]'>".$row2['objetivo']."</option>";
								} 
								/*echo "<option value=\"$row1[id_dominio]\"";
								if ($row1[id_objetivo]==$objetivo){echo"selected";}
								echo ">$row1[dominio]</option>";*/
							} 
						?>
					  </select>
					</td>
				  </tr>
				</table>
			</td>
          <tr>  
		  <!---->
		  <!------------------------------------------------------------------------------------------------------>
          <tr> 
          <br>
          <tr> 
            <td colspan="2"><div align="center"><br>
                <input name="save" type="submit" value="  GUARDAR  " >&nbsp;&nbsp;
				<input name="cancelar" type="submit" id="cancelar" value="CANCELAR" >
                <br>
              </div></td>
          </tr>
		  <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
		</td>
    </tr>
  </table>
  
  </td></tr></table>
</form>
<script language="JavaScript">
// Funciones adicionales 
function irapagina(pagina)
{         
  if (pagina!="") 
  {
   	self.location = pagina;
  }
}
function tipo(men)
{
 	id = document.form1.id_orden.value;
	var pg = document.form1.pg.value;
	var area = document.form1.area.value;
	var dominio = 0;
	var objetivo = 0;
	irapagina("tipos.php?menu="+men+"&Naveg=Registrar Proceso&id_orden="+id+"&area="+ area +"&dominio="+ dominio +"&objetivo="+objetivo + "&pg=" + pg);
}
function tipo1(men,va1)
{
	id = document.form1.id_orden.value;
	var pg = document.form1.pg.value;
	var area = document.form1.area.value;
	var dominio = document.form1.dominio.value;
	var objetivo = document.form1.objetivo.value;
	irapagina("tipos.php?menu="+men+"&obco="+va1+"&Naveg=Registrar Proceso&id_orden="+id +"&area="+ area +"&dominio="+ dominio +"&objetivo="+objetivo + "&pg=" + pg);
}
//Fin
//-->
</script> 
<?php
function incidencia($id)
{
	include("conexion.php");
	if($id <> 0)
	{
		$sql = "select desc_inc from ordenes where id_orden = '$id'";
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res);
		$descripcion = $row['desc_inc'];
	}
	return (isset($descripcion));
}

?>