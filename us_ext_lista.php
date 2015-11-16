<?php
include("conexion.php");
if (isset($_REQUEST['RETORNAR']))
    header("location: us_externos.php");
$id_mod = $_REQUEST['id_mod'];
if (isset($_REQUEST['reg_form'])) {
    unset($msg);
    $nombre=$_REQUEST['nombre'];
    $cargo=$_REQUEST['cargo'];
    $cons = "SELECT * FROM us_ext_user WHERE nombre='$nombre'";
    $res = mysql_query($cons);
     echo "<script type=\"text/javascript\">alert(\"Fotos guardadas\");</script>"; 
    if (mysql_fetch_array($res)){
        
        header("location: us_ext_lista.php?id_mod=$id_mod&msg=1");

    }else {
        $sql = "INSERT INTO us_ext_user (nombre,cargo,id_mod) VALUES ('$nombre','$cargo','$id_mod')";
        mysql_db_query($db, $sql, $link);
    }
}
include("top.php");
?>
<html>
    <head>
        <title>Untitled Document</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>

    <body>
        <?php
        $sql_mod = "SELECT nombre FROM us_ext_mod WHERE id_mod='$id_mod'";
        $res_mod = mysql_db_query($db, $sql_mod, $link);
        $row_mod = mysql_fetch_array($res_mod);
        require_once ( "ValidatorJs.php" );
        $valid = new Validator("form2");
        $valid->addIsNotEmpty("nombre", "Nombre, $errorMsgJs[empty]");
        $valid->addExists("obs", "Observaciones, $errorMsgJs[empty]");
        print $valid->toHtml();
        ?>    
        <form name="form2" method="post" action="">
            <table width="70%" border="2" align="center" cellpadding="2" cellspacing="0" background="../auditoria/images/fondo.jpg">
                <tr> 
                    <th colspan="7" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
<?php= $row_mod['nombre'] ?> - USUARIOS</font></th>
                </tr>
                <tr> 
                    <th width="40" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
                    <th width="300" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">NOMBRE</font></th>
                    <th width="286" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">CARGO</font></th>
                </tr>
                <?php
                $cont = 0;
                $sql = "SELECT * FROM us_ext_user WHERE id_mod='$id_mod' ORDER BY nombre";
                $result = mysql_db_query($db, $sql, $link);

                while ($row = mysql_fetch_array($result)) {
                    $cont = $cont + 1;
                    ?>
                    <tr> 
                        <td align="center">&nbsp;<?php echo $cont ?></td>
                        <td align="center">&nbsp;<?php echo $row['nombre'] ?></td>
                        <td align="center">&nbsp;<?php echo $row['cargo'] ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr> 
                    <td colspan="7" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
<?php //echo $cad;  ?>
                        <div align="center"></div></td>
                </tr>
                <tr> 
                    <td width="40" height="7" nowrap bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nuevo</font></strong></div></td>
                    <td width="300" nowrap><div align="center"><strong> 
                                <input name="nombre" type="text" size="50" maxlength="100">
                            </strong></div></td>
                    <td nowrap height="7"><div align="center"><strong> 
                                <input name="cargo" type="text" id="cargo" value="" size="60">
                            </strong> </div></td>
                </tr>
                <tr> 
                    <td height="28" colspan="7" nowrap> <div align="center"> <br>
                            <strong>
                                <input name="id_mod" type="hidden" id="id_mod" value="<?php= $id_mod ?>">
                            </strong>
                            <input name="reg_form" type="submit" id="reg_form3" value="NUEVO USUARIO" <?php print $valid->onSubmit() ?>>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            <input name="RETORNAR" type="submit" id="reg_form" value="RETORNAR">
                            <br>
                            <br>
                        </div></td>
                </tr>
            </table>
        </form>
    </body>
</html>
<?php include("top_.php"); ?>
<script language="JavaScript" type="text/JavaScript">
<?php           
if ($msg == 1) {
       echo ("El nombre ya existe, seleccione otro.\\n Mensaje generado por GestorF1");
    
 }  ?>
</script>