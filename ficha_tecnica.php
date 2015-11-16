<?php
//include ("conexion.php");
if (isset($_REQUEST['RETORNAR'])) {
    header("location: lista_ficha.php");
}
if (isset($_REQUEST['GUARDATOS'])) {
    include ("conexion.php");
    session_start();
    $login = $_SESSION["login"];
    $FechPruFunc = date("Y-m-d");
    
    $TpRegFicha=$_REQUEST['TpRegFicha'];
    $RealizFicha=$_REQUEST['RealizFicha'];
    $Marca=$_REQUEST['Marca'];
    $AdicUSI=$_REQUEST['AdicUSI'];
    $Modelo=$_REQUEST['Modelo'];
    $CodActFijo=$_REQUEST['CodActFijo'];
    $NumSerie=$_REQUEST['NumSerie'];
    $Proveedor=$_REQUEST['Proveedor'];
    
    $FechAlta = $_REQUEST['ano1'] . '-' . $_REQUEST['mes1'] . '-' . $_REQUEST['dia1'];
    $GarantDe = $_REQUEST['ano2'] . '-' . $_REQUEST['mes2'] . '-' . $_REQUEST['dia2'];
    $GarantAl = $_REQUEST['ano3'] . '-' . $_REQUEST['mes3'] . '-' . $_REQUEST['dia3'];

    //$FechAlta="$ano1-$mes1-$dia1";
    //$GarantDe="$ano2-$mes2-$dia2";
    //$GarantAl="$ano3-$mes3-$dia3";
    $msgInvalid = "no es valido<br>";
    $errorNumber = 0;
    $sql = "INSERT INTO datfichatec (CodUsr,TpRegFicha,FechPruFunc,RealizFicha,Marca,AdicUSI,Modelo,CodActFijo,NumSerie,FechAlta,Proveedor,GarantDe,GarantAl) " .
            "VALUES ('$login','$TpRegFicha','$FechPruFunc','$RealizFicha','$Marca','$AdicUSI','$Modelo','$CodActFijo','$NumSerie','$FechAlta','$Proveedor','$GarantDe','$GarantAl')";
    //print_r($sql);exit;
    $result = mysql_db_query($db, $sql, $link);
    if (mysql_affected_rows() == 1) {
        $sql6 = "SELECT MAX(IdFicha) AS ID FROM datfichatec";
        $result6 = mysql_db_query($db, $sql6, $link);
        $row6 = mysql_fetch_array($result6);
        header("location: caracteristica.php?variable1=$row6[ID]&variable2=$TpRegFicha");
    } else {
        if (mysql_errno() == 1062)
            $errorForm[$errorNumber++] = "Adicional USI $AdicUSI ya existe. ";
        else
            $errorForm[$errorNumber++] = "Se ha producido un error al registrar los datos. ";
    }
    echo $sql;
}
?>
<?php
include ("top.php");
$log = $login;
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator("form1");
$valid->addIsTextNormal("Marca", "Marca, $errorMsgJs[expresion]");
$valid->addIsTextNormal("Modelo", "Modelo, $errorMsgJs[expresion]");
$valid->addIsTextNormal("NumSerie", "Numero de Serie, $errorMsgJs[expresion]");
$valid->addIsNotEmpty("Proveedor", "Proveedor, $errorMsgJs[empty]");
$valid->addIsNotEmpty("RealizFicha", "Realizado por, $errorMsgJs[empty]");
$valid->addIsTextNormal("AdicUSI", "Adicional USI, $errorMsgJs[expresion]");
//$valid->addIsTextNormal ( "CodActFijo",  "Codigo Activo Fijo, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty("CodActFijo", "Codigo Activo Fijo, $errorMsgJs[expresion]");

$valid->addIsDate("dia1", "mes1", "ano1", "Fecha de Alta, $errorMsgJs[date]");
$valid->addIsDate("dia2", "mes2", "ano2", "Fecha de Garantia Inicio, $errorMsgJs[date]");
$valid->addIsDate("dia3", "mes3", "ano3", "Fecha de Garantia Final, $errorMsgJs[date]");
//$valid->addCompareDates   ( "dia1", "mes1", "ano1","dia2", "mes2", "ano2", $errorMsgJs[compareDates]);
$valid->addCompareDates("dia2", "mes2", "ano2", "dia3", "mes3", "ano3", "$errorMsgJs[compareDates]");
$valid->addFunction("activoFijo", "");
print $valid->toHtml();
?>
<script language="JavaScript">
<!--
    function Form() {
        var key = window.event.keyCode;
        if (key == 13)
            return false;
        else
            return true;
    }
-->
</script>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td height="326"><div align="center"> 
                    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
                        <tr> 
                            <td><div align="center"><strong><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">LLENADO 
                                        DE FICHA TECNICA</font></strong></div></td>
                        </tr>
                    </table>
                    <table width="100%" border="1" cellpadding="1" cellspacing="0" background="images/fondo.jpg">
                        <tr> 
                            <td height="190"> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr> 
                                        <td colspan="2"><div align="center"> 
                                                <p><strong><font size="2" face="Arial, Helvetica, sans-serif">TIPO 
                                                        DE REGISTRO :</font> </strong> 
                                                    <select name="TpRegFicha" tabindex="50">
                                                        <?php
                                                        $sql = "SELECT * FROM menu_parametros WHERE cat='ft' AND estado =1 ORDER BY descrip ASC";
                                                        $result = mysql_db_query($db, $sql, $link);
                                                        while ($row = mysql_fetch_array($result)) {
                                                            echo "<option value=\"$row[descrip]\">$row[descrip]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    &nbsp;</p>
                                                <p>&nbsp;</p>
                                            </div></td>
                                    </tr>
                                    <tr> 
                                        <td width="47%"><strong>&nbsp;</strong><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
                                            de Prueba de Funcionamiento : <?php echo date("d/m/Y"); ?> </font>
                                        </td>
                                        <td width="53%"> <font size="2" face="Arial, Helvetica, sans-serif">Realizado 
                                            por &nbsp; &nbsp;:</font>&nbsp;&nbsp;&nbsp; 
                                            <select name="RealizFicha" id="select" tabindex="55">
                                                <option value="0"></option>
                                                <?php
                                                $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0 ORDER BY apa_usr ASC";
                                                $result = mysql_db_query($db, $sql, $link);
                                                while ($row = mysql_fetch_array($result)) {
                                                    echo "<option value=\"$row[login_usr]\"";
                                                    if (isset($_REQUEST['RealizFicha']) == $row['login_usr'])
                                                        print "selected";
                                                    print ">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
                                                }
                                                ?>
                                            </select></td>
                                    </tr>
                                </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr> 
                                        <td width="47%" height="23"><strong>&nbsp;</strong><font size="2" face="Arial, Helvetica, sans-serif">Marca 
                                            &nbsp;&nbsp;:</font><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> 
                                            <input name="Marca" type="text" value="<?php print isset($_REQUEST['Marca']); ?>" size="39" maxlength="40" tabindex="51"></td>
                                        <td width="53%"><font size="2" face="Arial, Helvetica, sans-serif">Codigo 
                                            Adicional &nbsp;:</font> <input name="AdicUSI" type="text" value="<?php print isset($_REQUEST['AdicUSI']) ?>" size="40" maxlength="40" tabindex="56"></td>
                                    </tr>
                                    <tr> 
                                        <td height="22"><strong>&nbsp;</strong><font size="2" face="Arial, Helvetica, sans-serif">Modelo 
                                            &nbsp;&nbsp;:</font>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<input name="Modelo" type="text" value="<?php print isset($_REQUEST['Modelo']) ?>" size="39" maxlength="40" tabindex="52"></td>
                                        <td><font size="2" face="Arial, Helvetica, sans-serif">Codigo 
                                            Activo Fijo:</font> 
                                            <input name="CodActFijo" type="text" readonly="yes" value="<?php echo isset($_REQUEST['cod_act']) ?>" size="40" maxlength="40">
                                            <input name="INGRESAR" type="button" id="INGRESAR" value="INGRESAR" onClick="caedec('activ_princ_clien');"  tabindex="57"></td>
                                    </tr>
                                    <tr> 
                                        <td><strong>&nbsp;</strong><font size="2" face="Arial, Helvetica, sans-serif">N&deg; 
                                            de Serie :</font> <input name="NumSerie" type="text" value="<?php print isset($_REQUEST['NumSerie']) ?>" size="39" maxlength="20" tabindex="53"></td>
                                        <td><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
                                            de Alta :</font>&nbsp; 
                                            <?php
                                            $fsist = date("Y-m-d");
                                            ?>
                                            <select name="dia1" tabindex="58" >
                                                <?php
                                                if ($_REQUEST['GUARDATOS']) {
                                                    $a1 = $ano1;
                                                    $m1 = $mes1;
                                                    $d1 = $dia1;
                                                } else {
                                                    $a1 = substr($fsist, 0, 4);
                                                    $m1 = substr($fsist, 5, 2);
                                                    $d1 = substr($fsist, 8, 2);
                                                }
                                                for ($i = 1; $i <= 31; $i++) {
                                                    echo "<option value=\"$i\"";
                                                    if ($d1 == "$i")
                                                        echo "selected";
                                                    echo">$i</option>";
                                                }
                                                ?>
                                            </select> <select name="mes1" tabindex="59">
                                                <?php
                                                for ($i = 1; $i <= 12; $i++) {
                                                    echo "<option value=\"$i\"";
                                                    if ($m1 == "$i")
                                                        echo "selected";
                                                    echo">$i</option>";
                                                }
                                                ?>
                                            </select> <select name="ano1" tabindex="60">
<?php
for ($i = 1990; $i <= 2020; $i++) {
    echo "<option value=\"$i\"";
    if ($a1 == "$i")
        echo "selected";
    echo">$i</option>";
}
?>
                                            </select>
                                            <strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong> 
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td>&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">Proveedor 
                                            :<strong>&nbsp;</strong></font>&nbsp; <select name="Proveedor" id="Proveedor" tabindex="54">
                                                <option value="0"></option>
<?php
//include ("conexion.php");
$sql = "SELECT IdProv, NombProv FROM proveedor";
$result = mysql_db_query($db, $sql, $link);
while ($row = mysql_fetch_array($result)) {
    echo "<option value=\"$row[IdProv]\"";
    if (isset($_REQUEST['Proveedor']) == $row['IdProv'])
        print "selected";
    print "> $row[NombProv] </option>";
}
?>
                                            </select> </td>
                                        <td><font size="2" face="Arial, Helvetica, sans-serif">Garantia 
                                            del&nbsp;</font><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;</font>&nbsp;&nbsp;&nbsp;</strong> 
                                                <?php
                                                $fsist = date("Y-m-d");
                                                ?>
                                            <select name="dia2" tabindex="60" >
                                                <?php
                                                if ($_REQUEST['GUARDATOS']) {
                                                    $a2 = $ano2;
                                                    $m2 = $mes3;
                                                    $d2 = $dia2;
                                                } else {
                                                    $a2 = substr($fsist, 0, 4);
                                                    $m2 = substr($fsist, 5, 2);
                                                    $d2 = substr($fsist, 8, 2);
                                                }
                                                for ($i = 1; $i <= 31; $i++) {
                                                    echo "<option value=\"$i\"";
                                                    if ($d2 == "$i")
                                                        echo "selected";
                                                    echo">$i</option>";
                                                }
                                                ?>
                                            </select> <select name="mes2" tabindex="61">
<?php
for ($i = 1; $i <= 12; $i++) {
    echo "<option value=\"$i\"";
    if ($m2 == "$i")
        echo "selected";
    echo">$i</option>";
}
?>
                                            </select> <select name="ano2" tabindex="62">
                                            <?php
                                            for ($i = 1990; $i <= 2020; $i++) {
                                                echo "<option value=\"$i\"";
                                                if ($a2 == "$i")
                                                    echo "selected";
                                                echo">$i</option>";
                                            }
                                            ?>
                                            </select>
                                            <strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal2.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></td>
                                    </tr>
                                </table>
                                <!---------------------------------------------------------------------------------------------->

                                <!---------------------------------------------------------------------------------------------->
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr> 
                                        <td width="47%">&nbsp;</td>
                                        <td width="53%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;al&nbsp;&nbsp;&nbsp;&nbsp;</font> 
                                            &nbsp; 
                                                <?php
                                                $fsist = date("Y-m-d");
                                                ?>
                                            <select name="dia3" tabindex="63">
                                                <?php
                                                if ($_REQUEST['GUARDATOS']) {
                                                    $a3 = $ano3;
                                                    $m3 = $mes3;
                                                    $d3 = $dia3;
                                                } else {
                                                    $a3 = substr($fsist, 0, 4);
                                                    $m3 = substr($fsist, 5, 2);
                                                    $d3 = substr($fsist, 8, 2);
                                                }
                                                for ($i = 1; $i <= 31; $i++) {
                                                    echo "<option value=\"$i\"";
                                                    if ($d3 == "$i")
                                                        echo "selected";
                                                    echo">$i</option>";
                                                }
                                                ?>
                                            </select> <select name="mes3" tabindex="64">
                                            <?php
                                            for ($i = 1; $i <= 12; $i++) {
                                                echo "<option value=\"$i\"";
                                                if ($m3 == "$i")
                                                    echo "selected";
                                                echo">$i</option>";
                                            }
                                            ?>
                                            </select> <select name="ano3" tabindex="65">
                                            <?php
                                            for ($i = 1990; $i <= 2020; $i++) {
                                                echo "<option value=\"$i\"";
                                                if ($a3 == "$i")
                                                    echo "selected";
                                                echo">$i</option>";
                                            }
                                            ?>
                                            </select>
                                            &nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal3.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                            /* $dep_cod=$_POST['dep_cod'];
                                              echo "AREA:"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                              echo "<select name=\"dep_cod\" onChange=\"this.form.submit()\">\n";
                                              echo "<option value=\"\"> Seleccione el Area</option>\n";

                                              $sql_p="SELECT * FROM area";
                                              $con_p = mysql_db_query($db,$sql_p,$link);

                                              while($reg_p=mysql_fetch_assoc($con_p)){

                                              if ($dep_cod== $reg_p['area_cod']){
                                              echo "<option value=\"".$reg_p['area_cod']."\" selected>".$reg_p['area_nombre']."</option>\n";
                                              } else {
                                              echo "<option value=\"".$reg_p['area_cod']."\">".$reg_p['area_nombre']."</option>\n";
                                              }
                                              }
                                              echo "</select>\n\n";
                                              mysql_free_result($con_p); */
                                            ?>
                                            <br></br>
<?php
/* echo "UBICACION:"; echo "<select name=\"ubica\">\n";

  if (!empty($dep_cod)){

  $sql_hi="SELECT * FROM ficha_ubica WHERE `id_dep` = '$dep_cod'";
  $con_h = mysql_query($sql_hi) or die(mysql_error());

  if (mysql_num_rows($con_h) != 0){
  echo "<option value=\"0\">Seleccione una ubicacion</option>";
  while($reg_h=mysql_fetch_assoc($con_h)){

  echo "<option value=\"".$reg_h['id_agencia']."\">".$reg_h['agencia']."</option>\n";
  }
  } else {
  echo "<option value=\"\"> No hay registros para esta area</option>";
  }
  } else {
  echo "<option value=\"\">Seleccione la ubicacion </option>";
  }
  mysql_free_result($con_h);

  echo "</select>\n\n"; */
?>
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td height="41" colspan="2"> <p align="center"><br>
                                                <input type="submit" name="GUARDATOS" value="GUARDAR Y CONTINUAR" <?php print $valid->onSubmit() ?> tabindex="66">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR" tabindex="67">
                                            </p></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                    <p><strong>
                        </strong></p>
                </div></td>
        </tr>
    </table>
</form>
<script language="JavaScript">
    <!-- 
                 var cal1 = new calendar1(document.forms['form1'].elements['dia1'], document.forms['form1'].elements['mes1'], document.forms['form1'].elements['ano1']);
    cal1.year_scroll = true;
    cal1.time_comp = false;
    var cal2 = new calendar1(document.forms['form1'].elements['dia2'], document.forms['form1'].elements['mes2'], document.forms['form1'].elements['ano2']);
    cal2.year_scroll = true;
    cal2.time_comp = false
    var cal3 = new calendar1(document.forms['form1'].elements['dia3'], document.forms['form1'].elements['mes3'], document.forms['form1'].elements['ano3']);
    cal3.year_scroll = true;
    cal3.time_comp = false;
    function caedec(campo) {
        var camp = campo;
        window.open('comprobar.php', 'Boris', 'toolbar=no,status=no,menubar=no,location=no,directories=no,resizable=no,scrollbars=no,width=530,height=175,left=150,top=150');
    }
//-->
</script>
<script language="JavaScript">
    function activoFijo() {
        var form = document.form1;
        var msg = "\n \n Mensaje generado por GesTor F1.";

<?php
include ("conexion.php");
$vector = array();
$str = "SELECT * FROM datfichatec";
$res = mysql_db_query($db, $str, $link);
$c = 0;
while ($fila = mysql_fetch_array($res)) {
    $vector[$c] = $fila['CodActFijo'];
    $c++;
}
$j = 0;
?>
        var activo;
        var c;
        var mat = new Array();
        for (i = 0; i < c; i++)
            mat[i] = new Array();
        /*for (i=0; i<c; i++){
         mat[i] ="<?php echo $vector[$j]; ?>";	
<?php $j++; ?>
         }*/
        mat = "<?php echo $vector; ?>";
        c = "<?php echo $c; ?>";
        for (i = 0; i < c; i++)
        {
            if (form.CodActFijo.value == mat[i])
            {
                activo = "1";
            }
        }
        //activo = "1";
        if (activo == 1)
        {	//if (form.CodActFijo.value == activo ) {
            alert("Activo Fijo debe ser un valor unico" + msg);
            return (false);
            //}
        }
        return true;
    }
</script>
<?php
if (isset($errorForm)) {
    print "<script language=\"JavaScript\">\n<!--\n";
    foreach ($errorForm as $tmp) {
        print "alert (\"$tmp\");\n";
    }
    print "-->\n</script>";
}
?>  
<?php include("top_.php"); ?>
