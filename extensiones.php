<?php include("top.php");

	if(isset($reg_form)){
		if(isset($ID_now)){
			$sql= "UPDATE arch_ext  SET tipo='$tipo' WHERE id='$ID_now'";
			mysql_query($sql,$link);
		}
		else{
			$sql= "INSERT INTO arch_ext (tipo, estado) VALUES ($tipo, 1)";
			mysql_query($sql,$link);
		}
	}
	if($ejecutar=="eliminar"){
		$sql= "UPDATE arch_ext SET estado=0 WHERE ID='$id'";
		mysql_query($sql,$link);
	}
	mysql_query($sl,$link);
?>
<br>
<table width="44%" height="227" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $PHP_SELF ?>" >
	<tr> 
      <td height="190"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th background="images/main-button-tileR1.jpg" height="26" colspan="6" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">REGISTRO DE EXTENSION DE ARCHIVOS A SUBIR</font></th>
          </tr>
          <tr> 
            <th background="images/main-button-tileR1.jpg" width="100" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tipo de archivo</font></th>
            <th background="images/main-button-tileR1.jpg" width="30" nowrap bgcolor="#006699"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Eliminar</font></div></th>
          </tr>
          <?php
		$sql = "SELECT * FROM arch_ext WHERE estado =1 ORDER BY tipo ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{ ?>
          <tr> 
		    <?php echo "<td><a href=\"extensiones.php?edit=1&id=$row[id]\">".$row[tipo]."</a></td>";?> 
            <td><?php echo "<a href=\"?ejecutar=eliminar&id=$row[id]\"onClick=\"return confirmLink(this,'$row[id]')\"> <img src=\"images/eliminar.gif\" border=\"0\" alt=\"Eliminar\"></a>"; ?> </td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="6" height="7" nowrap><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font> 
              </div>
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td height="7" nowrap><p><strong> 
			  <?php
			  if($edit==1){
			  		$sql_up="SELECT * FROM arch_ext WHERE id=$id";
					$rs_up=mysql_db_query($db,$sql_up,$link);
					$row3=mysql_fetch_array($rs_up);
					echo "<input name=\"ID_now\" type=\"hidden\" value=\"$row3[id]\">";	
			  }
			  ?>
			
                <input name="tipo" type="text" id="obs_seg2" value="" size="50" maxlength="50"> </td>			
            <td width="70" nowrap height="7"><strong> 
				
              </strong> </td>
          </tr>
          <tr> 
            <td height="30" colspan="6" nowrap>
<div align="left"></div>
              <div align="center"> <br>
                <input name="reg_form" type="submit" id="reg_form3" value="GUARDAR CAMBIOS">
			  </div>
            </td>
          </tr>
        </table>
        
      </td>
    </tr></form>
</table>
<script language="JavaScript">
function confirmLink(theLink, archi)
{
    var is_confirmed = confirm("Desea realmente eliminar este registro? \n\nMensaje generado por GesTor F1");
    if (is_confirmed) {
        theLink.href += '&confirmado=1&Naveg=Seguridad >> Tipo de archivos';
    }
	
    return is_confirmed;
} // end of the 'con firmLink()' function
			
</script>		
<?php include("top_.php");?>