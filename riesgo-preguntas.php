<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		12/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])) {
    if ($_SESSION['tipo'] == 'C') {
        header('location:pagina_inicio.php');
    }
}
require_once("funciones.php");
require("conexion.php");
if (isset($_REQUEST['retornar'])) {
    header("location: riesgo-opciones.php?idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
}
if (isset($_REQUEST['reg_form'])) {
    $sql_max = "SELECT MAX(id_riesgo) AS nummax FROM riesgo_pregunta";
    $result_max = mysql_query($sql_max);
    $row_max = mysql_fetch_array($result_max);
    $maximo = $row_max['nummax'] + 1;
    $tipo_riesgo = $_REQUEST['tipo_riesgo'];
    $idproc = $_REQUEST['idproc'];
    $pg = $_REQUEST['pg'];
    $BUSCAR = $_REQUEST['BUSCAR'];
    $menu= $_REQUEST['menu'];
    $busc= $_REQUEST['busc'];
    $desc_riesgo=$_REQUEST['desc_riesgo'];
    $fase=$_REQUEST['fase'];
                
    if ($_REQUEST['fase'] == "nuevo") {
        $sql3 = "INSERT INTO riesgo_pregunta (id_riesgo,desc_riesgo,tipo_r,sel) VALUES ('$maximo','$desc_riesgo','$tipo_riesgo','0')";
        print_r($sql3);
       // exit;
    } else {
        $sql3 = "UPDATE riesgo_pregunta SET desc_riesgo='$desc_riesgo' WHERE id_riesgo='$fase'";
                print_r($sql3);
        //exit;
    }
    mysql_query($sql3);
    header("location: riesgo-preguntas.php?tipo_riesgo=$tipo_riesgo&idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
}
if (isset($_REQUEST['accion']) && $_REQUEST['accion'] == "elimina") {
    $nom=$_REQUEST['nom'];
    $tipo_riesgo = $_REQUEST['tipo_riesgo'];
    $idproc = $_REQUEST['idproc'];
    $pg = $_REQUEST['pg'];
    $BUSCAR = $_REQUEST['BUSCAR'];
    $menu= $_REQUEST['menu'];
    $busc= $_REQUEST['busc'];
      
    $sql = "DELETE FROM riesgo_pregunta WHERE id_riesgo='$nom'";
       mysql_query($sql);
    $sql_max = "SELECT id_riesgo FROM riesgo_pregunta";
    $result_max = mysql_query($sql_max);
    while ($row_max = mysql_fetch_array($result_max)) {
        $j = $j + 1;
        $sql_1 = "UPDATE riesgo_pregunta SET id_riesgo='$j' WHERE id_riesgo='$row_max[id_riesgo]'";
        mysql_query($sql_1);
    }
    header("location: riesgo-preguntas.php?tipo_riesgo=$tipo_riesgo&idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc");
}
include("top.php");
?>
<script language="JavaScript">
<!--
    function confirmLink(theLink, usuario, tipo_riesgo) {
        var is_confirmed = confirm("Desea Realmente Eliminar " + ' :\n' + usuario);
        if (is_confirmed) {
            theLink.href += '&accion=elimina&tipo_riesgo=' + tipo_riesgo;
        }
        return is_confirmed;
    }
-->
</script>
<form name="form1" method="post" action="" >
    <input name="idproc" type="hidden" id="idproc" value="<?php echo $_REQUEST['idproc']; ?>" >
    <input name="pg" type="hidden" id="pg" value="<?php echo $_REQUEST['pg']; ?>" >
    <input name="BUSCAR" type="hidden" value="<?php echo $_REQUEST['BUSCAR']; ?>">
    <input name="menu" type="hidden" value="<?php echo $_REQUEST['menu']; ?>">
    <input name="busc" type="hidden" value="<?php echo $_REQUEST['busc']; ?>">
    <table border="1" align="center" cellpadding="0" cellspacing="2" bgcolor="#EAEAEA"  background="images/fondo.jpg">
        <tr> 
            <th colspan="3" background="images/main-button-tileR2.jpg">DEFINICION DE RIESGOS PARA EL GRUPO:<br>
                " 
                <?php
                $tipo_riesgo = $_REQUEST['tipo_riesgo'];
                $idproc = $_REQUEST['idproc'];
                $pg = $_REQUEST['pg'];
                $BUSCAR = $_REQUEST['BUSCAR'];
                $menu= $_REQUEST['menu'];
                $busc= $_REQUEST['busc'];
                $sql3 = "SELECT * FROM riesgo_tipos WHERE id_riesgo='$tipo_riesgo'";
                $result3 = mysql_query($sql3);
                $row3 = mysql_fetch_array($result3);
                echo $row3['descripcion'];
                ?>
                &quot; </th>
        </tr>
        <tr align="center"> 
            <td class="menu" width="67" background="images/main-button-tileR1.jpg">NRO</td>
            <td class="menu" width="416" background="images/main-button-tileR1.jpg">DESCRIPCION DEL RIESGO</td>
            <td class="menu" width="65" background="images/main-button-tileR1.jpg">ELIMINAR</td>
        </tr>
        <?php
        if(empty($_REQUEST['num1'])){
        $_REQUEST['num1']='';           
        }
        
        $num = 0;
        $sql = "SELECT * FROM riesgo_pregunta WHERE tipo_r='$tipo_riesgo'";
        $result = mysql_query($sql);
        while ($row = mysql_fetch_array($result)) {
            $num++;
            ?>
            <tr> <?php echo "<td align=\"center\"><a href=\"riesgo-preguntas.php?variable1=$row[id_riesgo]&tipo_riesgo=$tipo_riesgo&num1=$num&idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc\">" . $num . "</a></td>"; ?> 
                <td>&nbsp;&nbsp;<?php echo $row['desc_riesgo']; ?></td>
                <?php echo "<td align=\"center\"><a href=\"riesgo-preguntas.php?nom=" . $row['id_riesgo'] . "&idproc=$idproc&pg=$pg&BUSCAR=$BUSCAR&menu=$menu&busc=$busc\" onClick=\"return confirmLink(this,'$row[desc_riesgo]','$tipo_riesgo')\"><img src=\"images/eliminar.gif\" border=\"0\" alt=\"Eliminar\"></a></td>"; ?> 
            </tr>
        <?php } ?>
        <tr> 
            <th colspan="3" background="images/main-button-tileR1.jpg">NUEVO / MODIFICAR</th>
        </tr>
        <tr align="center"> 
            <td background="images/main-button-tileR1.jpg"> <select name="fase">
                    <option value="<?php $variable1=$_REQUEST['variable1']; echo $variable1; ?>"><?php echo $_REQUEST['num1'] ?></option>
                    <option value="nuevo" <?php if (!isset($variable1)) echo "selected" ?> >Nuevo</option>
                </select> </td>
            <?php
            @$sql2 = "SELECT * FROM riesgo_pregunta WHERE id_riesgo='" . $variable1 . "'";
            $result2 = mysql_query($sql2);
            $row2 = mysql_fetch_array($result2);
            ?>
            <td colspan="2"> <input name="tipo_riesgo" type="hidden" value="<?php echo $tipo_riesgo; ?>" > 
                <input name="desc_riesgo" type="text" size="65" maxlength="255" value="<?php echo $row2['desc_riesgo']; ?>" > 
                <input name="reg_form" type="submit" value="GUARDAR"> </td>
        </tr>
    </table>
    <br>
    <input type="submit" name="retornar" value="RETORNAR">
</form>
<br>