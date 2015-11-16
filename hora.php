<body onLoad="show5()">
<span id="liveclock" style="position:absolute;left:0;top:0;">
</span>
<script type="text/javascript">
<!--
function show5(){
 if (!document.layers&&!document.all&&!document.getElementById)
 return
 var Digital=new Date()
 var hours=Digital.getHours()
 var minutes=Digital.getMinutes()
 var seconds=Digital.getSeconds()
 var dn="AM" 
 if (hours>12){
 dn="PM"
 hours=hours-12
 }
 if (hours==0)
 hours=12
 if (minutes<=9)
 minutes="0"+minutes
 if (seconds<=9)
 seconds="0"+seconds
//change font size here to your desire
myclock="<font size='5' face='Arial' ><b><font size='1'></font></br>"+hours+":"+minutes+":"
 +seconds+" "+dn+"</b></font>"
 //	alert(seconds);
 if(hours==04 & minutes==16 & seconds==00){
 	if(dn=="AM")
 	{
 		location.reload();
 	}
 }
if (document.layers){
document.layers.liveclock.document.write(myclock)
document.layers.liveclock.document.close()
}
else if (document.all)
liveclock.innerHTML=myclock
else if (document.getElementById)
document.getElementById("liveclock").innerHTML=myclock
setTimeout("show5()",1000)
 }
//-->
//setTimeout('document.location.reload()',10000);
</script>
</body>   
<?php
include ("../conexion.php");
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
   $as=(md5(implode(',',$tablas)));
   $time=time();
   $nom = 'db-backup-'."$time-"."$as";
   
   $handle = fopen('db-backup-'."$time".'-'.(md5(implode(',',$tablas))).'.sql','w+');
   $archivo=fopen('db-backup-'.time().'-'.(md5(implode(',',$tablas))).'.sql','w+');
   fwrite($handle,$return);
   fclose($handle);
}
//Busca el archivo lo carga y saca su hash
function buscar($dir,&$archivo_buscar)
{   
     if ( is_dir($dir) )
     {
          $d=opendir($dir); 
          while( $archivo = readdir($d) )
          {
            if ( $archivo!="." AND $archivo!=".."  )
            {
                 if ( is_file($dir.'/'.$archivo) )
                 {
                      if ( $archivo == $archivo_buscar  )
                      {
                           return ($dir.'/'.$archivo);
                    }
                    
                }
                 
                if ( is_dir($dir.'/'.$archivo) )
                {
                     
                     $r=buscar($dir.'/'.$archivo,$archivo_buscar);
                     if ( basename($r) == $archivo_buscar )
                     {
                          return $r;
                    }    
                }    
            }         
        }       
    }
    return FALSE;
}

$archivo='$nom.php';
$hash=md5_file($archivo);
echo buscar('C:/Apache2.2/htdocs/gestor_demo/backups',$archivo);
echo "<br>";
echo $hash;
//Hasta aca e proceso de hash del archivo
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
