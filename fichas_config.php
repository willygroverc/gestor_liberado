<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($_REQUEST['RETORNAR'])){header("location: menu_parametros.php");}
include("top.php");

	if(isset($_REQUEST['reg_form'])){
            //$ID_now=  isset($_REQUEST['ID_now']);
		if(isset($_REQUEST['ID_now'])){
			$sql= "UPDATE menu_parametros SET descrip='$_REQUEST[descrip]' WHERE ID='$_REQUEST[ID_now]'";
			mysql_query($sql);
		}
		else{
			$sql= "INSERT INTO menu_parametros (descrip, cat, estado) VALUES ('".$_REQUEST['descrip']."', 'ft', 1)";
			mysql_query($sql);
		}
	}
	if(isset($_REQUEST['ejecutar']) && $_REQUEST['ejecutar']=="eliminar"){
                $id=$_REQUEST['id'];
		$sql= "UPDATE menu_parametros SET estado=0 WHERE ID='$id'";
		mysql_query($sql);
	} 
	if (isset($sl))
	mysql_query($sl);
?>
<table width="30%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
	<tr> 
      <td height="190"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th background="images/main-button-tileR1.jpg" height="26" colspan="6" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">FICHAS TECNICAS - TIPO DE REGISTRO</font></th>
          </tr>
          <tr> 
            <th background="images/main-button-tileR1.jpg" width="100" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Detalle</font></th>
            <th background="images/main-button-tileR1.jpg" width="30" nowrap bgcolor="#006699"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Eliminar</font></div></th>
          </tr>
          <?php
		$sql = "SELECT * FROM menu_parametros WHERE cat='ft' AND estado =1 ORDER BY descrip ASC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{ ?>
          <tr> 
		    <?php echo "<td><a href=\"fichas_config.php?edit=1&id=$row[ID]\">".$row['descrip']."</a></td>";?> 
            <td><?php echo "<a href=\"?ejecutar=eliminar&id=$row[ID]\"onClick=\"return confirmLink(this,'$row[ID]')\"> <img src=\"images/eliminar.gif\" border=\"0\" alt=\"Eliminar\"></a>"; ?> </td>
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
			  if(isset($_REQUEST['edit']) && $_REQUEST['edit']==1){
                                        $id=$_REQUEST['id'];
			  		$sql_up="SELECT * FROM menu_parametros WHERE ID=$id";
					$rs_up=mysql_query($sql_up);
					$row3=mysql_fetch_array($rs_up);
					echo "<input name=\"ID_now\" type=\"hidden\" value=\"$row3[ID]\">";	
			  }
			  ?>
			
                <input name="descrip" type="text" id="obs_seg2" value="<?php echo @$row3['descrip'];?>" size="50" maxlength="50"> </td>			
            <td width="70" nowrap height="7"><strong> 
				
              </strong> </td>
          </tr>
          <tr> 
            <td height="30" colspan="6" nowrap>
<div align="left"></div>
              <div align="center"> <br>
                <input name="reg_form" type="submit" id="reg_form3" value="GUARDAR CAMBIOS">
                <input type="submit" name="RETORNAR" value="RETORNAR">
              </div>
              </td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<script language="JavaScript">
function confirmLink(theLink, archi){
    var is_confirmed = confirm("Desea realmente eliminar este registro? \n\nMensaje generado por GesTor F1");
    if (is_confirmed) {
        theLink.href += '&confirmado=1&Naveg=Seguridad >> Recordatorios';
    }
	
    return is_confirmed;
} // end of the 'con firmLink()' function
			
</script>