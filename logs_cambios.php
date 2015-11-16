<?php include ("conexion.php");?>
<html>
<HEAD>
<TITLE>GesTor F1</TITLE>
<style>
textarea { font-size:9 pt; font-family: VERDANA; 
}
</style>

<script language="JavaScript" type="text/javascript">
<!--
function textValue(){	
	var stationInteger, stationString
	var str, srt2, str3, str4, str5
	var cad
		
	stationInteger=document.stationform.stationselect.selectedIndex	
	stationString=document.stationform.stationselect.options[stationInteger].text
	if ( stationString == "Version 1.0.2")	
	{	
		str =  " - Paginacion  de  las ordenes de trabajo. El  numero  de registros que  se despliegan por pagina  es  configurable  desde  los parametros del Sistema. \n\n- Notificacion por Correo Electronico al Administrador de Mesa de Ayuda cuando se registra una nueva Orden de Trabajo.\n\n"		
		str2 = "- Notificacion por Correo Electronico al Tecnico cuando se asigna una nueva Orden de Trabajo. El uso del correo electronico es configurable desde los parametros del Sistema.\n\n"			
		str3 = "- Agregado un campo adicional en el perfil de Usuarios, para  registrar  la  Agencia  a la  que  corresponde en  Instituciones  que  implementan   esta  estructura, e  incorporacion en el cuadro de Estadisticas. El uso de Agencias es configurable desde los parametros del Sistema y registrado desde un formulario independiente.\n\n";
		str4 = "- Control del numero de contrasenas que pueden ser iguales en el Sistema. La cantidad es configurable desde los parametros del Sistema.\n\n- Sincronizacion y Control entre la Mesa de Ayuda y el Modulo de Desarrollo y Mantenimiento, con referencia al registro de datos\n\n- En el modulo de Soporte Tecnico, Mantenimiento Fuera, especificacion del Equipo agregando el nombre del usuario asignado.\n\n- Impresion del nombre de usuario, cantidad de ordenes de trabajo pendientes de solucion y cantidad de ordenes de trabajo pendientes de conformidad, en el menu principal.\n\n- Impresion unitaria del perfil del Usuario.\n\n- Exclusion de las cuentas administradoras del Sistema en tareas operativas.\n\n";		
		//str5 = "- Sincronizacion y Control entre la Mesa de Ayuda y el Modulo de Desarrollo y Mantenimiento, con referencia al registro de datos.\n\n- En el modulo de Soporte Tecnico, Mantenimiento Fuera, especificacion del Equipo agregando el nombre del usuario asignado.\n\n- Impresion del nombre de usuario, cantidad de ordenes de trabajo pendientes de solucion y cantidad de ordenes de trabajo pendientes de conformidad, en el menu principal.\n\n- Impresion unitaria del perfil del Usuario.\n- Exclusion de las cuentas administradoras del Sistema en tareas operativas.\n\n- Agregado un nuevo tipo de cuenta: Backup, con los mismos privilegios del tipo Administrador; con el proposito de suplir las funciones de Administrador cuando esta cuenta ha sido bloqueado.\n\n- Impresion de la descripcion de la incidencia en los formularios de la mesa de ayuda y en el modulo de Problemas e Incidentes."
		str5 = "- Agregado un nuevo tipo de cuenta: Backup, con los mismos privilegios del tipo Administrador; con el proposito de suplir las funciones de Administrador cuando esta cuenta ha sido bloqueado.\n\n- Impresion de la descripcion de la incidencia en los formularios de la mesa de ayuda y en el modulo de Problemas e Incidentes.\n\n- Llenado automatico del nombre del Proyecto en Administracion y Aseguramiento, Analisis de Riesgos y Factibilidad Economica. La lista se obtiene de Solicitud de Proyectos.\n\n- En Produccion, Inventario de Medios, agregado el filtro por Tipo, Fecha de Alta y una palabra clave de Observacion.\n\n- En Produccion, Ubicacion de Respaldos, agregado el filtro por Ubicacion.\n\n- En Contingencia, Ejecucion, el registro de datos de Llenar y Completar reducido a uno solo.	"
		document.stationform.stationtext.value = "Version 1.0.2 2009-10-01\n\n" + str + str2+ str3+ str4 + str5 +" "	
	}
	if ( stationString == "Version 1.0.3")	
	{	cad = "- Notificacion  por  mensajes SMS al telefono  movil del  Administrador  de  Mesa de  Ayuda cuando se registra una nueva Orden de Trabajo.\n\n- Notificacion  por  mensajes SMS al  telefono movil del Tecnico cuando se asigna una nueva Orden de Trabajo. El uso de mensajes SMS es configurable desde los parametros del Sistema.\n\n- En Gestion, Riesgos, campo adicional para registrar el Titulo del Ejercicio.\n\n- En  la  lista de ordenes, impresion  de la fecha de  solucion  y resaltado con un color cuando sea ha vencido.\n\n- En asignacion, en la lista historica, impresion de todos los campos registrados.";	
		document.stationform.stationtext.value = "Version 1.0.3 2010-05-01\n\n" + cad + " "
	}
	if ( stationString == "Version 1.0.4")	
	{	cad = "- Creacion de un boletin informativo para la difusion de mensajes que podrian tener un archivo adjunto. El mismo funciona tanto a nivel Interno (Intranet), como reservado (solo personal autorizado).\n\n- Paginacion en todas las listas que se presentan en el sistema. El numero de registros que se muestran por pagina es configurable desde los parametros de control del Sistema.\n\n- Busqueda por fecha y observacion en la lista de Inventario de Medios.\n\n- Mejora en la validacion de contrasenas, respecto a caracteres secuenciales y repetidos.\n\n- Control de sesion en todos los formularios de impresion.\n\n- Presentacion de mas informacion sobre la orden de trabajo (Seguimiento y Solucion) al momento de emitir la conformidad de la misma.";	
		document.stationform.stationtext.value = "Version 1.0.4 2011-02-10\n\n" + cad + " "
	}
	if ( stationString == "Version 1.1.0")	
	{	cad = "- Caracterizacion con colores de los mensajes del boletin informativo, para indicar el dia de emision del mensaje. Color rojo si es un mensaje emitido en el dia, color amarillo si es un mensaje del dia anterior y verde para los mensajes pasados.\n\n- En la paginacion existente en todas las pantallas que presentan listas, el numero de registros que se despliegan por pagina es configurable desde los parametros del Sistema y varia desde 10 hasta 50 registros por pagina.\n\n- Mejora en la descripcion del codigo del respaldo en Ubicacion de Respaldos.";	
		document.stationform.stationtext.value = "Version 1.1.0 2010-05-06\n\n" + cad + " "
	}
	if ( stationString == "Version 1.1.1")	
	{	cad1 = "- En el registro de la minuta se crearon las opciones de Agregar un Asistente Interno o un Asistente Externo a las reuniones. Por Asistente Interno, se entiende un usuario del sistema que no fue invitado. Por Asistente Externo se entiende una persona externa a la institucion y que no tiene una cuenta en el sistema.\n\n"
	    cad2 = "- En Gestion - Contratos, creacion de un campo para registrar el motivo de cierre de un contrato.\n\n"
		cad3 = "- En Planificacion Estrategica, creacion de un campo para registrar el costo estimado por estrategia y visualizacion del costo total de acuerdo al tipo de planificacion.\n\n"
		cad4 = "- En Soporte Tecnico - Fichas Tecnicas, creacion de las opciones de impresion: por agencia y por area.\n\n"
		cad5 = "- En Soporte Tecnico - Mantenimiento Fuera, creacion del campo Observaciones de Retorno, presente en la modificacion de un registro. Este campo esta destinado para el registro de la fecha real y otras observaciones de retorno del equipo.\n\n"
		cad6 = "- Impresion de los datos del usuario de acuerdo a la fecha de ultimo acceso.\n\n"
		cad7 = "- Opcion de busqueda de acuerdo al tipo de ubicacion de los respaldos.\n\n"	
		document.stationform.stationtext.value = "Version 1.1.1 2011-06-12\n\n" + cad1 + cad2 + cad3 + cad4 + cad5 + cad6 + cad7 + " "
	}
	if ( stationString == "Version 1.2.0")	
	{	cad1 = "- Se creo la seccion de Favoritos para cada sesion de Usuario.\n\n"
	    cad2 = "- Maestro de Cambios en el Modulo de Cambios en Produccion - PROACP.\n\n"
		cad3 = "- Backup de la BD en el Modulo de Seguridad.\n\n"
		cad4 = "- Creacion de seccion de Administracion de Fuentes dentro el modulo PROACP.\n\n"
		cad5 = "- Backups del modulo de fuentes de PROACP.\n\n"
		cad6 = "- Pistas de Auditoria de la seccion de Administracion de Fuentes.\n\n"
		cad7 = "- Ubicacion en la Navegacion dentro todo el Sistema hasta un nivel 3 de profundidad.\n\n"
		cad8 = "- La solucion permite adjuntar archivos.\n\n"
		cad9 = "- Nuevo ANS para proveedores.\n\n"
		cad10 = "- En la Planificacion Estrategica puede introducirse mas de una accion.\n\n"
		cad11 = "- Incluir el logo institucional dentro el control de parametros.\n\n"
		cad12 = "- Opcion de parametrizar, para no visualizar las tareas cumplidas, a nivel de usuario o sesion.\n\n"
		cad13 = "- Se clasifica las ordenes de trabajo por usuario interno y externo.\n\n"
		cad14 = "- Cuando un usuario bloquea una cuenta, el sistema envia una orden de trabajo al Administrador.\n\n"
		cad15 = "- Actualizacion de los manuales en linea: Tecnico y administrador.\n\n"
		cad16 = "- Al realizar las actas y minutas, se envian las mismas a las personas que estaran y estuvieron presentes o invitados.\n\n"	
		document.stationform.stationtext.value = "Version 1.2.0 2011-08-21\n\n" + cad1 + cad2 + cad3 + cad4 + cad5 + cad6 + cad7 + cad8 + cad9 + cad10 + cad11 + cad12 + cad13 + cad14 + cad15 + cad16 + " "
	}
	if ( stationString == "Version 1.3.0")	
	{	cad = "- Se introdujo un campo de codigo para Iventario de Medios en PROAPD.\n\n- Las Ordenes de Trabajo tienen un filtrado mas especifico.\n\n-  Los archivos dentro de Repositorio ya se asignan a un usuario especifico cuando se pasa a Copia de Trabajo.\n\n- En D&M se puede realizar la impresion de manera individual, no es necesario llenar todo el formulario.\n\n- En Administracion de Fuentes se introdujo un campo de observaciones en la subida a Replica y a Repositorio.\n\n- En Fichas Tecnicas de PROAST se puede ingresar mas caracteristicas de un dispositivo o parte de un equipo, como tambien el software que contiene cada computador.";	
		document.stationform.stationtext.value = "Version 1.3.0 2011-09-21\n\n" + cad + " "
	}
	if ( stationString == "Version 1.3.2")	
	{	cad = "- Se incluyo la opcion de registro de retorno del mantenimiento fuera de los dispositivos.\n\n- Nueva pantalla de aviso sobre las ordenes abiertas y los contratos que se venceran en un determinado tiempo, este tiempo es parametrizable.\n\n- En proyectos se graba la fecha de ejecucion de cada fase.\n\n- En las Estadisticas de Contratos se muestra un detalle de los contratos que se estan por vencer, es parametrizable este campo, para determinar el tiempo de alerta.\n\n- Los contratos ya tiene un control cuando la entrega sea por fases o solo unica fase.\n\n- Se incremento el modulo de Capacitacion para poder tomarse evaluaciones de prueba para la certificacion CISA.\n\n- Se incremento la opcion de parametrizar la vista de los datos de los Titulares en la pantalla de registro de Ordenes.\n\n- Nueva forma de comprobar el Codigo de Activo Fijo dentro el inventario de Fichas Tecnicas en PROAST.";	
		document.stationform.stationtext.value = "Version 1.3.2 2012-05-12\n\n" + cad + " "
	}
	if ( stationString == "Version 1.4.0")	
	{	cad = "- En contratos se introdujo la opcion de busquedas por proveedor.\n\n- En Proveedores se incremento la opcion de busqueda.\n\n- En fichas técnicas se aumento la busqueda por el Codigo Adicional.\n\n- En calendarizacion de mantenimiento se puede establecer si un dispositivo se encuentra bajo contrato y/o garantia.\n\n- Las ordenes pueden ser anidadas en caso de retraso o disconformidad de las mismas.\n\n- Los examenes en linea del modulo de Capacitacion pueden ser parametrizados, y determinar la cantidad de examenes que esta permitido tomarse.\n\n- Se creo el modulo de Panel de Control en el cual se accede a un resumen de estadisticas e impresiones de los modulos del sistema.";	
		document.stationform.stationtext.value = "Version 1.4.0 2012-06-11\n\n" + cad + " "
	}
	if ( stationString == "Version 1.5.0")	
	{	cad = "- En Fichas Tecnicas de incluyo la inventariacion de software.\n\n- La modulo de Riesgos reporta el promedio de la evaluacion.\n\n- En el modulo de Riesgos se puede incluir una observacion por recurso evaluado.\n\n- En Cliente/Titular se incremento un campo para personas casadas.\n\n- Se incremento la opcion de registrar el retorno de los mantenimientos fuera en Soporte Técnico.";	
		document.stationform.stationtext.value = "Version 1.5.0 2012-08-21\n\n" + cad + " "
	}
	if ( stationString == "Version 2.0.0")	
	{	cad = "- Las Tareas o Fases de DyM tienen la opcion de crear ordenes de trabajo.\n\n- La Planificacion estratégica a Corto Plazo origina ordenes y se puede hacer su respectivo seguimiento desde este modulo.\n\n- En la lista de Ordenes de Trabajo se incremento una columna con el origen de la Orden.\n\n- El backup de la BD del sistema ahora tiene la opcion de ser zipeado.\n\n- El Administrador de Fuentes cuenta ahora con una verificacion de seguridad de los archivos mediante una funcion hash.\n\n- Existe una tipificacion de mantenimiento de los equipos que se reporta en las impresiones de las fichas técnicas.\n\n- Seguimiento mas exacto de las actividades del proyecto.\n\n- Se agrego la opcion incinerado en Clasificacion de la Informacion.\n\n- En Desarrollo y Mantenimiento se añadieron observaciones en la Aprobacion de Implementacion.\n\n- Se insertaron 7 definiciones de riesgos como datos base para dicho analisis.";
		document.stationform.stationtext.value = "Version 2.0.0 2012-09-27\n\n" + cad + " "
	}
	if ( stationString == "Version 2.1.0")	
	{	cad1 = "- En el modulo de Actas, se incremento un totalizador en la duración de los temas.\n\n";
		cad1 += "- Dentro las minutas, se añadió una opción para agregar proposiciones y un campo para recaudación, cada proposición permite adjuntar un archivo.\n\n";
		cad1 += "- Se cambió el formato de la inserción de la hora, en las agendas y en las minutas.\n\n";
		cad1 += "- Los asistentes externos, deben ser ingresados previamente al sistema según su entidad de origen (modulo), parametrizable desde la pantalla inicial del modulo de actas.\n\n";
		cad1 += "- Los códigos de agenda son ahora parametrizables desde la misma pantalla.\n\n";
		cad1 += "- En Actas, se añadieron reportes y estadisticas generales bajo diferentes criterios.\n\n";
		cad1 += "- En Actas, la opción de adjuntar archivo, ahora permite adjuntar varios.\n\n";
		cad1 += "- Todos los reportes tienen un encabezado con los datos de la institución, su visibilidad es parametrizable desde los parámetros de control del sistema.\n\n";
		cad1 += "- El boletin informativo permite enviar mensajes vía SMS y por correo electrónico a los usuarios.\n\n";
		cad1 += "- Los usuarios eliminados o bloqueados por sistema, no son visibles para asignaciones, etc.\n\n";
		cad1 += "- La eliminación de usuarios requiere que se cierren todas sus ordenes abiertas.\n\n";
		cad1 += "- En el módulo de riesgos se añadió un consolidador para agrupar las evaluaciones realizadas, además estas evaluaciones ya pueden ser modificadas.\n\n";
		cad1 += "- En planificación estratégica, cada Objetivo de Negocio ahora puede tener varios Objetivos de TI, los costos son manejados ahora por actividades.\n\n";
		cad1 += "- En la pantalla que contiene la lista de usuarios ahora se tiene un reporte con los roles d cada usuario.\n\n";
		cad1 += "- Se añadió la opción de impresión por sistema/aplicación en el control de usuarios dentro del modulo de seguridad.\n\n";
		cad1 += "- La pantalla de carga de asignaciones ahora proporciona más información como el número de pendientes de solucion, pendientes de conformidad y cerrados por el usuario.\n\n";
		cad1 += "- En fichas tecnicas existe la opcion de dar de baja los recursos que ya no se encuentren en uso, y poder desplegar posteriormente una lista de estas fichas eliminadas.\n\n";
		cad1 += "- En el ingreso de nuevos requerimientos y en la solucion, se puede ingresar mas de dos adjuntos.\n\n";
		document.stationform.stationtext.value = "Version 2.1.0 2012-10-21\n\n" + cad1 + " "
	}
	if ( stationString == "Version 2.1.1")	
	{	cad1 = "- En Cambios en Produccion se creo el modulo de Pruebas que tienen origen en una Orden de Trabajo y luego tienen que ser planificadas para poder habilitarse para su respectiva ejecucion.\n\n";
		cad1 += "- Los passwords tienen tiempo de caducidad, que es parametrizado por el administrador.\n\n";
		cad1 += "- Los passwords tienen una cantidad parametrizable de no repetidos (Cantidad de Historicos).\n\n";
		cad1 += "- Los passwords tienen ingresos de gracia ante la caducidad o ante la reasignacion de la contraseña.\n\n";
		cad1 += "- En Calendarizacion de Administracion del Ambiente de Produccion se puede asignar un responsable de una tarea específica.\n\n";
		cad1 += "- En soporte Tecnico, todo tipo de mantenimiento de recurso tecnologico, se encuentra registrado y va en la impresion de la ficha tecnica asociada.\n\n";
		cad1 += "- Se creo un menu de parametros mucho mas amigable para los usuarios administradores.\n\n";
		cad1 += "- El fondo del sistema es ahora parametriable y configurable segun criterio del administrador.\n\n";
		cad1 += "- Se inserto la opcion de parametrizar por usuario que en el momento de ingresar un requerimiento tambien se pueda asignar inmediatamente a un responsable.\n\n";
		cad1 += "- El escalamiento deja de ser nominativo. Ahora se envia a correo y celular cuando una orden es escalada.\n\n";
		cad1 += "- La estadisticas fueron reestructuradas para una mayor comprension.\n\n";
		cad1 += "- La Calendarizacion dentro del Modulo de Produccion puede ser asignado a un tecnico especifico.\n\n";
		cad1 += "- Se introdujo un filtro de la lista de usuarios para el administardor.\n\n";
		document.stationform.stationtext.value = "Version 2.1.1 2012-11-05\n\n" + cad1 + " "
	}
	if ( stationString == "Version 3.0.0")	
	{	cad1 = " IMPLEMENTACIÓN DE MÓDULO TIPIFICACIÓN DE ORDENES\n\n - Se creo el módulo de tipificación de ordenes de trabajo para poder controlar el origen y tener una clasificación adecuada de las mismas. \n\n - Solo el administrador puede crear los niveles de tipificación \n\n - El técnico y el administrador pueden ver la tipificación (no así el cliente) \n\n - Las estadísticas fuerón modificadas para que se visualicen los parámetros de tipificación por niveles. \n\n - Las impresiones se generan adicionalmente con el criterio de tipificación.  \n\n";
		cad1 += "  CAMBIOS EN FICHAS TECNICAS\n\n - Se modificó las características del software para que en la opción de edición pueda cambiarse el nombre del software y se realice la actualización del registro elegido. \n\n";
		cad1 += "  ASIGNACIÓN DE ORDENES A VARIOS USUARIOS.\n\n - Se desarrolló la opción de asignar órdenes a varios usuarios, generando nuevas órdenes con el mismo requerimiento.\n\n - Se notifica en caso de ser un grupo de usuarios a través de los medios ya establecidos en el sistema (Correo electrónico, SMS).\n\n - Se puede asignar la orden a un solo usuario o a varios.\n\n - Mayor control respecto a la asignación de las órdenes de trabajo, en caso de asignar la orden por equivocación a un usuario, se emite un mensaje de cofirmación de asignación. \n\n";
		cad1 += "  MEJORA EN FORMATO DE REPORTES\n\n - Corrección en reportes de fichas técnicas y custodio.\n\n - Se mejoró el formato de presentación de los reportes tanto de fichas técnicas como las fichas en custodio. \n\n";
		document.stationform.stationtext.value = "Version 3.0.0 2013-02-12\n\n" + cad1 + " "
	}
	if ( stationString == "Version 4.0.1")	
	{	cad1 = " MEJORA DE LA INTERFAZ DE USUARIO\n\n -	Cambio del login.\n\n -	Cambio del banner principal. \n\n -	El menú es mas interactivo.  \n\n";
		cad1 += "  ADICION DE USUARIO SUPERADMINISTRADOR\n\n -	El superadministrador tiene la tarea de realizar el manejo de proceso de ordenes por regionales o sucursales. \n\n";
		cad1 += "  LAS FICHAS TECNICAS SE PUEDEN ADMINISTRAR POR REGIONALES Y/O SUCURSALES\n\n -	Se puede realizar las búsquedas  por regional y/o sucursal.\n\n -	Al asignar un usuario la ficha despliega la descripción de la regional y/o sucursal. \n\n -	El acceso puede hacerse desde cualquier directorio del árbol de unidades organizativas. \n\n";
		cad1 += "  ADICION DE REPORTES EN EL PANEL DE MANDO INTEGRAL\n\n -	Ordenes de trabajo según tipo y por regional y/o sucursal.\n\n -	Ordenes de trabajo por técnico. \n\n -	Ordenes de trabajo por tiempo de solución. \n\n";
		cad1 += "  ADICION DE UN MODULO PARA DAR DE ALTA Y BAJA  A USUARIOS\n\n -	Se  registran los datos de un usuario para darle de Alta incluyendo datos personales, permiso de accesos. \n\n -	Es asignado a un usuario para dar su aprobación o no aprobación. \n\n";
		document.stationform.stationtext.value = "Version 4.0.1 2013-08-11\n\n" + cad1 + " "
	}
	if ( stationString == "Version 4.0.2")	
	{	cad1 = " MEJORAS VISUALES\n\n -	Web 2.0 en Login y Manejo de Usuarios.\n\n -  La pantalla de Inicio de Sesión es más informtiva, respecto al número de intentos realizados  e intentos restantes. \n\n -";
		cad1 += "  MEJORAS EN INTEGRACION DE DATOS\n\n -	El módulo Ordenes de Trabajo, permite exportar los reportes estadísticos a formato PDF. \n\n";
		cad1 += "  MEJORAS DE SEGURIDAD DE LA INFORMACION\n\n -	Detección de Acceso Directo No Autorizado. \n\n -	Validación de caracteres especiales en formularios de Entrada. \n\n";
		cad1 += "  ASISTENTE PARA RECUPERAR PASSWORD\n\n -	Accesibilidad desde la pantalla de autentificación.\n\n -	Solicitud de contraseña mediante correo electrónico y codigo CAPTCHA. \n\n";
		cad1 += "  MEJORAMIENTO DE REGISTRO DE PROVEEDORES\n\n -	Parametrizacion del tipo de servicio en proveedores, segun su tipo.\n\n -	En registro y actualizacion de proveedores se ha incrementado nivel de riesgo y nivel de claidad de servicio de un proveedor. \n\n";
		cad1 += "  MODULO DE PNP\n\n -	Es posible observar las normas en PDF mientras el sistema cuenta automaticamente la cantidad que un usuario observa cada norma. \n\n -    Se ha creado un grafico donde es posible observar la cantidad de veces que un usuario ha ingresado a una determinada norma. \n\n";
		cad1 += "  CAMBIO DE CIFRADO\n\n -	Se ha cambiado el cifrado de contraseñas de md5 a sha1, con lo que mejora la seguridad de las contraseñas. \n\n ";
		document.stationform.stationtext.value = "Version 4.0.2 2014-02-22\n\n" + cad1 + " "
	}
	
	
 }

//-->
</script>
</head>
<BODY topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0">
<table width="70%" border="1" cellspacing="0" align="center">
  <tr> 
    <td colspan="4" width="100%"><!--object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="650" height="70">
        <param name="movie" value="images/header.swf">
        <param name="quality" value="high">
        <embed src="images/header.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="650" height="70"></embed></object-->
		<img src="images/bannerTI.jpg">
	</td>
  </tr>
</table>
<table align="center" width="78%" border="0" cellpadding="4" cellspacing="0" background="images/fondo.jpg">
  <tr><td width="30%" bgcolor=""></td></tr>
 <tr>  <td align="center" bgcolor="">

<font size="3" face="Arial, Helvetica, sans-serif" color="#006699"><b> Logs de Cambios GesTor F1</b></font>
<form name="stationform">
&nbsp;&nbsp;&nbsp;
 
<table align="center">
<tr>	<td bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="verdana"><strong>NRO. DE VERSION: </strong></font></div></td></tr>
<tr><td>
<select name="stationselect" onChange="textValue()" multiple size="10"  style="width:180px">
<option>Version 1.0.2
<option>Version 1.0.3
<option>Version 1.0.4 
<option>Version 1.1.0
<option>Version 1.1.1 
<option>Version 1.2.0 
<option>Version 1.3.0 
<option>Version 1.3.2 
<option>Version 1.4.0 
<option>Version 1.5.0
<option>Version 2.0.0 
<option>Version 2.1.0 
<option>Version 2.1.1 
<option>Version 3.0.0
<option>Version 4.0.1 
<option>Version 4.0.2
</select>
</td></tr>
<tr><td height="120"></td></tr>
</table>
<br>
<td width="50%" bgcolor="">
<font face="Verdana, Arial, Helvetica, sans-serif" size="1">
<textarea name="stationtext" cols="70" rows="31" readonly> 
&nbsp;
&nbsp;Presione sobre el Nro. de Version para ver mas detalles.
</textarea>

</font>
</form>
</table>
<tr><td></td></tr></table>
<center>
<?php include ("top_.php");?>
</center>
</body>
</HTML>
