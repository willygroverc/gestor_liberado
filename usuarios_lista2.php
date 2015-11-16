<?php include("top.php");
?>
<script language="JavaScript">
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
</script>
<?php 
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("ei","Cliente Externo/Interno");
	$help->AddHelp("fono","Numero de Telefono");
	$help->AddHelp("privil","Privilegios");
	$help->AddHelp("ulti","Ultimo acceso");
	print $help->ToHtml();
?>
<form name="form1" action="" method="get" onKeyPress="return Form()">
  <table width="80%" border="1" align="center" bgcolor="#006699">
    <tr> 
      <td width="60%"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Busqueda por :</strong></font> 
          <select name="campo">
            <option value="nom_usr" <?php if ($campo=="nom_usr") echo "selected";?>>NOMBRE</option>
            <option value="apa_usr" <?php if ($campo=="apa_usr") echo "selected";?>>APELLIDO PATERNO</option>
            <option value="area_usr" <?php if ($campo=="area_usr") echo "selected";?>>AREA</option>
            <option value="ciu_usr" <?php if ($campo=="ciu_usr") echo "selected";?>>CIUDAD</option>
          </select>
          &nbsp;&nbsp; 
          <input name="busqueda" type="text" size="30" value="<?php echo $busqueda;?>">
          &nbsp;<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Tipo: 
          </strong></font>
          <select name="Usuario_Tipo" id="Usuario_Tipo">
            <option value="TC" <?php if ($Usuario_Tipo=="TC") print "selected";?>>General</option>
            <option value="C" <?php if ($Usuario_Tipo=="C") print "selected";?>>Cliente</option>
            <option value="T" <?php if ($Usuario_Tipo=="T") print "selected";?>>Tecnico</option>
          </select>
          &nbsp; 
          <input name="BUSCAR" type="submit" id="BUSCAR" value="BUSCAR">
        </div></td>
    </tr>
  </table>
  </form>
    
<table width="760" border="1" align="center" background="images/fondo.jpg">
  <tr align="center"> 
    <th colspan="12">LISTA DE USUARIOS</th>
  </tr>
  <tr align="center"> 
    <th width="5%"><a class="menu" href="usuarios_lista.php?orden=login_usr">LOGIN <?php if($orden=="login_usr") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7 >"; ?> </a></th>
    <th width="4%"><a class="menu" href="usuarios_lista.php?orden=tipo2_usr">TIPO <?php if($orden=="tipo2_usr") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7 >"; ?></a></th>
    <th width="13%" class="menu"><a class="menu" href="usuarios_lista.php?orden=nom_usr">NOMBRES <?php if($orden=="nom_usr") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7 >";?></a> &nbsp; Y &nbsp; <a class="menu" href="usuarios_lista.php?orden=apa_usr">APELLIDOS <?php if($orden=="apa_usr") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7 >";?> </a></th>
    <th width="5%"><a class="menu" href="usuarios_lista.php?orden=area_usr">AREA <?php if($orden=="area_usr") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7 >";?></a></th>
    <th width="6%"><a class="menu" href="usuarios_lista.php?orden=cargo_usr">CARGO  <?php if($orden=="cargo_usr") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7>"; ?></a></th>
    <th width="4%"><?php print $help->AddLink("fono", "TELF","usuarios_lista.php?orden=telf_usr","menu"); if($orden=="telf_usr") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7 >"; ?></th>
    <th width="4%"><a class="menu" href="usuarios_lista.php?&orden=direc_usr">DIRECCION  <?php if($orden=="direc_usr") echo "<img src=\"images/asc_order.gif\" border=0 width=7 height=7 >"; ?></a></th>
    <?php if ($tipo=="A") {  		
    	echo "<td class=\"menu\" width=\"13%\">ELIMINAR</td>";
		echo "<td class=\"menu\" width=\"13%\">".$help->AddLink("privil", "PRIVIL.")."</td>";
		echo "<td class=\"menu\" width=\"13%\">".$help->AddLink("ulti", "ULT. ACCESO")."</td>";
		echo "<td class=\"menu\" width=\"13%\">BLOQUEAR CUENTA</td>";
      }
    ?>
  </tr>
  <?php
 
    if (! isset($orden)) { $orden="login_usr";}
    $sql = "SELECT * FROM users ORDER BY $orden";

    if ($BUSCAR){$sql="SELECT * FROM users WHERE $campo LIKE '%$busqueda%' AND tipo2_usr LIKE '$Usuario_Tipo'";}

    $result=mysql_db_query($db,$sql,$link);

    while ($row=mysql_fetch_array($result)) {
 	echo "<tr align=\"center\">";
    if ($row[2] =="INTERNO" AND $row[17]=="0")   // INTERNO
		{$color="bgcolor=\"#00CC00\"";}
	elseif ($row[2]=="EXTERNO" AND $row[17]=="0") // EXTERNO
		{$color="bgcolor=\"#FFFF00\"";}
	elseif ($row[17]=="1") // BLOQUEADO
		{$color="bgcolor=\"#FF6666\"";}
		
    if ($tipo=="C") 		
    	echo "<td ".$color." nowrap>$row[0]</td>";
    else
     	echo "<td ".$color." nowrap><a href=\"usuario_modi.php?login_usr=$row[login_usr]\">$row[login_usr]</a></td>";
     
	?>
  <td nowrap $color><?php echo $row[3];?></td>
  <td nowrap><?php echo $row[4]." ".$row[5]." ".$row[6];?>&nbsp;</td>
  <td nowrap><?php echo $row[9];?>&nbsp;</td>
  <td nowrap><?php echo $row[10];?>&nbsp;</td>
  <td nowrap><?php echo $row[11];?>&nbsp;</td>
    <td nowrap><?php echo $row[14];?>&nbsp;</td>
  <?php 
	if ($tipo=="A") 
	{
    	echo "<td nowrap><a href=\"?ejecutar=eliminar&login_usr=$row[login_usr]\" onClick=\"return confirmLink(this,'$row[4] $row[5] $row[6]')\"><img src=\"images/eliminar.gif\" border=\"0\" alt=\"Eliminar\"></a>&nbsp;</td>";
		if ($row[3]=="C")
			{echo "<td><img src=\"images/usuario2.gif\" border=\"0\"></td>";}
		else
			{echo "<td nowrap><a href=\"roles.php?login_usr=$row[login_usr]\"><img src=\"images/usuario.gif\" border=\"0\" alt=\"Roles\"></a>&nbsp;</td>";}
		  $sql3 = "SELECT * FROM registro WHERE login_usr='$row[login_usr]' AND tipo_c='INGRESO' ORDER BY fecha DESC LIMIT 0,1";
		  $result3 = mysql_db_query($db,$sql3,$link);
		  $row3 = mysql_fetch_array($result3);
				$a1=substr($row3[fecha],0,4);
				$m1=substr($row3[fecha],5,2);
				$d1=substr($row3[fecha],8,2);
		  echo "<td nowrap>".$a1."-".$m1."-".$d1."</td>";

		if ($row[bloquear]=="1")
			echo "<td nowrap><font color=\"#FF0000\" face=\"Arial, Helvetica, sans-serif\"><a href=\"?bloquear=0&log=$row[login_usr]\")\"><img src=\"images/desbloquear.gif\" border=\"0\" alt=\"Habilitar\"></a></font>&nbsp;</td>";
		else
			echo "<td nowrap><a href=\"?bloquear=1&log=$row[login_usr]\")\"><img src=\"images/bloquear.gif\" border=\"0\" alt=\"Bloquear\"></a>&nbsp;</td>";

/*		if ($row[3]=="T" OR $row[3]=="C")
		{
		if ($row[bloquear]=="1")
			echo "<td nowrap><font color=\"#FF0000\" face=\"Arial, Helvetica, sans-serif\"><a href=\"?bloquear=0&log=$row[login_usr]\")\"><img src=\"images/desbloquear.gif\" border=\"0\" alt=\"Habilitar\"></a></font>&nbsp;</td>";
		else
			echo "<td nowrap><a href=\"?bloquear=1&log=$row[login_usr]\")\"><img src=\"images/bloquear.gif\" border=\"0\" alt=\"Bloquear\"></a>&nbsp;</td>";
		}

		elseif ($row[3]=="A") {
<IPM-28072004>		
//		echo "<td nowrap><img src=\"images/no2.gif\" border=\"0\" alt=\"Habilitado\"></td>";
			if ($row[bloquear]=="1")
				echo "<td nowrap><font color=\"#FF0000\" face=\"Arial, Helvetica, sans-serif\"><a href=\"?bloquear=0&log=$row[login_usr]\")\"><img src=\"images/desbloquear.gif\" border=\"0\" alt=\"Habilitar\"></a></font>&nbsp;</td>";
			else
				echo "<td nowrap><a href=\"?bloquear=1&log=$row[login_usr]\")\"><img src=\"images/bloquear.gif\" border=\"0\" alt=\"Bloquear\"></a>&nbsp;</td>";
		}
		*/
	}
    ?>
  </tr>
  <?php 
	} //End del While
  ?>
</table>
  <br>
  
<table width="70%" border="1" align="center">
  <tr> 
    <td width="18%" height="28"> 
      <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">USUARIO 
        CON CUENTA BLOQUEADA</font></div></td>
    <td width="8%" bgcolor="#FF6666">&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td width="16%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">USUARIO 
        INTERNO </font></div></td>
    <td width="9%" bgcolor="#00CC00">&nbsp;</td>
    <td width="8%">&nbsp;</td>
    <td width="18%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">USUARIO 
        EXTERNO </font></div></td>
    <td width="11%" bgcolor="#FFFF00">&nbsp;</td>
  </tr>
</table>
  <div align="center"><br>
    <?php if ($tipo=="A" OR $tipo=="T") {?>
	
  <input name="IMPRESION" type="button" id="IMPRESION" value="IMPRIMIR" onClick="openStat_2()">
	<?php }?>
  </div>
</form>
  </p>
<script language="JavaScript">
<!--
function openStat_2() {
	window.open("impresion_seleccionar.php",'Usuarios', 'width=590,height=140,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
-->
</script>
<script language="JavaScript">
		<!-- 
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
</script>
<script language="JavaScript">
		<!-- 
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
</script>
  <?php include("top_.php");?> 
