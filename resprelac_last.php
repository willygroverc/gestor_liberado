<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		17/DIC/2012
// Autor: 		Cesar Cuenca
//
// Version: 	2.0
// Objetivo: 	Sanitizacion de datos al momento de registrar
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		03/SEP/2012
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($TERMINAR)){header("location: lista_planifpru1.php");}
if (isset($guardar)){
  require("conexion.php");
  require_once('funciones.php');
  	    $sql66= "SELECT * FROM resprelac WHERE idplanpru='$var' AND nombresp='$responsable'";
		$result66=mysql_query($sql66);
		$row66=mysql_fetch_array($result66);
			if(!isset($row66['nombresp']))
				{   
					$var=SanitizeString($var);
					$responsable=SanitizeString($responsable);
					$comentresp=SanitizeString($comentresp);
					$sql77="INSERT INTO resprelac(idplanpru,nombresp,comentresp) values ('$var','$responsable','$comentresp')";
					mysql_query($sql77);
					header("location: resprelac_last.php?idplanpru=$idplanpru");
				} 
		
		   else
				{    	
				     $var=SanitizeString($var);
					$responsable=SanitizeString($responsable);
					$comentresp=SanitizeString($comentresp);
					 $sql6="UPDATE resprelac SET comentresp='$comentresp'".
					"WHERE nombresp='$responsable' AND idplanpru='$var'";
					mysql_query($sql6);
					header("location: resprelac_last.php?idplanpru=$var");
		        } 
}
else {
include ("top.php");
$idplan=($_GET['idplanpru']);
if (isset($_GET['nombresp']))
	$nomb=($_GET['nombresp']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "responsable",  "Nombre Responsable, $errorMsgJs[empty]" );
$valid->addLength ( "comentresp",  "Comentarios, $errorMsgJs[length]" );
print $valid->toHtml ();
?> 
<table width="75%">
  <tr>
    <td height="233"> 
      <form name="form2" method="post" action="">
		<table width="100%" border="1">
          <tr>
		  <input name="var" type="hidden" value="<?php echo $idplan;?>">
        <input name="var1" type="hidden" value="<?php echo $nomb;?>">
        
            <td bgcolor="#006699">
<div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Responsables 
                Relacionados - PLANIFICACION</strong></font></div></td>
          </tr>
        </table>
        <table width="100%" border="1" background="images/fondo.jpg">
          <tr>
            <td width="31%" bgcolor="#006699">
<div align="center"><strong></strong></div>
              <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombre 
                Responsable</font></strong></div></td>
            <td width="69%" bgcolor="#006699"><div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Comentario</font></strong></div></td>
          </tr>
         <?php
			$sql1 = "SELECT * FROM resprelac WHERE idplanpru='$idplanpru'";
			$result1=mysql_query($sql1);
			while($row1=mysql_fetch_array($result1)){
		  ?>
		  <tr>
			<?php
				$sql44="SELECT * FROM users WHERE login_usr='".$row1['nombresp']."'";
				$result44 = mysql_query($sql44);
				$row44 = mysql_fetch_array($result44);
				$name=$row44['nom_usr']." ".$row44['apa_usr']." ".$row44['ama_usr']; 
				echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"resprelac_last.php?idplanpru=$idplan&nombresp=".$row1['nombresp']."\">".$name."</a></font></td>";?>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row1['comentresp'];?></td>
          </tr>
		  <?php } ?>
        </table>
        <table width="100%" border="1" background="images/fondo.jpg">
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <?php @$sql2 = "SELECT * FROM resprelac WHERE idplanpru='$idplanpru' AND nombresp='$nomb'";
			  $result12=mysql_query($sql2);
			  $row12=mysql_fetch_array($result12); ?>
            <td width="31%"><div align="center"> 
                <select name="responsable" id="select13">
                  <option value="0"></option>
                  <?php 
					  $sql11 = "SELECT * FROM users WHERE tipo2_usr='T' OR tipo2_usr='C' ORDER BY apa_usr ASC";
			  		  $result11 = mysql_query($sql11);
					  while ($row11 = mysql_fetch_array($result11)){
						if ($row11['login_usr']==$nomb)
						    echo '<option value="'.$row11['login_usr'].'" selected>'.$row11['apa_usr'].' '.$row11['ama_usr'].' '.$row11['nom_usr'].'</option>';
						else
							echo '<option value="'.$row11['login_usr'].'">'.$row11['apa_usr'].' '.$row11['ama_usr'].' '.$row11['nom_usr'].'</option>';
						}
			   		 ?>
                </select>
              </div></td>
            <td width="69%" align="center"><textarea name="comentresp" cols="60"><?php echo $row12['comentresp'];?></textarea></td>
          </tr>
          <tr> 
            <td colspan="2"><div align="center"><br>
                <input type="Submit" name="guardar" value="GUARDAR CAMBIOS"  <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="TERMINAR" value="TERMINAR">
              </div></td>
          </tr>
        </table>
        </form></td>
  </tr>
</table>
  <?php } ?>