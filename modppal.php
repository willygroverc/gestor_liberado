<?php
 
// valida Email
function NotIsEmail($sCadena)
{
   // primero validamos la longuitud de la direccion
   if ((strlen($sCadena) < 8) or (strlen($sCadena) > 100)) 
      return 'La dirección de <b>E-mail</b> debe tener mínimo ocho (8) caracteres 
y un máximo de cien (100)';
  else
  {
    return (!preg_match("/^[_a-zA-Z0-9-ñÑ]+(\\.[_a-zA-Z0-9-ñÑ]+)*@+([_a-zA-Z0-9-
]+\\.)*[a-zA-Z0-9-]{2,100}\\.[a-zA-Z]{2,6}$/",$sCadena) ? 
'El formato correcto del <b>E-mail</b> es "Id[arroba]dominio[punto]algo",<br/> 
ej: "camila_canaval@gmail.com"' : false);
  }
}
 
// los campos Nombre y Apellido deben ser alfanbeticos y tener ciertas dimensiones
function NotIsCorrect($sCadena,$sCampo)
{
   if (!preg_match("/^[a-z_ÑÁÉÍÓÚÄËÏÖÜñáéíóüäëïöü\'\s]*$/i",$sCadena))
      return "El campo <b>$sCampo</b> solo acepta caracteres alfanumericos y espacios, 
apóstrofe";
   elseif ((strlen($sCadena) < 2) or (strlen($sCadena) > 40))
      return "El <b>$sCampo</b> debe estar formado por mas de una letra y 
ser menor o igual a cuarenta (40) caracteres";
   else
      return false;
}
 
// campo CI debe albergar solo numeros y tener cirtas dimensiones
function ($CI)
{
   if (!ctype_digit($CI))
      return 'El campo <b>Cédula de Identidad</b> solo acepta números';
   elseif (substr($CI,0,1) == 0)
      return 'La <b>Cédula de Identidad</b> no puede comenzar por cero (0)';
   elseif (strlen($CI) > 8)
      return 'La <b>Cédula de Identidad</b> debe ser menor o igual a ocho (8)';
   else
      return false;
}
 
// el password debe tener minimo 6 y maximo 20 caracteres    
function NotIsPassword($sCadena)
{
   if (!ctype_alnum($sCadena))
      return 'Solo se permiten caracteres <b>alfa-numéricos</b> (letras/números) en el campo password';
   elseif ((strlen($sCadena) <= 5) or (strlen($sCadena) > 25))
      return 'El campo Password debe ser mayor a seis (5) caracteres y 
ser menor o igual a veinticinco (25) caracteres';
   else
      return false;
}
 
// se compara el campo de confirmacion
function NotIsEqua($sValCampo1,$sValCampo2,$sCampoName)
{
   return ($sValCampo1 != $sValCampo2) ? 
   "El segundo <b>$sCampoName</b> introducido no coincide con el primero<br/>
Respete las letras mayusculas y minusculas" : false;
}
?>