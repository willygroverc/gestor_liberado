<?php 
include("conexion.php");

$i=1;

$sql="DROP TABLE `asignacion`, `ordenes`, `solucion`, `conformidad`, `seguimiento`, `parametros_dym`, `solicitud`, `cronograma`, `aprobus`, `implantus`";
if(mysql_db_query($db,$sql,$link)){$i++;}
else{$j=1;}

$sql="CREATE TABLE asignacion (
  id_asig int(8) NOT NULL auto_increment,
  id_orden int(11) NOT NULL default '0',
  nivel_asig int(1) NOT NULL default '0',
  criticidad_asig int(1) NOT NULL default '0',
  prioridad_asig int(1) NOT NULL default '0',
  asig varchar(100) NOT NULL default '0',
  fecha_asig date NOT NULL default '0000-00-00',
  hora_asig time NOT NULL default '00:00:00',
  fechaestsol_asig date NOT NULL default '0000-00-00',
  reg_asig varchar(100) NOT NULL default '',
  diagnos varchar(100) NOT NULL default '',
  escal varchar(100) NOT NULL default '',
  date_esc date NOT NULL default '0000-00-00',
  time_esc time NOT NULL default '00:00:00',
  fechasol_esc date NOT NULL default '0000-00-00',
  area varchar(20) default NULL,
  area_1 varchar(10) NOT NULL default '',
  PRIMARY KEY  (id_asig),
  KEY id_asig (id_asig)
) TYPE=MyISAM
";
if(mysql_db_query($db,$sql,$link)){$i++;}
else{$j=2;}

$sql="CREATE TABLE ordenes (
  id_orden int(11) NOT NULL auto_increment,
  fecha date NOT NULL default '0000-00-00',
  time time NOT NULL default '00:00:00',
  cod_usr varchar(15) NOT NULL default '0',
  desc_inc text NOT NULL,
  tipo varchar(30) default NULL,
  nomb_archivo mediumtext NOT NULL,
  ci_ruc varchar(20) NOT NULL default '',
  id_anidacion int(11) NOT NULL default '0',
  origen varchar(20) NOT NULL default '',
  hash_archivo text NOT NULL,
  KEY id_orden (id_orden)
) TYPE=MyISAM COMMENT='ORDEN DE TRABAJO'";
if(mysql_db_query($db,$sql,$link)){$i++;}
else{$j=3;}


$sql="CREATE TABLE conformidad (
  id_orden int(11) NOT NULL default '0',
  fecha_conf date NOT NULL default '0000-00-00',
  hora_conf time NOT NULL default '00:00:00',
  tiemposol_conf char(1) NOT NULL default '',
  calidaten_conf char(1) NOT NULL default '',
  obscli_conf text NOT NULL,
  reg_conf varchar(100) NOT NULL default '0',
  tipo_conf char(1) NOT NULL default '',
  UNIQUE KEY id_orden_2 (id_orden),
  KEY id_orden (id_orden)
) TYPE=MyISAM";
if(mysql_db_query($db,$sql,$link)){$i++;}
else{$j=4;}

$sql="CREATE TABLE seguimiento (
  id_seg int(11) NOT NULL auto_increment,
  id_orden int(11) NOT NULL default '0',
  estado_seg varchar(10) NOT NULL default '',
  obs_seg varchar(200) NOT NULL default '',
  fecha_seg date NOT NULL default '0000-00-00',
  hora_seg time NOT NULL default '00:00:00',
  login_usr varchar(100) NOT NULL default '0',
  KEY id_seg (id_seg)
) TYPE=MyISAM";
if(mysql_db_query($db,$sql,$link)){$i++;}
else{$j=5;}

$sql="CREATE TABLE solucion (
  id_orden int(11) NOT NULL default '0',
  detalles_sol text NOT NULL,
  fecha_sol_e date NOT NULL default '0000-00-00',
  fecha_sol date NOT NULL default '0000-00-00',
  hora_sol time NOT NULL default '00:00:00',
  medprev_sol text NOT NULL,
  login_sol varchar(100) NOT NULL default '0',
  nomb_archivo mediumtext NOT NULL,
  hash_archivo text NOT NULL,
  UNIQUE KEY id_orden (id_orden)
) TYPE=MyISAM";
if(mysql_db_query($db,$sql,$link)){$i++;}
else{$j=6;}

$sql="CREATE TABLE parametros_dym (
  id_etapa tinyint(4) NOT NULL default '0',
  etapa_1 text NOT NULL,
  etapa_2 text NOT NULL,
  etapa_3 text NOT NULL,
  etapa_4 text NOT NULL,
  etapa_5 text NOT NULL,
  etapa_6 text NOT NULL,
  etapa_7 text NOT NULL,
  etapa_8 text NOT NULL,
  etapa_9 text NOT NULL,
  etapa_10 text NOT NULL,
  etapa_11 text NOT NULL,
  etapa_12 text NOT NULL
) TYPE=MyISAM";
if(mysql_db_query($db,$sql,$link)){$i++;}
else{$j=7;}

$sql="INSERT INTO parametros_dym VALUES (1, 'Especificación de requerimientos', 'Aprobacion de requerimientos por el usuario', 'Análisis', 'Diseño', 'Programación', 'Pruebas', 'Documentación', 'Pase a Produccion', 'Capacitación', 'Implantación', 'Explotación', 'Satisfaccion usuaria')";
if(mysql_db_query($db,$sql,$link)){$i++;}
else{$j=8;}

$sql="CREATE TABLE cronograma (
  IdCrono int(8) NOT NULL auto_increment,
  TareCrono varchar(40) NOT NULL default '',
  FeProIni date default '0000-00-00',
  FeProTer date default '0000-00-00',
  FeRealIni date default '0000-00-00',
  FeRealTer date default '0000-00-00',
  RubricaR varchar(30) default NULL,
  Observ mediumtext,
  OrdAyuda int(5) NOT NULL default '0',
  estado tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (IdCrono),
  UNIQUE KEY IdCrono (IdCrono)
) TYPE=MyISAM";
if(mysql_db_query($db,$sql,$link)){$i++;}
else{$j=9;}


$sql="CREATE TABLE solicitud (
  IdSolicitud int(11) NOT NULL auto_increment,
  OrdAyuda int(11) NOT NULL default '0',
  Fecha date NOT NULL default '0000-00-00',
  Hora time NOT NULL default '00:00:00',
  AsignA varchar(30) NOT NULL default '',
  Viabilidad set('SI','NO') NOT NULL default '',
  Tiempo varchar(10) NOT NULL default '',
  Tiempo1 varchar(15) NOT NULL default '',
  CostoI float(10,2) NOT NULL default '0.00',
  MonedaI set('Bs','Sus') NOT NULL default '',
  CostoII float(10,2) NOT NULL default '0.00',
  MonedaII set('Bs','Sus') NOT NULL default '',
  Prioridad int(1) NOT NULL default '0',
  FechEstEnt date NOT NULL default '0000-00-00',
  Aceptac set('SI','NO') NOT NULL default '',
  FechAcep date NOT NULL default '0000-00-00',
  estado int(1) NOT NULL default '0',
  UNIQUE KEY IdSolicitud (IdSolicitud,OrdAyuda,AsignA)
) TYPE=MyISAM";
if(mysql_db_query($db,$sql,$link)){$i++;}
else{$j=10;}

$sql="CREATE TABLE aprobus (
  IdAprob int(5) NOT NULL auto_increment,
  NombRespAp varchar(70) NOT NULL default '',
  FechRespAp date NOT NULL default '0000-00-00',
  NomUsRespAp varchar(70) NOT NULL default '',
  FechUsRespAp date NOT NULL default '0000-00-00',
  ComCambAp varchar(70) NOT NULL default '',
  FechComAp date NOT NULL default '0000-00-00',
  OrdAyuda int(5) NOT NULL default '0',
  estado int(1) NOT NULL default '0',
  observ1 text NOT NULL,
  observ2 text NOT NULL,
  observ3 text NOT NULL,
  PRIMARY KEY  (IdAprob),
  UNIQUE KEY IdAprob (IdAprob,OrdAyuda)
) TYPE=MyISAM";
if(mysql_db_query($db,$sql,$link)){$i++;}
else{$j=11;}


$sql="CREATE TABLE implantus (
  IdConf int(5) NOT NULL auto_increment,
  NomCordCamb varchar(70) NOT NULL default '',
  FechCordConf date NOT NULL default '0000-00-00',
  ResuCordConf set('SI','PARCIAL','NO') NOT NULL default '',
  NomUsConf varchar(70) NOT NULL default '',
  FechUsConf date NOT NULL default '0000-00-00',
  ResuUsConf set('SI','PARCIAL','NO') NOT NULL default '',
  OrdAyuda int(5) NOT NULL default '0',
  estado int(1) NOT NULL default '0',
  observ1 text NOT NULL,
  observ2 text NOT NULL,
  PRIMARY KEY  (IdConf),
  UNIQUE KEY IdConf (IdConf,OrdAyuda)
) TYPE=MyISAM";
if(mysql_db_query($db,$sql,$link)){$i++;}
else{$j=12;}

if($i==13){echo "LA BASE DE DATOS SE ACTUALIZO CON EXITO. FELICIDADES!!!!!!";}
else
{
if($j==1){echo "Error al borrar las bases de Datos";}
if($j==2){echo "Error al crear la tabla ASIGNACION";}
if($j==3){echo "Error al crear la tabla ORDENES";}
if($j==4){echo "Error al crear la tabla CONFORMIDAD";}
if($j==5){echo "Error al crear la tabla SEGUIMIENTO";}
if($j==6){echo "Error al crear la tabla SOLUCION";}
if($j==7){echo "Error al crear la tabla PARAMETROS_DYM";}
if($j==8){echo "Error al INSERTAR DATOS en la tabla PARAMETROS DYM";}
if($j==9){echo "Error al crear la tabla CRONOGRAMA";}
if($j==10){echo "Error al crear la tabla SOLICITUD";}
if($j==11){echo "Error al crear la tabla APROBUS";}
if($j==12){echo "Error al crear la tabla IMPLANTUS";}

}

?>

