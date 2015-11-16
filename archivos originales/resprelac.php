<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		17/DIC/2012
// Autor: 		Cesar Cuenca
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
	    $sql66= "SELECT * FROM resprelac WHERE idplanpru='$idplanpru' AND nombresp='$nombresp'";
		$result66=mysql_query($sql66);
		$row66=mysql_fetch_array($result66);
		if(!$row66['nombresp'])
    	  {
		  $sql = "INSERT INTO resprelac (idplanpru,nombresp,comentresp) ".
		  "VALUES ('$idplanpru','$nombresp','$comentresp')";
		  $result=mysql_query($sql);
		  header("location: resprelac.php?varia2=$idplanpru&varia1=$var");
		  }
		  else
		  {
		   $sql6="UPDATE resprelac SET comentresp='$comentresp'".
					"WHERE nombresp='$nombresp' AND idplanpru='$idplanpru'";
					mysql_query($sql6);
					header("location: resprelac.php?varia2=$idplanpru&varia1=$var");
			}
} 
else {
include ("top.php");
$OrdAyuda=($_GET['varia1']);
$idplanpru=($_GET['varia2']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty ( "nombresp",  "Nombre Responsable, $errorMsgJs[empty]" );
$valid->addLength ( "comentresp",  "Comentarios, $errorMsgJs[length]" );
print $valid->toHtml ();
?> 
<table width="75%" height="27" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
  <tr>
    <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Responsables 
        Relacionados - PLANIFICACION</strong></font></div></td>
  </tr>
  
</table>
<table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr>
    <td height="70"> 
      <form name="form1" method="post" action="resprelac.php">
	<table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
	<input name="var" type="hidden" value="<?php echo $OrdAyuda;?>">
	<input name="idplanpru" type="hidden" value="<?php echo $idplanpru;?>">
         
            <td height="21" bgcolor="#006699"> <div align="center"><strong></strong></div>
              <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombre 
                Responsable </font></strong></div></td>
            <td width="64%" bgcolor="#006699"><div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Comentarios</font></strong></div></td>
          </tr>
          <?php
		$sql1 = "SELECT * FROM resprelac WHERE idplanpru='$idplanpru' ORDER BY idplanpru ASC";
		$result1=mysql_query($sql1);
		while($row1=mysql_fetch_array($result1)) 
  		{
		$sql44="SELECT * FROM users WHERE login_usr='$row1[nombresp]'";
				$result44 = mysql_query($sql44);
				$row44 = mysql_fetch_array($result44);
		 ?>
          <tr> 
            <?php $nom=$row44['nom_usr'];
		  $ap=$row44['apa_usr'];
		  $am=$row44['ama_usr'];
		   $name="$nom $ap $am";?>
            <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $name;?></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row1['comentresp'];?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td> <div align="center">
                <select name="nombresp" id="select24">
                  <option value="0"></option>
                  <?php 
			  require("conexion.php");
			  $sql1 = "SELECT * FROM users WHERE tipo2_usr='T' OR tipo2_usr='C' ORDER BY apa_usr ASC";
			  $result1 = mysql_query($sql1);
			  while ($row1 = mysql_fetch_array($result1)){
					echo '<option value="'.$row1['login_usr'].'">'.$row1['apa_usr'].' '.$row1['ama_usr'].' '.$row1['nom_usr'].'</option>';
	           }
			   ?>
                </select>
              </div></td>
            <td align="center"><textarea name="comentresp" cols="60"></textarea></td>
          </tr>
        </table>
        <table width="98%" cellspacing="0" cellpadding="0">
          <tr> 
            <td> </td>
          </tr>
        </table>
        
          
        <div align="center"><br>
          <input type="Submit" name="guardar" value="GUARDAR" <?php print $valid->onSubmit() ?>>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="TERMINAR" value="TERMINAR">
        </div>
      </form>
     
    </td>
  </tr>
</table>
  <?php } ?>