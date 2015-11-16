<?php
@session_start();
require ("../conexion.php");
require_once('../funciones.php');
        $Descripcion=  $_POST['Descripcion'];
	$Id_Tipo=$_POST['Id_Tipo'];
	$Area=$_POST['Area'];
	$Titular1=$_POST['Titular1'];
	$Suplente1=$_POST['Suplente1'];
	$Titular2=$_POST['Titular2'];
	$Suplente2=$_POST['Suplente2'];
        $var1=$_POST['var1'];
        
	$Descripcion=_clean($Descripcion);
	$Id_Tipo=_clean($Id_Tipo);
	$Titular1=_clean($Titular1);
	$Suplente1=_clean($Suplente1);
	$Area=_clean($Area);
	$Titular2=_clean($Titular2);
	$Suplente2=_clean($Suplente2);
	
	$Descripcion=SanitizeString($Descripcion);
	$Id_Tipo=SanitizeString($Id_Tipo);
	$Titular1=SanitizeString($Titular1);
	$Suplente1=SanitizeString($Suplente1);
	$Area=SanitizeString($Area);
	$Titular2=SanitizeString($Titular2);
	$Suplente2=SanitizeString($Suplente2);
	
	$Descripcion=normaliza($Descripcion);
	$Id_Tipo=normaliza($Id_Tipo);
	$Titular1=normaliza($Titular1);
	$Suplente1=normaliza($Suplente1);
	$Area=normaliza($Area);
	$Titular2=normaliza($Titular2);
	$Suplente2=normaliza($Suplente2);
        

	//ajax.send("RealizFicha="+RealizFicha.value+"marca="+marca.value+"&AdicUSI1="+AdicUSI1.value+"&Modelo1="+Modelo.value+"&CodActFijo1="+CodActFijo1.value+"&NumSerie1="+NumSerie.value+"&FechAlta="+FechAlta.value+"&GarantDe="+GarantDe.value+"&GarantAl="+GarantAl.value);
	$sql="UPDATE sistemas SET Descripcion='$Descripcion',Id_Tipo='$Id_Tipo',Titular1='$Titular1',Suplente1='$Suplente1',".
	"Area='$Area',Titular2='$Titular2',Suplente2='$Suplente2' WHERE Id_Sistema='$var1'";

if (mysql_query($sql)) {
    //print_r($sql);exit;	
    echo 0;
} // Insercion correcta
else{
    //print_r($sql);exit;	
                    echo $sql;

}
?>