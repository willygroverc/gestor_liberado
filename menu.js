//----------DHTML Menu Created using AllWebMenus PRO ver 5.0-#706---------------
//C:\Documents and Settings\Leo\Mis documentos\menu\Menus\menumesa1.awm
awmRelativeCorner=8;
var awmMenuName='menu';
var awmLibraryBuild=706;
var awmLibraryPath='/awmdata';
var awmImagesPath='/windowsvista-assets';
var awmSupported=(navigator.appName + navigator.appVersion.substring(0,1)=="Netscape5" || document.all || document.layers || navigator.userAgent.indexOf('Opera')>-1 || navigator.userAgent.indexOf('Konqueror')>-1)?1:0;
if (awmAltUrl!='' && !awmSupported) window.location.replace(awmAltUrl);
if (awmSupported){
//var nua=navigator.userAgent,scriptNo=(nua.indexOf('Safari')>-1)?7:(nua.indexOf('Gecko')>-1)?2:((document.layers)?3:((nua.indexOf('Opera')>-1)?4:((nua.indexOf('Mac')>-1)?5:1)));
var nua=navigator.userAgent,scriptNo=(nua.indexOf('Chrome')>-1)?2:((nua.indexOf('Safari')>-1)?7:(nua.indexOf('Gecko')>-1)?2:((document.layers)?3:((nua.indexOf('Opera')>-1)?4:((nua.indexOf('Mac')>-1)?5:1))));
var mpi=document.location,xt="";
var mpa=mpi.protocol+"//"+mpi.host;
var mpi=mpi.protocol+"//"+mpi.host+mpi.pathname;
if(scriptNo==1){oBC=document.all.tags("BASE");if(oBC && oBC.length) if(oBC[0].href) mpi=oBC[0].href;}
while (mpi.search(/\\/)>-1) mpi=mpi.replace("\\","/");
mpi=mpi.substring(0,mpi.lastIndexOf("/")+1);
var e=document.getElementsByTagName("SCRIPT");
for (var i=0;i<e.length;i++){if (e[i].src){if (e[i].src.indexOf(awmMenuName+".js")!=-1){xt=e[i].src.split("/");if (xt[xt.length-1]==awmMenuName+".js"){xt=e[i].src.substring(0,e[i].src.length-awmMenuName.length-3);if (e[i].src.indexOf("://")!=-1){mpi=xt;}else{if(xt.substring(0,1)=="/")mpi=mpa+xt; else mpi+=xt;}}}}}
while (mpi.search(/\/\.\//)>-1) {mpi=mpi.replace("/./","/");}
var awmMenuPath=mpi.substring(0,mpi.length-1);
while (awmMenuPath.search("'")>-1) {awmMenuPath=awmMenuPath.replace("'","&#39;");}
document.write("<SCRIPT SRC='"+awmMenuPath+awmLibraryPath+"/awmlib"+scriptNo+".js'><\/SCRIPT>");
var n=null;
awmzindex=1000;
}

var awmImageName='';
var awmPosID='';
var awmSubmenusFrame='';
var awmSubmenusFrameOffset;
var awmOptimize=0;
var awmComboFix=1;
var awmUseTrs=0;
var awmSepr=["0","","",""];
function awmBuildMenu(){
if (awmSupported){
awmImagesColl=["main-header.jpg",4,32,"main-footer.jpg",4,32,"indicator.png",9,32,"main-button-tile.jpg",21,32,"main-buttonOver-tile.jpg",21,32,"main-buttonOver-left.jpg",21,32,"main-buttonOver-right.jpg",21,32,"cargadeasig.gif",25,25,"hassubmenu.gif",4,7,"sub-button-tile.jpg",20,26,"sub-buttonOver-tile.jpg",20,26,"sub-button-left.jpg",34,26,"sub-buttonOver-left.jpg",34,26,"sub-button-right.jpg",34,26,"sub-buttonOver-right.jpg",34,26,"separator.jpg",227,2,"spacer.gif",1,1,"asignar.gif",20,26,"usuarios1.gif",20,21,"icon-awmlite.gif",16,16,"icon-lwbm.gif",16,16,"ordentrabajo.gif",20,25,"tipificacion.gif",22,22,"backup.gif",25,25,"boletin.gif",25,24,"configuracion.gif",24,24];
awmCreateCSS(1,2,1,'#FFFFFF',n,n,'14px sans-serif',n,'none',0,'#000000','0px 0px 0px 0',0);
awmCreateCSS(0,2,1,'#FFFFFF',n,n,'14px sans-serif',n,'none',0,'#000000','0px 0px 0px 0',0);
awmCreateCSS(1,2,1,'#000000',n,n,'14px sans-serif',n,'none',0,'#000000','0px 0px 0px 0',0);
awmCreateCSS(0,1,0,n,n,n,n,n,'none',0,'#000000',0,0);
awmCreateCSS(1,2,1,'#FFFFFF',n,3,'bold 11px Tahoma',n,'none',0,'#000000','0px 15px 0px 25',1);
awmCreateCSS(0,2,1,'#FFFFFF',n,4,'bold 11px Tahoma',n,'none',0,'#000000','0px 15px 0px 25',1);
awmCreateCSS(0,1,0,n,n,n,n,n,'solid',1,'#808080',0,0);
awmCreateCSS(1,2,0,'#000000',n,9,'11px Tahoma',n,'none',0,'#000000','0px 10px 0px 7',1);
awmCreateCSS(0,2,0,'#000000',n,10,'11px Tahoma',n,'none',0,'#000000','0px 10px 0px 7',1);
awmCreateCSS(1,2,0,'#000000',n,15,'11px Tahoma',n,'none',0,'#000000','0px 0px 0px 0',1);
awmCreateCSS(0,2,0,'#000000',n,15,'11px Tahoma',n,'none',0,'#000000','0px 0px 0px 0',1);
var s0=awmCreateMenu(0,0,0,0,1,0,0,0,8,0,0,0,1,3,0,0,1,n,n,100,1,0,10,10,511,-1,1,200,200,0,0,0,"0,0");
it=s0.addItemWithImages(0,1,1,"","","","",0,0,0,3,3,3,n,n,n,"",n,n,n,n,n,0,0,0,n,n,n,n,n,n,0,0,0,0,0);
it=s0.addItemWithImages(4,5,5,"INICIO",n,n,"",n,n,n,3,3,3,n,n,n,"",n,n,n,"pagina_inicio.php?Naveg=Inicio",n,0,0,2,n,5,5,n,6,6,0,1,1,0,0);
it=s0.addItemWithImages(4,5,5,"ASIGNACIONES",n,n,"",n,n,n,3,3,3,2,2,2,"",n,n,n,n,n,0,0,2,n,5,5,n,6,6,0,1,1,0,0);
var s1=it.addSubmenu(0,0,-1,0,0,0,0,6,0,1,0,n,n,100,0,4,0,-1,1,200,200,0,0);
it=s1.addItemWithImages(7,8,8,"    Carga de Asignaciones",n,n,"",7,7,7,3,3,3,n,n,n,"",n,n,n,"lista_carga.php?Naveg=Carga",n,0,0,2,11,12,12,13,14,14,1,1,1,0,0);
it=s1.addItemWithImages(9,10,10,"",n,n,"",16,n,n,3,3,3,n,n,n,"",n,n,n,n,n,0,2,2,n,n,n,n,n,n,0,0,0,0,0);
it=s1.addItemWithImages(7,8,8,"    Asignaciones",n,n,"",17,17,17,3,3,3,n,n,n,"",n,n,n,"lista_asig.php?Naveg=Asignaciones",n,0,0,2,11,12,12,13,14,14,1,1,1,0,0);
it=s0.addItemWithImages(4,5,5,"ADMINISTRACION DE USUARIO",n,n,"",n,n,n,3,3,3,2,2,2,"",n,n,n,n,n,0,0,2,n,5,5,n,6,6,0,1,1,0,0);
var s1=it.addSubmenu(0,0,-1,0,0,0,0,6,0,1,0,n,n,100,0,1,0,-1,1,200,200,0,0);
it=s1.addItemWithImages(7,8,8,"    Añadir Usuario                                 ",n,n,"",18,18,18,3,3,3,n,n,n,"",n,n,n,"usuarios.php?Naveg=Anadir%20Usuario",n,0,0,2,11,12,12,13,14,14,1,1,1,0,0);
it=s1.addItemWithImages(9,10,10,"",n,n,"",16,n,n,3,3,3,n,n,n,"",n,n,n,n,n,0,2,2,n,n,n,n,n,n,0,0,0,0,0);
it=s1.addItemWithImages(7,8,8,"    Lista de Usuarios",n,n,"",19,19,19,3,3,3,n,n,n,"",n,n,n,"usuarios_lista.php?Naveg=Usuarios",n,0,0,2,11,12,12,13,14,14,1,1,1,0,0);
it=s1.addItemWithImages(9,10,10,"",n,n,"",16,n,n,3,3,3,n,n,n,"",n,n,n,n,n,0,2,2,n,n,n,n,n,n,0,0,0,0,0);
it=s1.addItemWithImages(7,8,8,"    Lista de Titulares",n,n,"",20,20,20,3,3,3,n,n,n,"",n,n,n,"lista_titulares.php?Naveg=Titulares",n,0,0,2,11,12,12,13,14,14,1,1,1,0,0);
it=s0.addItemWithImages(4,5,5,"ORDENES DE TRABAJO",n,n,"",n,n,n,3,3,3,2,2,2,"",n,n,n,n,n,0,0,2,n,5,5,n,6,6,0,1,1,0,0);
var s1=it.addSubmenu(0,0,-1,0,0,0,0,6,0,1,0,n,n,100,0,2,0,-1,1,200,200,0,0);
it=s1.addItemWithImages(7,8,8,"    Orden de Trabajo           ",n,n,"",21,21,21,3,3,3,n,n,n,"",n,n,n,"lista.php?Naveg=Ordenes%20de%20Trabajo",n,0,0,2,11,12,12,13,14,14,1,1,1,0,0);
it=s1.addItemWithImages(9,10,10,"",n,n,"",16,n,n,3,3,3,n,n,n,"",n,n,n,n,n,0,2,2,n,n,n,n,n,n,0,0,0,0,0);
it=s1.addItemWithImages(7,8,8,"    Tipificacion",n,n,"",22,22,22,3,3,3,n,n,n,"",n,n,n,"lista_tipos.php?Naveg=Tipificaci%F3n",n,0,0,2,11,12,12,13,14,14,1,1,1,0,0);
it=s1.addItemWithImages(9,10,10,"",n,n,"",16,n,n,3,3,3,n,n,n,"",n,n,n,n,n,0,2,2,n,n,n,n,n,n,0,0,0,0,0);
it=s1.addItemWithImages(7,8,8,"    Reportes",n,n,"",22,22,22,3,3,3,n,n,n,"",n,n,n,"reportes/index.php","new",0,0,2,11,12,12,13,14,14,1,1,1,0,0);
it=s0.addItemWithImages(4,5,5,"ADMINISTRACION DEL SISTEMA",n,n,"",n,n,n,3,3,3,2,2,2,"",n,n,n,n,n,0,0,2,n,5,5,n,6,6,0,1,1,0,0);
var s1=it.addSubmenu(0,0,-1,0,0,0,0,6,0,1,0,n,n,100,0,3,0,-1,1,200,200,0,0);
it=s1.addItemWithImages(7,8,8,"    Backup de la BBDD                          ",n,n,"",23,23,23,3,3,3,n,n,n,"",n,n,n,"auditoria.php?Naveg=Backup%20de%20la%20Base%20de%20Datos",n,0,0,2,11,12,12,13,14,14,1,1,1,0,0);
it=s1.addItemWithImages(9,10,10,"",n,n,"",16,n,n,3,3,3,n,n,n,"",n,n,n,n,n,0,2,2,n,n,n,n,n,n,0,0,0,0,0);
it=s1.addItemWithImages(7,8,8,"    Boletin Informativo",n,n,"",24,24,24,3,3,3,n,n,n,"",n,n,n,"faq.php?Naveg=Boletin Informativo",n,0,0,2,11,12,12,13,14,14,1,1,1,0,0);
it=s1.addItemWithImages(9,10,10,"",n,n,"",16,n,n,3,3,3,n,n,n,"",n,n,n,n,n,0,2,2,n,n,n,n,n,n,0,0,0,0,0);
it=s1.addItemWithImages(7,8,8,"    Configuracion del Sistema",n,n,"",25,25,25,3,3,3,n,n,n,"",n,n,n,"menu_Parametros.php?Naveg=Men%FA%20de%20Par%E1metros",n,0,0,2,11,12,12,13,14,14,1,1,1,0,0);
it=s0.addItemWithImages(2,1,1,"","","","",1,1,1,3,3,3,n,n,n,"",n,n,n,n,n,0,0,0,n,n,n,n,n,n,0,0,0,0,0);
s0.pm.buildMenu();
}}
