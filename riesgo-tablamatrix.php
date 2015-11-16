<?php 
require_once("funciones.php");
//if (valida("Riesgo")=="bad") {header("location: pagina_error.php");}

if (isset($retornar)) { header("location: riesgo-opciones.php"); }
include("conexion.php");	

$num=0;
$matrix0[]=0;
$matrix1[]=0;
$sql0 = "SELECT * FROM riesgo_probabilidad";
$result0 = mysql_db_query($db,$sql0,$link);
while($row=mysql_fetch_array($result0)) {
	$matrix0[$num]=$row['descripcion'];
	$matrix1[$num]=$row['valoracion'];
	$num++;
}

$num1=0;
$matrix2[]=0;
$matrix3[]=0;
$sql1 = "SELECT * FROM riesgo_impacto";
$result1 = mysql_db_query($db,$sql1,$link);
while($row1=mysql_fetch_array($result1)) {
	$matrix2[$num1]=$row1['desc_impac'];
	$matrix3[$num1]=$row1['val_impac'];
	$num1++;
}

include("top.php");
?> 
<style type="text/css">
<!--
.mio {
	height: 20px;
	width: 30px;
}
.mio2 {
	height: 20px;
	width: 40px;
}
-->
</style>
  <table width="70%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <tr> 
      <th  colspan="<?php echo $num1+1?>">RIESGO ABSOLUTO</th>
    </tr>
    <?php
		for($i=0 ; $i<count($matrix0)+1 ; $i++){//IMPACTO
			echo "<tr align=\"center\">";		
			for($j=0 ; $j<count($matrix2)+1 ; $j++){//PROBABILIDAD			
				if ($i==0 && $j==0){
					echo "<td>&nbsp;</td>";
				}
				else if($i==0){
					echo " <td>".$matrix2[$j-1]."</td>";//TITULO IMPACTO
				}
				else if($j==0){
					echo " <td>".$matrix0[$i-1]."</td>";				
				}
				else {
					echo " <td>".$num."</td>";
				}
			}
			echo "</tr>\n";		
		}
	 ?>
  </table>
 <br>
<?php include("top_.php");?>