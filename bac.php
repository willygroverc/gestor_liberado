<script>setTimeout('document.location.reload()',10000); </script>
<?php
include ("conexion.php");
echo "<script>setTimeout('document.location.reload()',10000); </script>\n";
$ip = $_SERVER['REMOTE_ADDR'];
backup_tablas('localhost','root','','prueba');

function backup_tablas($host,$user,$pass,$name,$tablas = '*')
{
   
   $link = mysql_connect($host,$user,$pass);
   mysql_select_db($name,$link);
   if($tablas == '*')
   {
      $tablas = array();
      $result = mysql_query('SHOW TABLES');
      while($row = mysql_fetch_row($result))
      {
         $tablas[] = $row[0];
      }
   }
   else
   {
      $tablas = is_array($tablas) ? $tablas : explode(',',$tablas);
   }
   
   foreach($tablas as $table)
   {
      $result = mysql_query('SELECT * FROM '.$table);
      $num_fields = mysql_num_fields($result);
      
     // $return.= 'DROP TABLE '.$table.';';
      $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
      $return.= "\n\n".$row2[1].";\n\n";
      
    for ($i = 0; $i < $num_fields; $i++)
      {
         while($row = mysql_fetch_row($result))
         {
            $return.= 'INSERT INTO '.$table.' VALUES(';
            for($j=0; $j<$num_fields; $j++) 
            {
               $row[$j] = addslashes($row[$j]);
               $row[$j] = ereg_replace("\n","\\n",$row[$j]);
               if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
               if ($j<($num_fields-1)) { $return.= ','; }
            }
            $return.= ");\n";
         }
      }
      $return.="\n\n\n";
   }
   
   $handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tablas))).'.sql','w+');
   fwrite($handle,$return);
   fclose($handle);
}
$sqlSystem = "SELECT nombre, mail, conf_mail, conf_sms, web, mail_institucion FROM control_parametros";
$systemData = mysql_fetch_array(mysql_db_query($db, $sqlSystem, $link));
$hora_backup=date("h:i:s");
$fecha_backup=date("d-M-Y");
$nombre_host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$correo = 'arodriguez@yanapti.com';					
							if (!(empty($correo)))
							{
								$asunto = "Backup de base de datos realizado con exito";	
								$mail = $correo;
								$mensaje = "
									<b>Mensaje Generado por el Gestor F1</b> <br>
									<b>-----------------------------------------------------</b><br><br>												
									<b>Se realizo correctamente el Backup 
									de la base de datos</b><br><br>
									<b>Hora:</b> &nbsp;&nbsp;&nbsp;$hora_backup <br>
									<b>Fecha:</b>&nbsp;&nbsp;&nbsp;$fecha_backup<br> 
									<b>IP:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ip<br>
									<b>Nombre del equipo:</b>&nbsp;&nbsp;&nbsp;&nbsp;$nombre_host<br>
									$systemData[nombre];
									<br>
									Para mayores detalles, consulte el Sistema GesTor F1. <br>
									$systemData[nombre]";
									$tunombre = $systemData[nombre];		
									$tuemail = $systemData[mail_institucion];
									$headers = "MIME-Version: 2.0\r\n"; 
									$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
									$headers .= "From: $tunombre <$tuemail>\r\n"; 
									mail($mail,$asunto,$mensaje,$headers);
							}
?>