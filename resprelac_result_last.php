<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
require("conexion.php");
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($RETORNAR)){header("location: lista_planifpru2.php");}
//Para los responsables de ART
if (isset($guardar3)){
		$sql66= "SELECT * FROM resp_resulteval WHERE id_resulpru='$var' AND nombre='$nombrespeval'";
		$result66=mysql_query($sql66);
		$row66=mysql_fetch_array($result66);
				if(!$row66['nombre']){   
					$sql77="INSERT INTO resp_resulteval(id_resulpru,nombre,comentario) values ('$var','$nombrespeval','$comentarioeval')";
					mysql_query($sql77);
					header("location: resprelac_result_last.php?idresulpru=$var&OrdAyuda=$OrdAyuda");
				}
			   else
				{    	
				     $sql6="UPDATE resp_resulteval SET comentario='$comentarioeval'".
					"WHERE nombre='$nombrespeval' AND id_resulpru='$var'";
					mysql_query($sql6);
					header("location: resprelac_result_last.php?idresulpru=$var&OrdAyuda=$OrdAyuda");
		        } 
}

else {
include ("top.php");
$idresul=($_GET['idresulpru']);
$OrdAyuda=($_GET['OrdAyuda']);
$nomb=($_GET['nombresp']);

$sql20 = "SELECT * FROM planprueba WHERE ordayuda='$OrdAyuda'";
$result=mysql_query($sql20);
$row=mysql_fetch_array($result);

?> 
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty ( "nombrespeval",  "Nombre Responsable, $errorMsgJs[empty]" );
print $valid->toHtml ();
?> 
<table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr>
    <td height="204"><form name="form1" method="post" action="" onKeyPress="return Form()">
        <table width="100%" border="1" align="center" background="images/fondo.jpg">
          <tr> 
            <input name="var" type="hidden" value="<?php echo $idresul;?>">
            <input name="var1" type="hidden" value="<?php echo $nomb;?>">
            <td colspan="2" bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF">Responsables 
                Relacionados - RESULTADOS</font></strong></font></div>
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="33%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombre 
                del responsable </font></div></td>
            <td width="67%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Comentario 
                del responsable </font></div></td>
          </tr>
          <?php
			$sql1 = "SELECT * FROM resp_resulteval WHERE id_resulpru='$idresulpru'";
			$result1=mysql_query($sql1);
			while($row1=mysql_fetch_array($result1)) 
  			{
			?>
          <tr> 
            <?php 
				$sql44="SELECT * FROM users WHERE login_usr='$row1[nombre]'";
				$result44 = mysql_query($sql44);
				$row44 = mysql_fetch_array($result44);
				$name=$row44['nom_usr'].' '.$row44['apa_usr'].' '.$row44['ama_usr']; 
				echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"resprelac_result_last.php?idresulpru=$idresul&OrdAyuda=$OrdAyuda&nombresp=".$row1['nombre']."\">".$name."</a></font></td>";?>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row1['comentario'];?></td>
          </tr>
          <?php }?>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <?php $sql2 = "SELECT * FROM resp_resulteval WHERE id_resulpru='$idresulpru' AND nombre='$nomb'";
			  $result12=mysql_query($sql2);
			  $row12=mysql_fetch_array($result12); ?>
            <td height="74"> <div align="center"> 
                <select name="nombrespeval" id="select24">
                  <option value="0"></option>
                  <?php 
					$sql = "SELECT * FROM resprelac WHERE idplanpru='$row[idplanpru]'";
					$result1=mysql_query($sql);
				 	 while ($row1 = mysql_fetch_array($result1)) 
					{
					$sql4="SELECT * FROM users WHERE login_usr='$row1[nombresp]' ORDER BY apa_usr ASC";
					$result4 = mysql_query($sql4);
					$row4 = mysql_fetch_array($result4);
						if ($row4['login_usr']==$nomb)
						    echo '<option value="'.$row4['login_usr'].'" selected>'.$row4['apa_usr'].' '.$row4['ama_usr'].' '.$row4['nom_usr'].'</option>';
						else
							echo '<option value="'.$row4['login_usr'].'">'.$row4['apa_usr'].' '.$row4['ama_usr'].' '.$row4['nom_usr'].'</option>';
					}
			   ?>
                </select>
              </div></td>
            <td align="center"><textarea name="comentarioeval" cols="50" ><?php echo $row12['comentario'];?></textarea></td>
          </tr>
          <tr> 
            <td height="23" colspan="2"><div align="center"><br>
                <input type="Submit" name="guardar3" value="GUARDAR CAMBIOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="TERMINAR">
              </div></td>
          </tr>
        </table>
      </form></table>
    <br>
<?php } ?>

